<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index($id)
    {
        $paket = Paket::find($id);
        if (!$paket) {
            return redirect()->route('listharga')->with('error', 'Paket tidak ditemukan');
        }

        return view('booking', compact('paket'));
    }

    // Method store untuk menyimpan data booking
    public function store(Request $request)
    {
        $request->validate([
            'paket_id' => 'required|exists:bundlings,id',
            'nama' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'jam' => 'required',
            'tanggal' => 'required|date',
            'tipe' => 'required|in:indoor,outdoor',
            'sum_order' => 'nullable|integer|min:1',
            'note' => 'nullable|string|max:255'
        ]);

        $paket = Paket::findOrFail($request->paket_id);

        $order = Order::create([
            'customer_id' => Auth::id(),
            'bundling_id' => $paket->id,
            'book_date' => $request->tanggal,
            'book_time' => $request->jam,
            'location' => $request->tipe,
            'note' => $request->note ?? null,
            'order_status' => 'unpaid',
            'total_price' => $paket->price_bundling * ($request->sum_order ?? 1),
            'sum_order' => $request->sum_order ?? 1,
            'nama' => $request->nama,
            'no_wa' => $request->no_wa
        ]);

        return redirect()->back()->with('success', 'Booking berhasil!');
    }

}
