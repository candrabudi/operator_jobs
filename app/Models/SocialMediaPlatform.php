<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaPlatform extends Model
{
    use HasFactory;
    protected $fillable = ['social_media_name', 'description'];

    public function limits()
    {
        return $this->hasMany(SocialMediaLimit::class, 'social_media_platform_id', 'id');
    }

    public function requestPost()
    {
        return $this->hasMany(RequestPosting::class, 'social_media_platform_id', 'id');
    }
    
    public function requestBoost()
    {
        return $this->hasMany(RequestBoosting::class, 'social_media_platform_id', 'id');
    }
}
