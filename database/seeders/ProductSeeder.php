<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $electronics = Category::where('category_name', 'Electronics')->first();
        $smartphones = Category::where('category_name', 'Smartphones')->first();
        $laptops = Category::where('category_name', 'Laptops')->first();
        $clothing = Category::where('category_name', 'Clothing')->first();
        $mensClothing = Category::where('category_name', 'Men\'s Clothing')->first();
        $womensClothing = Category::where('category_name', 'Women\'s Clothing')->first();
        $books = Category::where('category_name', 'Books')->first();
        $fiction = Category::where('category_name', 'Fiction')->first();
        $nonFiction = Category::where('category_name', 'Non-Fiction')->first();

        if ($smartphones) {
            Product::create([
                'product_name' => 'iPhone 15 Pro',
                'product_description' => 'Latest iPhone with A17 Pro chip, titanium design, and advanced camera system. Features 6.1-inch Super Retina XDR display, 48MP main camera, and all-day battery life.',
                'category_id' => $smartphones->id,
            ]);

            Product::create([
                'product_name' => 'Samsung Galaxy S24',
                'product_description' => 'Premium Android smartphone with AI-powered features, 6.2-inch Dynamic AMOLED display, 50MP camera system, and long-lasting battery with fast charging.',
                'category_id' => $smartphones->id,
            ]);
        }

        if ($laptops) {
            Product::create([
                'product_name' => 'MacBook Pro 16"',
                'product_description' => 'Professional laptop with M3 Pro chip, 16-inch Liquid Retina XDR display, up to 96GB unified memory, and exceptional performance for creative professionals.',
                'category_id' => $laptops->id,
            ]);

            Product::create([
                'product_name' => 'Dell XPS 15',
                'product_description' => 'Premium Windows laptop with Intel Core i9 processor, 15.6-inch 4K OLED display, NVIDIA RTX graphics, and premium build quality for power users.',
                'category_id' => $laptops->id,
            ]);
        }

        if ($mensClothing) {
            Product::create([
                'product_name' => 'Classic White T-Shirt',
                'product_description' => 'Premium cotton crew neck t-shirt with perfect fit. Made from 100% organic cotton, breathable and comfortable for everyday wear.',
                'category_id' => $mensClothing->id,
            ]);

            Product::create([
                'product_name' => 'Slim Fit Jeans',
                'product_description' => 'Modern slim fit jeans with stretch denim for maximum comfort. Classic blue wash with subtle distressing for a contemporary look.',
                'category_id' => $mensClothing->id,
            ]);
        }

        if ($womensClothing) {
            Product::create([
                'product_name' => 'Floral Summer Dress',
                'product_description' => 'Beautiful floral print summer dress with adjustable straps and flowy design. Perfect for warm weather and casual occasions.',
                'category_id' => $womensClothing->id,
            ]);

            Product::create([
                'product_name' => 'High-Waist Leggings',
                'product_description' => 'Comfortable high-waist leggings with moisture-wicking fabric. Perfect for workouts or casual wear with excellent stretch and support.',
                'category_id' => $womensClothing->id,
            ]);
        }

        if ($fiction) {
            Product::create([
                'product_name' => 'The Great Gatsby',
                'product_description' => 'F. Scott Fitzgerald\'s masterpiece about the Jazz Age. A story of decadence and excess, Gatsby explores the darker aspects of the Jazz Age, and the American Dream.',
                'category_id' => $fiction->id,
            ]);

            Product::create([
                'product_name' => '1984',
                'product_description' => 'George Orwell\'s dystopian masterpiece about totalitarianism and surveillance. A powerful warning about the dangers of authoritarianism and the manipulation of truth.',
                'category_id' => $fiction->id,
            ]);
        }

        if ($nonFiction) {
            Product::create([
                'product_name' => 'Atomic Habits',
                'product_description' => 'James Clear\'s transformative book about building good habits and breaking bad ones. Learn how tiny changes create remarkable results.',
                'category_id' => $nonFiction->id,
            ]);

            Product::create([
                'product_name' => 'Sapiens: A Brief History of Humankind',
                'product_description' => 'Yuval Noah Harari\'s groundbreaking exploration of human history. From ancient humans to the present day, this book challenges everything you thought you knew about humanity.',
                'category_id' => $nonFiction->id,
            ]);
        }

        $this->command->info('Products seeded successfully!');
    }
}
