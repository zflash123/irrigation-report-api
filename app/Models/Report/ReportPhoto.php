<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ReportPhoto extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'report.report_photo';
    
    protected $fillable = [
        'report_segment_id',
        'upload_dump_id',
        'filename',
        'file_url'
    ];
}
