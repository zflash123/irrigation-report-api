<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class MapList extends Model
{
    use HasFactory;
    protected $table = 'master.irrigations';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'district_id',
        'sub_district_id',
        'name',
        'type',
        'length',
        'created_at',
        'updated_at',
        'geom',
        'geojson'
    ];
}
