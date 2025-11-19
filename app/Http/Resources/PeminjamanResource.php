<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PeminjamanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'ruangan' => new RuanganResource($this->whenLoaded('ruangan')),
            'waktu_mulai' => $this->waktu_mulai->format('Y-m-d H:i:s'),
            'waktu_selesai' => $this->waktu_selesai->format('Y-m-d H:i:s'),
            'keperluan' => $this->keperluan,
            'status' => $this->status,
            'catatan' => $this->catatan,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}