<?php

namespace Modules\Prize\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Prize\Entities\Prize;
use Modules\Prize\Entities\PrizeTypes;

class PrizeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        if (count(PrizeTypes::where('code', 'money')->get()->toArray()) === 0) {
            PrizeTypes::create([
                'code' => 'money'
            ]);
        }
        if (count(PrizeTypes::where('code', 'chips')->get()->toArray()) === 0) {
            PrizeTypes::create([
                'code' => 'chips'
            ]);
        }
        if (count(PrizeTypes::where('code', 'item')->get()->toArray()) === 0) {
            PrizeTypes::create([
                'code' => 'item'
            ]);
        }

        if (!Prize::find(1)) {
            Prize::create([
                'id' => 1,
                'prizeName' => 'PlayStation 5 Digital Edition',
                'price' => 300
            ]);
        }
        if (!Prize::find(2)) {
            Prize::create([
                'id' => 2,
                'prizeName' => 'PlayStation 5',
                'price' => 400,
            ]);
        }

        // $this->call("OthersTableSeeder");
    }
}
