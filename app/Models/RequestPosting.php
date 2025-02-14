<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPosting extends Model
{
    use HasFactory;

    public function requestMediaPosts()
    {
        return $this->hasMany(RequestPostingMedia::class, 'request_posting_id', 'id');
    }

    public function mediaFiles()
    {
        return $this->hasMany(RequestPostingMedia::class, 'request_posting_id', 'id');
    }

    public function platform()
    {
        return $this->hasOne(SocialMediaPlatform::class, 'id', 'social_media_platform_id');
    }
    
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
