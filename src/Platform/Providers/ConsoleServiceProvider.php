<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Commands\AdminCommand;
use Orchid\Platform\Commands\ChartCommand;
use Orchid\Platform\Commands\FilterCommand;
use Orchid\Platform\Commands\InstallCommand;
use Orchid\Platform\Commands\ListenerCommand;
use Orchid\Platform\Commands\PresenterCommand;
use Orchid\Platform\Commands\PublishCommand;
use Orchid\Platform\Commands\RowsCommand;
use Orchid\Platform\Commands\ScreenCommand;
use Orchid\Platform\Commands\SelectionCommand;
use Orchid\Platform\Commands\TableCommand;
use Orchid\Platform\Commands\TabMenuCommand;
use Orchid\Support\Facades\Dashboard;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * The available command shortname.
     *
     * @var array
     */
    protected $commands = [
        InstallCommand::class,
        PublishCommand::class,
        AdminCommand::class,
        FilterCommand::class,
        RowsCommand::class,
        ScreenCommand::class,
        TableCommand::class,
        ChartCommand::class,
        SelectionCommand::class,
        ListenerCommand::class,
        PresenterCommand::class,
        TabMenuCommand::class,
    ];

    public function boot(): void
    {
        AboutCommand::add('Orchid Platform', fn () => [
            'Version'       => Dashboard::version(),
            'Domain'        => config('platform.domain'),
            'Prefix'        => config('platform.prefix'),
            'Assets Status' => Dashboard::assetsAreCurrent() ? '<fg=green;options=bold>CURRENT</>' : '<fg=yellow;options=bold>OUTDATED</>',
        ]);

        $this
            ->registerMigrationsPublisher()
            ->registerTranslationsPublisher()
            ->registerConfigPublisher()
            ->registerOrchidPublisher()
            ->registerViewsPublisher()
            ->registerAssetsPublisher()
            ->commands($this->commands);
    }

    /**
     * Register migrate.
     *
     * @return $this
     */
    protected function registerMigrationsPublisher(): self
    {
        $this->publishes([
            Dashboard::path('database/migrations') => database_path('migrations'),
        ], 'orchid-migrations');

        return $this;
    }

    /**
     * Register translations.
     *
     * @return $this
     */
    public function registerTranslationsPublisher(): self
    {
        $this->publishes([
            Dashboard::path('resources/lang') => lang_path('vendor/platform'),
        ], 'orchid-lang');

        return $this;
    }

    /**
     * Register views & Publish views.
     *
     * @return $this
     */
    public function registerViewsPublisher(): self
    {
        $this->publishes([
            Dashboard::path('resources/views') => resource_path('views/vendor/platform'),
        ], 'orchid-views');

        return $this;
    }

    /**
     * Register config.
     *
     * @return $this
     */
    protected function registerConfigPublisher(): self
    {
        $this->publishes([
            Dashboard::path('config/platform.php') => config_path('platform.php'),
        ], 'orchid-config');

        return $this;
    }

    /**
     * Register orchid.
     *
     * @return $this
     */
    protected function registerOrchidPublisher(): self
    {
        $this->publishes([
            Dashboard::path('stubs/app/routes/') => base_path('routes'),
            Dashboard::path('stubs/app/Orchid/') => app_path('Orchid'),
        ], 'orchid-app-stubs');

        return $this;
    }

    /**
     * Register the asset publishing configuration.
     *
     * @return $this
     */
    protected function registerAssetsPublisher(): self
    {
        $this->publishes([
            Dashboard::path('public') => public_path('vendor/orchid'),
        ], ['orchid-assets', 'laravel-assets']);

        return $this;
    }
}
