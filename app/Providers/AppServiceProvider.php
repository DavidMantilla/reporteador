<?php

namespace App\Providers;

use Flat3\Lodata\Facades\Lodata;
use Flat3\Lodata\EntityType;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Lodata::discover(\App\Models\User::class);
        Lodata::discover(\App\Models\Empresa::class);
        
        Lodata::discover(\App\Models\licenciamiento::class);
        Lodata::discover(\App\Models\sucursales::class);
        Lodata::discover(\App\Models\ventas::class);
        Lodata::discover(\App\Models\partventa::class);

    }
}
