<?php

namespace App\Models\Report;

use App\Models\Map\MapSegment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ReportSegment extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'report.report_segment';

    protected $fillable = [
        'report_id',
        'segment_id',
        'level',
        'type',
        'rate',
        'comment'
    ];

    public function report()
    {
        return $this->belongsTo(ReportList::class, 'report_id');
    }

    public function segment()
    {
        return $this->belongsTo(MapSegment::class, 'segment_id');
    }

    public function report_photo(): HasOne
    {
        return $this->hasOne(ReportPhoto::class, 'report_segment_id');
    }
}
