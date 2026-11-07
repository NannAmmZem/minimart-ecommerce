<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Mini Mart') }} - @yield('title', 'Your Neighborhood Store')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('home') }}" class="logo">
                <span class="logo-icon">🛒</span>
                <span class="logo-text">Mini Mart</span>
            </a>
            
            <div class="nav-links">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('shop.index') }}" class="{{ request()->routeIs('shop.*') ? 'active' : '' }}">Shop</a>
                
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}">Admin</a>
                    @else
                        <a href="{{ route('orders.index') }}">My Orders</a>
                    @endif
                @endauth
                
                <a href="{{ route('cart.index') }}" class="cart-link">
                    🛒 Cart <span class="cart-count">{{ count(session()->get('cart', [])) }}</span>
                </a>
                
                @guest
                    <a href="{{ route('login') }}" class="btn btn-sm">Login</a>
                @else
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <div class="container">{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <div class="container">{{ session('error') }}</div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3>Mini Mart</h3>
                    <p>Your neighborhood store for fresh groceries and daily essentials.</p>
                </div>
                
                <div class="footer-col">
                    <h4>Opening Hours</h4>
                    <p>Monday - Saturday: 7:00 AM - 10:00 PM</p>
                    <p>Sunday: 8:00 AM - 9:00 PM</p>
                </div>
                
                <div class="footer-col">
                    <h4>Contact Us</h4>
                    <p>📞 (555) 123-4567</p>
                    <p>📧 info@minimart.test</p>
                    <p>📍 123 Main Street, City</p>
                </div>
                
                <div class="footer-col">
                    <h4>Delivery Info</h4>
                    <p>Free delivery on orders over $20</p>
                    <p>Same-day local delivery available</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Mini Mart. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
