@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">📅</div>
        <div class="stat-info">
            <h3>{{ $todayOrders }}</h3>
            <p>Today's Orders</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-info">
            <h3>${{ number_format($todaySales, 2) }}</h3>
            <p>Today's Sales</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-info">
            <h3>{{ $totalProducts }}</h3>
            <p>Total Products</p>
        </div>
    </div>
    
    <div class="stat-card stat-card-warning">
        <div class="stat-icon">⚠️</div>
        <div class="stat-info">
            <h3>{{ $lowStockProducts }}</h3>
            <p>Low Stock Alerts</p>
        </div>
    </div>
</div>

<!-- Recent Orders & Low Stock -->
<div class="admin-grid-2">
    <div class="admin-card">
        <h2>Recent Orders</h2>
        
        @if($recentOrders->count() > 0)
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="link">
                                    {{ $order->order_number }}
                                </a>
                            </td>
                            <td>{{ $order->user->name }}</td>
                            <td>${{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <span class="badge badge-{{ $order->status_badge_color }}">
                                    {{ $order->formatted_status }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('M d, h:i A') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">No recent orders</p>
        @endif
    </div>
    
    <div class="admin-card">
        <h2>Low Stock Alert</h2>
        
        @if($lowStockItems->count() > 0)
            <div class="low-stock-list">
                @foreach($lowStockItems as $product)
                    <div class="low-stock-item">
                        <div>
                            <strong>{{ $product->name }}</strong>
                            <span class="text-muted">{{ $product->category->name }}</span>
                        </div>
                        <span class="badge badge-warning">{{ $product->stock_quantity }} left</span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">All products are well stocked!</p>
        @endif
    </div>
</div>
@endsection
