<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSegment extends Model
{
    protected $table = 'report.report_segment';
    use HasFactory;

    protected $fillable = [
        'report_id',
        'segment_id',
        'level',
        'rate',
        'comment',
        'note'
    ];
}
