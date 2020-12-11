<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaldocompradetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saldocompradetalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->unsignedBigInteger('saldocompra_id')->unsigned();
            $table->unsignedBigInteger('mes_id')->unsigned();
            $table->decimal('ingreso', 11, 2);
            $table->decimal('egreso', 11, 2);
            $table->decimal('saldo', 11, 2);
            $table->string('registro_clientIP', 15);
            $table->string('registro_clientIP_update', 15);
            $table->boolean('condicion')->default(1);
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('saldocompra_id')->references('id')->on('saldocompras');
            // $table->foreign('mes_id')->references('id')->on('meses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saldocompradetalles');
    }
}
