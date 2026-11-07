@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Banner -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Your Neighborhood Mini Mart</h1>
            <p class="hero-subtitle">Fresh & Fast — Daily Essentials Delivered to Your Door</p>
            <a href="{{ route('shop.index') }}" class="btn btn-lg">Shop Now</a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="section">
    <div class="container">
        <h2 class="section-title">Shop by Category</h2>
        
        <div class="categories-grid">
            @foreach($categories as $category)
            <a href="{{ route('shop.index', ['category' => $category->id]) }}" class="category-card">
                <div class="category-icon">
                    @if(Str::contains($category->name, 'Fruit'))
                        🍎
                    @elseif(Str::contains($category->name, 'Snack'))
                        🍿
                    @elseif(Str::contains($category->name, 'Dairy'))
                        🥛
                    @elseif(Str::contains($category->name, 'Bread'))
                        🍞
                    @elseif(Str::contains($category->name, 'Household'))
                        🧹
                    @else
                        🧴
                    @endif
                </div>
                <h3>{{ $category->name }}</h3>
                <p>{{ $category->activeProductsCount() }} items</p>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="section section-gray">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Today's Specials</h2>
            <a href="{{ route('shop.index') }}" class="link">View All →</a>
        </div>
        
        <div class="products-grid">
            @foreach($featuredProducts as $product)
            <div class="product-card">
                <div class="product-image">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <div class="product-placeholder">📦</div>
                    @endif
                    
                    @if($product->is_featured)
                        <span class="badge badge-featured">Special</span>
                    @endif
                </div>
                
                <div class="product-info">
                    <span class="product-category">{{ $product->category->name }}</span>
                    <h3 class="product-name">{{ $product->name }}</h3>
                    <p class="product-unit">{{ $product->unit }}</p>
                    
                    <div class="product-bottom">
                        <span class="product-price">${{ number_format($product->price, 2) }}</span>
                        
                        @if($product->in_stock)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-sm">Add to Cart</button>
                            </form>
                        @else
                            <span class="badge badge-danger">Out of Stock</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Store Info Section -->
<section class="section">
    <div class="container">
        <div class="info-grid">
            <div class="info-card">
                <div class="info-icon">🚚</div>
                <h3>Fast Delivery</h3>
                <p>Same-day delivery within 5km radius</p>
            </div>
            
            <div class="info-card">
                <div class="info-icon">🌱</div>
                <h3>Fresh Products</h3>
                <p>Daily fresh fruits and vegetables</p>
            </div>
            
            <div class="info-card">
                <div class="info-icon">💰</div>
                <h3>Best Prices</h3>
                <p>Competitive prices on all items</p>
            </div>
            
            <div class="info-card">
                <div class="info-icon">⏰</div>
                <h3>Open Daily</h3>
                <p>7 days a week for your convenience</p>
            </div>
        </div>
    </div>
</section>
@endsection
