<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaPlatform extends Model
{
    use HasFactory;

    protected $fillable = [
        'social_media_name', 
        'description'
    ];

    public function socialMediaPlatformEngagement()
    {
        return $this->hasMany(SocialMediaPlatformEngagement::class, 'social_media_platform_id', 'id')
            ->join('social_media_engagements as sme', 'sme.id', '=', 'engagement_type_id');
    }
}
