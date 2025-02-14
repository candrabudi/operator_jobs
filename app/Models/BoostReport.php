<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoostReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_boost_id',
        'report_title',
        'report_content'
    ];

    public function requestBoosting()
    {
        return $this->belongsTo(RequestBoosting::class);
    }

    public function mediaFiles()
    {
        return $this->hasMany(BoostReportMedia::class);
    }
}
