<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Insert sample data into transactions table
        for ($i = 0; $i < 10; $i++) {
            DB::table('transactions')->insert([
                'user_id' => rand(1, 5), // Assuming you have 5 users in the users table
                'category_id' => rand(1, 3), // Assuming you have 3 categories in the categories table
                'customer_id' => rand(1, 5), // Assuming you have customers linked to users
                'amount' => $faker->randomFloat(2, 10, 1000), // Random amount between 10 and 1000
                'description' => $faker->sentence(), // Random description
                'transaction_date' => $faker->date(), // Random transaction date
                'created_at' => now(), // Current timestamp for created_at
                'updated_at' => now(), // Current timestamp for updated_at
            ]);
        }
    }

    
}
