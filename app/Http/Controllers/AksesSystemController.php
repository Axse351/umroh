<?php

namespace App\Http\Controllers;

use App\Models\AksesSystem;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AksesSystemController extends Controller
{
    public function index()
    {
        $akses = AksesSystem::with('user', 'karyawan')->latest()->paginate(10);
        return view('akses-system.index', compact('akses'));
    }

    public function create()
    {
        $karyawans = Karyawan::where('status', 'aktif')
            ->doesntHave('aksesSystem')->get();
        return view('akses-system.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id'  => 'required|exists:karyawans,id',
            'email'        => 'required|email|unique:users',
            'password'     => 'required|min:8|confirmed',
            'role'         => 'required|in:superadmin,admin,kasir,marketing,gudang,viewer',
            'permissions'  => 'nullable|array',
            'status'       => 'required|in:aktif,nonaktif',
        ]);

        $karyawan = Karyawan::findOrFail($request->karyawan_id);

        $user = User::create([
            'name'     => $karyawan->nama_lengkap,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        AksesSystem::create([
            'user_id'     => $user->id,
            'karyawan_id' => $request->karyawan_id,
            'role'        => $request->role,
            'permissions' => $request->permissions,
            'status'      => $request->status,
        ]);

        return redirect()->route('akses-system.index')->with('success', 'Akses sistem berhasil dibuat.');
    }

    public function show(AksesSystem $aksesSystem)
    {
        $aksesSystem->load('user', 'karyawan');
        return view('akses-system.show', compact('aksesSystem'));
    }

    public function edit(AksesSystem $aksesSystem)
    {
        $aksesSystem->load('user', 'karyawan');
        return view('akses-system.edit', compact('aksesSystem'));
    }

    public function update(Request $request, AksesSystem $aksesSystem)
    {
        $request->validate([
            'role'        => 'required|in:superadmin,admin,kasir,marketing,gudang,viewer',
            'permissions' => 'nullable|array',
            'status'      => 'required|in:aktif,nonaktif',
            'password'    => 'nullable|min:8|confirmed',
        ]);

        $aksesSystem->update([
            'role'        => $request->role,
            'permissions' => $request->permissions,
            'status'      => $request->status,
        ]);

        if ($request->filled('password')) {
            $aksesSystem->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('akses-system.index')->with('success', 'Akses sistem berhasil diperbarui.');
    }

    public function destroy(AksesSystem $aksesSystem)
    {
        $aksesSystem->user->delete();
        $aksesSystem->delete();
        return redirect()->route('akses-system.index')->with('success', 'Akses sistem berhasil dihapus.');
    }
}
