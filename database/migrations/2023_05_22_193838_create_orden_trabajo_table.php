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
            $table->unsignedBigInteger('uuid')->unique();
            $table->string('patente')->nullable();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->integer('kilometraje')->nullable();
            $table->string('nombre_cliente')->nullable();
            $table->string('mecanico')->nullable();
            $table->string('forma_pago')->nullable();
            $table->integer('total_a_pagar')->nullable();
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
