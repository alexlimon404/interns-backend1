<?php

namespace App\app\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = ['id', 'user', 'user_id'];
}
// Это модель