<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modelo Client
// Representa la tabla 'clients' en la base de datos
// Laravel usa este modelo para interactuar con los datos de los clientes
// a traves del ORM Eloquent, sin necesidad de escribir SQL directamente
class Client extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'clients';

    // Clave primaria de la tabla
    // Se usa client_id en vez del id por defecto de Laravel
    protected $primaryKey = 'client_id';

    // Campos que se pueden llenar de forma masiva
    // Esto protege contra asignaciones no deseadas (mass assignment)
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'date_of_birth',
    ];

    // Casteo de campos para que Laravel los convierta automaticamente
    // al tipo correcto cuando los leemos desde la base de datos
    protected $casts = [
        'date_of_birth' => 'date',
    ];
}
