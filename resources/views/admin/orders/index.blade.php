@extends('layouts.admin')
@section('title', 'Manajemen Pesanan')

@section('content')
{{-- Filter --}}
<form method="GET" class="mb-6 flex gap-3 flex-wrap">
    @foreach(['', 'pending', 'confirmed', 'processing', 'delivered', 'cancelled'] as $status)
        <a href="{{ route('admin.orders.index', $status ? ['status' => $status] : []) }}"
           class="px-4 py-2 rounded-xl text-sm font-medium transition-colors
                  {{ request('status') === $status || (!request('status') && $status === '') ? 'bg-primary-600 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            {{ $status ? ucfirst($status) : 'Semua' }}
        </a>
    @endforeach
</form>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">No.</th>
                    <th class="px-6 py-3 text-left">Pelanggan</th>
                    <th class="px-6 py-3 text-left">Total</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Tanggal</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-700">#{{ $order->id }}</td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-800">{{ $order->user->name }}</p>
                            <p class="text-xs text-gray-400">{{ $order->user->phone }}</p>
                        </td>
                        <td class="px-6 py-4 font-semibold text-primary-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($order->status === 'delivered') bg-green-100 text-green-700
                                @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                                @elseif($order->status === 'pending') bg-yellow-100 text-yellow-700
                                @else bg-blue-100 text-blue-700 @endif">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-400">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-primary-600 hover:underline text-xs font-medium">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-10 text-center text-gray-400">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $orders->links() }}
    </div>
</div>
@endsection
