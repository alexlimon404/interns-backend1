<?php

namespace App\app\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profiles';
    protected $fillable = ['id', 'name', 'user_id'];
//    protected $fillable2 = ['id', 'name', 'email', ];

}
// Это модель
