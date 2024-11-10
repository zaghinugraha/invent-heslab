<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = collect([
            [
                'id'    => 1,
                'name'  => 'Mainboard',
                'slug'  => 'mainboard',
                'created_at' => now(),
                'user_id' => 1
            ],
            [
                'id'    => 2,
                'name'  => 'Sensor',
                'slug'  => 'sensor',
                'created_at' => now(),
                'user_id' => 1
            ],
            [
                'id'    => 3,
                'name'  => 'Miscellaneous',
                'slug'  => 'misc',
                'created_at' => now(),
                'user_id' => 1
            ],
            [
                'id'    => 4,
                'name'  => 'Cables',
                'slug'  => 'cables',
                'created_at' => now(),
                'user_id' => 1
            ],
            [
                'id'    => 5,
                'name'  => 'Software',
                'slug'  => 'software',
                'created_at' => now(),
                'user_id' => 1
            ]
        ]);

        $categories->each(function ($category){
            Category::insert($category);
        });
    }
}
