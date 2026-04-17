<?php

namespace App\Http\Controllers;

// Controlador de salud del sistema
// Su funcion es responder con el estado actual de la aplicacion
// Esto permite saber si el backend esta operativo y funcionando en Docker
class HealthController extends Controller
{
    // Metodo que retorna el estado del sistema en formato JSON
    // Responde con un codigo HTTP 200 (OK) para confirmar que esta activo
    public function index()
    {
        return response()->json([
            'status' => 'online',
            'version' => '1.0.0',
            'environment' => 'docker',
        ], 200);
    }
}
