@extends('layouts.app')

@section('title', $product->name)

@section('content')
<section class="section">
    <div class="container">
        <div class="product-detail">
            <div class="product-detail-image">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                    <div class="product-placeholder-large">📦</div>
                @endif
            </div>
            
            <div class="product-detail-info">
                <nav class="breadcrumb">
                    <a href="{{ route('home') }}">Home</a> / 
                    <a href="{{ route('shop.index') }}">Shop</a> / 
                    <a href="{{ route('shop.index', ['category' => $product->category_id]) }}">{{ $product->category->name }}</a>
                </nav>
                
                <h1>{{ $product->name }}</h1>
                
                <div class="product-meta">
                    <span class="product-category-badge">{{ $product->category->name }}</span>
                    
                    @if($product->is_featured)
                        <span class="badge badge-featured">Special Offer</span>
                    @endif
                    
                    @if($product->isLowStock())
                        <span class="badge badge-warning">Only {{ $product->stock_quantity }} left!</span>
                    @endif
                </div>
                
                <div class="product-price-large">
                    ${{ number_format($product->price, 2) }} <span class="price-unit">/ {{ $product->unit }}</span>
                </div>
                
                <div class="product-description">
                    <p>{{ $product->description ?? 'Fresh and high quality product available at our store.' }}</p>
                </div>
                
                <div class="product-stock">
                    @if($product->in_stock)
                        <span class="stock-status in-stock">✓ In Stock ({{ $product->stock_quantity }} available)</span>
                    @else
                        <span class="stock-status out-stock">✗ Out of Stock</span>
                    @endif
                </div>
                
                @if($product->in_stock)
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                        @csrf
                        <div class="quantity-selector">
                            <label for="quantity">Quantity:</label>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="form-input">
                        </div>
                        
                        <button type="submit" class="btn btn-lg btn-primary">Add to Cart</button>
                    </form>
                @endif
            </div>
        </div>
        
        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="related-products">
            <h2 class="section-title">You May Also Like</h2>
            
            <div class="products-grid">
                @foreach($relatedProducts as $relatedProduct)
                <div class="product-card">
                    <a href="{{ route('shop.show', $relatedProduct->slug) }}" class="product-image">
                        @if($relatedProduct->image)
                            <img src="{{ asset('storage/' . $relatedProduct->image) }}" alt="{{ $relatedProduct->name }}">
                        @else
                            <div class="product-placeholder">📦</div>
                        @endif
                    </a>
                    
                    <div class="product-info">
                        <span class="product-category">{{ $relatedProduct->category->name }}</span>
                        <h3 class="product-name">
                            <a href="{{ route('shop.show', $relatedProduct->slug) }}">{{ $relatedProduct->name }}</a>
                        </h3>
                        <p class="product-unit">{{ $relatedProduct->unit }}</p>
                        
                        <div class="product-bottom">
                            <span class="product-price">${{ number_format($relatedProduct->price, 2) }}</span>
                            
                            @if($relatedProduct->in_stock)
                                <form action="{{ route('cart.add', $relatedProduct->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-sm">Add</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
