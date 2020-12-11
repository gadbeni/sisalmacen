<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnidadadministrativasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidadadministrativas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo', 10);
            $table->text('nombre');
            $table->unsignedBigInteger('direccionadministrativa_id')->unsigned();
            $table->integer('idNivelID')->unsigned()->nullable();
            $table->integer('estado');

            // $table->foreign('direccionadministrativa_id')->references('id')->on('direccionadministrativas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unidadadministrativas');
    }
}
