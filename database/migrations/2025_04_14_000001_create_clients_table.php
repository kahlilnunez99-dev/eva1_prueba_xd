<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migracion para crear la tabla 'clients'
// Las migraciones permiten versionar los cambios en la base de datos
// Asi todo el equipo puede tener la misma estructura sin ejecutar SQL manual
return new class extends Migration
{
    // Metodo up: se ejecuta cuando corremos la migracion
    // Crea la tabla clients con los campos solicitados
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            // ID autoincremental sin signo como clave primaria
            $table->increments('client_id');

            // Datos personales del cliente
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 100)->unique(); // El email debe ser unico
            $table->string('phone_number', 20)->nullable(); // El telefono es opcional
            $table->date('date_of_birth')->nullable(); // La fecha de nacimiento es opcional

            // Timestamps para saber cuando se creo y actualizo el registro
            $table->timestamps();
        });
    }

    // Metodo down: se ejecuta cuando revertimos la migracion
    // Elimina la tabla clients
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
