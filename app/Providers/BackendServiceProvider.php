<?php

namespace App\Providers;

use App\Repositories\Eloquent\Transaction\TransactionRepositoryInterface;
use App\Repositories\Eloquent\Transaction\TransactionRepository;
use App\Repositories\Eloquent\User\UserRepositoryInterface;
use App\Repositories\Eloquent\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $providers = [
            TransactionRepositoryInterface::class => TransactionRepository::class,
            UserRepositoryInterface::class => UserRepository::class
        ];

        foreach ($providers as $interface => $repository) {
            $this->app->bind($interface, $repository);
        }
    }
}
