<?php

namespace Modules\Draw\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Draw\Entities\Draw;
use Modules\Draw\Entities\DrawPrizes;

class DrawDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Draw::factory(3)->create();

        if (!DrawPrizes::find(1)) {
            DrawPrizes::create([
                'id' => 1,
                'draw_id' => 1,
                'prize_type' => 1,
                'amount' => 10000,
                'max_count' => 200,
            ]);
        }
        if (!DrawPrizes::find(2)) {
            DrawPrizes::create([
                'id' => 2,
                'draw_id' => 1,
                'prize_type' => 2,
                'max_count' => 150,
            ]);
        }
        if (!DrawPrizes::find(3)) {
            DrawPrizes::create([
                'id' => 3,
                'draw_id' => 2,
                'prize_type' => 1,
                'amount' => 10000,
                'max_count' => 50,
            ]);
        }
        if (!DrawPrizes::find(4)) {
            DrawPrizes::create([
                'id' => 4,
                'draw_id' => 2,
                'prize_type' => 2,
                'max_count' => 200,
            ]);
        }
        if (!DrawPrizes::find(5)) {
            DrawPrizes::create([
                'id' => 5,
                'draw_id' => 2,
                'prize_type' => 3,
                'amount' => 1,
                'item_id' => 1,
            ]);
        }
        if (!DrawPrizes::find(6)) {
            DrawPrizes::create([
                'id' => 6,
                'draw_id' => 3,
                'prize_type' => 1,
                'amount' => 1000,
                'max_count' => 100,
            ]);
        }
        if (!DrawPrizes::find(7)) {
            DrawPrizes::create([
                'id' => 7,
                'draw_id' => 3,
                'prize_type' => 2,
                'max_count' => 100,
            ]);
        }
        if (!DrawPrizes::find(8)) {
            DrawPrizes::create([
                'id' => 8,
                'draw_id' => 3,
                'prize_type' => 3,
                'amount' => 3,
                'item_id' => 2,
            ]);
        }

        // $this->call("OthersTableSeeder");
    }
}
