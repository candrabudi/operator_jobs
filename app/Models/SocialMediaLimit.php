<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaLimit extends Model
{
    use HasFactory;

    protected $fillable = ['social_media_platform_id', 'platform_type', 'min', 'max'];
}
