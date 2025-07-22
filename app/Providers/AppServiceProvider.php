<?php

namespace App\Providers;

use App\View\Composers\ProfilComposer;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
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
    public function boot(): void
    {
        // share data profil instansi
        View::composer('*', ProfilComposer::class);

        // Pagination
        Paginator::useBootstrapFive();

        // Localization Carbon
        Carbon::setLocale(config('app.locale'));
    }
}
