<?php

namespace Modules\Api\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Api\Base\OrderFactory;
use Modules\Api\Entities\PermissionModel;
use Modules\Api\Entities\QuotaModel;
use Modules\Api\Observers\PermissionObserver;
use Modules\Api\Observers\QuotaObserver;
use Vanilo\Order\Contracts\OrderFactory as VaniloOrderFactory;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        
        //Cargo los observadores
        PermissionModel::observe(PermissionObserver::class);
        QuotaModel::observe(QuotaObserver::class);

        $this->app->bind(VaniloOrderFactory::class, OrderFactory::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        //$this->app->bind(VaniloCheckoutDataFactory::class, CheckoutDataFactory::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('api.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'api'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/api');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/api';
        }, \Config::get('view.paths')), [$sourcePath]), 'api');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/api');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'api');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'api');
        }
    }

    /**
     * Register an additional directory of factories.
     * 
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
