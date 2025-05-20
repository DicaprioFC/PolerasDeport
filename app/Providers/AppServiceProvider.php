<?php

namespace App\Providers;

use App\Models\Carrito;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */


    public function boot()
    {
        View::composer('*', function ($view) {
            $carritoCantidad = 0;
            if (Auth::check()) {
                $carritoCantidad = Carrito::where('user_id', Auth::id())->sum('cantidad');
            }
            session(['carrito_cantidad' => $carritoCantidad]);
        });
    }
}
