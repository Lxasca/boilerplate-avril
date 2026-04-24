<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /**User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);**/

        /**Product::factory(100)->create();
        ProductVariant::factory(500)->create();
        Collection::factory(6)->create();

        $products = Product::all();
        Collection::all()->each(function($collection) use ($products) {
            $collection->products()->attach(
                $products->random(rand(5, 20))->pluck('id')->toArray()
            );
        });**/
    }
}
