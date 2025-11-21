<?php

namespace App\Http\Controllers;

use App\Models\Image;

class GalleryController extends Controller
{
    /**
     * Menampilkan galeri berdasarkan slug kategori (opsional).
     * Route: /galeri/{slug?} dengan default 'baby'.
     */
    public function index(?string $slug = null)
    {
        $slug = $slug ?? request()->query('category', 'baby');

        // Pemetaan slug ke enum kategori di DB (nilai enum persis pada migrasi)
        $categoryMap = [
            'baby' => 'Baby & Kids',
            'birthday' => 'Birthday',
            'maternity' => 'Maternity',
            'prewed' => 'Prewed',
            'graduation' => 'Graduation',
            'family' => 'Family',
            'group' => 'Group',
            'couple' => 'Couple',
            'personal' => 'Personal',
            'pas-foto' => 'Pas Foto',
            'print-frame' => 'Print & Frame',
        ];

        // Normalisasi slug jika tidak ada di map: coba Title Case atau langsung
        $enumCategory = $categoryMap[$slug]
            ?? match ($slug) {
                'pasfoto','pas_foto' => 'Pas Foto',
                'print','printframe','print_frame' => 'Print & Frame',
                default => ucfirst(str_replace(['-','_'], ' ', $slug)),
            };

        // Pastikan fallback aman: jika tidak cocok salah satu enum, pakai default
        $allowed = array_values($categoryMap);
        $allowed[] = 'Baby & Kids';
        if (!in_array($enumCategory, $allowed, true)) {
            $enumCategory = 'Baby & Kids';
        }

        // Ambil url_image dari tabel images (koleksi bisa kosong jika belum ada data)
        $images = Image::where('category', $enumCategory)->orderByDesc('id')->pluck('url_image');

        $title = 'Galeri Foto ' . $enumCategory;
        $subtitle = 'Koleksi foto kategori ' . $enumCategory . ' dari Vanillablue Photostudio';

        return view('galeri.viewgaleri', compact('title', 'subtitle', 'images', 'enumCategory'));
    }
}
