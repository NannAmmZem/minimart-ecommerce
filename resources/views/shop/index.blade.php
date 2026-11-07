@extends('layouts.app')

@section('title', 'Shop')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="page-title">Shop All Products</h1>
        
        <!-- Filters -->
        <div class="shop-filters">
            <form action="{{ route('shop.index') }}" method="GET" class="filter-form">
                <!-- Search -->
                <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}" class="form-input">
                
                <!-- Category Filter -->
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                
                <!-- Sort -->
                <select name="sort" class="form-select">
                    <option value="">Sort by</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
                
                <button type="submit" class="btn">Filter</button>
                <a href="{{ route('shop.index') }}" class="btn btn-outline">Clear</a>
            </form>
        </div>
        
        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                <div class="product-card">
                    <a href="{{ route('shop.show', $product->slug) }}" class="product-image">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <div class="product-placeholder">📦</div>
                        @endif
                        
                        @if($product->is_featured)
                            <span class="badge badge-featured">Special</span>
                        @endif
                        
                        @if($product->isLowStock())
                            <span class="badge badge-warning">Low Stock</span>
                        @endif
                    </a>
                    
                    <div class="product-info">
                        <span class="product-category">{{ $product->category->name }}</span>
                        <h3 class="product-name">
                            <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="product-unit">{{ $product->unit }}</p>
                        
                        <div class="product-bottom">
                            <span class="product-price">${{ number_format($product->price, 2) }}</span>
                            
                            @if($product->in_stock)
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-sm">Add</button>
                                </form>
                            @else
                                <span class="badge badge-danger">Out of Stock</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $products->links() }}
            </div>
        @else
            <div class="empty-state">
                <p>No products found.</p>
                <a href="{{ route('shop.index') }}" class="btn">View All Products</a>
            </div>
        @endif
    </div>
</section>
@endsection
