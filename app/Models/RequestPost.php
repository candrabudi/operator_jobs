<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPost extends Model
{
    use HasFactory;

    public function platform()
    {
        return $this->hasOne(SocialMediaPlatform::class, 'id', 'social_media_platform_id');
    }

    public function media()
    {
        return $this->hasMany(RequestPostMedia::class, 'request_posting_id', 'id');
    }

    public function updatedBy()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
