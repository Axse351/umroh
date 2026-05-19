<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jamaah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Daftar semua user (admin, kasir, kolektor, user)
     */
    public function index(Request $request)
    {
        $role   = $request->role;
        $search = $request->search;

        $users = User::with('jamaah')
            ->when(
                $search,
                fn($q) => $q
                    ->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
            )
            ->when($role, fn($q) => $q->where('role', $role))
            ->latest()
            ->paginate(15);

        $counts = [
            'all'      => User::count(),
            'admin'    => User::where('role', 'admin')->count(),
            'kasir'    => User::where('role', 'kasir')->count(),
            'kolektor' => User::where('role', 'kolektor')->count(),
            'user'     => User::where('role', 'user')->count(),
        ];

        return view('admin.user.index', compact('users', 'role', 'search', 'counts'));
    }

    /**
     * Form tambah user
     */
    public function create()
    {
        // Jamaah yang belum punya akun user
        $jamaahs = Jamaah::whereDoesntHave('user')->orderBy('nama_lengkap')->get();

        return view('admin.user.create', compact('jamaahs'));
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'role'       => 'required|in:admin,kasir,kolektor,user',
            'password'   => ['required', 'confirmed', Password::min(6)],
            'jamaah_id'  => 'nullable|exists:jamaah,id|unique:users,jamaah_id',
        ], [
            'jamaah_id.unique' => 'Jamaah ini sudah memiliki akun user.',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'password'  => Hash::make($request->password),
            'jamaah_id' => $request->role === 'user' ? $request->jamaah_id : null,
        ]);

        return redirect()
            ->route('admin.user.index')
            ->with('success', "User <strong>{$request->name}</strong> berhasil dibuat dengan role <strong>{$request->role}</strong>.");
    }

    /**
     * Detail user
     */
    public function show(User $user)
    {
        $user->load('jamaah.pendaftarans.keberangkatan.paket');
        return view('admin.user.show', compact('user'));
    }

    /**
     * Form edit user
     */
    public function edit(User $user)
    {
        $jamaahs = Jamaah::whereDoesntHave('user')
            ->orWhere('id', $user->jamaah_id)
            ->orderBy('nama_lengkap')
            ->get();

        return view('admin.user.edit', compact('user', 'jamaahs'));
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'role'      => 'required|in:admin,kasir,kolektor,user',
            'password'  => ['nullable', 'confirmed', Password::min(6)],
            'jamaah_id' => 'nullable|exists:jamaah,id|unique:users,jamaah_id,' . $user->id,
        ], [
            'jamaah_id.unique' => 'Jamaah ini sudah memiliki akun user.',
        ]);

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'jamaah_id' => $request->role === 'user' ? $request->jamaah_id : null,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('admin.user.index')
            ->with('success', "User <strong>{$user->name}</strong> berhasil diperbarui.");
    }

    /**
     * Hapus user (tidak bisa hapus diri sendiri)
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()
            ->route('admin.user.index')
            ->with('success', "User <strong>{$name}</strong> berhasil dihapus.");
    }

    /**
     * Reset password user ke password baru (quick action)
     */
    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'new_password' => ['required', Password::min(6)],
        ]);

        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', "Password user <strong>{$user->name}</strong> berhasil direset.");
    }
}
