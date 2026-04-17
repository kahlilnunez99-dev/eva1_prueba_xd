<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Seeder principal de la aplicacion
// Desde aqui se llaman a todos los seeders del proyecto
// Al ejecutar 'php artisan db:seed' se ejecuta este archivo
class DatabaseSeeder extends Seeder
{
    // Ejecuta los seeders registrados
    public function run(): void
    {
        // Llamamos al seeder de clientes para insertar datos de prueba
        $this->call([
            ClientSeeder::class,
        ]);
    }
}
