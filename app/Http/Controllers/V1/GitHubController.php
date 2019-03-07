<?php

namespace App\Http\Controllers\V1;
use App\Models\GitHub\GitHubRepositories;
use App\Models\GitHub\GitHubUsers;
use App\Models\GitHub\GitHubIssues;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GitHubController extends Controller
{
/*
 * 1. GET api/v1/github/{userName}/{repositoryName}/issues
 *
 * */
    public function issues($userName, $repositoryName)
    {
        $user = DB::table('github_users')->where('username', $userName)->first();
        $repositories = DB::table('github_repositories')->where('name', $repositoryName)->get();
        //ищем значения в базе данных
        if (!empty($user and $repositories)) {
            $issuesArr = [];
            foreach ($repositories as $repositori) {
            $data = GitHubIssues::where('github_id', $repositori->github_id)->get();
            array_push($issuesArr, $data);
            }
            return response()->json([
                "success" => true,
                "data" => [
                    "issues" =>  $issuesArr
                ]
            ]);
        } else {
            //если нету, идём на github
            $client = new \Github\Client();
            //получаем issues c github
            $issues = $client->api('issue')->all($userName, $repositoryName, array());
            //запись нового user'a
            $newUser = GitHubUsers::firstOrCreate(['username' => $userName]);
            //запись нового repositories
            $repositories=[];
                foreach ($issues as $github_id) {
                    $repositoriesData = GitHubRepositories::firstOrCreate(['github_id'=> $github_id['id'], 'name' => $repositoryName, 'github_user_id' => $newUser->id]);
                    array_push($repositories, $repositoriesData);
                }
                //запись нового issues
                foreach ($issues as $issue) {
                    GitHubIssues::firstOrCreate([
                        'github_id' => $issue['id'],
                        'title' =>$issue['title'],
                        'number' => $issue['number'],
                        'state' => $issue['state']
                        ]);
                }
                //дописываем в issues -> repository_id
                foreach ($repositories as $repository) {
                     GitHubIssues::updateOrCreate(['github_id' =>$repository->github_id], ['repository_id' => $repository->id]);
                }
                //выводим результат записи
                $repositoriesName = DB::table('github_repositories')->where('name', $repositoryName)->get();
                $issuesArr = [];
                foreach ($repositoriesName as $repo) {
                    $data = GitHubIssues::where('github_id', $repo->github_id)->get();
                    array_push($issuesArr, $data);
                }
                return response()->json([
                    "success" => true,
                    "data" => [
                        "issues" => $issuesArr
                    ]
                ]);
            }
    }
/*
 * 2. GET api/v1/github/{userName}/repositories
 * */
    public function userNameRepositories($userName)
    {
        $user = GitHubUsers::where('username', $userName)->firstOrFail();
        $perPage = 10;
        $repositories = GitHubRepositories::where('github_user_id', $user->id)->paginate($perPage)->items();
        $repositoriesArr = [];
        foreach ($repositories as $rep) {
            $data = [
                "id" => $rep->id,
                "github_id" => $rep->github_id,
                "name" => $userName,
                "description" => $rep->description
            ];
            array_push($repositoriesArr, $data);
        }
        return response()->json([
            "success" => true,
            "data" => [
                "repositories" => $repositoriesArr
            ]
        ]);
    }
/*
 * 3. GET api/v1/github/{userName}/issues/search
 * */

    public function issuesSearch($userName, Request $param)
    {
        $user = GitHubUsers::where('username', $userName)->firstOrFail();
        $repositories = GitHubRepositories::where('github_user_id', $user->id)->get();
        $githubId = [];
        foreach ($repositories as $rep) {
            $data = ["github_id" => $rep->github_id];
            array_push($githubId, $data);
        }
        $issuesSearch = [];
        foreach ($githubId as $id) {
            $data = GitHubIssues::where('github_id', $id)->where('title', 'LIKE', "%$param->title%")->where('number', $param->number)->where('state', "$param->state")->get();
            array_push($issuesSearch, $data);
        }
        return response()->json([
            "success" => true,
            "data" => [
                "issues" => $issuesSearch
            ]
        ]);
    }
/*
 * 4. GET api/v1/github/{userName}/repositories/search
 * */
    public function repositoriesSearch($userName, Request $param)
    {

    }


}
