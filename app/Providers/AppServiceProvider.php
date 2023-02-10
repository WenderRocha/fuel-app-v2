<?php

namespace App\Providers;

use App\Services\Management\ManagementService;
use App\Services\Management\ManagementServiceInterface;
use App\Services\Trade\TradeService;
use App\Services\Trade\TradeServiceInterface;
use App\Services\Wallet\WalletService;
use App\Services\Wallet\WalletServiceInterface;
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
        $this->app->bind(TradeServiceInterface::class, TradeService::class);
        $this->app->bind(ManagementServiceInterface::class, ManagementService::class);
        $this->app->bind(WalletServiceInterface::class, WalletService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
