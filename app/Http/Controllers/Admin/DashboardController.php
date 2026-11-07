<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Today's stats
        $todayOrders = Order::today()->count();
        $todaySales = Order::today()->sum('total_amount');
        
        // Overall stats
        $totalProducts = Product::count();
        $lowStockProducts = Product::whereRaw('stock_quantity <= low_stock_alert')
            ->where('stock_quantity', '>', 0)
            ->count();
        
        // Recent orders
        $recentOrders = Order::with('user')->recent()->take(10)->get();
        
        // Low stock products
        $lowStockItems = Product::with('category')
            ->whereRaw('stock_quantity <= low_stock_alert')
            ->where('stock_quantity', '>', 0)
            ->orderBy('stock_quantity', 'asc')
            ->get();
        
        return view('admin.dashboard', compact(
            'todayOrders',
            'todaySales',
            'totalProducts',
            'lowStockProducts',
            'recentOrders',
            'lowStockItems'
        ));
    }
}
