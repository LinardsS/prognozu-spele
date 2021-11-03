<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\League;
use DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user')->truncate();
        DB::table('league_user')->truncate();

        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();
        $ownerRole = Role::where('name', 'owner')->first();

        $admin = User::create([
          'name' => 'Admin User',
          'email' => 'admin@test.com',
          'password' => Hash::make('1234')
        ]);
        $user = User::create([
          'name' => 'Generic User',
          'email' => 'user@test.com',
          'password' => Hash::make('1234')
        ]);
        $owner = User::create([
          'name' => 'Owner User',
          'email' => 'owner@test.com',
          'password' => Hash::make('1234')
        ]);

        $admin->roles()->attach($adminRole);
        $user->roles()->attach($userRole);
        $owner->roles()->attach($ownerRole);

        $testLeague = League::where('name', 'NHL testa līga')->first();

        $admin->leagues()->attach($testLeague);
    }
}
