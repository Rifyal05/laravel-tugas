<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Categories;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // panggil semua data product categories
        $categories = Categories::all();

        $products = [];
        $faker = \Faker\Factory::create();

        foreach ($categories as $category) {
            for ($i = 1; $i <= 200; $i++) {
                $products[] = [
                    'name' => $category->name . ' Product ' . $i,
                    'slug' => strtolower(str_replace(' ', '-', $category->name)) . '-product-' . $i,
                    'description' => $faker->sentence(10),
                    'sku' => strtoupper($category->name) . '-' . $faker->unique()->numerify('#####'),
                    'stock' => $faker->numberBetween(1, 100),
                    'category_id' => $category->id, // Diperbaiki
                    'price' => $faker->randomFloat(2, 10, 1000),
                    'is_active' => $faker->boolean(80),
                    'image' => 'https://placehold.co/300x300?text=' . urlencode($category->name . ' ' . $i), // Diperbaiki
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // insert into products table
        Product::insert($products);
        $this->command->info('Categories and products seeded successfully!');
    }
}