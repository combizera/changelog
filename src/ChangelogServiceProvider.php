<?php

namespace Combizera\Changelog;

use Illuminate\Support\ServiceProvider;
use Combizera\Changelog\Console\InstallChangelogCommand;

class ChangelogServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallChangelogCommand::class,
            ]);
        }
    }
}
