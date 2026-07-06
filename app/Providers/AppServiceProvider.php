<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;

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
    if (app()->environment('production')) {
        URL::forceScheme('https');
    }

    // Paginatsiya — Bootstrap markup (admin AdminLTE/Bootstrap CSS bilan styling bo'ladi).
    // Journal panellari .jsite-admin-pagination CSS orqali shu markupga moslangan.
    Paginator::useBootstrapFour();
}
}
