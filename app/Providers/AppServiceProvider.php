<?php

namespace App\Providers;

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
        // $this->routes(function () {
        //     Route::middleware('console')
        //         ->prefix('console')
        //         ->group(base_path('routes/console.php'));

        //     Route::middleware('web')
        //         ->group(base_path('routes/web.php'));
        // });
    }

}