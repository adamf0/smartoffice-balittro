<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        config(['app.locale' => 'id']);
        \Carbon\Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID');
        date_default_timezone_set('Asia/Jakarta');
    }
}
