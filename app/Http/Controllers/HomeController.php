<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        
        $featuredProducts = Product::featured()
            ->with('category')
            ->take(8)
            ->get();
        
        return view('home', compact('categories', 'featuredProducts'));
    }
}
