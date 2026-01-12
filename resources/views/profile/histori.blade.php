@extends('layouts.main')

@section('title', 'Pesanan Saya')

@section('container')

<section id="my-orders" class="py-5" style="margin-top:60px; background-color:#dadada">
    <div class="container">
        
        {{-- Header Halaman --}}
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-dark">Pesanan Saya</h2>
                <p class="text-muted">Riwayat dan status booking foto Anda.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                
                {{-- LOOPING DATA ORDERS --}}
                {{-- Menggunakan @forelse untuk menangani jika data ada atau kosong --}}
                @forelse ($orders as $order)
                    
                    <div class="card border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                
                                {{-- KOLOM 1: INFO PAKET & WAKTU --}}
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        {{-- Nama Paket --}}
                                        <h5 class="fw-bold text-dark mb-0">
                                            {{ $order->bundling->name_bundling ?? 'Paket Tidak Ditemukan' }}
                                        </h5>
                                    </div>
                                    {{-- ID Order --}}
                                    <p class="small text-muted mb-2">ID Order: {{ $order->id }}</p>
                                    
                                    {{-- Badges Tanggal & Jam --}}
                                    <div class="d-flex gap-2">
                                        <span class="badge bg-light text-dark border">
                                            <i class="far fa-calendar me-1"></i>
                                            {{-- Format Tanggal: 25 November 2025 --}}
                                            {{ \Carbon\Carbon::parse($order->book_date)->translatedFormat('d F Y') }}
                                        </span>
                                        <span class="badge bg-light text-dark border">
                                            <i class="far fa-clock me-1"></i>
                                            {{-- Format Jam: 14:30 --}}
                                            {{ \Carbon\Carbon::parse($order->book_time)->format('H:i') }} WIB
                                        </span>
                                    </div>
                                </div>

                                {{-- KOLOM 2: HARGA & STATUS ORDER --}}
                                <div class="col-md-3 mb-3 mb-md-0 text-md-center">
                                    <div class="fw-bold text-dark mb-2">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </div>
                                    
                                    {{-- Logika Warna Badge Status Order --}}
                                    @php
                                        $statusClass = match($order->order_status) {
                                            'pending' => 'bg-warning text-dark',
                                            'confirmed' => 'bg-primary text-white',
                                            'completed' => 'bg-success text-white',
                                            'cancelled' => 'bg-danger text-white',
                                            default => 'bg-secondary text-white',
                                        };
                                        
                                        $statusLabel = match($order->order_status) {
                                            'pending' => 'Menunggu Konfirmasi',
                                            'confirmed' => 'Dikonfirmasi',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                            default => ucfirst($order->order_status),
                                        };
                                    @endphp
                                    
                                    <span class="badge {{ $statusClass }} rounded-pill px-3">
                                        {{ $statusLabel }}
                                    </span>
                                </div>

                                {{-- KOLOM 3: STATUS PEMBAYARAN --}}
                                <div class="col-md-3 mb-3 mb-md-0 text-md-center">
                                    @php
                                        $orderStatus = $order->order_status;

                                        // Hitung sisa pembayaran: total harga paket - nominal DP dibayar user (pada Payment)
                                        $dpAmount = (float) ($order->payment->amount ?? 0);
                                        $totalPrice = (float) ($order->total_price ?? 0);
                                        $sisaPembayaran = max(0, $totalPrice - $dpAmount);

                                        // Warna teks berdasarkan status order
                                        $payTextClass = match($orderStatus) {
                                            'completed' => 'text-success',
                                            'confirmed' => 'text-warning',
                                            'pending' => 'text-warning',
                                            default => 'text-danger',
                                        };

                                        // Label pembayaran
                                        if ($orderStatus === 'completed') {
                                            $payLabel = 'Lunas';
                                        } elseif ($orderStatus === 'confirmed') {
                                            $payLabel = 'Dikonfirmasi — Sisa Pembayaran: Rp ' . number_format($sisaPembayaran, 0, ',', '.');
                                        } elseif ($orderStatus === 'pending') {
                                            $payLabel = 'Menunggu Konfirmasi';
                                        } else {
                                            $payLabel = 'Tidak Diketahui';
                                        }
                                    @endphp
                                    
                                    <small class="d-block text-muted mb-1" style="font-size: 0.8rem;">Status Pembayaran</small>
                                    <span class="fw-bold {{ $payTextClass }}">
                                        <i class="fas fa-circle small me-1" style="font-size: 0.6rem;"></i> 
                                        {{ $payLabel }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    {{-- TAMPILAN JIKA TIDAK ADA PESANAN (EMPTY STATE) --}}
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-folder-open fa-3x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted">Anda belum memiliki riwayat pesanan.</h5>
                        <p class="text-muted small mb-4">Yuk abadikan momen spesialmu sekarang!</p>
                        
                        <a href="{{ route('listharga') }}" class="btn btn-warning fw-bold px-4">
                            Lihat Daftar Harga
                        </a>
                    </div>
                @endforelse

            </div>
        </div>

    </div>
</section>

@endsection