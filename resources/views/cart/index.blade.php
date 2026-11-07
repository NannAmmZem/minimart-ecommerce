@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="page-title">Shopping Cart</h1>
        
        @php
            $cart = session()->get('cart', []);
            $subtotal = 0;
        @endphp
        
        @if(!empty($cart))
            <div class="cart-layout">
                <div class="cart-items">
                    @foreach($cart as $id => $item)
                        @php
                            $itemTotal = $item['price'] * $item['quantity'];
                            $subtotal += $itemTotal;
                        @endphp
                        
                        <div class="cart-item">
                            <div class="cart-item-image">
                                @if($item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                                @else
                                    <div class="product-placeholder-sm">📦</div>
                                @endif
                            </div>
                            
                            <div class="cart-item-info">
                                <h3>{{ $item['name'] }}</h3>
                                <p class="text-muted">{{ $item['unit'] }}</p>
                                <p class="cart-item-price">${{ number_format($item['price'], 2) }}</p>
                            </div>
                            
                            <div class="cart-item-quantity">
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="quantity-form">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="99" class="form-input-sm">
                                    <button type="submit" class="btn btn-sm">Update</button>
                                </form>
                            </div>
                            
                            <div class="cart-item-total">
                                <strong>${{ number_format($itemTotal, 2) }}</strong>
                            </div>
                            
                            <div class="cart-item-remove">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon" title="Remove">🗑️</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="cart-summary">
                    <h2>Cart Summary</h2>
                    
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Delivery Fee:</span>
                        <span>{{ $subtotal >= 20 ? 'FREE' : '$3.00' }}</span>
                    </div>
                    
                    <div class="summary-divider"></div>
                    
                    <div class="summary-row summary-total">
                        <span>Total:</span>
                        <span>${{ number_format($subtotal >= 20 ? $subtotal : $subtotal + 3, 2) }}</span>
                    </div>
                    
                    @if($subtotal < 20)
                        <p class="delivery-note">Add ${{ number_format(20 - $subtotal, 2) }} more for free delivery!</p>
                    @else
                        <p class="delivery-note success">🎉 You qualify for free delivery!</p>
                    @endif
                    
                    @auth
                        <a href="{{ route('checkout.index') }}" class="btn btn-lg btn-block">Proceed to Checkout</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-lg btn-block">Login to Checkout</a>
                    @endauth
                    
                    <a href="{{ route('shop.index') }}" class="btn btn-outline btn-block">Continue Shopping</a>
                    
                    <form action="{{ route('cart.clear') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="btn btn-text btn-block" onclick="return confirm('Clear all items from cart?')">Clear Cart</button>
                    </form>
                </div>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">🛒</div>
                <h2>Your cart is empty</h2>
                <p>Add some products to get started!</p>
                <a href="{{ route('shop.index') }}" class="btn btn-lg">Start Shopping</a>
            </div>
        @endif
    </div>
</section>
@endsection
