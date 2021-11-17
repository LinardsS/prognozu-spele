<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Game::truncate();

        Game::create(['home_team' => 'Pušas Nezvēri',
                      'away_team' => 'Purvciema Blēži',
                      'start_time' => date('Y-m-d H:i', strtotime('2021-01-30 22:30')),
                      'ended'      => false]);
        Game::create(['home_team' => 'Ludzas Nemiernieki',
                      'away_team' => 'Pleskavas Plēsēji',
                      'start_time' => date('Y-m-d H:i', strtotime('2021-01-31 21:10')),
                      'ended'      => false]);
        Game::create(['home_team' => 'Durbes Urbji',
                      'away_team' => 'Stoļerovas Policisti',
                      'start_time' => date('Y-m-d H:i', strtotime('2021-02-01 19:00')),
                      'ended'      => true]);
    }
}
