@extends('layouts.admin')
@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-400 hover:text-gray-600 mb-6 inline-block">← Kembali</a>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        {{-- Customer Info --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-semibold text-gray-700 mb-3 text-sm uppercase tracking-wide">Info Pelanggan</h3>
            <p class="font-medium text-gray-800">{{ $order->user->name }}</p>
            <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
            <p class="text-sm text-gray-500">{{ $order->user->phone ?? '-' }}</p>
        </div>

        {{-- Shipping --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-semibold text-gray-700 mb-3 text-sm uppercase tracking-wide">Alamat Pengiriman</h3>
            <p class="text-sm text-gray-700">{{ $order->shipping_address }}</p>
        </div>
    </div>

    {{-- Order Items --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-4">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Item Pesanan</h3>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">Produk</th>
                    <th class="px-6 py-3 text-right">Harga</th>
                    <th class="px-6 py-3 text-right">Qty</th>
                    <th class="px-6 py-3 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($order->items as $item)
                    <tr>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $item->product->product_name }}</td>
                        <td class="px-6 py-4 text-right text-gray-500">Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right text-gray-500">{{ $item->quantity }} {{ $item->product->unit }}</td>
                        <td class="px-6 py-4 text-right font-semibold text-gray-700">Rp {{ number_format($item->quantity * $item->price_at_purchase, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-700">Total</td>
                    <td class="px-6 py-4 text-right font-bold text-primary-600 text-lg">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Update Status --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <h3 class="font-semibold text-gray-700 mb-4">Update Status Pesanan</h3>
        <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="flex gap-3 items-center">
            @csrf @method('PATCH')
            <select name="status" class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-400">
                @foreach(['pending' => 'Menunggu Konfirmasi', 'confirmed' => 'Dikonfirmasi', 'processing' => 'Diproses', 'delivered' => 'Dikirim', 'cancelled' => 'Dibatalkan'] as $val => $label)
                    <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-medium px-5 py-2.5 rounded-xl text-sm transition-colors">
                Update
            </button>
        </form>
    </div>
</div>
@endsection
