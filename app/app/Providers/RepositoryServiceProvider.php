<?php

namespace App\Providers;

use App\Repositories\CompanyRepository;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Repositories\Contracts\GatewayRepositoryInterface;
use App\Repositories\Contracts\Gateways\PaymentGatewayRepositoryInterface;
use App\Repositories\Contracts\LoginRepositoryInterface;
use App\Repositories\Contracts\PayerRepositoryInterface;
use App\Repositories\Contracts\PaymentIntentionRepositoryInterface;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Repositories\Gateways\MercadoPagoRepository;
use App\Repositories\GatewayRepository;
use App\Repositories\LoginRepository;
use App\Repositories\PayerRepository;
use App\Repositories\PaymentIntentionRepository;
use App\Repositories\PaymentRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            CompanyRepositoryInterface::class,
            CompanyRepository::class
        );

        $this->app->bind(
            PayerRepositoryInterface::class,
            PayerRepository::class
        );

        $this->app->bind(
            PaymentRepositoryInterface::class,
            PaymentRepository::class
        );

        $this->app->bind(
            PaymentIntentionRepositoryInterface::class,
            PaymentIntentionRepository::class
        );

        $this->app->bind(
            GatewayRepositoryInterface::class,
            GatewayRepository::class
        );

        $this->app->bind(
            PaymentGatewayRepositoryInterface::class,
            MercadoPagoRepository::class
        );

        $this->app->bind(
            LoginRepositoryInterface::class,
            LoginRepository::class
        );
    }
}
