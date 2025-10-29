<?php

// app/Providers/RouteServiceProvider.php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot(): void
    {
        parent::boot();

        $this->routes(function () {
            //
        });
    }
}
