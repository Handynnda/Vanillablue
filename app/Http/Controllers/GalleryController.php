<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Bundling;

class GalleryController extends Controller
{
    /**
     * Menampilkan galeri berdasarkan slug kategori (opsional).
     * Route: /galeri/{slug?} dengan default 'baby'.
     */
    public function index(?string $slug = null)
    {
        $slug = $slug ?? request()->query('category', 'baby');

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

        $enumCategory = $categoryMap[$slug]
            ?? match ($slug) {
                'pasfoto','pas_foto' => 'Pas Foto',
                'print','printframe','print_frame' => 'Print & Frame',
                default => ucfirst(str_replace(['-','_'], ' ', $slug)),
            };

        $allowed = array_values($categoryMap);
        $allowed[] = 'Baby & Kids';
        if (!in_array($enumCategory, $allowed, true)) {
            $enumCategory = 'Baby & Kids';
        }

        $images = Image::query()
            ->select('url_image')
            ->where('category', $enumCategory)
            ->whereNotNull('url_image')
            ->groupBy('url_image')
            ->orderByRaw('MAX(id) DESC')
            ->pluck('url_image');

        $title = 'Galeri Foto ' . $enumCategory;
        $subtitle = 'Koleksi foto kategori ' . $enumCategory . ' dari Vanillablue Photostudio';

        // Ambil paket / bundling yang kait dengan kategori ini
        $packages = Bundling::where('category', $enumCategory)
            ->orderBy('price_bundling')
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name_bundling,
                    'price' => $p->price_bundling,
                    'description' => Bundling::parseDescription($p->description_bundling),
                ];
            });

        return view('galeri.viewgaleri', compact('title', 'subtitle', 'images', 'enumCategory', 'packages'));
    }
}
