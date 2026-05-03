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
        // Admin tidak bisa checkout
        if (auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Admin tidak dapat melakukan pembelian.');
        }

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
        // Admin tidak bisa order
        if (auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Admin tidak dapat melakukan pembelian.');
        }

        $request->validate([
            'recipient_name'   => 'required|string|max:255',
            'recipient_phone'  => 'nullable|string|max:20',
            'shipping_address' => 'required|string|min:10|max:500',
        ], [
            'recipient_name.required'   => 'Nama penerima wajib diisi.',
            'shipping_address.required' => 'Alamat pengiriman wajib diisi.',
            'shipping_address.min'      => 'Alamat terlalu pendek, minimal 10 karakter.',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }
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
                'recipient_name'   => $request->recipient_name,
                'recipient_phone'  => $request->recipient_phone,
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
        $waMessage = $this->buildWhatsAppMessage($order->fresh(['items.product']), $request->recipient_name, $request->recipient_phone);
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
        $waMessage = $this->buildWhatsAppMessage($order, $order->recipient_name, $order->recipient_phone);
        $waUrl = 'https://wa.me/' . self::ADMIN_WHATSAPP . '?text=' . urlencode($waMessage);

        return view('orders.success', compact('order', 'waUrl'));
    }

    /**
     * Beli Sekarang — langsung ke halaman checkout tanpa lewat keranjang
     */
    public function buyNow(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Admin tidak dapat melakukan pembelian.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = \App\Models\Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        // Simpan sementara di session untuk checkout
        session(['buy_now' => [
            'product_id' => $product->id,
            'quantity'   => $request->quantity,
        ]]);

        return redirect()->route('orders.checkout.buynow');
    }

    public function checkoutBuyNow()
    {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Admin tidak dapat melakukan pembelian.');
        }

        $buyNow = session('buy_now');
        if (!$buyNow) {
            return redirect()->route('products.index')->with('error', 'Sesi pembelian tidak valid.');
        }

        $product  = \App\Models\Product::with('category')->findOrFail($buyNow['product_id']);
        $quantity = $buyNow['quantity'];
        $total    = $product->price * $quantity;

        return view('orders.checkout_buynow', compact('product', 'quantity', 'total'));
    }

    public function storeBuyNow(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Admin tidak dapat melakukan pembelian.');
        }

        $request->validate([
            'recipient_name'   => 'required|string|max:255',
            'recipient_phone'  => 'nullable|string|max:20',
            'shipping_address' => 'required|string|min:10|max:500',
        ]);

        $buyNow = session('buy_now');
        if (!$buyNow) {
            return redirect()->route('products.index')->with('error', 'Sesi pembelian tidak valid.');
        }

        $product  = \App\Models\Product::findOrFail($buyNow['product_id']);
        $quantity = $buyNow['quantity'];

        if ($product->stock < $quantity) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $total = $product->price * $quantity;

        DB::transaction(function () use ($product, $quantity, $total, $request, &$order) {
            $order = Order::create([
                'user_id'          => auth()->id(),
                'total_price'      => $total,
                'status'           => 'pending',
                'shipping_address' => $request->shipping_address,
                'recipient_name'   => $request->recipient_name,
                'recipient_phone'  => $request->recipient_phone,
            ]);

            OrderItem::create([
                'order_id'          => $order->id,
                'product_id'        => $product->id,
                'quantity'          => $quantity,
                'price_at_purchase' => $product->price,
            ]);

            $product->decrement('stock', $quantity);
        });

        session()->forget('buy_now');

        $waMessage = $this->buildWhatsAppMessage($order->fresh(['items.product']), $request->recipient_name, $request->recipient_phone);
        $waUrl     = 'https://wa.me/' . self::ADMIN_WHATSAPP . '?text=' . urlencode($waMessage);

        return redirect()->route('orders.success', $order->id)
            ->with('wa_url', $waUrl)
            ->with('success', 'Pesanan berhasil dibuat!');
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
        $waMessage = $this->buildWhatsAppMessage($order, $order->recipient_name, $order->recipient_phone);
        $waUrl = 'https://wa.me/' . self::ADMIN_WHATSAPP . '?text=' . urlencode($waMessage);

        return view('orders.show', compact('order', 'waUrl'));
    }

    private function buildWhatsAppMessage(Order $order, ?string $recipientName = null, ?string $recipientPhone = null): string
    {
        $user  = auth()->user();
        $name  = $recipientName  ?? $user->name;
        $phone = $recipientPhone ?? $user->phone ?? '-';

        $lines   = [];
        $lines[] = "*PESANAN BARU - Warung Sayur*";
        $lines[] = "────────────────────";
        $lines[] = "*No. Pesanan:* #" . $order->id;
        $lines[] = "*Nama:* " . $name;
        $lines[] = "*Telepon:* " . $phone;
        $lines[] = "*Alamat Pengiriman:*";
        $lines[] = $order->shipping_address;
        $lines[] = "────────────────────";
        $lines[] = "*Detail Pesanan:*";

        foreach ($order->items as $item) {
            $subtotal = $item->quantity * $item->price_at_purchase;
            $lines[]  = "- {$item->product->product_name} x{$item->quantity} {$item->product->unit} = Rp " . number_format($subtotal, 0, ',', '.');
        }

        $lines[] = "────────────────────";
        $lines[] = "*Total: Rp " . number_format($order->total_price, 0, ',', '.') . "*";
        $lines[] = "";
        $lines[] = "Mohon konfirmasi pesanan dan informasi pembayaran. Terima kasih!";

        return implode("\n", $lines);
    }
}
