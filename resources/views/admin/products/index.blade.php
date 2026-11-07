@extends('layouts.admin')

@section('title', 'Products')
@section('header', 'Products Management')

@section('content')
<div class="admin-actions">
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Add New Product</a>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Unit</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                        @else
                            <div style="width: 50px; height: 50px; background: #f3f4f6; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 24px;">📦</div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $product->name }}</strong>
                        @if($product->is_featured)
                            <span class="badge badge-featured">Featured</span>
                        @endif
                    </td>
                    <td>{{ $product->category->name }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>
                        @if($product->isLowStock())
                            <span class="badge badge-warning">{{ $product->stock_quantity }}</span>
                        @elseif($product->stock_quantity == 0)
                            <span class="badge badge-danger">0</span>
                        @else
                            {{ $product->stock_quantity }}
                        @endif
                    </td>
                    <td>{{ $product->unit }}</td>
                    <td>
                        @if($product->in_stock)
                            <span class="badge badge-success">In Stock</span>
                        @else
                            <span class="badge badge-danger">Out of Stock</span>
                        @endif
                    </td>
                    <td class="table-actions">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    {{ $products->links() }}
</div>
@endsection
