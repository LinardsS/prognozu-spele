<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(LeaguesTableSeeder::class);
        $this->call(GamesTableSeeder::class);
        $this->call(PredictionsTableSeeder::class);
        $this->call(ResultsTableSeeder::class);

    }
}
