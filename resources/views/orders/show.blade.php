@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<section class="section">
    <div class="container">
        <div class="order-detail-header">
            <div>
                <h1>Order #{{ $order->order_number }}</h1>
                <p class="text-muted">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>
            <span class="badge badge-{{ $order->status_badge_color }} badge-lg">{{ $order->formatted_status }}</span>
        </div>
        
        <div class="order-detail-layout">
            <div class="order-detail-main">
                <div class="card">
                    <h2>Order Items</h2>
                    
                    <div class="order-items-list">
                        @foreach($order->orderItems as $item)
                            <div class="order-detail-item">
                                <div class="order-item-info">
                                    <strong>{{ $item->product->name }}</strong>
                                    <span class="text-muted">{{ $item->product->unit }}</span>
                                </div>
                                <div class="order-item-qty">
                                    {{ $item->quantity }} × ${{ number_format($item->price, 2) }}
                                </div>
                                <div class="order-item-total">
                                    ${{ number_format($item->subtotal, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="order-total-section">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span>${{ number_format($order->orderItems->sum('subtotal'), 2) }}</span>
                        </div>
                        <div class="summary-row summary-total">
                            <span>Total:</span>
                            <span>${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="order-detail-sidebar">
                <div class="card">
                    <h3>Delivery Information</h3>
                    <div class="info-group">
                        <label>Address:</label>
                        <p>{{ $order->delivery_address }}</p>
                    </div>
                    
                    <div class="info-group">
                        <label>Phone:</label>
                        <p>{{ $order->phone_number }}</p>
                    </div>
                    
                    <div class="info-group">
                        <label>Time Slot:</label>
                        <p>{{ $order->delivery_time_slot }}</p>
                    </div>
                </div>
                
                <div class="card">
                    <h3>Payment</h3>
                    <div class="info-group">
                        <label>Method:</label>
                        <p>{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</p>
                    </div>
                    
                    <div class="info-group">
                        <label>Total Amount:</label>
                        <p><strong>${{ number_format($order->total_amount, 2) }}</strong></p>
                    </div>
                </div>
                
                @if($order->notes)
                <div class="card">
                    <h3>Notes</h3>
                    <p>{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>
        
        <div class="order-actions">
            <a href="{{ route('orders.index') }}" class="btn btn-outline">← Back to Orders</a>
            @if($order->status === 'pending')
                <p class="text-muted">Your order is being processed. We'll update you soon!</p>
            @endif
        </div>
    </div>
</section>
@endsection
