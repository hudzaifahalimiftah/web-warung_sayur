@extends('layouts.app')
@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('orders.history') }}"
           class="flex items-center gap-1 text-gray-400 hover:text-gray-600 transition-colors text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <h1 class="text-xl font-bold text-gray-800">Pesanan #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h1>
    </div>

    {{-- ===== ORDER TRACKING ===== --}}
    @php
        $steps = [
            'pending'    => ['label' => 'Menunggu Konfirmasi', 'desc' => 'Pesanan diterima, menunggu konfirmasi pembayaran dari admin.'],
            'confirmed'  => ['label' => 'Dikonfirmasi',        'desc' => 'Pembayaran dikonfirmasi. Pesanan sedang disiapkan.'],
            'processing' => ['label' => 'Sedang Diproses',     'desc' => 'Sayuran sedang dipilih dan dikemas untuk Anda.'],
            'delivered'  => ['label' => 'Dalam Pengiriman',    'desc' => 'Pesanan sedang dalam perjalanan ke alamat Anda.'],
            'completed'  => ['label' => 'Selesai',             'desc' => 'Pesanan telah diterima. Terima kasih sudah berbelanja!'],
        ];
        $stepOrder  = ['pending', 'confirmed', 'processing', 'delivered', 'completed'];
        $currentIdx = array_search($order->status, $stepOrder);
        $isCancelled = $order->status === 'cancelled';
    @endphp

    @if($isCancelled)
        {{-- Cancelled state --}}
        <div class="bg-red-50 border border-red-200 rounded-2xl p-5 mb-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="font-bold text-red-700">Pesanan Dibatalkan</p>
                <p class="text-sm text-red-500 mt-0.5">Pesanan ini telah dibatalkan. Stok produk sudah dikembalikan.</p>
            </div>
        </div>
    @else
        {{-- Step tracker --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-5">
            <h2 class="font-bold text-gray-800 mb-5 text-sm">Status Pesanan</h2>
            <div class="relative">
                {{-- Line background --}}
                <div class="absolute top-5 left-5 right-5 h-0.5 bg-gray-100" style="z-index:0"></div>
                {{-- Line progress --}}
                @if($currentIdx !== false && $currentIdx > 0)
                    <div class="absolute top-5 left-5 h-0.5 bg-green-500 transition-all" style="z-index:1; width: calc({{ ($currentIdx / (count($stepOrder)-1)) * 100 }}% - 20px)"></div>
                @endif

                <div class="relative flex justify-between" style="z-index:2">
                    @foreach($stepOrder as $i => $stepKey)
                        @php
                            $isDone    = $currentIdx !== false && $i < $currentIdx;
                            $isCurrent = $currentIdx !== false && $i === $currentIdx;
                            $isFuture  = $currentIdx === false || $i > $currentIdx;
                        @endphp
                        <div class="flex flex-col items-center gap-2 flex-1">
                            {{-- Circle --}}
                            <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all
                                {{ $isDone    ? 'bg-green-500 border-green-500' : '' }}
                                {{ $isCurrent ? 'bg-white border-green-500 shadow-md shadow-green-100' : '' }}
                                {{ $isFuture  ? 'bg-white border-gray-200' : '' }}">
                                @if($isDone)
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @elseif($isCurrent)
                                    <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                                @else
                                    <div class="w-2.5 h-2.5 bg-gray-200 rounded-full"></div>
                                @endif
                            </div>
                            {{-- Label --}}
                            <p class="text-[10px] text-center leading-tight font-medium
                                {{ $isDone    ? 'text-green-600' : '' }}
                                {{ $isCurrent ? 'text-green-700 font-bold' : '' }}
                                {{ $isFuture  ? 'text-gray-300' : '' }}">
                                {{ $steps[$stepKey]['label'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Deskripsi status saat ini --}}
            @if($currentIdx !== false)
                <div class="mt-5 pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-600 text-center">
                        {{ $steps[$stepOrder[$currentIdx]]['desc'] }}
                    </p>
                    {{-- Countdown hanya untuk pending --}}
                    @if($order->status === 'pending')
                        @php
                            $deadline  = $order->created_at->addHours(24);
                            $remaining = now()->diffInSeconds($deadline, false);
                        @endphp
                        @if($remaining > 0)
                            <div class="flex items-center justify-center gap-2 mt-3">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-xs text-amber-600">Batas konfirmasi:</span>
                                <span class="font-mono font-bold text-sm text-amber-700 bg-amber-50 px-2 py-0.5 rounded-lg"
                                      id="countdown" data-deadline="{{ $deadline->toIso8601String() }}">--:--:--</span>
                            </div>
                        @else
                            <p class="text-center text-xs text-red-500 mt-2 font-medium">Waktu konfirmasi habis</p>
                        @endif
                    @endif
                    {{-- Pesan selesai --}}
                    @if($order->status === 'completed')
                        <div class="flex items-center justify-center gap-2 mt-3">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm text-green-600 font-semibold">Pesanan selesai! Terima kasih sudah berbelanja.</span>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @endif

    {{-- Info Pesanan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
        <div class="flex items-center justify-between mb-5">
            <div>
                <p class="text-xs text-gray-400">Tanggal Pesanan</p>
                <p class="font-semibold text-gray-700 text-sm">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-400">Penerima</p>
                <p class="font-semibold text-gray-700 text-sm">{{ $order->recipient_name ?? $order->user->name }}</p>
            </div>
        </div>

        <div class="mb-5">
            <p class="text-xs font-medium text-gray-400 mb-1">Alamat Pengiriman</p>
            <p class="text-gray-700 text-sm">{{ $order->shipping_address }}</p>
        </div>

        <div class="border-t border-gray-100 pt-5">
            <h3 class="font-semibold text-gray-700 mb-4 text-sm">Item Pesanan</h3>
            <div class="space-y-3">
                @foreach($order->items as $item)
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                            <img src="{{ $item->product->image_url }}"
                                 alt="{{ $item->product->product_name }}"
                                 class="w-full h-full object-cover"
                                 onerror="this.src='https://images.unsplash.com/photo-1540420773420-3366772f4999?w=100&q=80'">
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-800">{{ $item->product->product_name }}</p>
                            <p class="text-xs text-gray-400">{{ $item->quantity }} {{ $item->product->unit }} × Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</p>
                        </div>
                        <span class="text-sm font-bold text-gray-700">Rp {{ number_format($item->quantity * $item->price_at_purchase, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
            <div class="border-t border-gray-100 mt-4 pt-4 flex justify-between font-bold text-gray-800 text-lg">
                <span>Total</span>
                <span class="text-green-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- Tombol WA hanya untuk pending --}}
    @if($order->status === 'pending')
        <a href="{{ $waUrl }}" target="_blank"
           class="flex items-center justify-center gap-2 w-full bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-xl transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            Konfirmasi Pembayaran via WhatsApp
        </a>
    @endif

</div>

@push('scripts')
<script>
const el = document.getElementById('countdown');
if (el) {
    const deadline = new Date(el.dataset.deadline);
    function tick() {
        const diff = deadline - new Date();
        if (diff <= 0) { el.textContent = 'Waktu habis'; el.classList.add('text-red-600','bg-red-50'); return; }
        const h = Math.floor(diff/3600000);
        const m = Math.floor((diff%3600000)/60000);
        const s = Math.floor((diff%60000)/1000);
        el.textContent = String(h).padStart(2,'0')+':'+String(m).padStart(2,'0')+':'+String(s).padStart(2,'0');
        if (h < 1) el.classList.add('text-red-600','bg-red-50');
    }
    tick();
    setInterval(tick, 1000);
}
</script>
@endpush
@endsection
