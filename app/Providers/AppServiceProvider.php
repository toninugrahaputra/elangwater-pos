<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\BrandRepositoryInterface;
use App\Repositories\BrandRepository;
use App\Repositories\WarehouseRepositoryInterface;
use App\Repositories\WarehouseRepository;
use App\Repositories\ProductStockRepositoryInterface;
use App\Repositories\ProductStockRepository;
use App\Repositories\StockMutationRepositoryInterface;
use App\Repositories\StockMutationRepository;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\CustomerRepository;
use App\Repositories\SupplierRepositoryInterface;
use App\Repositories\SupplierRepository;
use App\Repositories\PurchaseRepositoryInterface;
use App\Repositories\PurchaseRepository;
use App\Repositories\UnitRepositoryInterface;
use App\Repositories\UnitRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(WarehouseRepositoryInterface::class, WarehouseRepository::class);
        $this->app->bind(ProductStockRepositoryInterface::class, ProductStockRepository::class);
        $this->app->bind(StockMutationRepositoryInterface::class, StockMutationRepository::class);
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(SupplierRepositoryInterface::class, SupplierRepository::class);
        $this->app->bind(PurchaseRepositoryInterface::class, PurchaseRepository::class);
        $this->app->bind(UnitRepositoryInterface::class, UnitRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define rate limiter for login attempts
        RateLimiter::for('login', function (string $key) {
            return Limit::perMinute(5);
        });
    }
}