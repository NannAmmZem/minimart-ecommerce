<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fruits & Vegetables
        $fruitsVeg = Category::where('slug', 'fruits-vegetables')->first();
        Product::create([
            'category_id' => $fruitsVeg->id,
            'name' => 'Fresh Bananas',
            'slug' => 'fresh-bananas',
            'description' => 'Ripe yellow bananas, sweet and delicious',
            'price' => 3.99,
            'unit' => 'kg',
            'stock_quantity' => 50,
            'is_featured' => true,
            'in_stock' => true,
        ]);

        Product::create([
            'category_id' => $fruitsVeg->id,
            'name' => 'Red Apples',
            'slug' => 'red-apples',
            'description' => 'Crisp and juicy red apples',
            'price' => 5.49,
            'unit' => 'kg',
            'stock_quantity' => 40,
            'is_featured' => true,
            'in_stock' => true,
        ]);

        Product::create([
            'category_id' => $fruitsVeg->id,
            'name' => 'Fresh Tomatoes',
            'slug' => 'fresh-tomatoes',
            'description' => 'Farm fresh red tomatoes',
            'price' => 4.99,
            'unit' => 'kg',
            'stock_quantity' => 35,
            'in_stock' => true,
        ]);

        // Snacks & Drinks
        $snacksDrinks = Category::where('slug', 'snacks-drinks')->first();
        Product::create([
            'category_id' => $snacksDrinks->id,
            'name' => 'Cola 2L',
            'slug' => 'cola-2l',
            'description' => 'Refreshing cola drink',
            'price' => 3.49,
            'unit' => 'bottle',
            'stock_quantity' => 60,
            'is_featured' => true,
            'in_stock' => true,
        ]);

        Product::create([
            'category_id' => $snacksDrinks->id,
            'name' => 'Potato Chips',
            'slug' => 'potato-chips',
            'description' => 'Crispy salted potato chips',
            'price' => 2.99,
            'unit' => 'pack',
            'stock_quantity' => 45,
            'in_stock' => true,
        ]);

        Product::create([
            'category_id' => $snacksDrinks->id,
            'name' => 'Orange Juice 1L',
            'slug' => 'orange-juice-1l',
            'description' => 'Pure orange juice, no added sugar',
            'price' => 4.99,
            'unit' => 'bottle',
            'stock_quantity' => 30,
            'in_stock' => true,
        ]);

        // Dairy & Eggs
        $dairyEggs = Category::where('slug', 'dairy-eggs')->first();
        Product::create([
            'category_id' => $dairyEggs->id,
            'name' => 'Fresh Milk 1L',
            'slug' => 'fresh-milk-1l',
            'description' => 'Full cream fresh milk',
            'price' => 3.99,
            'unit' => 'bottle',
            'stock_quantity' => 40,
            'is_featured' => true,
            'in_stock' => true,
        ]);

        Product::create([
            'category_id' => $dairyEggs->id,
            'name' => 'Farm Fresh Eggs',
            'slug' => 'farm-fresh-eggs',
            'description' => 'Free range eggs, pack of 12',
            'price' => 5.99,
            'unit' => 'dozen',
            'stock_quantity' => 25,
            'in_stock' => true,
        ]);

        Product::create([
            'category_id' => $dairyEggs->id,
            'name' => 'Cheddar Cheese',
            'slug' => 'cheddar-cheese',
            'description' => 'Aged cheddar cheese block',
            'price' => 7.99,
            'unit' => '250g',
            'stock_quantity' => 20,
            'in_stock' => true,
        ]);

        // Bread & Pastries
        $breadPastries = Category::where('slug', 'bread-pastries')->first();
        Product::create([
            'category_id' => $breadPastries->id,
            'name' => 'White Bread',
            'slug' => 'white-bread',
            'description' => 'Soft white bread loaf',
            'price' => 2.49,
            'unit' => 'loaf',
            'stock_quantity' => 30,
            'is_featured' => true,
            'in_stock' => true,
        ]);

        Product::create([
            'category_id' => $breadPastries->id,
            'name' => 'Croissant',
            'slug' => 'croissant',
            'description' => 'Buttery French croissant',
            'price' => 1.99,
            'unit' => 'pc',
            'stock_quantity' => 15,
            'in_stock' => true,
        ]);

        // Household Essentials
        $household = Category::where('slug', 'household-essentials')->first();
        Product::create([
            'category_id' => $household->id,
            'name' => 'Dish Soap',
            'slug' => 'dish-soap',
            'description' => 'Effective dish washing liquid',
            'price' => 4.49,
            'unit' => 'bottle',
            'stock_quantity' => 35,
            'in_stock' => true,
        ]);

        Product::create([
            'category_id' => $household->id,
            'name' => 'Toilet Paper 12 Pack',
            'slug' => 'toilet-paper-12-pack',
            'description' => 'Soft 3-ply toilet paper',
            'price' => 9.99,
            'unit' => 'pack',
            'stock_quantity' => 20,
            'in_stock' => true,
        ]);

        // Personal Care
        $personalCare = Category::where('slug', 'personal-care')->first();
        Product::create([
            'category_id' => $personalCare->id,
            'name' => 'Hand Soap',
            'slug' => 'hand-soap',
            'description' => 'Antibacterial hand wash',
            'price' => 3.99,
            'unit' => 'bottle',
            'stock_quantity' => 30,
            'in_stock' => true,
        ]);

        Product::create([
            'category_id' => $personalCare->id,
            'name' => 'Toothpaste',
            'slug' => 'toothpaste',
            'description' => 'Mint flavored toothpaste',
            'price' => 4.99,
            'unit' => 'tube',
            'stock_quantity' => 25,
            'in_stock' => true,
        ]);

        Product::create([
            'category_id' => $personalCare->id,
            'name' => 'Shampoo 500ml',
            'slug' => 'shampoo-500ml',
            'description' => 'Nourishing hair shampoo',
            'price' => 6.99,
            'unit' => 'bottle',
            'stock_quantity' => 22,
            'in_stock' => true,
        ]);
    }
}
