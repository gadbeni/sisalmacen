<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEgresodetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egresodetalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            //Usuario del Sistema
            $table->unsignedBigInteger('user_id')->unsigned();
            //Sucursal del usuario
            $table->unsignedBigInteger('sucursal_id')->unsigned();
            $table->unsignedBigInteger('egreso_id');
            $table->unsignedBigInteger('facturadetalle_id');
            $table->unsignedBigInteger('solicitudcompra_id');
            $table->decimal('cantidad', 11, 2);
            $table->decimal('cantidadegresada', 11, 2);
            $table->decimal('totalbs', 11, 2);
            //ip del usuario que realiza el registro
            $table->string('registro_clientIP', 15);
            //ip del usuario que actualiza el registro
            $table->string('registro_clientIP_update', 15);
            $table->boolean('condicion')->default(1);
            $table->string('gestion', 10);
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('sucursal_id')->references('id')->on('sucursals');
            // $table->foreign('egreso_id')->references('id')->on('egresos');
            // $table->foreign('facturadetalle_id')->references('id')->on('facturadetalles');
            // $table->foreign('solicitudcompra_id')->references('id')->on('solicitudcompras');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('egresodetalles');
    }
}
