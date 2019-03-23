<?php

namespace Future\Admin;



use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
class AdminServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $commands = [
        Console\AdminCommand::class,
        Console\MakeCommand::class,
        Console\MenuCommand::class,
        Console\InstallCommand::class,
        Console\PublishCommand::class,
        Console\UninstallCommand::class,
        Console\ImportCommand::class,
        Console\CreateUserCommand::class,
        Console\ResetPasswordCommand::class,
        Console\ExtendCommand::class,
        Console\ExportSeedCommand::class,
    ];


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        //
        $this->loadAdminAuthConfig();

        $this->commands($this->commands);

    }

    /**
     * @throws \ReflectionException
     */
    public function boot()
    {
        if (config('admin.https') || config('admin.secure')) {
            \URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }

        //
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'admin');

        if (file_exists($routes = admin_path('routes.php'))) {
            $this->loadRoutesFrom($routes);
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config' => config_path()], 'future-admin-config');
            $this->publishes([__DIR__.'/../resources/lang' => resource_path('lang')], 'future-admin-lang');
//            $this->publishes([__DIR__.'/../resources/views' => resource_path('views/vendor/admin')],           'future-admin-views');
            $this->publishes([__DIR__.'/../database/migrations' => database_path('migrations')], 'future-admin-migrations');
            $this->publishes([__DIR__.'/../resources/assets' => public_path('assets')], 'future-admin-assets');
        }

        //remove default feature of double encoding enable in laravel 5.6 or later.
        $bladeReflectionClass = new \ReflectionClass('\Illuminate\View\Compilers\BladeCompiler');
        if ($bladeReflectionClass->hasMethod('withoutDoubleEncoding')) {

            Blade::withoutDoubleEncoding();
        }

    }

    /**
     * Setup auth configuration.
     *
     * @return void
     */
    protected function loadAdminAuthConfig()
    {
        config(array_dot(config('admin.auth', []), 'auth.'));
    }

}
