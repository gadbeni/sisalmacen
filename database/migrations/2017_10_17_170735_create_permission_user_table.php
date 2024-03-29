<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionUserTable extends Migration
{
    public function up()
    {
        $name = config('shinobi.tables.permission_user');

        Schema::create($name, function (Blueprint $table) {
            $table->integer('id');
            $table->integer('permission_id');
            // $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->integer('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        $name = config('shinobi.tables.permission_user');

        Schema::drop($name);
    }

}
