<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\League;

class LeaguesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        League::truncate();

        League::create(['name' => 'NHL testa līga',
                        'maxPlayers' => 8,
                        'description' => 'Testa teksts',
                        'scoring' => 'H2H',
                        'private' => false,
                        'predictionType' => 'Win',
                        'owner_id' => 1]);
        League::create(['name' => 'Draugu līga',
                        'maxPlayers' => 10,
                        'description' => 'Šeit spēlē draugi',
                        'scoring' => 'Classic',
                        'private' => false,
                        'predictionType' => 'Score',
                        'owner_id' => 1]);
    }
}
