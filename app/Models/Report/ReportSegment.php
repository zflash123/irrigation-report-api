<?php

namespace App\Models\Report;

use App\Models\Map\MapSegment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSegment extends Model
{
    use HasFactory;
    protected $table = 'report.report_segment';
    protected $keyType = 'string';
    public $incrementing = true;

    protected $fillable = [
        'report_id',
        'segment_id',
        'level',
        'type',
        'rate',
        'comment',
        'created_at',
        'updated_at',
    ];

    public function report()
    {
        return $this->belongsTo(ReportList::class, 'report_id');
    }

    public function segmen()
    {
        return $this->belongsTo(MapSegment::class, 'segment_id');
    }
}
