<?php

namespace App\Models\GitHub;

use Illuminate\Database\Eloquent\Model;

class GitHubIssues extends Model
{
    protected $table = "github_issues";

    protected $fillable = [
        'github_id', 'state', 'title', 'number', 'repository_id'
        ];

    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'email_verified_at', 'api_token'
    ];

    public $timestamps = false;

    protected $guarded = [];
}
