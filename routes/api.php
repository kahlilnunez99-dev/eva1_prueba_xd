<?php

// Archivo de rutas de la API
// Aqui se definen todos los endpoints que estaran disponibles para el cliente
// Laravel agrega automaticamente el prefijo /api a todas las rutas de este archivo

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthController;

// Ruta de salud del sistema
// Se usa para verificar que la aplicacion esta funcionando correctamente
// Metodo: GET | URL: /api/health
Route::get('/health', [HealthController::class, 'index']);
