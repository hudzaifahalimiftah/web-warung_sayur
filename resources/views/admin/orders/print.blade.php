<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }

        @media print {
            body { background: white; margin: 0; padding: 0; }
            .no-print { display: none !important; }
            .receipt {
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }
            @page {
                size: 148mm 210mm;
                margin: 5mm;
            }
        }
    </style>
</head>
<body class="flex flex-col items-center py-6 px-4">

    {{-- Tombol Print (tidak ikut print) --}}
    <div class="no-print flex gap-3 mb-6 w-full max-w-sm">
        <button onclick="window.print()"
                class="flex-1 bg-gray-900 hover:bg-black text-white font-bold py-2.5 rounded-xl text-sm transition-colors">
            Cetak / Simpan PDF
        </button>
        <button onclick="window.close()"
                class="px-4 bg-gray-100 hover:bg-gray-200 text-gray-600 font-medium py-2.5 rounded-xl text-sm transition-colors">
            Tutup
        </button>
    </div>

    {{-- STRUK --}}
    <div class="receipt bg-white rounded-2xl border border-gray-200 w-full max-w-sm overflow-hidden"
         style="box-shadow: 0 4px 24px rgba(0,0,0,0.08);">

        {{-- Header Toko --}}
        <div class="text-center px-6 pt-6 pb-4 border-b-2 border-dashed border-gray-200">
            <div class="flex items-center justify-center gap-1 mb-1">
                <span class="text-xl font-extrabold text-green-700 tracking-tight">Warung</span>
                <span class="text-xl font-extrabold text-green-500 tracking-tight">Sayur</span>
            </div>
            <p class="text-xs text-gray-400">Sayur Segar Langsung dari Petani Lokal</p>
            <p class="text-xs text-gray-400">0812-3456-7890 &nbsp;|&nbsp; Jakarta, Indonesia</p>
        </div>

        {{-- Info Order --}}
        <div class="px-6 py-4 border-b border-dashed border-gray-200">
            <div class="grid grid-cols-2 gap-y-3">
                <div>
                    <p class="text-[9px] text-gray-400 uppercase tracking-widest mb-0.5">No. Pesanan</p>
                    <p class="font-bold text-gray-900 font-mono text-sm">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[9px] text-gray-400 uppercase tracking-widest mb-0.5">Tanggal</p>
                    <p class="font-semibold text-gray-700 text-xs">{{ $order->created_at->format('d M Y') }}</p>
                    <p class="text-gray-400 text-xs">{{ $order->created_at->format('H:i') }} WIB</p>
                </div>
            </div>
        </div>

        {{-- Penerima --}}
        <div class="px-6 py-4 border-b border-dashed border-gray-200">
            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-3">Informasi Penerima</p>
            <div class="space-y-2">
                <div class="flex gap-3">
                    <span class="text-gray-400 text-xs w-16 flex-shrink-0 pt-0.5">Nama</span>
                    <span class="font-semibold text-gray-900 text-sm">{{ $order->recipient_name ?? $order->user->name }}</span>
                </div>
                <div class="flex gap-3">
                    <span class="text-gray-400 text-xs w-16 flex-shrink-0 pt-0.5">Telepon</span>
                    <span class="font-semibold text-gray-900 text-sm">{{ $order->recipient_phone ?? $order->user->phone ?? '-' }}</span>
                </div>
                <div class="flex gap-3">
                    <span class="text-gray-400 text-xs w-16 flex-shrink-0 pt-0.5">Alamat</span>
                    <span class="font-semibold text-gray-900 text-sm leading-relaxed">{{ $order->shipping_address }}</span>
                </div>
            </div>
        </div>

        {{-- Item --}}
        <div class="px-6 py-4 border-b border-dashed border-gray-200">
            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-3">Detail Pesanan</p>
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="pb-2 text-left text-xs font-semibold text-gray-500">Produk</th>
                        <th class="pb-2 text-center text-xs font-semibold text-gray-500">Qty</th>
                        <th class="pb-2 text-right text-xs font-semibold text-gray-500">Harga</th>
                        <th class="pb-2 text-right text-xs font-semibold text-gray-500">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr class="border-b border-gray-50">
                        <td class="py-2.5 font-medium text-gray-900 text-sm">{{ $item->product->product_name }}</td>
                        <td class="py-2.5 text-center text-xs text-gray-500">{{ $item->quantity }} {{ $item->product->unit }}</td>
                        <td class="py-2.5 text-right text-xs text-gray-500">Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</td>
                        <td class="py-2.5 text-right font-semibold text-gray-800 text-sm">Rp {{ number_format($item->quantity * $item->price_at_purchase, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Total --}}
        <div class="px-6 py-4 border-b-2 border-dashed border-gray-200">
            <div class="space-y-1.5 mb-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Subtotal ({{ $order->items->sum('quantity') }} item)</span>
                    <span class="font-medium text-gray-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Ongkos Kirim</span>
                    <span class="text-gray-400 text-xs italic">Sesuai kesepakatan</span>
                </div>
            </div>
            <div class="flex justify-between items-center pt-3 border-t-2 border-gray-900">
                <span class="font-extrabold text-gray-900 text-base">TOTAL BAYAR</span>
                <span class="font-extrabold text-green-600 text-2xl">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-5 text-center">
            <p class="text-xs text-gray-500 font-medium mb-1">Terima kasih telah berbelanja di Warung Sayur!</p>
            <p class="text-[10px] text-gray-300">Dicetak: {{ now()->format('d M Y, H:i') }} WIB</p>
        </div>
    </div>

</body>
</html>
