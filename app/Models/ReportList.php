<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ReportList extends Model
{
    protected $table = 'report.report_list';
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'segment_id',
        'user_id',
        'status_id',
        'no_ticket',
        'note',
        'maintenance_by',
        'survey_status',
    ];

    public function report_segment(): HasMany
    {
        return $this->hasMany(ReportSegment::class, 'report_id');
    }
}
