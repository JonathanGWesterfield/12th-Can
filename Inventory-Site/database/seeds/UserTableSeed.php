<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert a test user for this test to work
        DB::table('users')->insert([
            'name' => 'Big Boss',
            'email' => 'bigboss@metalgear.com',
            'password' => '$2y$10$VbA0IkDbHOgU1aa7NWJk2erTd5E/v5Ia4NPE3DJarkSO9Y.dGp2Ou',
            'created_at' => '2019-10-15 18:01:17',
            'updated_at' => '2019-10-15 18:01:17',
            'phone' => '7132536097'
        ]);

        // Insert a test user for this test to work
        DB::table('users')->insert([
            'name' => 'Abdul Gay',
            'email' => 'abdul@gay.com',
            'password' => '$2y$10$VbA0IkDbHOgU1aa7NWJk2erTd5E/v5Ia4NPE3DJarkSO9Y.dGp2Ou',
            'created_at' => '2019-10-16 18:01:17',
            'updated_at' => '2019-10-16 18:01:17',
            'phone' => '7982341928'
        ]);
    }
}
