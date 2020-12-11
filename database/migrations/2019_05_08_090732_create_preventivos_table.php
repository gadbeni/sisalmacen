<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreventivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preventivos', function (Blueprint $table) {
            $table->bigIncrements('id');
            //Usuario del Sistema
            $table->unsignedBigInteger('user_id')->unsigned();
            //Sucursal del usuario
            $table->unsignedBigInteger('sucursal_id')->unsigned();
            $table->unsignedBigInteger('solicitudcompra_id');
            $table->unsignedBigInteger('proyecto_id');
            $table->unsignedBigInteger('partida_id');
            $table->string('numeropreventivo', 50);
            $table->decimal('monto', 11, 2);
            //ip del usuario que realiza el registro
            $table->string('registro_clientIP', 15);
            //ip del usuario que actualiza el registro
            $table->string('registro_clientIP_update', 15);
            $table->boolean('condicion')->default(1);
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('sucursal_id')->references('id')->on('sucursals');
            // $table->foreign('solicitudcompra_id')->references('id')->on('solicitudcompras');
            // $table->foreign('proyecto_id')->references('id')->on('proyectos');
            // $table->foreign('partida_id')->references('id')->on('partidas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preventivos');
    }
}
