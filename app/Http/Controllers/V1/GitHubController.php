<?php

namespace App\Http\Controllers\V1;
use App\Models\GitHub\GitHubRepositories;
use App\Models\GitHub\GitHubUsers;
use App\Models\GitHub\GitHubIssues;
use App\Http\Requests\v1\GitHubApiRequest;
use App\Http\Requests\v1\GitHubIssuesSearchRequest;
use App\Http\Requests\v1\GitHubRepositoriesSearchRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Support\GitHubApiFunc;

class GitHubController extends Controller
{
/*
 * 1. GET api/v1/github/{userName}/{repositoryName}/issues
 *
 * */
    public function issues($userName, $repositoryName, GitHubApiRequest $request)
    {
        $fromDb = $request->get('fromDb');
        $page = $request->get('page');
        $perPage = $request->get('perPage');
        //если true то ищем в базе, если false идем на github
        if ($fromDb) {
            $result = GitHubApiFunc::getIssues($userName, $repositoryName);
            return response()->json([
                "success" => true,
                "data" => [
                    "issues" => GitHubApiFunc::paginate($result, $perPage, $page, ['data'])
                ]
            ]);
        } else {
            $client = new \Github\Client();
            //получаем issues c github
            $issues = $client->api('issue')->all($userName, $repositoryName, array());
            //пишем в бд Issues
            GitHubApiFunc::createNewIssues($userName, $issues, $repositoryName);
            //выводим результат записи
            $result = GitHubApiFunc::getIssues($userName, $repositoryName);
                return response()->json([
                "success" => true,
                "data" => [
                    "issues" => GitHubApiFunc::paginate($result, $perPage, $page, ['data'])
                ]
            ]);
        }
    }
/*
 * 2. GET api/v1/github/{userName}/repositories
 * */
    public function userNameRepositories($userName, GitHubApiRequest $request)
    {
        $fromDb = $request->get('fromDb');
        $page = $request->get('page');
        $perPage = $request->get('perPage');
        if ($fromDb) {
            $result = GitHubApiFunc::getRepositories($userName);
            return response()->json([
                "success" => true,
                "data" => [
                    "repositories" => GitHubApiFunc::paginate($result, $perPage, $page, ['data'])
                ]
            ]);
        } else {
            $client = new \Github\Client();
            //получаем issues c github
            $repos = $client->api('user')->repositories($userName);
            //запись user и repositories
            GitHubApiFunc::createNewRepositories($repos, $userName);
            $result = GitHubApiFunc::getRepositories($userName);
            return response()->json([
                "success" => true,
                "data" => [
                    "repositories" => GitHubApiFunc::paginate($result, $perPage, $page, ['data'])
                ]
            ]);
        }
    }
/*
 * 3. GET api/v1/github/{userName}/issues/search
 * */
    public function issuesSearch($userName, GitHubIssuesSearchRequest $request)
    {
        $fromDb = $request->get('fromDb');
        $page = $request->get('page');
        $perPage = $request->get('perPage');
        if($fromDb) {
            return response()->json([
                "success" => true,
                "data" => [
                    "issues" => GitHubApiFunc::findInIssuesForAllRepositories($userName,$request)
                ]
            ]);
        } else {
            $client = new \Github\Client();
            //получаем repositories c github
            $repos = $client->api('user')->repositories($userName);
            //записываем user и repositories
            $repositories = GitHubApiFunc::createNewRepositories($repos, $userName);
            //запись всех issues для всех repositories
            GitHubApiFunc::createNewIssuesForAllRepositories($repositories, $client, $userName);
            return response()->json([
                "success" => true,
                "data" => [
                    "issues" => GitHubApiFunc::findInIssuesForAllRepositories($userName,$request)
                ]
            ]);
        }
    }
/*
 * 4. GET api/v1/github/{userName}/repositories/search
 * */
    public function repositoriesSearch($userName, GitHubRepositoriesSearchRequest $request)
    {
        $fromDb = $request->get('fromDb');
        $page = $request->get('page');
        $perPage = $request->get('perPage');
        if($fromDb) {
            $result = GitHubApiFunc::findInRepositories($userName, $request);
            return response()->json([
                "success" => true,
                "data" => [
                    "issues" => GitHubApiFunc::paginate($result, $perPage, $page, ['data'])
                ]
            ]);
        } else {
            $client = new \Github\Client();
            //получаем repositories c github
            $repos = $client->api('user')->repositories($userName);
            //записываем user и repositories
            GitHubApiFunc::createNewRepositories($repos, $userName);
            $result = GitHubApiFunc::findInRepositories($userName, $request);
            return response()->json([
                "success" => true,
                "data" => [
                    "repositories" => GitHubApiFunc::paginate($result, $perPage, $page, ['data'])
                ]
            ]);
        }
    }
}
