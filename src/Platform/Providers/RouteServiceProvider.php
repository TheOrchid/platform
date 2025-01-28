<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Orchid\Platform\Http\Middleware\Access;
use Orchid\Platform\Http\Middleware\Turbo;
use Orchid\Support\Facades\Dashboard;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @internal param Router $router
     */
    public function boot()
    {
        Route::middlewareGroup('platform', [
            Turbo::class,
            Access::class,
        ]);

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        /*
         * Dashboard routes.
         *
         * The dashboard routes have a subdomain of the platform.domain config value,
         * a prefix consisting of the Dashboard::prefix() method return value,
         * an alias of 'platform.', middleware from the platform.middleware.private config value,
         * and are defined in the Dashboard::path('routes/dashboard.php') file.
         */
        Route::domain((string) config('platform.domain'))
            ->prefix(Dashboard::prefix('/'))
            ->as('platform.')
            ->middleware(config('platform.middleware.private'))
            ->group(Dashboard::path('routes/dashboard.php'));

        /*
         * Auth routes.
         *
         * The auth routes have a subdomain of the platform.domain config value,
         * a prefix consisting of the Dashboard::prefix() method return value,
         * an alias of 'platform.', middleware from the platform.middleware.public config value,
         * and are defined in the Dashboard::path('routes/auth.php') file.
         */
        Route::domain((string) config('platform.domain'))
            ->prefix(Dashboard::prefix('/'))
            ->as('platform.')
            ->middleware(config('platform.middleware.public'))
            ->group(Dashboard::path('routes/auth.php'));

        /*
         * Application routes.
         *
         * If the 'routes/platform.php' file exists, its routes have a subdomain of the platform.domain config value,
         * a prefix consisting of the Dashboard::prefix() method return value,
         * and middleware from the platform.middleware.private config value.
         */
        if (file_exists(base_path('routes/platform.php'))) {
            Route::domain((string) config('platform.domain'))
                ->prefix(Dashboard::prefix('/'))
                ->middleware(config('platform.middleware.private'))
                ->group(base_path('routes/platform.php'));
        }
    }
}
