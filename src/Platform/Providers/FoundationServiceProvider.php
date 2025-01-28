<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Scout\ScoutServiceProvider;
use Orchid\Icons\IconServiceProvider;
use Orchid\Platform\Components\Notification;
use Orchid\Platform\Components\Stream;
use Orchid\Platform\Dashboard;
use Orchid\Screen\Components\Popover;
use Tabuna\Breadcrumbs\BreadcrumbsServiceProvider;
use Watson\Active\ActiveServiceProvider;

/**
 * Class FoundationServiceProvider.
 * After update run: php artisan vendor:publish --provider="Orchid\Platform\Providers\FoundationServiceProvider".
 */
class FoundationServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this
            ->registerViews()
            ->registerOctaneEventsListen();
    }

    /**
     * Register translations.
     *
     * @return $this
     */
    public function registerTranslations(): self
    {
        $this->loadJsonTranslationsFrom(Dashboard::path('resources/lang/'));

        return $this;
    }

    /**
     * Register views & Publish views.
     *
     * @return $this
     */
    public function registerViews(): self
    {
        $this->loadViewsFrom(Dashboard::path('resources/views'), 'platform');

        return $this;
    }

    /**
     * Register provider.
     *
     * @return $this
     */
    public function registerProviders(): self
    {
        foreach ($this->provides() as $provide) {
            $this->app->register($provide);
        }

        if ($this->app->runningInConsole()) {
            $this->app->register(ConsoleServiceProvider::class);
        }

        return $this;
    }

    /**
     * Flush state when using Laravel Octane
     * https://laravel.com/docs/8.x/octane
     *
     * @return $this
     */
    public function registerOctaneEventsListen(): self
    {
        Event::listen(fn (\Laravel\Octane\Events\RequestReceived $request) => \Orchid\Support\Facades\Dashboard::flush());

        return $this;
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [
            ScoutServiceProvider::class,
            ActiveServiceProvider::class,
            IconServiceProvider::class,
            BreadcrumbsServiceProvider::class,
            RouteServiceProvider::class,
            PlatformServiceProvider::class,
        ];
    }

    /**
     * Register bindings the service provider.
     */
    public function register(): void
    {
        $this
            ->registerTranslations()
            ->registerProviders();

        $this->app->bind(
            Dashboard::class,
            fn (Application $app) => $app->make(Dashboard::class)
        );

        $this->app->singleton(
            Dashboard::class,
            static fn (Application $app) => new Dashboard
        );

        $this
            ->registerScreenMacro()
            ->mergeConfigFrom(
                Dashboard::path('config/platform.php'), 'platform'
            );

        Blade::component('orchid-popover', Popover::class);
        Blade::component('orchid-notification', Notification::class);
        Blade::component('orchid-stream', Stream::class);
    }

    /**
     * Register the 'screen' route macro.
     */
    protected function registerScreenMacro(): self
    {
        if (Route::hasMacro('screen')) {
            return $this;
        }

        $macro = function (string $url, string $screen) {
            return Route::match(['GET', 'HEAD', 'POST'], $url.'/{method?}', $screen)
                ->where('method', $screen::getAvailableMethods()->implode('|'));
        };

        Route::macro('screen', $macro);

        return $this;
    }
}
