<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan baris ini

class RuanganController extends Controller
{
    public function index()
    {
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();
        return view('ruangan.index', compact('ruangans'));
    }

    public function create()
    {
        // Hanya administrator yang bisa menambah ruangan
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        return view('ruangan.create');
    }

    public function store(Request $request)
    {
        // Hanya administrator yang bisa menambah ruangan
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'kode_ruangan' => 'required|string|max:50|unique:ruangans',
            'deskripsi' => 'nullable|string',
            'kapasitas' => 'required|integer|min:1',
            'lokasi' => 'required|string|max:255',
            'status' => 'required|in:tersedia,tidak_tersedia',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ruangan'), $filename);
            $data['foto'] = $filename;
        }

        Ruangan::create($data);

        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function show(Ruangan $ruangan)
    {
        return view('ruangan.show', compact('ruangan'));
    }

    public function edit(Ruangan $ruangan)
    {
        // Hanya administrator yang bisa mengedit ruangan
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        return view('ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        // Hanya administrator yang bisa mengedit ruangan
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'kode_ruangan' => 'required|string|max:255|unique:ruangans,kode_ruangan,' . $ruangan->id,
            'deskripsi' => 'nullable|string',
            'kapasitas' => 'required|integer|min:1',
            'lokasi' => 'required|string|max:255',
            'status' => 'required|in:tersedia,tidak_tersedia',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($ruangan->foto && file_exists(public_path('uploads/ruangan/' . $ruangan->foto))) {
                unlink(public_path('uploads/ruangan/' . $ruangan->foto));
            }
            
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ruangan'), $filename);
            $data['foto'] = $filename;
        }

        $ruangan->update($data);

        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(Ruangan $ruangan)
    {
        // Hanya administrator yang bisa menghapus ruangan
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if room has active bookings
        if ($ruangan->peminjamans()->whereIn('status', ['menunggu', 'disetujui'])->exists()) {
            return back()->with('error', 'Tidak dapat menghapus ruangan yang memiliki peminjaman aktif.');
        }

        // Delete photo
        if ($ruangan->foto && file_exists(public_path('uploads/ruangan/' . $ruangan->foto))) {
            unlink(public_path('uploads/ruangan/' . $ruangan->foto));
        }

        $ruangan->delete();

        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil dihapus.');
    }
}