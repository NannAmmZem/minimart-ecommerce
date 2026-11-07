@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="page-title">My Orders</h1>
        
        @if($orders->count() > 0)
            <div class="orders-list">
                @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <strong>Order #{{ $order->order_number }}</strong>
                                <span class="text-muted">{{ $order->created_at->format('M d, Y') }}</span>
                            </div>
                            <span class="badge badge-{{ $order->status_badge_color }}">{{ $order->formatted_status }}</span>
                        </div>
                        
                        <div class="order-items-preview">
                            @foreach($order->orderItems->take(3) as $item)
                                <div class="order-item-small">
                                    <span>{{ $item->product->name }} ({{ $item->quantity }}x)</span>
                                </div>
                            @endforeach
                            
                            @if($order->orderItems->count() > 3)
                                <p class="text-muted">and {{ $order->orderItems->count() - 3 }} more items...</p>
                            @endif
                        </div>
                        
                        <div class="order-footer">
                            <div class="order-total">
                                <strong>Total: ${{ number_format($order->total_amount, 2) }}</strong>
                            </div>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm">View Details</a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            {{ $orders->links() }}
        @else
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <h2>No orders yet</h2>
                <p>Start shopping to place your first order!</p>
                <a href="{{ route('shop.index') }}" class="btn btn-lg">Shop Now</a>
            </div>
        @endif
    </div>
</section>
@endsection
