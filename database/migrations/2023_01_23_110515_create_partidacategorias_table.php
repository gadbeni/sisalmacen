<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartidacategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partidacategorias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partida_id')->unsigned();
            $table->unsignedBigInteger('categoria_id')->unsigned();
            $table->timestamps();

            $table->foreign('partida_id')->references('id')->on('partidas');
            $table->foreign('categoria_id')->references('id')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partidacategorias');
    }
}
