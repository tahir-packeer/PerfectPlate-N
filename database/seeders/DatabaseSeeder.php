<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\User;
use App\Models\Slider;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //User::factory()->create([
          //  'name' => 'Test User',
            //'email' => 'test@example.com',
        //]);
        $this->call(UserSeeder::class);
        Slider::factory(3)->create();
        $this->call(CategorySeeder::class);
        \App\Models\Product::factory(10)->create();
        \App\Models\Coupon::factory(3)->create();
    }
}
