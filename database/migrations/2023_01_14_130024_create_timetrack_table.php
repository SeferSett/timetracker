<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetrack', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('user_id');
            $table->bigInteger('start_time');
            $table->bigInteger('finish_time')->nullable();
            $table->integer('is_paused')->nullable();
            $table->bigInteger('next_id')->nullable();
            $table->bigInteger('prev_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timetrack');
    }
};
