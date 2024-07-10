<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'types' => 'Smartphone',
            'brand' => 'Apple',
            'model' => 'iPhone',
            'capacity' => '2GB/16GB',
            'quantity' => rand(1, 50),
        ];
    }
}
