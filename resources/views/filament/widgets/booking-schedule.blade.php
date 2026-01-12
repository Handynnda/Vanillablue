@php use Illuminate\Support\Str; @endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            .booking-date-picker {
                margin-bottom: 24px;
            }

            .booking-date-picker input {
                padding: 8px 12px;
                border: 1px solid #e5e7eb;
                border-radius: 6px;
                font-size: 14px;
            }

            .location-section {
                margin-bottom: 32px;
            }

            .location-title {
                font-size: 16px;
                font-weight: 600;
                margin-bottom: 16px;
                color: #1f2937;
            }

            .time-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
                gap: 12px;
            }

            .time-slot {
                padding: 12px;
                text-align: center;
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                font-size: 13px;
                background-color: #ffffff;
                color: #4b5563;
                min-height: 50px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            .time-slot.empty {
                background-color: #f3f4f6;
                color: #9ca3af;
                border-color: #d1d5db;
            }

            .time-slot.booked {
                background-color: #dcfce7;
                color: #15803d;
                border-color: #86efac;
                font-weight: 600;
            }

            .slot-time {
                font-weight: 600;
                font-size: 14px;
                margin-bottom: 4px;
            }

            .slot-name {
                font-size: 11px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .no-bookings {
                text-align: center;
                padding: 32px;
                color: #6b7280;
                font-size: 14px;
            }

            .legend {
                display: flex;
                gap: 24px;
                margin-top: 24px;
                padding-top: 16px;
                border-top: 1px solid #e5e7eb;
            }

            .legend-item {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 13px;
            }

            .legend-box {
                width: 24px;
                height: 24px;
                border-radius: 4px;
                border: 1px solid #e5e7eb;
            }

            .legend-booked {
                background-color: #dcfce7;
                border-color: #86efac;
            }

            .legend-empty {
                background-color: #f3f4f6;
                border-color: #d1d5db;
            }
        </style>

        <div class="booking-schedule-widget" wire:poll.15s="loadBookings">
            <h3 style="margin-bottom: 16px; font-size: 18px; font-weight: 700; color: #1f2937;">
                Jadwal Pemotretan
            </h3>

            <div class="booking-date-picker">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                    Pilih Tanggal
                </label>
                <input type="date"
                    wire:model.live="selectedDate"
                    min="{{ now()->format('Y-m-d') }}"
                    style="width: 100%; max-width: 300px;">
            </div>

            <div class="booking-date-picker">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                    Pilih Lokasi
                </label>
                <select wire:model.live="locationFilter" style="width: 100%; max-width: 300px; padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 14px;">
                    <option value="all">Semua Lokasi</option>
                    <option value="indoor">Indoor (Photo Studio)</option>
                    <option value="outdoor">Outdoor</option>
                </select>
            </div>

            @php
                $showIndoor = $locationFilter === 'all' || $locationFilter === 'indoor';
                $showOutdoor = $locationFilter === 'all' || $locationFilter === 'outdoor';
            @endphp

            @if(count($this->bookings) > 0)
                @if($showIndoor)
                    <div class="location-section">
                        <div class="location-title">Indoor (Photo Studio)</div>
                        <div class="time-grid">
                            @foreach($this->timeOptions as $time)
                                @php
                                    $isBooked = $this->isTimeSlotBooked($time, 'indoor');
                                    $booking = $isBooked ? $this->getBookingForSlot($time, 'indoor') : null;
                                @endphp

                                @if($isBooked && $booking)
                                    <div class="time-slot booked" title="Dipesan oleh: {{ $booking['name'] }} ({{ $booking['phone'] ?? '-' }})">
                                        <div class="slot-time">{{ $time }}</div>
                                        <div class="slot-name">{{ Str::limit($booking['name'], 14) }}</div>
                                    </div>
                                @else
                                    <div class="time-slot empty">
                                        <div class="slot-time">{{ $time }}</div>
                                        <div class="slot-name">Kosong</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($showOutdoor)
                    <div class="location-section">
                        <div class="location-title">Outdoor</div>
                        <div class="time-grid">
                            @foreach($this->timeOptions as $time)
                                @php
                                    $isBooked = $this->isTimeSlotBooked($time, 'outdoor');
                                    $booking = $isBooked ? $this->getBookingForSlot($time, 'outdoor') : null;
                                @endphp

                                @if($isBooked && $booking)
                                    <div class="time-slot booked" title="Dipesan oleh: {{ $booking['name'] }} ({{ $booking['phone'] ?? '-' }})">
                                        <div class="slot-time">{{ $time }}</div>
                                        <div class="slot-name">{{ Str::limit($booking['name'], 14) }}</div>
                                    </div>
                                @else
                                    <div class="time-slot empty">
                                        <div class="slot-time">{{ $time }}</div>
                                        <div class="slot-name">Kosong</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="legend">
                    <div class="legend-item">
                        <div class="legend-box legend-booked"></div>
                        <span>Sudah Dipesan</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box legend-empty"></div>
                        <span>Kosong</span>
                    </div>
                </div>
            @else
                <div class="no-bookings">
                    Tidak ada jadwal pemotretan pada tanggal {{ \Illuminate\Support\Carbon::parse($this->selectedDate)->translatedFormat('d F Y') }}
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
