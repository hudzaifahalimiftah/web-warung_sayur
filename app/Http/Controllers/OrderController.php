<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Nomor WhatsApp admin (ganti sesuai kebutuhan)
    const ADMIN_WHATSAPP = '6285693490621';

    public function checkout()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);

        return view('orders.checkout', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|min:10|max:500',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        // Cek stok semua item
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->with('error', "Stok {$item->product->product_name} tidak mencukupi.");
            }
        }

        $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);

        DB::transaction(function () use ($cartItems, $total, $request, &$order) {
            // Buat order
            $order = Order::create([
                'user_id'          => auth()->id(),
                'total_price'      => $total,
                'status'           => 'pending',
                'shipping_address' => $request->shipping_address,
            ]);

            // Buat order items & kurangi stok
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'          => $order->id,
                    'product_id'        => $item->product_id,
                    'quantity'          => $item->quantity,
                    'price_at_purchase' => $item->product->price,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            // Kosongkan keranjang
            Cart::where('user_id', auth()->id())->delete();
        });

        // Buat pesan WhatsApp
        $waMessage = $this->buildWhatsAppMessage($order->fresh(['items.product']));
        $waUrl = 'https://wa.me/' . self::ADMIN_WHATSAPP . '?text=' . urlencode($waMessage);

        return redirect()->route('orders.success', $order->id)
            ->with('wa_url', $waUrl)
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');
        $waMessage = $this->buildWhatsAppMessage($order);
        $waUrl = 'https://wa.me/' . self::ADMIN_WHATSAPP . '?text=' . urlencode($waMessage);

        return view('orders.success', compact('order', 'waUrl'));
    }

    public function history()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('orders.history', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');
        $waMessage = $this->buildWhatsAppMessage($order);
        $waUrl = 'https://wa.me/' . self::ADMIN_WHATSAPP . '?text=' . urlencode($waMessage);

        return view('orders.show', compact('order', 'waUrl'));
    }

    private function buildWhatsAppMessage(Order $order): string
    {
        $user = auth()->user();
        $lines = [];
        $lines[] = "🛒 *PESANAN BARU - Warung Sayur*";
        $lines[] = "━━━━━━━━━━━━━━━━━━━━";
        $lines[] = "📋 *No. Pesanan:* #" . $order->id;
        $lines[] = "👤 *Nama:* " . $user->name;
        $lines[] = "📞 *Telepon:* " . ($user->phone ?? '-');
        $lines[] = "📍 *Alamat Pengiriman:*";
        $lines[] = $order->shipping_address;
        $lines[] = "━━━━━━━━━━━━━━━━━━━━";
        $lines[] = "🥬 *Detail Pesanan:*";

        foreach ($order->items as $item) {
            $subtotal = $item->quantity * $item->price_at_purchase;
            $lines[] = "• {$item->product->product_name} x{$item->quantity} {$item->product->unit} = Rp " . number_format($subtotal, 0, ',', '.');
        }

        $lines[] = "━━━━━━━━━━━━━━━━━━━━";
        $lines[] = "💰 *Total: Rp " . number_format($order->total_price, 0, ',', '.') . "*";
        $lines[] = "";
        $lines[] = "Mohon konfirmasi pesanan dan informasi pembayaran. Terima kasih! 🙏";

        return implode("\n", $lines);
    }
}
