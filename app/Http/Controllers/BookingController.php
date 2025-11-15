<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        // sementara cuma tampilkan halaman booking.blade.php
        return view('booking');
    }
}
