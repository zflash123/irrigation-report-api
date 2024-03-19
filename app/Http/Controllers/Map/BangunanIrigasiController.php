<?php

namespace App\Http\Controllers\Map;

use App\Http\Controllers\Controller;
use App\Http\Resources\Map\BangunanIrigasiResource;
use App\Models\Map\BangunanIrigasi;
use App\Services\Map\BangunanIrigasiFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class BangunanIrigasiController extends Controller
{
    public function index(Request $request)
    {
        $bangunanIrigasiFilter = new BangunanIrigasiFilter();
        $queryItems = $bangunanIrigasiFilter->transform($request);

        $query = QueryBuilder::for(BangunanIrigasi::class)
            ->allowedSorts([
                'nama_bangunan',
                'tipe_saluran',
                'jarak',
                'b_saluran  ',
                'sempadan_kanan ',
                'sempadan_kiri',
                'luas_saluran',
                'sisi_terluar_kanan',
                'sisi_terluar_kiri',
                'saluran_kanan',
                'saluran_panjang_kanan',
                'saluran_kiri',
                'saluran_panjang_kiri',
                'keterangan',
                'created_at',
                'updated_at',
                'geom'
            ]);

        foreach ($queryItems as $filter) {
            $query->where($filter[0], $filter[1], $filter[2]);
        }

        if ($request->has('limit')) {
            $bangunanIrigasi = $query->paginate($request->query('limit'));
        } else {
            $bangunanIrigasi = $query->paginate();
        }
        // $geojson = DB::selectOne('SELECT ST_AsGeoJSON(ST_Transform(geom, 4326)) as geojson FROM map.irrigations_building WHERE id = ?', [$item->id])->geojson;

        $bangunanIrigasi->transform(function ($item) {
            $geojson = DB::selectOne('SELECT ST_AsGeoJSON(ST_Transform(geom, 4326)) as geojson FROM map.irrigations_building WHERE id = ?', [$item->id])->geojson;
            $item->geojson = $geojson;
            return $item;
        });

        return BangunanIrigasiResource::collection($bangunanIrigasi);
    }

    public function show($id)
    {
        $item = BangunanIrigasi::findOrFail($id);

        $geojson = DB::selectOne('SELECT ST_AsGeoJSON(ST_Transform(geom, 4326)) as geojson FROM map.irrigations_building WHERE id = ?', [$item->id])->geojson;
        $item->geojson = $geojson;

        return new BangunanIrigasiResource($item);
    }
}
