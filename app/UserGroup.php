<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $table = "user_group";
    protected $fillable = ['name'];
    public $timestamps = false;
}
