<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        // category slug from query string, e.g. ?category=baby
        $slug = $request->query('category', 'baby');

        // load mapping from config/gallery.php
        $all = config('gallery.images', []);

        // map some common slugs to config keys
        $slugMap = [
            'baby' => 'baby',
            'birthday' => 'birthday',
            'prewed' => 'prewed',
            'graduation' => 'graduation',
            'family' => 'family',
            'couple' => 'couple',
        ];

        $key = $slugMap[$slug] ?? 'baby';

        $images = $all[$key] ?? [];

        // Title / subtitle simple mapping
        $titles = [
            'baby' => 'Galeri Foto Baby',
            'birthday' => 'Galeri Foto Birthday',
            'prewed' => 'Galeri Foto Prewed',
            'graduation' => 'Galeri Foto Graduation',
            'family' => 'Galeri Foto Family',
            'couple' => 'Galeri Foto Couple',
        ];

        $title = $titles[$key] ?? 'Galeri Foto';
        $subtitle = 'Koleksi foto terbaik dari Vanillablue Photostudio';

        return view('galeri.viewgaleri', compact('title', 'subtitle', 'images'));
    }
}
