<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $name = config('shinobi.tables.permission_role');

        Schema::create($name, function (Blueprint $table) {
            $table->integer('id');
            $table->integer('permission_id');
            // $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->integer('role_id');
            // $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
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
        $name = config('shinobi.tables.permission_role');

        Schema::drop($name);
    }
}
