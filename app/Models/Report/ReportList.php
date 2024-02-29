<?php

namespace App\Models\Report;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportList extends Model
{
    use HasFactory;
    protected $table = 'report.report_list';
    protected $keyType = 'string';
    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'status_id',
        'no_ticket',
        'note',
        'maintenance_by',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
