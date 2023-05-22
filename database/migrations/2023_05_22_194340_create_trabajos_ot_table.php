<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabajosOtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajos_ot', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_trabajo');
            $table->integer('precio');
            $table->unsignedBigInteger('ot_id');
            $table->timestamps();

            $table->foreign('ot_id')->references('id')->on('orden_trabajo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabajos_ot');
    }
}
