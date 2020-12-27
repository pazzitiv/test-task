<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrawPrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draw_prizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('draw_id')
                ->constrained('draws');
            $table->foreignId('prize_type')
                ->constrained('prize_types');
            $table->bigInteger('amount')
                ->default(0)
                ->nullable(false);
            $table->bigInteger('item_id')
                ->nullable('true')
                ->default(null);
            $table->bigInteger('max_count')
                ->nullable(false)
                ->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('draw_prizes');
    }
}
