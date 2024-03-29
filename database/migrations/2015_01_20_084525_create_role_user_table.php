<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $name = config('shinobi.tables.role_user');

        Schema::create($name, function (Blueprint $table) {
            // $table->bigIncrements('id');
            $table->integer('id');
            $table->integer('role_id');
            // $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->integer('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        $name = config('shinobi.tables.role_user');

        Schema::drop($name);
    }
}
