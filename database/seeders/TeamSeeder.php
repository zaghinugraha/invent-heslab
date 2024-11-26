<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\User;
use Str;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            [
                'name' => 'Admin',
                'user_id' => 1,
                'personal_team' => false,
            ],
            [
                'name' => 'Regular',
                'user_id' => 1,
                'personal_team' => false,
            ],
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }
    }
}
