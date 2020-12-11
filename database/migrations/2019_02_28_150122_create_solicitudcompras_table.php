<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudcomprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudcompras', function (Blueprint $table) {
            $table->bigIncrements('id');
            //Usuario del Sistema
            $table->unsignedBigInteger('user_id')->unsigned();
            //Sucursal del usuario
            $table->unsignedBigInteger('sucursal_id')->unsigned();
            //Entidades solicitantes
            $table->unsignedBigInteger('entidad_id')->unsigned();
            //$table->string('entidad', 512)->nullable();
            $table->string('numerosolicitud', 30)->nullable();
            $table->date('fechaingreso');
            //ip del usuario que realiza el registro
            $table->string('registro_clientIP', 15);
            //ip del usuario que actualiza el registro
            $table->string('registro_clientIP_update', 15);
            $table->boolean('condicionegreso')->default(1);
            $table->boolean('condicion')->default(1);
            $table->string('gestion', 10);
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('sucursal_id')->references('id')->on('sucursals');
            // $table->foreign('entidad_id')->references('id')->on('entidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitudcompras');
    }
}
