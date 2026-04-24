<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('setting.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_perusahaan'   => 'required|string|max:255',
            'alamat'            => 'nullable|string',
            'no_telepon'        => 'nullable|string|max:20',
            'email'             => 'nullable|email',
            'website'           => 'nullable|url',
            'dp_minimal_persen' => 'required|numeric|min:0|max:100',
            'logo'              => 'nullable|image|max:2048',
        ]);

        $keys = [
            'nama_perusahaan',
            'alamat',
            'no_telepon',
            'email',
            'website',
            'dp_minimal_persen',
        ];

        foreach ($keys as $key) {
            Setting::set($key, $request->$key);
        }

        if ($request->hasFile('logo')) {
            $logo = Setting::get('logo');
            if ($logo) Storage::disk('public')->delete($logo);
            $path = $request->file('logo')->store('setting', 'public');
            Setting::set('logo', $path);
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
