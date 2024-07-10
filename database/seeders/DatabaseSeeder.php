<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
        \App\Models\Product::factory()->create([
            'id' => '4450',
            'types' => 'Smartphone',
            'brand' => 'Apple',
            'model' => 'iPhone SE',
            'capacity' => '2GB/16GB',
            'quantity' => '13',
        ]);

        \App\Models\Product::factory()->create([
            'id' => '4768',
            'types' => 'Smartphone',
            'brand' => 'Apple',
            'model' => 'iPhone SE',
            'capacity' => '2GB/32GB',
            'quantity' => '30',
        ]);

        \App\Models\Product::factory()->create([
            'id' => '4451',
            'types' => 'Smartphone',
            'brand' => 'Apple',
            'model' => 'iPhone SE',
            'capacity' => '2GB/64GB',
            'quantity' => '20',
        ]);

        \App\Models\Product::factory()->create([
            'id' => '4574',
            'types' => 'Smartphone',
            'brand' => 'Apple',
            'model' => 'iPhone SE',
            'capacity' => '2GB/128GB',
            'quantity' => '16',
        ]);

        \App\Models\Product::factory()->create([
            'id' => '6039',
            'types' => 'Smartphone',
            'brand' => 'Apple',
            'model' => 'iPhone SE (2020)',
            'capacity' => '3GB/64GB',
            'quantity' => '18',
        ]);
    }
}
