<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturadetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturadetalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            //Usuario del Sistema
            $table->unsignedBigInteger('user_id')->unsigned();
            //Sucursal del Usuario
            $table->unsignedBigInteger('sucursal_id')->unsigned();
            $table->unsignedBigInteger('factura_id');
            $table->unsignedBigInteger('articulo_id');
            $table->decimal('cantidadsolicitada', 11, 2);
            $table->decimal('cantidadrestante', 11, 2);
            $table->decimal('preciocompra', 11, 2);
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
            // $table->foreign('factura_id')->references('id')->on('facturas');
            // $table->foreign('articulo_id')->references('id')->on('articulos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturadetalles');
    }
}
