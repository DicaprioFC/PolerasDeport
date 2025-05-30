<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('precio', 8, 2);
            $table->string('marca');
            $table->string('imagen');
            $table->boolean('oferta')->default(false); // si está en oferta o no
            $table->decimal('descuento', 5, 2)->nullable(); // porcentaje o monto de descuento
            $table->unsignedBigInteger('id_usuario');
            $table->timestamps();

            // Aquí la clave foránea apunta a 'users', no 'usuarios'
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }

    
};
