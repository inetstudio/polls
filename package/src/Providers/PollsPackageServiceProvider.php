<?php

namespace InetStudio\PollsPackage\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class PollsPackageServiceProvider.
 */
class PollsPackageServiceProvider extends ServiceProvider
{
    /**
     * Загрузка сервиса.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerConsoleCommands();
    }

    /**
     * Регистрация команд.
     *
     * @return void
     */
    protected function registerConsoleCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                'InetStudio\PollsPackage\Console\Commands\SetupCommand',
            ]);
        }
    }
}
