<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestBoost extends Model
{
    use HasFactory;

    public function platform()
    {
        return $this->hasOne(SocialMediaPlatform::class, 'id', 'social_media_platform_id');
    }

    public function engagement()
    {
        return $this->hasOne(SocialMediaEngagement::class, 'id', 'social_media_engagement_id');
    }
}
