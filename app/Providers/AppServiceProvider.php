<?php

namespace App\Providers;

use App\Repositories\Hotel\HotelRepository;
use App\Repositories\Hotel\HotelRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(HotelRepositoryInterface::class, HotelRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
