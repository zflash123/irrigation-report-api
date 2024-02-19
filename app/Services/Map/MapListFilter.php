<?php

namespace App\Services\Map;

use App\Services\ApiFilter;

class MapListFilter extends ApiFilter
{
    protected $safeParms = [
        'district_id' => ['eq', 'ne'],
        'sub_district_id' => ['eq', 'ne'],
        'name' => ['eq'],
    ];

    protected $columnMap = [
        'district_id' => 'district_id',
        'sub_district_id' => 'sub_district_id',
        'name' => 'name'
    ];

    protected $operatorMap = [
        'eq' => '=', // Sama dengan
        'ne' => '!=', // Tidak sama dengan
        'lt' => '<', // Kurang dari
        'gt' => '>',  // Lebih dari
    ];
}
