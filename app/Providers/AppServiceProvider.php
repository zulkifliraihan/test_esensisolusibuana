<?php

namespace App\Providers;

use App\Http\Repository\CustomerRepository\CustomerRepository;
use App\Http\Repository\CustomerRepository\CustomerRepositoryInterface;
use App\Http\Repository\InvoiceRepository\InvoiceRepository;
use App\Http\Repository\InvoiceRepository\InvoiceRepositoryInterface;
use App\Http\Repository\ItemRepository\ItemRepository;
use App\Http\Repository\ItemRepository\ItemRepositoryInterface;
use App\Http\Repository\TypeRepository\TypeRepository;
use App\Http\Repository\TypeRepository\TypeRepositoryInterface;

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
        $this->app->bind(TypeRepositoryInterface::class, TypeRepository::class);
        $this->app->bind(ItemRepositoryInterface::class, ItemRepository::class);
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
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
