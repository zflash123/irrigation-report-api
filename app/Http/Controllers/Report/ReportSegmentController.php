<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\Report\ReportSegmentResource;
use App\Models\Report\ReportSegment;
use App\Services\Report\ReportSegmentFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ReportSegmentController extends Controller
{
    public function index(Request $request)
    {
        $reportSegmentFilter = new ReportSegmentFilter();
        $queryItems = $reportSegmentFilter->transform($request);

        $query = QueryBuilder::for(ReportSegment::class)
            ->allowedSorts([
                'id',
                'report_id',
                'segment_id',
                'level',
                'type',
                'rate',
                'comment',
                'created_at',
                'updated_at',
            ]);

        foreach ($queryItems as $filter) {
            $query->where($filter[0], $filter[1], $filter[2]);
        }

        if ($request->has('limit')) {
            $reportSegment = $query->paginate($request->query('limit'));
        } else {
            $reportSegment = $query->paginate();
        }

        $reportSegment->getCollection()->transform(function ($reportSegment) {
            return $reportSegment;
        });

        return ReportSegmentResource::collection($reportSegment);
    }

    public function show($id)
    {
        $reportSegmentId = ReportSegment::findOrFail($id);

        return new ReportSegmentResource($reportSegmentId);
    }
}

// "segmens": [
        //     {
        //         "id": "bd022fb4-1acf-470b-aa21-f53d06ea5aab",
        //         "report_id": "918659ef-f7e2-4463-8f85-c1b5e25bc499",
        //         "map_street_segmen_id": "7dc0710e-0314-44ac-8180-b04182a66cf7",
        //         "user_type": "PermukaanKasar",
        //         "user_level": "Ringan",
        //         "created_at": "2023-12-18T08:22:02.869+07:00",
        //         "updated_at": "2023-12-22T09:05:39.194+07:00",
        //         "photos": [
        //             {
        //                 "id": "d452b2d9-aaf9-4c98-b2d5-4edf3f99dba6",
        //                 "report_segmen_id": "bd022fb4-1acf-470b-aa21-f53d06ea5aab",
        //                 "filename": "image_cropper_1702862471190_image.jpg",
        //                 "abs_path": "https://roadreport-bucket.s3.ap-southeast-1.amazonaws.com/image/3bda1730f6_image_cropper_1702862471190_image.jpg",
        //                 "file_dump_id": "d807c66b-8441-425c-ab1e-e8511d0d3f7a",
        //                 "created_at": "2023-12-18T08:22:02.883+07:00",
        //                 "updated_at": "2023-12-18T08:22:02.883+07:00"
        //             }
        //         ],
        //         "segmen": {
        //             "id": "7dc0710e-0314-44ac-8180-b04182a66cf7",
        //             "map_street_section_id": "042a7dba-9895-4797-9c11-925a564fb4e2",
        //             "map_street_id": "4f8a8858-ce8a-4d59-bc2e-4d67e7f3cf40",
        //             "name": "Jalan Munif",
        //             "order": null,
        //             "geojson": "{\"type\":\"LineString\",\"coordinates\":[[112.526849201,-7.871532273],[112.526790813,-7.871532823]]}",
        //             "center_point": "{\"type\":\"Point\",\"coordinates\":[112.526669477,-7.871533965]}",
        //             "length": 10,
        //             "created_at": "2023-11-22T04:19:06.295+07:00",
        //             "updated_at": null
        //         }
        //     },
        //     {
        //         "id": "9daf0530-ecaf-4575-9560-80484a1fa056",
        //         "report_id": "918659ef-f7e2-4463-8f85-c1b5e25bc499",
        //         "map_street_segmen_id": "caac9ec1-5405-41ae-846e-d5d1663d2d0f",
        //         "user_type": "PermukaanKasar",
        //         "user_level": "Ringan",
        //         "created_at": "2023-12-18T08:22:02.891+07:00",
        //         "updated_at": "2023-12-22T09:05:49.178+07:00",
        //         "photos": [
        //             {
        //                 "id": "33ba3fe0-bbe4-43c3-bb47-c3f65d3cf09c",
        //                 "report_segmen_id": "9daf0530-ecaf-4575-9560-80484a1fa056",
        //                 "filename": "image_cropper_1702862486349_image.jpg",
        //                 "abs_path": "https://roadreport-bucket.s3.ap-southeast-1.amazonaws.com/image/9ae7dc0b3c_image_cropper_1702862486349_image.jpg",
        //                 "file_dump_id": "85134ce7-c932-4db5-a5e8-5e68b7e87f2e",
        //                 "created_at": "2023-12-18T08:22:02.896+07:00",
        //                 "updated_at": "2023-12-18T08:22:02.896+07:00"
        //             }
        //         ],
        //         "segmen": {
        //             "id": "caac9ec1-5405-41ae-846e-d5d1663d2d0f",
        //             "map_street_section_id": "042a7dba-9895-4797-9c11-925a564fb4e2",
        //             "map_street_id": "4f8a8858-ce8a-4d59-bc2e-4d67e7f3cf40",
        //             "name": "Jalan Munif",
        //             "order": null,
        //             "geojson": "{\"type\":\"LineString\",\"coordinates\":[[112.526669546,-7.871533964],[112.526611158,-7.871534514]]}",
        //             "center_point": "{\"type\":\"Point\",\"coordinates\":[112.526669477,-7.871533965]}",
        //             "length": 10,
        //             "created_at": "2023-11-22T04:19:06.295+07:00",
        //             "updated_at": null
        //         }
        //     }
        // ],
