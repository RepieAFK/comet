<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        // Hanya administrator yang bisa mengakses semua method di controller ini
        $this->middleware('role:administrator');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:administrator,petugas,peminjam',
            'nomor_induk' => 'required|string|max:50|unique:users',
            'telepon' => 'nullable|string|max:20',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'nomor_induk' => $request->nomor_induk,
            'telepon' => $request->telepon,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $totalPeminjaman = Peminjaman::where('user_id', $user->id)->count();
        $recentPeminjaman = Peminjaman::with('ruangan')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('users.show', compact('user', 'totalPeminjaman', 'recentPeminjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $isSelf = Auth::user()->id === $user->id;

        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'nomor_induk' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users')->ignore($user->id),
            ],
            'telepon' => 'nullable|string|max:20',
        ];

        // Role hanya bisa diubah jika bukan diri sendiri
        if (!$isSelf) {
            $rules['role'] = 'required|in:administrator,petugas,peminjam';
        }

        // Password hanya wajib jika diisi
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($rules);

        $data = $request->all();
        
        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        // Update role hanya jika bukan diri sendiri
        if (!$isSelf) {
            $data['role'] = $request->role;
        } else {
            unset($data['role']); // Jangan ubah role diri sendiri
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Cegah admin menghapus dirinya sendiri
        if (Auth::user()->id === $user->id) {
            return back()->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        // Cek apakah user memiliki peminjaman aktif
        if ($user->peminjamans()->whereIn('status', ['menunggu', 'disetujui'])->exists()) {
            return back()->with('error', 'Tidak dapat menghapus user yang memiliki peminjaman aktif.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}