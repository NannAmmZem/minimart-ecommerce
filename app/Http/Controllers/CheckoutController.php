<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $deliveryFee = $subtotal >= 20 ? 0 : 3;
        $total = $subtotal + $deliveryFee;
        
        return view('checkout.index', compact('cart', 'subtotal', 'deliveryFee', 'total'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'delivery_address' => 'required|string|max:500',
            'phone_number' => 'required|string|max:20',
            'delivery_time_slot' => 'required|string',
            'payment_method' => 'required|in:cash_on_delivery,bank_transfer',
        ]);
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
        DB::beginTransaction();
        
        try {
            // Calculate total
            $subtotal = 0;
            foreach ($cart as $id => $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            
            $deliveryFee = $subtotal >= 20 ? 0 : 3;
            $total = $subtotal + $deliveryFee;
            
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'delivery_address' => $request->delivery_address,
                'phone_number' => $request->phone_number,
                'delivery_time_slot' => $request->delivery_time_slot,
                'notes' => $request->notes,
            ]);
            
            // Create order items and update stock
            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
                
                // Update product stock
                $product = Product::find($id);
                if ($product) {
                    $product->decrement('stock_quantity', $item['quantity']);
                    
                    if ($product->stock_quantity <= 0) {
                        $product->update(['in_stock' => false]);
                    }
                }
            }
            
            DB::commit();
            
            // Clear cart
            session()->forget('cart');
            
            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order placed successfully!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }
}
