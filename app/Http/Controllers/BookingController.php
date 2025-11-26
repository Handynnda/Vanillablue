<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bundling;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index($id)
    {
        $paket = Bundling::find($id);
        if (!$paket) {
            return redirect()->route('listharga')->with('error', 'Paket tidak ditemukan');
        }

        return view('booking', compact('paket'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'paket_id' => 'required|exists:bundlings,id',
        'nama' => 'required|string|max:255',
        'no_wa' => 'required|string|max:20',
        'jam' => 'required',
        'tanggal' => 'required|date',
        'tipe' => 'required|in:indoor,outdoor',
    ]);

        $paket = Bundling::findOrFail($request->paket_id);

        $order = Order::create([
            'customer_id' => Auth::id(),
            'bundling_id' => $paket->id,
            'book_date'   => $request->tanggal,
            'book_time'   => $request->jam,
            'location'    => $request->tipe,
            'order_status'=> 'unpaid',
            'total_price' => $paket->price_bundling * ($request->sum_order ?? 1),
            'name'        => $request->nama, 
            'phone'       => $request->no_wa 
        ]);

        return redirect()->back()->with('success', 'Booking berhasil!');
    }
}
