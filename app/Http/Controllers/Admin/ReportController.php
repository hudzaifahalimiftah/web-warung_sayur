<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $year  = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        // Pemasukan per hari — semua pesanan kecuali cancelled
        $dailyRevenue = Order::whereNotIn('status', ['cancelled'])
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->select(
                DB::raw('DAY(created_at) as day'),
                DB::raw('SUM(total_price) as revenue'),
                DB::raw('COUNT(*) as total_orders')
            )
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        // Total bulan ini (confirmed ke atas)
        $monthlyRevenue = Order::whereIn('status', ['confirmed', 'processing', 'delivered', 'completed'])
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->sum('total_price');

        $monthlyOrders = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        // Pelanggan baru bulan ini
        $newCustomers = User::where('role', 'user')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        // Hari ini
        $todayRevenue = Order::whereNotIn('status', ['cancelled'])
            ->whereDate('created_at', today())
            ->sum('total_price');

        $todayOrders = Order::whereDate('created_at', today())->count();

        // Ringkasan per bulan (tahun ini)
        $yearlyData = Order::whereIn('status', ['confirmed', 'processing', 'delivered', 'completed'])
            ->whereYear('created_at', $year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as revenue'),
                DB::raw('COUNT(*) as total_orders')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        // Daftar tahun yang tersedia
        $availableYears = Order::selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderByDesc('year')
            ->pluck('year')
            ->toArray();

        if (empty($availableYears)) {
            $availableYears = [date('Y')];
        }

        $daysInMonth = (int) \Carbon\Carbon::create($year, $month, 1)->daysInMonth;

        return view('admin.reports.index', compact(
            'dailyRevenue', 'monthlyRevenue', 'monthlyOrders',
            'newCustomers', 'yearlyData',
            'year', 'month', 'availableYears', 'daysInMonth',
            'todayRevenue', 'todayOrders'
        ));
    }
}
