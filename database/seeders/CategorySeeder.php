<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{

    public function run(): void
    {
        $electronics = Category::create([
            'category_name' => 'Electronics',
        ]);

        $clothing = Category::create([
            'category_name' => 'Clothing',
        ]);

        $books = Category::create([
            'category_name' => 'Books',
        ]);
        
        Category::create([
            'category_name' => 'Smartphones',
            'parent_id' => $electronics->id,
        ]);

        Category::create([
            'category_name' => 'Laptops',
            'parent_id' => $electronics->id,
        ]);

        Category::create([
            'category_name' => 'Men\'s Clothing',
            'parent_id' => $clothing->id,
        ]);

        Category::create([
            'category_name' => 'Women\'s Clothing',
            'parent_id' => $clothing->id,
        ]);

        Category::create([
            'category_name' => 'Fiction',
            'parent_id' => $books->id,
        ]);

        Category::create([
            'category_name' => 'Non-Fiction',
            'parent_id' => $books->id,
        ]);

        $this->command->info('Categories seeded successfully!');
    }
}
