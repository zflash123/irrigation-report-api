<?php

namespace App\Services\Report;

use App\Services\ApiFilter;

class ReportListFilter extends ApiFilter
{
    protected $safeParms = [
        "user_id" => ['eq', 'ne'],
        "status_id" => ['eq', 'ne'],
        "no_ticket" => ['eq', 'ne'],
        "note" => ['eq', 'ne'],
        "maintenance_by" => ['eq', 'ne'],
    ];

    protected $columnMap = [
        "user_id" => "user_id",
        "status_id" => "status_id",
        "no_ticket" => "no_ticket",
        "note" => "note",
        "maintenance_by" => "maintenance_by",
    ];

    protected $operatorMap = [
        'eq' => '=', // Sama dengan
        'ne' => '!=', // Tidak sama dengan
        'lt' => '<', // Kurang dari
        'gt' => '>',  // Lebih dari
    ];
}
