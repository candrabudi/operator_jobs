<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoostReportMedia extends Model
{
    use HasFactory;
    protected $fillable = ['boost_report_id', 'file_name', 'file_path'];
    public function boostingReport()
    {
        return $this->belongsTo(BoostReport::class);
    }
}
