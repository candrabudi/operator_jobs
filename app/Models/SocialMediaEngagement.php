<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaEngagement extends Model
{
    use HasFactory;

    protected $fillable = [
        'engagement_type',
        'min',
        'max',
    ];
}
