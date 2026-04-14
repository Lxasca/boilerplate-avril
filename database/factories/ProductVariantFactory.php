<?php

namespace Database\Factories;

use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['clothing', 'liquid', 'color_only', 'clothing_color']);

        $color = fake()->randomElement(['Rouge', 'Bleu', 'Noir', 'Gris', 'Blanc', 'Vert', 'Jaune', 'Rose']);
        $size = fake()->randomElement(['XS', 'S', 'M', 'L', 'XL', 'XXL']);
        $capacity = fake()->randomElement(['50ml', '100ml', '200ml', '250ml', '500ml', '1L', '1.5L', '2L']);

        return [
            'product_id' => fake()->numberBetween(1, 100),
            'color' => in_array($type, ['color_only', 'clothing_color']) ? $color : null,
            'size' => in_array($type, ['clothing', 'clothing_color']) ? $size : null,
            'capacity' => $type === 'liquid' ? $capacity : null,
            'price' => fake()->optional(0.4)->randomFloat(2, 5, 500),
            'stock' => fake()->numberBetween(0, 50),
            'is_active' => fake()->boolean(90),
        ];
    }
}
