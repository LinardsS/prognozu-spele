<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->string('home_team')->nullable();
            $table->string('away_team')->nullable();
            $table->integer('home_team_points');
            $table->integer('away_team_points');
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->dateTime('start_time')->nullable();
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('results');
        Schema::enableForeignKeyConstraints();
    }
}
