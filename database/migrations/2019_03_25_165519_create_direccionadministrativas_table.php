<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDireccionadministrativasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direccionadministrativas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo', 250)->nullable();
            $table->string('nombre', 250)->nullable();
            $table->string('numero', 250)->nullable();
            $table->string('nit', 250)->nullable();
            $table->unsignedBigInteger('grupoda_id')->unsigned();
            $table->integer('idNivelE')->unsigned();
            $table->integer('idMae')->unsigned();
            $table->integer('estado');
            $table->timestamps();

            // $table->foreign('grupoda_id')->references('id')->on('grupodas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('direccionadministrativas');
    }
}
