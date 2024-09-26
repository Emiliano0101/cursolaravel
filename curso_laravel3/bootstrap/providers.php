<?php

use Barryvdh\Debugbar\ServiceProvider as DebugbarServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    // Otros Service Providers...

    // Agregar Debugbar ServiceProvider
    Barryvdh\Debugbar\ServiceProvider::class,
];
