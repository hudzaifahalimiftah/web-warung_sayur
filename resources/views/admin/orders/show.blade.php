@extends('layouts.admin')
@section('title', 'Detail Pesanan')
@push('styles')
<style>
@media print {
    /* Sembunyikan SEMUA kecuali struk */
    body * { visibility: hidden; }
    #receipt, #receipt * { visibility: visible; }

    /* Posisi struk di pojok kiri atas */
    #receipt {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 148mm !important;   /* A5 dibagi 2 = A6 landscape / setengah A5 */
        max-width: 148mm !important;
        border: none !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        font-size: 10pt !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Ukuran kertas A5 landscape (setengah A4) */
    @page {
        size: 148mm 210mm;
        margin: 5mm;
    }
}
</style>
@endpush
@section('content')
<div class="max-w-2xl">

{{-- Toolbar --}}
<div class="flex items-center justify-between mb-5 no-print">
    <a href="{{ route('admin.orders.index') }}" class="text-xs text-slate-400 hover:text-slate-600">
        &larr; Kembali
    </a>
    <button onclick="window.open('{{ route('admin.orders.print', $order) }}', '_blank')"
            class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white font-semibold px-4 py-2 rounded-xl text-sm">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
        </svg>
        Cetak Struk
    </button>
</div>

{{-- STRUK --}}
<div id="receipt" class="bg-white rounded-2xl border border-slate-200 overflow-hidden mb-5">

    {{-- Header Toko --}}
    <div class="text-center px-8 pt-7 pb-5 border-b-2 border-dashed border-slate-200">
        <div class="flex items-center justify-center gap-1 mb-1">
            <span class="text-xl font-extrabold text-green-700 tracking-tight">Warung</span>
            <span class="text-xl font-extrabold text-green-500 tracking-tight">Sayur</span>
        </div>
        <p class="text-xs text-slate-400">Sayur Segar Langsung dari Petani Lokal</p>
        <p class="text-xs text-slate-400">0812-3456-7890 &nbsp;|&nbsp; Jakarta, Indonesia</p>
    </div>

    {{-- Info Order --}}
    <div class="px-8 py-4 border-b border-dashed border-slate-200">
        <div class="grid grid-cols-2 gap-y-3">
            <div>
                <p class="text-[10px] text-slate-400 uppercase tracking-wide mb-0.5">No. Pesanan</p>
                <p class="font-bold text-slate-800 font-mono">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="text-right">
                <p class="text-[10px] text-slate-400 uppercase tracking-wide mb-0.5">Tanggal</p>
                <p class="font-semibold text-slate-700 text-xs">{{ $order->created_at->format('d M Y') }}</p>
                <p class="text-slate-400 text-xs">{{ $order->created_at->format('H:i') }} WIB</p>
            </div>
            <div class="col-span-2">
                <p class="text-[10px] text-slate-400 uppercase tracking-wide mb-1">Status</p>
                @php
                    $bc = match($order->status) {
                        'completed'  => 'bg-green-100 text-green-700',
                        'delivered'  => 'bg-cyan-100 text-cyan-700',
                        'cancelled'  => 'bg-red-100 text-red-600',
                        'pending'    => 'bg-amber-100 text-amber-700',
                        'confirmed'  => 'bg-blue-100 text-blue-700',
                        'processing' => 'bg-violet-100 text-violet-700',
                        default      => 'bg-slate-100 text-slate-600',
                    };
                @endphp
                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-bold {{ $bc }}">
                    {{ $order->status_label }}
                </span>
            </div>
        </div>
    </div>

    {{-- Penerima --}}
    <div class="px-8 py-4 border-b border-dashed border-slate-200">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Informasi Penerima</p>
        <div class="space-y-2">
            <div class="flex gap-3 text-sm">
                <span class="text-slate-400 w-20 flex-shrink-0 text-xs pt-0.5">Nama</span>
                <span class="font-semibold text-slate-800">{{ $order->recipient_name ?? $order->user->name }}</span>
            </div>
            <div class="flex gap-3 text-sm">
                <span class="text-slate-400 w-20 flex-shrink-0 text-xs pt-0.5">Telepon</span>
                <span class="font-semibold text-slate-800">{{ $order->recipient_phone ?? $order->user->phone ?? '-' }}</span>
            </div>
            <div class="flex gap-3 text-sm">
                <span class="text-slate-400 w-20 flex-shrink-0 text-xs pt-0.5">Alamat</span>
                <span class="font-semibold text-slate-800 leading-relaxed">{{ $order->shipping_address }}</span>
            </div>
        </div>
    </div>

    {{-- Item Pesanan --}}
    <div class="px-8 py-4 border-b border-dashed border-slate-200">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Detail Pesanan</p>
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="pb-2 text-left text-xs font-semibold text-slate-500">Produk</th>
                    <th class="pb-2 text-center text-xs font-semibold text-slate-500">Qty</th>
                    <th class="pb-2 text-right text-xs font-semibold text-slate-500">Harga</th>
                    <th class="pb-2 text-right text-xs font-semibold text-slate-500">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr class="border-b border-slate-50">
                    <td class="py-2.5 font-medium text-slate-800">{{ $item->product->product_name }}</td>
                    <td class="py-2.5 text-center text-xs text-slate-500">{{ $item->quantity }} {{ $item->product->unit }}</td>
                    <td class="py-2.5 text-right text-xs text-slate-500">Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</td>
                    <td class="py-2.5 text-right font-semibold text-slate-700">Rp {{ number_format($item->quantity * $item->price_at_purchase, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Total --}}
    <div class="px-8 py-4 border-b-2 border-dashed border-slate-200">
        <div class="space-y-1.5 mb-3">
            <div class="flex justify-between text-sm">
                <span class="text-slate-500">Subtotal ({{ $order->items->sum('quantity') }} item)</span>
                <span class="font-medium text-slate-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-slate-500">Ongkos Kirim</span>
                <span class="text-slate-400 text-xs italic">Sesuai kesepakatan</span>
            </div>
        </div>
        <div class="flex justify-between items-center pt-3 border-t-2 border-slate-800">
            <span class="font-extrabold text-slate-800 text-base">TOTAL BAYAR</span>
            <span class="font-extrabold text-green-600 text-2xl">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Footer Struk --}}
    <div class="px-8 py-5 text-center">
        <p class="text-xs text-slate-500 font-medium mb-1">Terima kasih telah berbelanja di Warung Sayur!</p>
        <p class="text-[10px] text-slate-300">Dicetak: {{ now()->format('d M Y, H:i') }} WIB</p>
    </div>
