<?php

namespace App\Http\Resources\Map;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'district_id' => $this->district_id,
            'sub_district_id' => $this->sub_district_id,
            'name' => $this->name,
            'type' => $this->type,
            'length' => $this->length,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'geojson' => $this->geojson
        ];
    }
}
