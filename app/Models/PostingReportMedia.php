<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostingReportMedia extends Model
{
    use HasFactory;

    protected $fillable = ['posting_report_id', 'file_name', 'file_path'];

    public function postingReport()
    {
        return $this->belongsTo(PostingReport::class);
    }
}