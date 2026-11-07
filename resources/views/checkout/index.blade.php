@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="page-title">Checkout</h1>
        
        <div class="checkout-layout">
            <div class="checkout-form">
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-section">
                        <h2>Delivery Information</h2>
                        
                        <div class="form-group">
                            <label for="delivery_address">Delivery Address *</label>
                            <textarea name="delivery_address" id="delivery_address" rows="3" class="form-input" required>{{ old('delivery_address') }}</textarea>
                            @error('delivery_address')
                                <span class="text-error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="phone_number">Phone Number *</label>
                            <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" class="form-input" required>
                            @error('phone_number')
                                <span class="text-error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="delivery_time_slot">Preferred Delivery Time *</label>
                            <select name="delivery_time_slot" id="delivery_time_slot" class="form-select" required>
                                <option value="">Select time slot</option>
                                <option value="Morning (9 AM - 12 PM)">Morning (9 AM - 12 PM)</option>
                                <option value="Afternoon (12 PM - 3 PM)">Afternoon (12 PM - 3 PM)</option>
                                <option value="Evening (3 PM - 6 PM)">Evening (3 PM - 6 PM)</option>
                                <option value="Night (6 PM - 9 PM)">Night (6 PM - 9 PM)</option>
                            </select>
                            @error('delivery_time_slot')
                                <span class="text-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h2>Payment Method</h2>
                        
                        <div class="payment-options">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cash_on_delivery" checked>
                                <div class="payment-card">
                                    <strong>Cash on Delivery</strong>
                                    <p>Pay when you receive your order</p>
                                </div>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="bank_transfer">
                                <div class="payment-card">
                                    <strong>Bank Transfer</strong>
                                    <p>Transfer to our bank account</p>
                                </div>
                            </label>
                        </div>
                        
                        @error('payment_method')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-section">
                        <h2>Additional Notes (Optional)</h2>
                        
                        <div class="form-group">
                            <textarea name="notes" id="notes" rows="3" class="form-input" placeholder="Any special instructions for delivery...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-lg btn-block">Place Order</button>
                </form>
            </div>
            
            <div class="checkout-summary">
                <h2>Order Summary</h2>
                
                <div class="order-items">
                    @foreach($cart as $id => $item)
                        <div class="order-item">
                            <div class="order-item-info">
                                <strong>{{ $item['name'] }}</strong>
                                <span>{{ $item['quantity'] }} × ${{ number_format($item['price'], 2) }}</span>
                            </div>
                            <span class="order-item-total">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        </div>
                    @endforeach
                </div>
                
                <div class="summary-divider"></div>
                
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                
                <div class="summary-row">
                    <span>Delivery Fee:</span>
                    <span>{{ $deliveryFee == 0 ? 'FREE' : '$' . number_format($deliveryFee, 2) }}</span>
                </div>
                
                <div class="summary-divider"></div>
                
                <div class="summary-row summary-total">
                    <span>Total:</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
