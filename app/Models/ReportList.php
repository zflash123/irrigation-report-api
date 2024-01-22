<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportList extends Model
{
    use HasFactory;

    protected $fillable = [
        'segment_id',
        'user_id',
        'status_id',
        'no_ticket',
        'note',
        'maintenance_by',
        'survey_status',
    ];
}
