<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\Report\ReportListResource;
use App\Models\Report\ReportList;
use App\Services\Report\ReportListFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ReportListController extends Controller
{
    public function index(Request $request)
    {
        $reportFilter = new ReportListFilter();
        $queryItems = $reportFilter->transform($request);

        $query = QueryBuilder::for(ReportList::class)
            ->allowedSorts([
                'user_id', 'status_id', 'no_ticket', 'note', 'maintenance_by', 'created_at', 'updated_at'
            ]);

        foreach ($queryItems as $filter) {
            $query->where($filter[0], $filter[1], $filter[2]);
        }

        if ($request->has('limit')) {
            $reportList = $query->paginate($request->query('limit'));
        } else {
            $reportList = $query->paginate();
        }

        $reportList->getCollection()->transform(function ($reportList) {
            return $reportList;
        });

        return ReportListResource::collection($reportList);
    }

    public function show($id)
    {
        $reportListId = ReportList::findOrFail($id);

        return new ReportListResource($reportListId);
    }
}
