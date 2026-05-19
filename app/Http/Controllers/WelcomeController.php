<?php

namespace App\Http\Controllers;

use App\Models\WelcomeSetting;
use App\Models\WelcomePackage;
use App\Models\WelcomeSlide;

class WelcomeController extends Controller
{
    /**
     * Halaman publik / landing page.
     * Mengirim semua data yang dibutuhkan welcome.blade.php
     */
    public function index()
    {
        $settings = WelcomeSetting::allAsArray();
        $slides   = WelcomeSlide::orderBy('sort_order')->get();
        $umroh    = WelcomePackage::umroh()->orderBy('sort_order')->get();
        $haji     = WelcomePackage::haji()->orderBy('sort_order')->get();

        return view('welcome', compact('settings', 'slides', 'umroh', 'haji'));
    }
}
