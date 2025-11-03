<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (!file_exists(storage_path('framework/views'))) {
            mkdir(storage_path('framework/views'), 0755, true);
        }
    }

}
