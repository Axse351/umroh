<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        $user = Auth::user();

        // Izinkan 'user' dan 'kolektor'
        if (!in_array($user->role, ['user', 'kolektor'])) {
            Auth::logout();
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak.',
            ], 403);
        }

        $user->tokens()->delete();
        $token = $user->createToken('flutter-app')->plainTextToken;

        // Untuk kolektor, tidak perlu data pendaftaran pribadi
        $pendaftaran = null;
        if ($user->role === 'user' && $user->jamaah_id) {
            $pendaftaran = Pendaftaran::where('jamaah_id', $user->jamaah_id)
                ->latest()->first();
        }

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data'    => [
                'token' => $token,
                'user'  => [
                    'id'              => $user->id,
                    'name'            => $user->name,
                    'email'           => $user->email,
                    'role'            => $user->role,           // ← flutter baca ini
                    'jamaah_id'       => $user->jamaah_id,
                    'saving_type'     => $pendaftaran?->jenis,
                    'registered_date' => $pendaftaran?->tanggal_daftar?->toDateString(),
                ],
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['success' => true, 'message' => 'Logout berhasil.']);
    }

    public function profile(Request $request)
    {
        $user = $request->user();

        $pendaftaran = null;
        if ($user->role === 'user' && $user->jamaah_id) {
            $pendaftaran = Pendaftaran::where('jamaah_id', $user->jamaah_id)
                ->latest()->first();
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'id'              => $user->id,
                'name'            => $user->name,
                'email'           => $user->email,
                'role'            => $user->role,
                'jamaah_id'       => $user->jamaah_id,
                'saving_type'     => $pendaftaran?->jenis,
                'registered_date' => $pendaftaran?->tanggal_daftar?->toDateString(),
            ],
        ]);
    }
}
