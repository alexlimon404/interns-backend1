<?php

namespace App\Models\GitHub;

use Illuminate\Database\Eloquent\Model;

class GitHubIssues extends Model
{
    protected $table = "github_issues";

    protected $fillable = [
        'github_id', 'state', 'title', 'number', 'repository_id'
    ];

    public $timestamps = false;

    protected $guarded = [];
}
