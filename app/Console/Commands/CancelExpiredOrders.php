<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class CancelExpiredOrders extends Command
{
    protected $signature   = 'orders:cancel-expired';
    protected $description = 'Batalkan pesanan pending yang sudah lebih dari 24 jam';

    public function handle(): void
    {
        $expiredOrders = Order::where('status', 'pending')
            ->where('created_at', '<=', now()->subHours(24))
            ->get();

        if ($expiredOrders->isEmpty()) {
            $this->info('Tidak ada pesanan yang perlu dibatalkan.');
            return;
        }

        foreach ($expiredOrders as $order) {
            // Kembalikan stok produk
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            $order->update(['status' => 'cancelled']);

            $this->line("Pesanan #{$order->id} ({$order->user->name}) dibatalkan — stok dikembalikan.");
        }

        $this->info("Total {$expiredOrders->count()} pesanan dibatalkan.");
    }
}
