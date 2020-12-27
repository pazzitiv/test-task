<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Draw\Database\Seeders\DrawDatabaseSeeder;
use Modules\Prize\Database\Seeders\PrizeDatabaseSeeder;
use Modules\User\Database\Seeders\UserDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(UserDatabaseSeeder::class)
            ->call(PrizeDatabaseSeeder::class)
            ->call(DrawDatabaseSeeder::class);
    }
}
