<?php

// Configuracion de logs de la aplicacion
// Los logs sirven para registrar errores y poder revisar que paso si algo falla
// Se guardan en storage/logs/laravel.log

return [

    // Canal por defecto que usa Laravel para escribir los logs
    'default' => env('LOG_CHANNEL', 'stack'),

    // Canales disponibles
    'channels' => [

        // Stack agrupa varios canales, en nuestro caso solo usa "single"
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
        ],

        // Single: escribe todo en un solo archivo de log
        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],

    ],

];
