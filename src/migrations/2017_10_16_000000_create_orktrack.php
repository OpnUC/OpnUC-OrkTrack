<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrktrack extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orktracks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('recid');
            $table->integer('status');
            $table->string('filename');
            $table->dateTime('timestamp');
            $table->string('localparty');
            $table->string('remoteparty');
            $table->integer('duration');
            $table->string('hostname');
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
        Schema::drop('orktracks');
    }
}