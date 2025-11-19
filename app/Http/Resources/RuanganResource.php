<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RuanganResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_ruangan' => $this->nama_ruangan,
            'kode_ruangan' => $this->kode_ruangan,
            'deskripsi' => $this->deskripsi,
            'kapasitas' => $this->kapasitas,
            'lokasi' => $this->lokasi,
            'status' => $this->status,
            'foto_url' => $this->foto ? url('uploads/ruangan/' . $this->foto) : null, // Menghasilkan URL lengkap
        ];
    }
}