<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestBoosting extends Model
{
    use HasFactory;

    public function socialMediaPlatform()
    {
        return $this->hasOne(SocialMediaPlatform::class, 'id', 'social_media_platform_id');
    }
    
    public function socialMediaPlatformLimit()
    {
        return $this->hasOne(SocialMediaLimit::class, 'id', 'social_media_platform_limit_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
