<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

// Seeder de clientes
// Los seeders sirven para insertar datos de prueba en la base de datos
// Esto es util para desarrollo y para verificar que la tabla funciona bien
class ClientSeeder extends Seeder
{
    // Metodo que inserta los datos de prueba en la tabla clients
    public function run(): void
    {
        // Creamos algunos clientes de ejemplo para probar la base de datos
        Client::create([
            'first_name' => 'Juan',
            'last_name' => 'Perez',
            'email' => 'juan.perez@email.com',
            'phone_number' => '+56912345678',
            'date_of_birth' => '1990-05-15',
        ]);

        Client::create([
            'first_name' => 'Maria',
            'last_name' => 'Lopez',
            'email' => 'maria.lopez@email.com',
            'phone_number' => '+56987654321',
            'date_of_birth' => '1985-10-20',
        ]);

        Client::create([
            'first_name' => 'Carlos',
            'last_name' => 'Gonzalez',
            'email' => 'carlos.gonzalez@email.com',
            'phone_number' => '+56911223344',
            'date_of_birth' => '1995-03-08',
        ]);
    }
}
