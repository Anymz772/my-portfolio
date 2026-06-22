<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'full_name', 'role_title', 'email', 'phone', 'bio',
        'hero_image', 'profile_image', 'github_url', 'linkedin_url',
        'twitter_url',
    ];
}
