<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egresos', function (Blueprint $table) {
            $table->bigIncrements('id');
            //Usuario del Sistema
            $table->unsignedBigInteger('user_id')->unsigned();
            //Sucursal del usuario
            $table->unsignedBigInteger('sucursal_id')->unsigned();
            //Direccion administrativa
            $table->unsignedBigInteger('direccionadministrativa_id')->unsigned();
            //Unidad administrativa
            $table->unsignedBigInteger('unidadadministrativa_id')->unsigned()->nullable();
            $table->unsignedBigInteger('cuenta_id');
            $table->string('codigopedido', 50);
            $table->date('fechasolicitud');
            $table->datetime('fechasalida');
            //ip del usuario que realiza el registro
            $table->string('registro_clientIP', 15);
            //ip del usuario que actualiza el registro
            $table->string('registro_clientIP_update', 15);
            $table->boolean('condicion')->default(1);
            $table->string('gestion', 10);
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('sucursal_id')->references('id')->on('sucursals');
            // $table->foreign('direccionadministrativa_id')->references('id')->on('direccionadministrativas');
            // $table->foreign('unidadadministrativa_id')->references('id')->on('unidadadministrativas');
            // $table->foreign('cuenta_id')->references('id')->on('cuentas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('egresos');
    }
}
