<?php

namespace App\Providers;

use Flat3\Lodata\ComplexValue;
use Flat3\Lodata\Facades\Lodata;
use Flat3\Lodata\GeneratedProperty;
use Flat3\Lodata\Operation;
use Flat3\Lodata\Type;
use Illuminate\Support\Facades\Log;
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
        Lodata::discover(\App\Models\partventa::class);
        Lodata::discover(\App\Models\ventas::class);
    
        // $getMonth = new Operation\Function_('month'); // Nombre de la función

        // $getMonth->setCallable(function (string $fechaDoc): int {
        //     return (int) date('m', strtotime($fechaDoc));
        // });
      //  Lodata::add($getMonth);
        







        // Agregar propiedad calculada para el mes



    }
}
