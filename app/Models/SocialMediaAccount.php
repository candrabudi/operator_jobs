<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_username',
        'account_password', 
        'account_email', 
        'account_email_password'
    ];

    public function socialMediaAccountTopic()
    {
        return $this->hasMany(SocialMediaAccountTopic::class, 'social_media_account_id', 'id')
            ->join('topics as t', 't.id', '=', 'social_media_account_topics.topic_id');
    }
   
    public function socialMediaAccountPlatformAssign()
    {
        return $this->hasMany(SocialMediaAccountPlatformAssign::class, 'social_media_account_id', 'id')
            ->join('social_media_platforms as smp', 'smp.id', '=', 'social_media_account_platform_assigns.social_media_platform_id');
    }
}
