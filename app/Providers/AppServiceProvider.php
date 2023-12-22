<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Responses\CustomTokenResponse;
// use Laravel\Passport\Response as PassportResponse;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Passport::routes();
        // $this->app->bind(PassportResponse::class, CustomTokenResponse::class);
    }
}
