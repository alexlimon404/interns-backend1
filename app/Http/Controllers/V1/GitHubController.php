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
}
