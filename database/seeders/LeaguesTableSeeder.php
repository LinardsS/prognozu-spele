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
                        'description' => 'Testa teksts',
                        'scoring' => 'H2H',
                        'private' => false]);
        League::create(['name' => 'Draugu līga',
                        'description' => 'Šeit spēlē draugi',
                        'scoring' => 'Classic',
                        'private' => false]);
    }
}
