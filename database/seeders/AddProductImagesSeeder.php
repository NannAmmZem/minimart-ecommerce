<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class AddProductImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create product images directory if it doesn't exist
        $imagesPath = storage_path('app/public/products');
        if (!File::exists($imagesPath)) {
            File::makeDirectory($imagesPath, 0755, true);
        }

        // Product image mapping (using emoji placeholders)
        $productImages = [
            'Fresh Bananas' => '🍌',
            'Red Apples' => '🍎',
            'Fresh Tomatoes' => '🍅',
            'Cola 2L' => '🥤',
            'Potato Chips' => '🍟',
            'Orange Juice 1L' => '🧃',
            'Fresh Milk 1L' => '🥛',
            'Farm Fresh Eggs' => '🥚',
            'Cheddar Cheese' => '🧀',
            'White Bread' => '🍞',
            'Croissant' => '🥐',
            'Dish Soap' => '🧼',
            'Toilet Paper 12 Pack' => '🧻',
            'Hand Soap' => '🧴',
            'Toothpaste' => '🦷',
            'Shampoo 500ml' => '🧴',
        ];

        foreach ($productImages as $productName => $emoji) {
            $product = Product::where('name', $productName)->first();
            
            if ($product) {
                // Create a simple SVG placeholder with emoji
                $svg = $this->createProductSVG($emoji, $productName);
                $filename = 'products/' . $product->slug . '.svg';
                $fullPath = storage_path('app/public/' . $filename);
                
                File::put($fullPath, $svg);
                
                // Update product with image path
                $product->update(['image' => $filename]);
                
                $this->command->info("✓ Added image for: {$productName}");
            }
        }

        $this->command->info('All product images added!');
    }

    /**
     * Create a simple SVG image with emoji
     */
    private function createProductSVG($emoji, $name): string
    {
        // Generate a nice color based on product category
        $colors = [
            '🍌' => '#FFE135', '🍎' => '#FF3B30', '🍅' => '#FF5733',
            '🥤' => '#007AFF', '🍟' => '#FFD60A', '🧃' => '#FF9500',
            '🥛' => '#E8F4F8', '🥚' => '#F5DEB3', '🧀' => '#FFD700',
            '🍞' => '#D4A373', '🥐' => '#C19A6B', '🧼' => '#87CEEB',
            '🧻' => '#FFFFFF', '🧴' => '#98D8C8', '🦷' => '#00CED1',
        ];
        
        $bgColor = $colors[$emoji] ?? '#F3F4F6';
        
        return <<<SVG
<svg width="400" height="400" xmlns="http://www.w3.org/2000/svg">
  <!-- Background with gradient -->
  <defs>
    <linearGradient id="grad1" x1="0%" y1="0%" x2="0%" y2="100%">
      <stop offset="0%" style="stop-color:{$bgColor};stop-opacity:0.9" />
      <stop offset="100%" style="stop-color:{$bgColor};stop-opacity:0.6" />
    </linearGradient>
  </defs>
  
  <rect width="400" height="400" fill="url(#grad1)"/>
  
  <!-- White container for better readability -->
  <rect x="20" y="120" width="360" height="260" fill="white" opacity="0.95" rx="15"/>
  
  <!-- Emoji -->
  <text x="200" y="220" font-size="100" text-anchor="middle">{$emoji}</text>
  
  <!-- Product name with better styling -->
  <text x="200" y="310" font-size="24" text-anchor="middle" fill="#1F2937" font-family="Arial, sans-serif" font-weight="bold">{$name}</text>
  
  <!-- Mini Mart branding -->
  <text x="200" y="345" font-size="14" text-anchor="middle" fill="#6B7280" font-family="Arial, sans-serif">Mini Mart</text>
  
  <!-- Decorative corner -->
  <circle cx="350" cy="50" r="30" fill="white" opacity="0.3"/>
  <text x="350" y="62" font-size="30" text-anchor="middle" opacity="0.4">🛒</text>
</svg>
SVG;
    }
}
