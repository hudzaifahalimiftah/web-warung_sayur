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

        // Pemasukan per hari dalam bulan yang dipilih
        $dailyRevenue = Order::whereIn('status', ['confirmed', 'processing', 'delivered', 'completed'])
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

        // Total bulan ini
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

        // Semua pesanan bulan ini (detail)
        $orders = Order::with('user')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->latest()
            ->paginate(20)
            ->withQueryString();

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

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        return view('admin.reports.index', compact(
            'dailyRevenue', 'monthlyRevenue', 'monthlyOrders',
            'newCustomers', 'orders', 'yearlyData',
            'year', 'month', 'availableYears', 'daysInMonth'
        ));
    }
}
