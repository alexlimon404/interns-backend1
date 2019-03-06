<?php

namespace App\Models\GitHub;

use Illuminate\Database\Eloquent\Model;

class GitHubUsers extends Model
{
    protected $table = 'github_users';

    protected $fillable = ['username'];

    public $timestamps = false;
}
