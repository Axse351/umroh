<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WelcomeSetting;
use App\Models\WelcomePackage;
use App\Models\WelcomeSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WelcomeSettingController extends Controller
{
    /* ================================================================
     |  INDEX — Tampilkan halaman CMS admin (bukan welcome publik!)
     * ================================================================ */
    public function index()
    {
        $settings = WelcomeSetting::allAsArray();
        $slides   = WelcomeSlide::orderBy('sort_order')->get();
        $umroh    = WelcomePackage::umroh()->orderBy('sort_order')->get();
        $haji     = WelcomePackage::haji()->orderBy('sort_order')->get();

        // ✅ View admin CMS, BUKAN welcome.blade.php
        return view('admin.welcome-setting.index', compact('settings', 'slides', 'umroh', 'haji'));
    }

    /* ================================================================
     |  UPDATE GENERAL SETTINGS (brand, about, stats, contact, seo)
     * ================================================================ */
    public function updateGeneral(Request $request)
    {
        $request->validate([
            'brand_name'        => 'required|string|max:100',
            'brand_tagline'     => 'required|string|max:100',
            'brand_since'       => 'required|string|max:10',
            'about_title'       => 'required|string|max:200',
            'about_text1'       => 'required|string',
            'about_text2'       => 'required|string',
            'about_badge_num'   => 'required|string|max:20',
            'about_badge_label' => 'required|string|max:50',
            'stat1_num'         => 'required|string|max:20',
            'stat1_label'       => 'required|string|max:50',
            'stat2_num'         => 'required|string|max:20',
            'stat2_label'       => 'required|string|max:50',
            'stat3_num'         => 'required|string|max:20',
            'stat3_label'       => 'required|string|max:50',
            'stat4_num'         => 'required|string|max:20',
            'stat4_label'       => 'required|string|max:50',
            'contact_phone'     => 'required|string|max:30',
            'contact_wa'        => 'required|string|max:30',
            'contact_wa_link'   => 'required|string|max:30',
            'contact_email'     => 'required|email|max:100',
            'contact_address'   => 'required|string|max:200',
            'seo_title'         => 'required|string|max:200',
            'seo_description'   => 'required|string',
            'brand_logo'        => 'nullable|image|max:2048',
            'about_image'       => 'nullable|image|max:5120',
        ]);

        // Upload brand_logo
        if ($request->hasFile('brand_logo')) {
            $old = WelcomeSetting::get('brand_logo');
            if ($old) Storage::disk('public')->delete($old);
            $path = $request->file('brand_logo')->store('welcome', 'public');
            WelcomeSetting::set('brand_logo', $path);
        }

        // Upload about_image
        if ($request->hasFile('about_image')) {
            $old = WelcomeSetting::get('about_image');
            if ($old) Storage::disk('public')->delete($old);
            $path = $request->file('about_image')->store('welcome', 'public');
            WelcomeSetting::set('about_image', $path);
        }

        // Simpan semua field text
        $textFields = [
            'brand_name',
            'brand_tagline',
            'brand_since',
            'about_title',
            'about_text1',
            'about_text2',
            'about_badge_num',
            'about_badge_label',
            'stat1_num',
            'stat1_label',
            'stat2_num',
            'stat2_label',
            'stat3_num',
            'stat3_label',
            'stat4_num',
            'stat4_label',
            'contact_phone',
            'contact_wa',
            'contact_wa_link',
            'contact_email',
            'contact_address',
            'seo_title',
            'seo_description',
        ];

        foreach ($textFields as $field) {
            WelcomeSetting::set($field, $request->input($field));
        }

        return back()->with('success', 'Pengaturan umum berhasil disimpan.');
    }

    /* ================================================================
     |  SLIDES — Create / Update / Delete / Reorder
     * ================================================================ */
    public function storeSlide(Request $request)
    {
        $data = $request->validate([
            'badge'              => 'required|string|max:200',
            'title'              => 'required|string',
            'description'        => 'required|string',
            'btn_primary_text'   => 'nullable|string|max:100',
            'btn_secondary_text' => 'nullable|string|max:100',
            'overlay_color'      => 'nullable|string|max:50',
            'bg_color'           => 'nullable|string|max:20',
            'image'              => 'nullable|image|max:5120',
            'stats'              => 'nullable|array',
            'stats.*.num'        => 'nullable|string|max:20',
            'stats.*.label'      => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('welcome/slides', 'public');
        }

        $data['stats'] = collect($request->input('stats', []))
            ->filter(fn($s) => !empty($s['num']) && !empty($s['label']))
            ->values()
            ->toArray();

        $data['sort_order'] = WelcomeSlide::max('sort_order') + 1;

        WelcomeSlide::create($data);

        return back()->with('success', 'Slide berhasil ditambahkan.');
    }

    public function updateSlide(Request $request, WelcomeSlide $slide)
    {
        $data = $request->validate([
            'badge'              => 'required|string|max:200',
            'title'              => 'required|string',
            'description'        => 'required|string',
            'btn_primary_text'   => 'nullable|string|max:100',
            'btn_secondary_text' => 'nullable|string|max:100',
            'overlay_color'      => 'nullable|string|max:50',
            'bg_color'           => 'nullable|string|max:20',
            'image'              => 'nullable|image|max:5120',
            'is_active'          => 'nullable|boolean',
            'stats'              => 'nullable|array',
            'stats.*.num'        => 'nullable|string|max:20',
            'stats.*.label'      => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('image')) {
            if ($slide->image) Storage::disk('public')->delete($slide->image);
            $data['image'] = $request->file('image')->store('welcome/slides', 'public');
        }

        $data['stats'] = collect($request->input('stats', []))
            ->filter(fn($s) => !empty($s['num']) && !empty($s['label']))
            ->values()
            ->toArray();

        $data['is_active'] = $request->boolean('is_active', true);

        $slide->update($data);

        return back()->with('success', 'Slide berhasil diperbarui.');
    }

    public function destroySlide(WelcomeSlide $slide)
    {
        if ($slide->image) Storage::disk('public')->delete($slide->image);
        $slide->delete();

        return back()->with('success', 'Slide berhasil dihapus.');
    }

    public function reorderSlides(Request $request)
    {
        $request->validate([
            'order'   => 'required|array',
            'order.*' => 'integer',
        ]);

        foreach ($request->order as $sort => $id) {
            WelcomeSlide::where('id', $id)->update(['sort_order' => $sort + 1]);
        }

        return response()->json(['success' => true]);
    }

    /* ================================================================
     |  PACKAGES — Create / Update / Delete
     * ================================================================ */
    public function storePackage(Request $request)
    {
        $data = $request->validate([
            'jenis'       => 'required|in:umroh,haji',
            'name'        => 'required|string|max:100',
            'badge'       => 'nullable|string|max:100',
            'is_featured' => 'nullable|boolean',
            'price'       => 'required|string|max:50',
            'duration'    => 'required|string|max:50',
            'hotel'       => 'required|string|max:100',
            'features'    => 'required|array|min:1',
            'features.*'  => 'required|string|max:200',
        ]);

        $data['features']    = array_values(array_filter($data['features']));
        $data['is_featured'] = $request->boolean('is_featured');
        $data['sort_order']  = WelcomePackage::where('jenis', $data['jenis'])->max('sort_order') + 1;

        WelcomePackage::create($data);

        return back()->with('success', 'Paket berhasil ditambahkan.');
    }

    public function updatePackage(Request $request, WelcomePackage $package)
    {
        $data = $request->validate([
            'jenis'       => 'required|in:umroh,haji',
            'name'        => 'required|string|max:100',
            'badge'       => 'nullable|string|max:100',
            'is_featured' => 'nullable|boolean',
            'price'       => 'required|string|max:50',
            'duration'    => 'required|string|max:50',
            'hotel'       => 'required|string|max:100',
            'features'    => 'required|array|min:1',
            'features.*'  => 'required|string|max:200',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['features']    = array_values(array_filter($data['features']));
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);

        $package->update($data);

        return back()->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroyPackage(WelcomePackage $package)
    {
        $package->delete();

        return back()->with('success', 'Paket berhasil dihapus.');
    }

    /* ================================================================
     |  HAPUS GAMBAR (brand_logo / about_image)
     * ================================================================ */
    public function deleteImage(Request $request)
    {
        $key         = $request->input('key');
        $allowedKeys = ['brand_logo', 'about_image'];

        if (in_array($key, $allowedKeys)) {
            $path = WelcomeSetting::get($key);
            if ($path) Storage::disk('public')->delete($path);
            WelcomeSetting::set($key, null);

            return back()->with('success', 'Gambar berhasil dihapus.');
        }

        return back()->with('error', 'Key tidak valid.');
    }
}
