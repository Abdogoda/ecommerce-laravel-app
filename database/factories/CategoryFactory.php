<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(mt_rand(2, 4), true);
        
        return [
            'name' => ucfirst($name),
            'description' => $this->faker->sentence(mt_rand(5, 15)),
            'slug' => Str::slug($name) . '-' . Str::random(6),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
