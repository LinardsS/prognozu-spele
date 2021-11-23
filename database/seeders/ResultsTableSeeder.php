<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Result;

class ResultsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Result::truncate();
        Result::create(['home_team'      => 'Pušas Nezvēri',
                      'away_team'        => 'Purvciema Blēži',
                      'home_team_points' => 5,
                      'away_team_points' => 4,
                      'game_id'          => 1]);
        Result::create(['home_team'      => 'Ludzas Nemiernieki',
                      'away_team'        => 'Pleskavas Plēsēji',
                      'home_team_points' => 100,
                      'away_team_points' => 97,
                      'game_id'          => 2]);
    }
}
