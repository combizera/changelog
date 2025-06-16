<?php

namespace Combizera\Changelog;

use Illuminate\Support\ServiceProvider;
use vendor\combizera\Changelog\src\Console\InstallChangelogCommand;

class ChangelogServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/changelog.php', 'changelog');
    }

    public function boot()
    {
        // Publicar configurações
        $this->publishes([
            __DIR__.'/../config/changelog.php' => config_path('changelog.php'),
        ], 'changelog-config');

        // Publicar views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/changelog'),
        ], 'changelog-views');

        // Publicar assets
        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/changelog'),
        ], 'changelog-assets');

        // Carregar views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'changelog');

        // Registrar rotas se habilitado
        if (config('changelog.enable_web_interface')) {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        }

        // Registrar comandos
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallChangelogCommand::class,
            ]);
        }
    }
}
