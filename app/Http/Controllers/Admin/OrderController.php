<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.product');
        return view('admin.orders.show', compact('order'));
    }

    public function print(Order $order)
    {
        $order->load('user', 'items.product');
        return view('admin.orders.print', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        // Status final tidak bisa diubah
        if (in_array($order->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'Status pesanan ini sudah final dan tidak dapat diubah.');
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,delivered,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan diperbarui.');
    }
}
