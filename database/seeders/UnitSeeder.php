<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = collect([
            [
                'name' => 'Piece',
                'slug' => 'piece',
                'short_code' => 'pc'
            ],
            [
                'name' => 'Set',
                'slug' => 'set',
                'short_code' => 'set'
            ]
        ]);

        $units->each(function ($unit){
            Unit::insert($unit);
        });
    }
}
