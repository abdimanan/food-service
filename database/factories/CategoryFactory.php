<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
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
        $name = fake()->unique()->randomElement([
            'Appetizers',
            'Main Courses',
            'Desserts',
            'Beverages',
            'Salads',
            'Soups',
            'Sandwiches',
            'Pizza',
            'Pasta',
            'Seafood',
            'Vegetarian',
            'Vegan',
            'Breakfast',
            'Lunch',
            'Dinner',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'is_active' => true,
        ];
    }
}
