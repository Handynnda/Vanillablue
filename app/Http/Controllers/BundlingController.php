<?php

namespace App\Http\Controllers;

use App\Models\Bundling;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class BundlingController extends Controller
{
    // Tampilkan daftar bundling ke view listharga
    public function index()
    {
        $categories = [
            'Baby & Kids','Birthday','Maternity','Prewed','Graduation','Family',
            'Group','Couple','Personal','Pas Foto','Print & Frame'
        ];

        $categoryData = collect($categories)->map(fn($c) => ['label'=>$c,'slug'=>Str::slug($c)]);

        $requestedSlug = request('category');
        $validSlugs = $categoryData->pluck('slug')->all();
        $activeSlug = in_array($requestedSlug, $validSlugs) ? $requestedSlug : $categoryData->first()['slug'];
        $activeLabel = $categoryData->firstWhere('slug', $activeSlug)['label'];

        $query = Bundling::orderBy('name_bundling');

        if (Schema::hasColumn('bundlings','category')) {
            // cari fleksibel: exact, lower, slug, fallback ke name_bundling
            $query->where(function($q) use ($activeLabel, $activeSlug) {
                $q->where('category', $activeLabel)
                  ->orWhereRaw('LOWER(category) = ?', [Str::lower($activeLabel)])
                  ->orWhereRaw('REPLACE(LOWER(category)," ", "-") = ?', [$activeSlug])
                  ->orWhereRaw('REPLACE(LOWER(name_bundling)," ", "-") = ?', [$activeSlug]);
            });
        } elseif (Schema::hasColumn('bundlings','category_bundling')) {
            $query->where(function($q) use ($activeLabel, $activeSlug) {
                $q->where('category_bundling', $activeLabel)
                  ->orWhereRaw('LOWER(category_bundling) = ?', [Str::lower($activeLabel)])
                  ->orWhereRaw('REPLACE(LOWER(category_bundling)," ", "-") = ?', [$activeSlug])
                  ->orWhereRaw('REPLACE(LOWER(name_bundling)," ", "-") = ?', [$activeSlug]);
            });
        } else {
            // tidak ada kolom kategori — tampilkan semua (opsi awal)
        }

        $bundlings = $query->get()->map(function ($b) {
            $b->desc_items = Bundling::parseDescription($b->description_bundling);
            return $b;
        });

        return view('listharga', [
            'bundlings'   => $bundlings,
            'categories'  => $categoryData,
            'activeSlug'  => $activeSlug,
        ]);
    }

    // (opsional) detail bundling
    public function show($id)
    {
        $bundling = Bundling::findOrFail($id);
        return view('bundlings.show', compact('bundling'));
    }
}
