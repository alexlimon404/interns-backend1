<?php

namespace App\Models\GitHub;

use Illuminate\Database\Eloquent\Model;

class GitHubRepositories extends Model
{
    protected $table = 'github_repositories';
    protected $fillable = ['github_id', 'name', 'github_user_id' ];
    public $timestamps = false;
}