</div>

{{-- Update Status --}}
<div class="bg-white rounded-2xl border border-slate-100 p-5 no-print">
    <h3 class="font-semibold text-slate-800 text-sm mb-4">Update Status Pesanan</h3>

    @if(in_array($order->status, ['completed', 'cancelled']))
        <div class="flex items-center gap-3 p-4 rounded-xl {{ $order->status === 'completed' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
            <svg class="w-5 h-5 flex-shrink-0 {{ $order->status === 'completed' ? 'text-green-500' : 'text-red-400' }}"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                @if($order->status === 'completed')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                @endif
            </svg>
            <div>
                <p class="text-sm font-semibold {{ $order->status === 'completed' ? 'text-green-800' : 'text-red-700' }}">
                    Pesanan {{ $order->status === 'completed' ? 'Selesai' : 'Dibatalkan' }}
                </p>
                <p class="text-xs {{ $order->status === 'completed' ? 'text-green-600' : 'text-red-500' }} mt-0.5">
                    Status ini sudah final dan tidak dapat diubah lagi.
                </p>
            </div>
        </div>
    @else
        <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="flex gap-3 items-center">
            @csrf @method('PATCH')
            <select name="status"
                    class="flex-1 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition">
                @foreach([
                    'pending'    => 'Menunggu Konfirmasi',
                    'confirmed'  => 'Dikonfirmasi',
                    'processing' => 'Sedang Diproses',
                    'delivered'  => 'Sudah Dikirim',
                    'completed'  => 'Selesai',
                    'cancelled'  => 'Dibatalkan',
                ] as $val => $label)
                    <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Update
            </button>
        </form>
    @endif
</div>

</div>
@endsection
