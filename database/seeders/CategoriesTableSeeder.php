<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Salary', 'type' => 'income'],
            ['name' => 'รายรับอื่น ๆ', 'type' => 'income'],
            ['name' => 'รายจ่ายอื่น ๆ', 'type' => 'expense'],
            ['name' => 'โอนเงิน', 'type' => 'expense'],
            ['name' => 'ได้รับเงินโอน', 'type' => 'income'],
        ];

        // Insert sample data into categories table
        DB::table('categories')->insert($categories);
    }
}
