<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(mt_rand(2, 5), true);
        
        return [
            'name' => ucfirst($name),
            'description' => $this->faker->paragraph(mt_rand(2, 4)),
            'slug' => Str::slug($name) . '-' . Str::random(6),
            'price' => $this->faker->randomFloat(2, 9.99, 999.99),
            'stock' => $this->faker->numberBetween(0, 500),
            'is_active' => $this->faker->boolean(95),
            'is_featured' => $this->faker->boolean(30),
        ];
    }
}
