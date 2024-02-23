<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiFilter
{
    protected $safeParms = [];

    protected $columnMap = [];

    protected $operatorMap = [];

    public function transform(Request $request)
    {
        $eloQuery = [];

        foreach ($this->safeParms as $parm => $operators) {
            $query = $request->query($parm);

            if (!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }

        // Tipe Saluran

        // Handle search parameter
        if ($search = $request->input('search')) {
            echo "Search keyword: " . $search . "<br>";

            foreach ($this->columnMap as $column) {
                echo "Searching in column: " . $column . "<br>";
                $eloQuery[] = [DB::raw('LOWER(' . $column . ')'), 'LIKE', '%' . strtolower($search) . '%'];
            }
        }


        return $eloQuery;
    }
}
