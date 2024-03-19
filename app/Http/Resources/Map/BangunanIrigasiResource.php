<?php

namespace App\Http\Resources\Map;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BangunanIrigasiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $data = [
            'id' => $this->id,
            'nama_bangunan' => $this->nama_bangunan,
            'tipe_saluran' => $this->tipe_saluran,
            'jarak' => $this->jarak,
            'b_saluran  ' => $this->b_saluran,
            'sempadan_kanan ' => $this->sempadan_kanan,
            'sempadan_kiri' => $this->sempadan_kiri,
            'luas_saluran' => $this->luas_saluran,
            'sisi_terluar_kanan' => $this->sisi_terluar_kanan,
            'sisi_terluar_kiri' => $this->sisi_terluar_kiri,
            'saluran_kanan' => $this->saluran_kanan,
            'saluran_panjang_kanan' => $this->saluran_panjang_kanan,
            'saluran_kiri' => $this->saluran_kiri,
            'saluran_panjang_kiri' => $this->saluran_panjang_kiri,
            'keterangan' => $this->keterangan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'geojson' => $this->geojson
        ];

        return $data;
    }
}
