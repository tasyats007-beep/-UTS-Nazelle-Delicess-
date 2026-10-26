<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalProducts = Product::count();
        $lowStockCount = Product::lowStock()->count();

        $completedSalesQuery = Sale::where('status', 'completed');
        $totalSalesCount = (clone $completedSalesQuery)->count();
        $totalSalesAmount = (clone $completedSalesQuery)->sum('total');

        $todaySalesAmount = Sale::where('status', 'completed')
            ->whereDate('sold_at', today())
            ->sum('total');

        $monthSalesAmount = Sale::where('status', 'completed')
            ->whereMonth('sold_at', now()->month)
            ->whereYear('sold_at', now()->year)
            ->sum('total');

        $completedPurchasesQuery = Purchase::where('status', 'completed');
        $totalPurchasesCount = (clone $completedPurchasesQuery)->count();
        $totalPurchasesAmount = (clone $completedPurchasesQuery)->sum('total');

        $lowStockProducts = Product::with('category')
            ->lowStock()
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        $recentSales = Sale::with('user')
            ->latest('sold_at')
            ->take(5)
            ->get();

        $recentPurchases = Purchase::with(['supplier', 'user'])
            ->latest('purchased_at')
            ->take(5)
            ->get();

        $featuredProducts = Product::with('category')
            ->where('stock', '>', 0)
            ->inRandomOrder()
            ->take(6)
            ->get();

        $customerSales = Sale::with('items.product')
            ->where('status', 'completed')
            ->where(function ($q) {
                $q->where('user_id', auth()->id())
                  ->orWhere('customer_name', 'like', '%' . auth()->user()->name . '%')
                  ->orWhere('customer_name', 'Pelanggan Umum');
            })
            ->latest('sold_at')
            ->take(5)
            ->get();

        $customerSalesCount = $customerSales->count();
        $customerSalesTotal = $customerSales->sum('total');

        return view('dashboard.index', compact(
            'totalProducts',
            'lowStockCount',
            'totalSalesCount',
            'totalSalesAmount',
            'todaySalesAmount',
            'monthSalesAmount',
            'totalPurchasesCount',
            'totalPurchasesAmount',
            'lowStockProducts',
            'recentSales',
            'recentPurchases',
            'featuredProducts',
            'customerSales',
            'customerSalesCount',
            'customerSalesTotal'
        ));
    }
}
