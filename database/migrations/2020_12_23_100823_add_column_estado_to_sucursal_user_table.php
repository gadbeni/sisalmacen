<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnEstadoToSucursalUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sucursal_user', function (Blueprint $table) {
            $table->string('estado',12);
            $table->datetime('fecha_inactivacion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sucursal_user', function (Blueprint $table) {
            $table->dropColumn('estado');
            $table->dropColumn('fecha_inactivacion');
        });
    }
}
