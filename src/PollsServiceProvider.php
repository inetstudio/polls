<?php

namespace InetStudio\Polls;

use Illuminate\Support\ServiceProvider;

class PollsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../public' => public_path(),
        ], 'public');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'admin.module.polls');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        if ($this->app->runningInConsole()) {
            if (! class_exists('CreatePollsTables')) {
                $timestamp = date('Y_m_d_His', time());
                $this->publishes([
                    __DIR__.'/../database/migrations/create_polls_tables.php.stub' => database_path('migrations/'.$timestamp.'_create_polls_tables.php'),
                ], 'migrations');
            }

            $this->commands([
                Commands\SetupCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
