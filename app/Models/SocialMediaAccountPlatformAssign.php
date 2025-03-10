<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaAccountPlatformAssign extends Model
{
    use HasFactory;

    protected $fillable = [
        'social_media_account_id', 
        'social_media_platform_id'
    ];
}
