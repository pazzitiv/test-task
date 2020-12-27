<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        if(!User::find(1)) User::create([
            'id' => 1,
            'login' => 'admin',
            'email' => 'pazzitiv@gmail.com',
            'password' => '123qwe',
            'card_number' => '1111-2222-3333-4444',
        ]);

        // $this->call("OthersTableSeeder");
    }
}
