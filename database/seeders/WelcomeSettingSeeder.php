<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WelcomeSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // ── GENERAL / BRAND ──────────────────────────────────────
            ['key' => 'brand_name',       'value' => 'GENMIM',              'type' => 'text',    'group' => 'general', 'label' => 'Nama Brand'],
            ['key' => 'brand_tagline',    'value' => 'Travel & Tour',       'type' => 'text',    'group' => 'general', 'label' => 'Tagline Brand'],
            ['key' => 'brand_since',      'value' => '2009',                'type' => 'text',    'group' => 'general', 'label' => 'Berdiri Sejak'],
            ['key' => 'brand_logo',       'value' => null,                  'type' => 'image',   'group' => 'general', 'label' => 'Logo (opsional)'],

            // ── ABOUT ────────────────────────────────────────────────
            ['key' => 'about_title',      'value' => 'Mitra Ibadah Terpercaya Sejak 2009', 'type' => 'text', 'group' => 'about', 'label' => 'Judul About'],
            ['key' => 'about_text1',      'value' => 'GENMIM Travel hadir dengan komitmen penuh untuk memberikan layanan ibadah Umroh dan Haji yang berkualitas, aman, dan nyaman. Kami percaya setiap muslim berhak mendapatkan pengalaman spiritual terbaik dalam perjalanan sucinya.', 'type' => 'textarea', 'group' => 'about', 'label' => 'Paragraf 1 About'],
            ['key' => 'about_text2',      'value' => 'Dengan tim yang berpengalaman, pembimbing ibadah bersertifikat, dan armada transportasi modern, kami telah membantu lebih dari 12.000 jamaah mewujudkan impian mereka.', 'type' => 'textarea', 'group' => 'about', 'label' => 'Paragraf 2 About'],
            ['key' => 'about_image',      'value' => null,                  'type' => 'image',   'group' => 'about', 'label' => 'Foto About'],
            ['key' => 'about_badge_num',  'value' => '15+',                 'type' => 'text',    'group' => 'about', 'label' => 'Badge Angka (misal: 15+)'],
            ['key' => 'about_badge_label', 'value' => 'TAHUN AMANAH',       'type' => 'text',    'group' => 'about', 'label' => 'Badge Label'],

            // ── STATS ────────────────────────────────────────────────
            ['key' => 'stat1_num',   'value' => '15+',      'type' => 'text', 'group' => 'stats', 'label' => 'Stat 1 - Angka'],
            ['key' => 'stat1_label', 'value' => 'Tahun Pengalaman', 'type' => 'text', 'group' => 'stats', 'label' => 'Stat 1 - Label'],
            ['key' => 'stat2_num',   'value' => '12.000+',  'type' => 'text', 'group' => 'stats', 'label' => 'Stat 2 - Angka'],
            ['key' => 'stat2_label', 'value' => 'Jamaah Diberangkatkan', 'type' => 'text', 'group' => 'stats', 'label' => 'Stat 2 - Label'],
            ['key' => 'stat3_num',   'value' => '98%',      'type' => 'text', 'group' => 'stats', 'label' => 'Stat 3 - Angka'],
            ['key' => 'stat3_label', 'value' => 'Tingkat Kepuasan', 'type' => 'text', 'group' => 'stats', 'label' => 'Stat 3 - Label'],
            ['key' => 'stat4_num',   'value' => '50+',      'type' => 'text', 'group' => 'stats', 'label' => 'Stat 4 - Angka'],
            ['key' => 'stat4_label', 'value' => 'Pembimbing Bersertifikat', 'type' => 'text', 'group' => 'stats', 'label' => 'Stat 4 - Label'],

            // ── CONTACT ──────────────────────────────────────────────
            ['key' => 'contact_phone',    'value' => '+62 21 1234 5678',           'type' => 'text', 'group' => 'contact', 'label' => 'Nomor Telepon'],
            ['key' => 'contact_wa',       'value' => '+62 812 3456 7890',          'type' => 'text', 'group' => 'contact', 'label' => 'WhatsApp'],
            ['key' => 'contact_wa_link',  'value' => '628123456789',               'type' => 'text', 'group' => 'contact', 'label' => 'WhatsApp Link (angka saja)'],
            ['key' => 'contact_email',    'value' => 'info@genmimtravel.co.id',    'type' => 'text', 'group' => 'contact', 'label' => 'Email'],
            ['key' => 'contact_address',  'value' => 'Jl. Sudirman No. 123, Jakarta Pusat', 'type' => 'text', 'group' => 'contact', 'label' => 'Alamat'],

            // ── SEO ──────────────────────────────────────────────────
            ['key' => 'seo_title',        'value' => 'GENMIM Travel & Tour - Paket Umroh & Haji Terpercaya', 'type' => 'text', 'group' => 'seo', 'label' => 'SEO Title'],
            ['key' => 'seo_description',  'value' => 'GENMIM Travel hadir dengan paket Umroh dan Haji terbaik, berpengalaman 15 tahun melayani 12.000+ jamaah.', 'type' => 'textarea', 'group' => 'seo', 'label' => 'SEO Description'],
        ];

        foreach ($settings as $setting) {
            DB::table('welcome_settings')->updateOrInsert(
                ['key' => $setting['key']],
                array_merge($setting, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        // ── DEFAULT PACKAGES ─────────────────────────────────────────
        $packages = [
            ['jenis' => 'umroh', 'name' => 'Paket Hemat',   'badge' => null,             'is_featured' => false, 'price' => 'Rp 25.000.000', 'duration' => '10 Hari 9 Malam',  'hotel' => 'Hotel Bintang 3', 'features' => json_encode(['Tiket PP + Visa Umroh', 'Hotel dekat Masjid', 'Muthawif berpengalaman', 'Ziarah Madinah', 'Perlengkapan Ihram']), 'sort_order' => 1],
            ['jenis' => 'umroh', 'name' => 'Paket Reguler', 'badge' => 'Paling Diminati', 'is_featured' => true,  'price' => 'Rp 32.000.000', 'duration' => '12 Hari 11 Malam', 'hotel' => 'Hotel Bintang 4', 'features' => json_encode(['Semua di Paket Hemat', 'Hotel Premium zone 1', 'City tour Mekah & Madinah', 'Manasik intensif', 'Souvenir eksklusif', 'Full asuransi jiwa']), 'sort_order' => 2],
            ['jenis' => 'umroh', 'name' => 'Paket VIP',     'badge' => null,             'is_featured' => false, 'price' => 'Rp 48.000.000', 'duration' => '14 Hari 13 Malam', 'hotel' => 'Hotel Bintang 5', 'features' => json_encode(['Semua di Paket Reguler', 'Hotel tower Abraj Al Bait', 'Private muthawif', 'Dinner gala malam', 'First Class experience', 'Concierge 24 jam']), 'sort_order' => 3],
            ['jenis' => 'haji',  'name' => 'Haji Plus',     'badge' => null,             'is_featured' => false, 'price' => 'Rp 135.000.000', 'duration' => '±30 Hari',         'hotel' => 'Hotel Bintang 4', 'features' => json_encode(['Antrian relatif cepat 8-9 th', 'Visa ONH Plus resmi', 'Hotel zona nyaman', 'Pembimbing ibadah', 'Perlengkapan haji lengkap']), 'sort_order' => 1],
            ['jenis' => 'haji',  'name' => 'Haji Furoda',   'badge' => 'Tanpa Antri',    'is_featured' => true,  'price' => 'Rp 210.000.000', 'duration' => '±30 Hari',         'hotel' => 'Hotel Bintang 5', 'features' => json_encode(['Visa Furoda — berangkat tahun ini', 'Hotel premium Mekah & Madinah', 'Full akomodasi mewah', 'Tim pembimbing khusus', 'Layanan premium door-to-door']), 'sort_order' => 2],
        ];

        foreach ($packages as $pkg) {
            DB::table('welcome_packages')->updateOrInsert(
                ['jenis' => $pkg['jenis'], 'name' => $pkg['name']],
                array_merge($pkg, ['is_active' => true, 'created_at' => now(), 'updated_at' => now()])
            );
        }

        // ── DEFAULT SLIDES ───────────────────────────────────────────
        $slides = [
            ['badge' => '✦ Perjalanan Suci Menuju Tanah Haram ✦', 'title' => 'Wujudkan Impian <span class="gold-text">Ibadah Umroh</span> & Haji Anda', 'description' => 'Kami hadir membimbing perjalanan ibadah Anda dengan pelayanan terbaik, pengalaman lebih dari <strong>15 tahun</strong>, dan lebih dari <strong>12.000 jamaah</strong> yang telah kami antarkan ke Tanah Suci.', 'btn_primary_text' => 'Lihat Paket Umroh ✦', 'btn_secondary_text' => 'Tentang Kami', 'stats' => json_encode([['num' => '15+', 'label' => 'Tahun Pengalaman'], ['num' => '12K+', 'label' => 'Jamaah Terkirim'], ['num' => '98%', 'label' => 'Kepuasan Jamaah']]), 'overlay_color' => 'rgba(7,45,27,0.87)', 'bg_color' => '#1a4a2e', 'sort_order' => 1],
            ['badge' => '✦ Paket Haji Plus & Furoda Tersedia ✦', 'title' => 'Raih <span class="gold-text">Panggilan Allah</span> ke Baitullah', 'description' => 'Daftar sekarang untuk paket Haji Plus & Furoda kami. Berangkat lebih cepat dengan <strong>visa Furoda</strong>, tanpa antrean panjang.', 'btn_primary_text' => 'Lihat Paket Haji ✦', 'btn_secondary_text' => 'Konsultasi Gratis', 'stats' => json_encode([['num' => '50+', 'label' => 'Pembimbing Bersertifikat'], ['num' => '5★', 'label' => 'Hotel Premium'], ['num' => '100%', 'label' => 'Izin Resmi Kemenag']]), 'overlay_color' => 'rgba(6,21,41,0.90)', 'bg_color' => '#061529', 'sort_order' => 2],
            ['badge' => '✦ Manasik Intensif & Bimbingan Penuh ✦', 'title' => 'Ibadah Lebih <span class="gold-text">Khusyu & Sempurna</span> Bersama Kami', 'description' => 'Program manasik intensif, pembimbing ustadz berpengalaman, dan dukungan <strong>24/7</strong> memastikan setiap langkah ibadah Anda bermakna.', 'btn_primary_text' => 'Keunggulan Kami ✦', 'btn_secondary_text' => 'Lihat Semua Paket', 'stats' => json_encode([['num' => '25:1', 'label' => 'Rasio Jamaah:Muthawif'], ['num' => '24/7', 'label' => 'Dukungan Perjalanan'], ['num' => '✓', 'label' => 'Asuransi Jiwa Penuh']]), 'overlay_color' => 'rgba(13,59,74,0.90)', 'bg_color' => '#0d3b4a', 'sort_order' => 3],
        ];

        foreach ($slides as $slide) {
            DB::table('welcome_slides')->updateOrInsert(
                ['sort_order' => $slide['sort_order']],
                array_merge($slide, ['is_active' => true, 'created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
