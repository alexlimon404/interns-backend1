<?php

namespace App\Support;
use Github\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\GitHub\GitHubRepositories;
use App\Models\GitHub\GitHubUsers;
use App\Models\GitHub\GitHubIssues;

class GitHubApiFunc
{
/**
 * @param string $userName
 * @param string $repositoryName
 *
 * @return array $issuesArr
 * */
    public static function getIssues($userName, $repositoryName)
    {
        $userId = GitHubUsers::where('username', $userName)->firstOrFail();
        $repositoryId = GitHubRepositories::where('github_user_id', $userId->id)->
            where('name', $repositoryName)->first();
        $issuesArr = GitHubIssues::where('repository_id', $repositoryId->id)->get();
        return $issuesArr;
    }

/**
 * @param string $userName
 * @param array $issues
 * @param string $repositoryName
 *
 * @return boolean
 * */
    public static function createNewIssues($userName, $issues, $repositoryName)
    {
        //запись нового user'a
        $newUser = GitHubUsers::firstOrCreate(['username' => $userName]);
        //запись нового repository
        $repository = GitHubRepositories::firstOrCreate([
            'name' => $repositoryName,
            'github_user_id' =>$newUser->id
        ]);
        //запись новых issues
        foreach ($issues as $issue) {
            GitHubIssues::firstOrCreate([
                'github_id' => $issue['id'],
                'repository_id' => $repository->id,
                'title' =>$issue['title'],
                'number' => $issue['number'],
                'state' => $issue['state']
            ]);
        }
        return true;
    }
/**
 * @param array $repos
 * @param string $userName
 *
 * @return array
 * */
    public static function createNewRepositories($repos, $userName)
    {
        //запись нового user'a
        $newUser = GitHubUsers::firstOrCreate(['username' => $userName]);
        //запись новых repositories
        $repositories=[];
        foreach ($repos as $repo) {
            $data = GitHubRepositories::firstOrCreate(
                //['github_id'=> $repo['id']],
                ['github_id'=> $repo['id'],
                    'name' => $repo['name'],
                    'github_user_id' => $newUser->id,
                    'description' => $repo['description'],
                    'private' => $repo['private'],
                    'language' => $repo['language']
                ]);
            array_push($repositories, $data);
        }
        return $repositories;
    }
/**
 * @param string $userName
 *
 * @return array
 * */
    public static function getRepositories($userName)
    {
        $user = GitHubUsers::where('username', $userName)->firstOrFail();
        $repositories = GitHubRepositories::where('github_user_id', $user->id)->get();
        $result = [];
        foreach ($repositories as $rep) {
            $data = [
                "id" => $rep->id,
                "github_id" => $rep->github_id,
                "name" => $userName,
                "description" => $rep->description
            ];
            array_push($result, $data);
        }
        return $result;
    }
/**
 * @param array $repositories
 * @param $client
 * @param string $userName
 *
 * @return boolean
 * */
    public static function createNewIssuesForAllRepositories($repositories, $client, $userName)
    {
        foreach ($repositories as $repo){
            //получаем issues c github
            $issues = $client->api('issue')->all($userName, $repo['name'], array());
            foreach ($issues as $issue) {
                $repository = GitHubRepositories::firstOrCreate([
                    'name' => $repo['id'],
                ]);
                //пишем все issues от всех repo
                GitHubIssues::firstOrCreate([
                    'github_id' => $issue['id'],
                    'repository_id' => $repository->name,
                    'title' =>$issue['title'],
                    'number' => $issue['number'],
                    'state' => $issue['state']
                ]);
            }
        }
        return true;
    }
/**
 * @param string $userName
 * @param  $request
 *
 * @return array
 * */
    public static function findInIssuesForAllRepositories($userName, $request)
    {
        $user = GitHubUsers::where('username', $userName)->firstOrFail();
        $repositories = GitHubRepositories::where('github_user_id', $user->id)->get();
        $githubId = [];
        foreach ($repositories as $rep) {
            $data = ["github_id" => $rep->id];
            array_push($githubId, $data);
        }
        $issuesSearch = [];
        //TODO: убрать LIKE из number u state
        foreach ($githubId as $id) {
            $data = GitHubIssues::where('repository_id', $id)->
            where('title', 'LIKE', "%$request->title%")->
            where('number','LIKE', "%$request->number%")->
            where('state', 'LIKE',"%$request->state%")->
            get();
            array_push($issuesSearch, $data);
        }
        return $issuesSearch;
    }

    public static function findInRepositories($userName, $request)
    {
        $user = GitHubUsers::where('username', $userName)->firstOrFail();
        $repositories = GitHubRepositories::where('github_user_id', $user->id)->get();
        $repositorySearch = GitHubRepositories::where('github_user_id', $repositories[0]['github_user_id'])->
            where('description', 'LIKE', "%$request->title%")->
            where('private', 'LIKE', "%$request->private%")->
            where('language', 'LIKE', "%$request->language%")->
            get();
        return $repositorySearch;
    }

/**
 *
 */
    public static function paginate($items, $perPage = null, $currentPage = null, array $options = [])
    {
        $currentPage = $currentPage ? : 1;
        $perPage = $perPage ? : 15;
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $results = new LengthAwarePaginator($items->forPage($currentPage, $perPage), $items->count(), $perPage, $currentPage, $options);
        return [
            'current_page' => $results->currentPage(),
            'data' => $results->values(),
        ];
    }
}