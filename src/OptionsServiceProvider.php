<?php

namespace Larapp\Options;

use Illuminate\Support\ServiceProvider;
use Larapp\Options\Options;
use Larapp\Options\Model\Option;
use Larapp\Options\Observers\OptionObserver;
use Larapp\Options\Commands\ClearOptionsCache;

class OptionsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
    */
    public function boot()
    {
        $options = new Options();
        $options->setToConfig();

        if(config('options-package.auto-observe', true)) {
            Option::observe(OptionObserver::class);    
        }
        
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../migrations');

            $this->publishes([
                __DIR__.'/../config/options.php' => config_path('options.php'),
                __DIR__.'/../config/options-package.php' => config_path('options-package.php'),
            ], 'options');

            $this->commands([
                ClearOptionsCache::class,
            ]);
        }
    }

    /**
     * Make config publishment optional by merging the config from the package.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Options::class, function ($app) {
            return new Options();
        });

        $this->app->alias(Options::class, 'Options');

        $this->mergeConfigFrom(__DIR__.'/../config/options-package.php', 'options-package');
    }
}
