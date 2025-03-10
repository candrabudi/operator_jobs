<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaPlatformEngagement extends Model
{
    use HasFactory;

    protected $fillable = [
        'social_media_platform_id', 
        'engagement_type_id'
    ];
}
