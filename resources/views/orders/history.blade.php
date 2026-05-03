@extends('layouts.app')
@section('title', 'Riwayat Pesanan')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">

    <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Pesanan</h1>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 py-20 text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <p class="text-gray-500 font-medium mb-1">Belum ada pesanan</p>
            <p class="text-gray-400 text-sm mb-5">Yuk mulai belanja sayur segar!</p>
            <a href="{{ route('products.index') }}"
               class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors text-sm">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="font-semibold text-gray-800">Pesanan #{{ $order->id }}</p>
                            <p class="text-sm text-gray-400 mt-0.5">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        @php
                            $badge = match($order->status) {
                                'completed'  => 'bg-green-100 text-green-700',
                                'delivered'  => 'bg-cyan-100 text-cyan-700',
                                'cancelled'  => 'bg-red-100 text-red-700',
                                'pending'    => 'bg-yellow-100 text-yellow-700',
                                'confirmed'  => 'bg-blue-100 text-blue-700',
                                'processing' => 'bg-violet-100 text-violet-700',
                                default      => 'bg-gray-100 text-gray-600',
                            };
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                            {{ $order->status_label }}
                        </span>
                    </div>

                    <div class="space-y-1 mb-4">
                        @foreach($order->items->take(3) as $item)
                            <p class="text-sm text-gray-600">• {{ $item->product->product_name }} ×{{ $item->quantity }} {{ $item->product->unit }}</p>
                        @endforeach
                        @if($order->items->count() > 3)
                            <p class="text-sm text-gray-400">+{{ $order->items->count() - 3 }} item lainnya</p>
                        @endif
                    </div>

                    {{-- Info status untuk non-pending --}}
                    @if($order->status === 'pending')
                        @php
                            $deadline = $order->created_at->addHours(24);
                            $remaining = now()->diffInSeconds($deadline, false);
                        @endphp
                        @if($remaining > 0)
                            <div class="flex items-center gap-2 mb-3 bg-amber-50 border border-amber-100 rounded-xl px-3 py-2">
                                <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-xs text-amber-700">Batas konfirmasi:</span>
                                <span class="font-mono font-bold text-xs text-amber-700 countdown-timer"
                                      data-deadline="{{ $deadline->toIso8601String() }}">
                                    --:--:--
                                </span>
                            </div>
                        @else
                            <div class="flex items-center gap-2 mb-3 bg-red-50 border border-red-100 rounded-xl px-3 py-2">
                                <svg class="w-4 h-4 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-xs text-red-600 font-medium">Waktu konfirmasi habis — pesanan akan segera dibatalkan</span>
                            </div>
                        @endif
                    @elseif($order->status === 'confirmed')
                        <div class="flex items-center gap-2 mb-3 bg-blue-50 border border-blue-100 rounded-xl px-3 py-2">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-xs text-blue-700 font-medium">Pembayaran dikonfirmasi. Pesanan sedang disiapkan.</span>
                        </div>
                    @elseif($order->status === 'processing')
                        <div class="flex items-center gap-2 mb-3 bg-violet-50 border border-violet-100 rounded-xl px-3 py-2">
                            <svg class="w-4 h-4 text-violet-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                            <span class="text-xs text-violet-700 font-medium">Sayuran sedang dikemas untuk Anda.</span>
                        </div>
                    @elseif($order->status === 'delivered')
                        <div class="flex items-center gap-2 mb-3 bg-cyan-50 border border-cyan-100 rounded-xl px-3 py-2">
                            <svg class="w-4 h-4 text-cyan-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                            </svg>
                            <span class="text-xs text-cyan-700 font-medium">Pesanan sedang dalam perjalanan ke alamat Anda.</span>
                        </div>
                    @elseif($order->status === 'completed')
                        <div class="flex items-center gap-2 mb-3 bg-green-50 border border-green-100 rounded-xl px-3 py-2">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-xs text-green-700 font-medium">Pesanan selesai! Terima kasih sudah berbelanja.</span>
                        </div>
                    @endif

                    <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                        <span class="font-bold text-green-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        <a href="{{ route('orders.show', $order) }}"
                           class="text-sm text-green-600 hover:text-green-700 font-semibold flex items-center gap-1">
                            Lihat Detail
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $orders->links() }}</div>
    @endif
</div>

@push('scripts')
<script>
// Countdown untuk semua pesanan pending di halaman riwayat
document.querySelectorAll('.countdown-timer').forEach(function(el) {
    const deadline = new Date(el.dataset.deadline);

    function tick() {
        const diff = deadline - new Date();
        if (diff <= 0) {
            el.textContent = 'Waktu habis';
            el.classList.add('text-red-600');
            return;
        }
        const h = Math.floor(diff / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);
        el.textContent = String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
        if (h < 1) el.classList.add('text-red-600');
    }

    tick();
    setInterval(tick, 1000);
});
</script>
@endpush
@endsection
