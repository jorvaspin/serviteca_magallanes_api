<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenTrabajoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_trabajo', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('patente');
            $table->string('marca');
            $table->string('modelo');
            $table->integer('kilometraje');
            $table->string('nombre_cliente');
            $table->string('mecanico');
            $table->string('forma_pago');
            $table->integer('total_a_pagar');
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
        Schema::dropIfExists('orden_trabajo');
    }
}
