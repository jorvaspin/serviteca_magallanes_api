<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewsRelationToOrdenTrabajo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orden_trabajo', function (Blueprint $table) {
            //añadimos work_id a las orden de trabajo
            $table->unsignedBigInteger('work_id')->nullable()->after('id');
            // relacion de workshop con orden_trabajo
            $table->foreign('work_id')->references('id')->on('workshops');
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
