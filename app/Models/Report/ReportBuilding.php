<?php

namespace App\Models\Report;

use App\Models\Map\BangunanIrigasi;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportBuilding extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'report.report_building';

    protected $fillable = [
        'report_id',
        'building_id',
        'level',
        'type',
        'rate',
        'comment',
        'note'
    ];

    public function report()
    {
        return $this->belongsTo(ReportList::class, 'report_id');
    }

    public function build()
    {
        return $this->belongsTo(BangunanIrigasi::class, 'building_id');
    }
}
