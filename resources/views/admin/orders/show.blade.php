@extends('layouts.admin')

@section('title', 'Order Details')
@section('header', 'Order #' . $order->order_number)

@section('content')
<div class="admin-grid-2">
    <div class="admin-card">
        <h2>Order Items</h2>
        
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" align="right"><strong>Total:</strong></td>
                        <td><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    
    <div>
        <div class="admin-card">
            <h2>Customer Information</h2>
            <div class="info-group">
                <label>Name:</label>
                <p>{{ $order->user->name }}</p>
            </div>
            <div class="info-group">
                <label>Email:</label>
                <p>{{ $order->user->email }}</p>
            </div>
            <div class="info-group">
                <label>Phone:</label>
                <p>{{ $order->phone_number }}</p>
            </div>
        </div>
        
        <div class="admin-card">
            <h2>Delivery Details</h2>
            <div class="info-group">
                <label>Address:</label>
                <p>{{ $order->delivery_address }}</p>
            </div>
            <div class="info-group">
                <label>Time Slot:</label>
                <p>{{ $order->delivery_time_slot }}</p>
            </div>
        </div>
        
        <div class="admin-card">
            <h2>Order Status</h2>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="form-group">
                    <label for="status">Update Status:</label>
                    <select name="status" id="status" class="form-select">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="out_for_delivery" {{ $order->status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        </div>
    </div>
</div>

<div class="admin-actions">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline">← Back to Orders</a>
</div>
@endsection
