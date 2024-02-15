<?php

namespace App\Services\User;

use App\Services\ApiFilter;

class UserSectionFilter extends ApiFilter
{
    protected $safeParms = [
        'urole_id' => ['eq', 'ne'],
        'username' => ['eq', 'ne'],
        'name' => ['eq', 'ne'],
        'email' => ['eq', 'ne'],
        'fullname' => ['eq', 'ne'],
        'shortname' => ['eq', 'ne'],
        'code' => ['eq', 'ne'],
    ];

    protected $columnMap = [
        'name' => 'name',
        'code' => 'code',
    ];

    protected $operatorMap = [
        'eq' => '=', // Sama dengan
        'ne' => '!=', // Tidak sama dengan
        'lt' => '<', // Kurang dari
        'gt' => '>',  // Lebih dari
    ];
}
