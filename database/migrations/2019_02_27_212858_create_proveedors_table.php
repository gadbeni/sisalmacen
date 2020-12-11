<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedors', function (Blueprint $table) {
            $table->integer('id');
            $table->string('nit', 20)->nullable();
            $table->string('razonsocial', 512)->nullable();
            $table->string('responsable', 512)->nullable();
            $table->string('direccion', 512)->nullable();
            $table->string('telefono', 512)->nullable();
            $table->string('fax', 512)->nullable();
            $table->string('comentario', 512)->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedors');
    }
}
