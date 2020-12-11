<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->bigIncrements('id');
            //Usuario del Sistema
            $table->unsignedBigInteger('user_id')->unsigned();
            //Sucursal del usuario
            $table->unsignedBigInteger('sucursal_id')->unsigned();
            $table->unsignedBigInteger('direccionadministrativa_id');
            $table->unsignedBigInteger('unidadadministrativa_id');
            $table->string('codigo', 10);
            $table->string('nombre', 512);
            $table->boolean('condicion')->default(1);
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('sucursal_id')->references('id')->on('sucursals');
            // $table->foreign('direccionadministrativa_id')->references('id')->on('direccionadministrativas');
            // $table->foreign('unidadadministrativa_id')->references('id')->on('unidadadministrativas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyectos');
    }
}
