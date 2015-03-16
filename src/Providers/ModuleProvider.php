<?php
namespace TypiCMS\Modules\Partners\Providers;

use Config;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Lang;
use TypiCMS\Modules\Partners\Models\Partner;
use TypiCMS\Modules\Partners\Models\PartnerTranslation;
use TypiCMS\Modules\Partners\Repositories\CacheDecorator;
use TypiCMS\Modules\Partners\Repositories\EloquentPartner;
use TypiCMS\Observers\FileObserver;
use TypiCMS\Observers\SlugObserver;
use TypiCMS\Services\Cache\LaravelCache;
use View;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {

        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php', 'typicms.partners'
        );

        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'partners');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'partners');

        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/partners'),
        ], 'views');
        $this->publishes([
            __DIR__ . '/../database' => base_path('database'),
        ], 'migrations');
        $this->publishes([
            __DIR__ . '/../../tests' => base_path('tests'),
        ], 'tests');

        AliasLoader::getInstance()->alias(
            'Partners',
            'TypiCMS\Modules\Partners\Facades\Facade'
        );

        // Observers
        PartnerTranslation::observe(new SlugObserver);
        Partner::observe(new FileObserver);
    }

    public function register()
    {

        $app = $this->app;

        /**
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Partners\Providers\RouteServiceProvider');

        /**
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Partners\Composers\SidebarViewComposer');

        $app->bind('TypiCMS\Modules\Partners\Repositories\PartnerInterface', function (Application $app) {
            $repository = new EloquentPartner(new Partner);
            if (! config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'partners', 10);

            return new CacheDecorator($repository, $laravelCache);
        });

    }
}
