<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PosController extends Controller
{
    /**
     * Display POS system
     */
    public function index(Request $request)
    {
        $categories = Category::withCount('products')->get();
        $selectedCategory = $request->get('category');
        
        $products = Product::where('in_stock', true)
            ->when($selectedCategory, function ($query) use ($selectedCategory) {
                return $query->where('category_id', $selectedCategory);
            })
            ->with('category')
            ->orderBy('name')
            ->get();

        // Get recent POS transactions (today)
        $recentSales = Order::whereDate('created_at', today())
            ->where('status', 'completed')
            ->with('user', 'items.product')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Today's statistics
        $todayStats = [
            'sales' => Order::whereDate('created_at', today())->sum('total_amount'),
            'transactions' => Order::whereDate('created_at', today())->count(),
            'items_sold' => OrderItem::whereHas('order', function ($query) {
                $query->whereDate('created_at', today());
            })->sum('quantity'),
        ];

        return view('admin.pos.index', compact('products', 'categories', 'selectedCategory', 'recentSales', 'todayStats'));
    }

    /**
     * Search products for POS
     */
    public function searchProducts(Request $request)
    {
        $search = $request->get('q');
        
        $products = Product::where('in_stock', true)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            })
            ->with('category')
            ->limit(20)
            ->get();

        return response()->json($products);
    }

    /**
     * Process POS sale
     */
    public function processSale(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'payment_method' => 'required|in:cash,card,mobile_money',
            'amount_paid' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Calculate total
            $total = 0;
            foreach ($request->items as $item) {
                $total += $item['quantity'] * $item['price'];
            }

            // Get or create walk-in customer
            $customer = User::firstOrCreate(
                ['email' => 'walkin@minimart.test'],
                [
                    'name' => $request->customer_name ?? 'Walk-in Customer',
                    'password' => bcrypt('password'),
                    'role' => 'customer',
                ]
            );

            // Create order
            $order = Order::create([
                'order_number' => 'POS-' . strtoupper(Str::random(8)),
                'user_id' => $customer->id,
                'total_amount' => $total,
                'status' => 'completed', // POS orders are immediately completed
                'payment_method' => $request->payment_method,
                'delivery_address' => $request->customer_name ?? 'In-store Purchase',
                'phone_number' => $request->customer_phone ?? 'N/A',
                'notes' => $request->notes,
            ]);

            // Create order items and update stock
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                // Check stock
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}. Available: {$product->stock_quantity}");
                }

                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Update product stock (real-time inventory update)
                $product->decrement('stock_quantity', $item['quantity']);

                // Update in_stock status
                if ($product->stock_quantity <= 0) {
                    $product->update(['in_stock' => false]);
                }
            }

            DB::commit();

            // Calculate change
            $change = $request->amount_paid - $total;

            return response()->json([
                'success' => true,
                'order' => $order->load('items.product'),
                'change' => $change,
                'message' => 'Sale completed successfully!',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Get product details for POS
     */
    public function getProduct($id)
    {
        $product = Product::with('category')->findOrFail($id);
        
        return response()->json($product);
    }

    /**
     * Get real-time stock updates
     */
    public function getStockUpdates(Request $request)
    {
        $productIds = $request->get('product_ids', []);
        
        $products = Product::whereIn('id', $productIds)
            ->select('id', 'name', 'stock_quantity', 'in_stock')
            ->get();

        return response()->json($products);
    }

    /**
     * Print receipt
     */
    public function printReceipt($orderId)
    {
        $order = Order::with('items.product', 'user')->findOrFail($orderId);
        
        return view('admin.pos.receipt', compact('order'));
    }

    /**
     * Get POS statistics
     */
    public function getStats()
    {
        $today = today();
        
        $stats = [
            'today' => [
                'sales' => Order::whereDate('created_at', $today)->sum('total_amount'),
                'transactions' => Order::whereDate('created_at', $today)->count(),
                'items_sold' => OrderItem::whereHas('order', function ($query) use ($today) {
                    $query->whereDate('created_at', $today);
                })->sum('quantity'),
            ],
            'this_week' => [
                'sales' => Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_amount'),
                'transactions' => Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            ],
            'this_month' => [
                'sales' => Order::whereMonth('created_at', now()->month)->sum('total_amount'),
                'transactions' => Order::whereMonth('created_at', now()->month)->count(),
            ],
            'low_stock' => Product::where('stock_quantity', '<=', DB::raw('low_stock_alert'))
                ->where('stock_quantity', '>', 0)
                ->count(),
            'out_of_stock' => Product::where('stock_quantity', 0)->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Hold transaction
     */
    public function holdTransaction(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'hold_name' => 'required|string|max:100',
        ]);

        $holdData = [
            'items' => $request->items,
            'hold_name' => $request->hold_name,
            'timestamp' => now(),
        ];

        session()->put("pos_hold_{$request->hold_name}", $holdData);

        return response()->json([
            'success' => true,
            'message' => 'Transaction held successfully',
        ]);
    }

    /**
     * Get held transactions
     */
    public function getHeldTransactions()
    {
        $held = [];
        
        foreach (session()->all() as $key => $value) {
            if (str_starts_with($key, 'pos_hold_')) {
                $held[] = $value;
            }
        }

        return response()->json($held);
    }

    /**
     * Resume held transaction
     */
    public function resumeTransaction($holdName)
    {
        $data = session()->pull("pos_hold_{$holdName}");
        
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
