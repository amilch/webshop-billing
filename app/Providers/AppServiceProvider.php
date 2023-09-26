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
        $this->app->bind(
            \Domain\Interfaces\OrderRepository::class,
            \App\Repositories\OrderDatabaseRepository::class
        );

        $this->app->bind(
            \Domain\Interfaces\OrderItemFactory::class,
            \App\Factories\OrderItemModelFactory::class
        );

        $this->app->bind(
            \Domain\Interfaces\OrderFactory::class,
            \App\Factories\OrderModelFactory::class
        );

        $this->app
            ->when(\App\Http\Controllers\GetOrdersController::class)
            ->needs(\Domain\UseCases\GetOrders\GetOrdersInputPort::class)
            ->give(function ($app) {
                return $app->make(\Domain\UseCases\GetOrders\GetOrdersInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\GetOrdersJsonPresenter::class)
                ]);
            });


        $this->app
            ->when(\App\Http\Controllers\CreateOrderController::class)
            ->needs(\Domain\UseCases\CreateOrder\CreateOrderInputPort::class)
            ->give(function ($app) {
                return $app->make(\Domain\UseCases\CreateOrder\CreateOrderInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\CreateOrderJsonPresenter::class),
                    'messageOutput' => $app->make(\App\Adapters\Publishers\OrderCreatedMessagePublisher::class),
                ]);
            });

        $this->app
            ->when(\App\Http\Controllers\UpdateOrderController::class)
            ->needs(\Domain\UseCases\UpdateOrder\UpdateOrderInputPort::class)
            ->give(function ($app) {
                return $app->make(\Domain\UseCases\UpdateOrder\UpdateOrderInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\UpdateOrderJsonPresenter::class)
                ]);
            });

        $this->app->bind(
            \Domain\Interfaces\MessageQueueService::class,
            \App\Services\RabbitMQService::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
