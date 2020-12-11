<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddObservationToSaldocomprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saldocompras', function (Blueprint $table) {
            $table->string('observation')->nullable();
            $table->decimal('saldo_final',8,2)->nullable()->default(0);
            //$table->renameColumn('monto_aux', 'saldo_final');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saldocompras', function (Blueprint $table) {
            $table->dropColumn('observation');
            $table->dropColumn('saldo_final');
        });
    }
}
