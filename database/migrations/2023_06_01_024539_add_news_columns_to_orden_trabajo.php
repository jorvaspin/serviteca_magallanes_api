<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewsColumnsToOrdenTrabajo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orden_trabajo', function (Blueprint $table) {
            //añadimos user_id y workshop_id a las orden de trabajo
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->unsignedBigInteger('workshop_id')->nullable()->after('id');
            // creamos la relacion entre la tabla orden_trabajo y users
            $table->foreign('user_id')->references('id')->on('users');
            // creamos la relacion entre la tabla orden_trabajo y workshops
            $table->foreign('workshop_id')->references('id')->on('workshops');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orden_trabajo', function (Blueprint $table) {
            //
        });
    }
}
