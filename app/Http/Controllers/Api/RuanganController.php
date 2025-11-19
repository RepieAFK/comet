<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RuanganResource;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangans = Ruangan::all();
        return RuanganResource::collection($ruangans);
    }

    public function show(Ruangan $ruangan)
    {
        return new RuanganResource($ruangan);
    }
}