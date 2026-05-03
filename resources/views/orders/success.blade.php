@extends('layouts.app')
@section('title', 'Pesanan Berhasil')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-16 text-center">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10">

        {{-- Icon sukses --}}
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-5">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-2">Pesanan Berhasil Dibuat!</h1>
        <p class="text-gray-500 mb-1">No. Pesanan: <span class="font-semibold text-gray-700">#{{ $order->id }}</span></p>
        <p class="text-gray-500 mb-8">Total: <span class="font-bold text-green-600 text-lg">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></p>

        {{-- Detail item --}}
        <div class="bg-gray-50 rounded-xl p-4 mb-6 text-left">
            <h3 class="font-semibold text-gray-700 mb-3 text-sm">Detail Pesanan</h3>
            <div class="space-y-2.5">
                @foreach($order->items as $item)
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-200 flex-shrink-0">
                            <img src="{{ $item->product->image_url }}"
                                 alt="{{ $item->product->product_name }}"
                                 class="w-full h-full object-cover"
                                 onerror="this.src='https://images.unsplash.com/photo-1540420773420-3366772f4999?w=100&q=80'">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-700 truncate">{{ $item->product->product_name }}</p>
                            <p class="text-xs text-gray-400">×{{ $item->quantity }} {{ $item->product->unit }}</p>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">Rp {{ number_format($item->quantity * $item->price_at_purchase, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Info WA + Countdown --}}
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-4 text-left">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <p class="text-sm text-amber-800 font-semibold mb-0.5">Batas Konfirmasi Pembayaran</p>
                    <p class="text-xs text-amber-700 mb-2">Pesanan akan otomatis dibatalkan jika belum dikonfirmasi dalam 24 jam.</p>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-amber-600 font-medium">Sisa waktu:</span>
                        <span id="countdown" class="font-mono font-bold text-amber-700 text-sm bg-amber-100 px-2 py-0.5 rounded-lg">
                            --:--:--
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6 text-left flex items-start gap-3">
            <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-sm text-green-800 font-semibold mb-0.5">Langkah Selanjutnya</p>
                <p class="text-sm text-green-700">Klik tombol di bawah untuk mengirim detail pesanan ke WhatsApp Admin dan konfirmasi pembayaran.</p>
            </div>
        </div>

        {{-- Tombol WA --}}
        <a href="{{ $waUrl }}" target="_blank"
           class="flex items-center justify-center gap-2 w-full bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-xl transition-colors text-base mb-4 shadow-sm">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            Konfirmasi via WhatsApp
        </a>

        <div class="flex gap-3">
            <a href="{{ route('orders.history') }}"
               class="flex-1 border border-gray-200 text-gray-600 hover:bg-gray-50 font-medium py-3 rounded-xl transition-colors text-sm">
                Riwayat Pesanan
            </a>
            <a href="{{ route('products.index') }}"
               class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-3 rounded-xl transition-colors text-sm">
                Belanja Lagi
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Countdown 24 jam dari waktu order dibuat
const orderCreatedAt = new Date("{{ $order->created_at->toIso8601String() }}");
const deadline = new Date(orderCreatedAt.getTime() + 24 * 60 * 60 * 1000);

function updateCountdown() {
    const now = new Date();
    const diff = deadline - now;

    if (diff <= 0) {
        document.getElementById('countdown').textContent = 'Waktu habis';
        document.getElementById('countdown').classList.add('text-red-600', 'bg-red-100');
        document.getElementById('countdown').classList.remove('text-amber-700', 'bg-amber-100');
        return;
    }

    const h = Math.floor(diff / 3600000);
    const m = Math.floor((diff % 3600000) / 60000);
    const s = Math.floor((diff % 60000) / 1000);

    document.getElementById('countdown').textContent =
        String(h).padStart(2,'0') + ':' +
        String(m).padStart(2,'0') + ':' +
        String(s).padStart(2,'0');

    // Warna merah kalau < 1 jam
    if (h < 1) {
        document.getElementById('countdown').classList.add('text-red-600', 'bg-red-100');
        document.getElementById('countdown').classList.remove('text-amber-700', 'bg-amber-100');
    }
}

updateCountdown();
setInterval(updateCountdown, 1000);
</script>
@endpush
@endsection
