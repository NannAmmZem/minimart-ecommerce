@extends('layouts.admin')

@section('title', 'Orders')
@section('header', 'Orders Management')

@section('content')
<div class="admin-filters">
    <form action="{{ route('admin.orders.index') }}" method="GET">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">All Orders</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="out_for_delivery" {{ request('status') == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </form>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td><strong>{{ $order->order_number }}</strong></td>
                    <td>{{ $order->user->name }}</td>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</td>
                    <td>
                        <span class="badge badge-{{ $order->status_badge_color }}">
                            {{ $order->formatted_status }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                    <td class="table-actions">
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    {{ $orders->links() }}
</div>
@endsection
