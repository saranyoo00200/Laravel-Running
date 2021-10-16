<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreboardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scoreboards', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable()->comment('รูป');
            $table->date('date_at')->nullable()->comment('วันที่ที่วิ่ง');
            $table->integer('number_score')->nullable()->comment('จำนวนระยะทาง(kl)');
            $table->char('user_id')->nullable()->comment('userID');
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
        Schema::dropIfExists('scoreboards');
    }
}
