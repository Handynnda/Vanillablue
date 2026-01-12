<x-filament::widget>
    <x-filament::card>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold">Jadwal Pemotretan</h2>

            <input
                type="date"
                class="filament-input"
                value="{{ now()->toDateString() }}"
            >
        </div>

        <div class="grid grid-cols-5 gap-3">
            @foreach([
                '09:00','09:30','10:00','10:30','11:00',
                '11:30','12:00','12:30','13:00',
                '13:30','14:00','14:30','15:00',
                '15:30','16:00','16:30','17:00','17:30','18:00'
            ] as $time)
                <div
                    class="border rounded-lg py-3 text-center text-sm font-medium
                           bg-white hover:bg-gray-100 cursor-pointer"
                >
                    {{ $time }}
                </div>
            @endforeach
        </div>
    </x-filament::card>
</x-filament::widget>
