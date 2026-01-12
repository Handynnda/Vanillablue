<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bundling;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index($id)
    {
        $paket = Bundling::find($id);
        if (!$paket) {
            return redirect()->route('listharga')->with('error', 'Paket tidak ditemukan');
        }

        // Ambil jam yang sudah dipesan untuk validasi awal (opsional)
        // Untuk fitur disable yang akurat, sebaiknya dipadukan dengan filter tanggal
        $bookedSlots = Order::select('book_time', 'book_date', 'location')->get();

        return view('booking', compact('paket', 'bookedSlots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paket_id' => 'required|exists:bundlings,id',
            'nama' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'jam' => 'required',
            'tanggal' => 'required|date|after_or_equal:today',
            'tipe' => 'required|in:indoor,outdoor',
            'note' => 'nullable|string|max:255'
        ]);

        if (!Auth::check()) return redirect()->route('login');

        $isBooked = Order::where('book_date', $request->tanggal)
                        ->where('book_time', $request->jam)
                        ->where('location', $request->tipe)
                        ->exists();


        if ($isBooked) {
            return back()->withInput()->with('error', 'Maaf, jam tersebut baru saja dipesan orang lain.');
        }

        $paket = Bundling::findOrFail($request->paket_id);

        $order = Order::create([
            'customer_id' => Auth::user()->id, 
            'bundling_id' => $paket->id,
            'book_date'   => $request->tanggal,
            'book_time'   => $request->jam,
            'location'    => $request->tipe,
            'order_status'=> 'pending',
            'total_price' => $paket->price_bundling,    
            'name'        => $request->nama, 
            'phone'       => $request->no_wa,
            'note'        => $request->note,
            'sum_order'   => 1
        ]);

        return redirect()->route('payment.create', ['order' => $order->id]);
    }
}