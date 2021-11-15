<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prediction;

class PredictionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Prediction::truncate();

        Prediction::create(['home_team_points' => 123,
                            'away_team_points' => 110,
                            'user_id'          => 1,
                            'league_id'        => 1,
                            'game_id'          => 1]);
        Prediction::create(['home_team_points' => 100,
                            'away_team_points' => 90,
                            'user_id'          => 2,
                            'league_id'        => 1,
                            'game_id'          => 1]);
    }
}
