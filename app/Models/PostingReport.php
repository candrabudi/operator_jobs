<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostingReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_posting_id',
        'report_title',
        'report_content'
    ];

    public function requestPosting()
    {
        return $this->belongsTo(RequestPosting::class);
    }

    public function mediaFiles()
    {
        return $this->hasMany(PostingReportMedia::class);
    }
}
