<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fruits & Vegetables',
                'slug' => 'fruits-vegetables',
                'description' => 'Fresh fruits and vegetables delivered daily',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Snacks & Drinks',
                'slug' => 'snacks-drinks',
                'description' => 'Refreshing beverages and tasty snacks',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Dairy & Eggs',
                'slug' => 'dairy-eggs',
                'description' => 'Fresh dairy products and farm eggs',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Bread & Pastries',
                'slug' => 'bread-pastries',
                'description' => 'Freshly baked bread and pastries',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Household Essentials',
                'slug' => 'household-essentials',
                'description' => 'Daily household necessities',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Personal Care',
                'slug' => 'personal-care',
                'description' => 'Personal hygiene and care products',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
