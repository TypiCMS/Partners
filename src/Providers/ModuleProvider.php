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
use TypiCMS\Modules\Partners\Services\Form\PartnerForm;
use TypiCMS\Modules\Partners\Services\Form\PartnerFormLaravelValidator;
use TypiCMS\Observers\FileObserver;
use TypiCMS\Observers\SlugObserver;
use TypiCMS\Services\Cache\LaravelCache;
use View;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Add dirs
        View::addNamespace('partners', __DIR__ . '/../views/');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'partners');
        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php', 'typicms.partners'
        );
        $this->publishes([
            __DIR__ . '/../migrations/' => base_path('/database/migrations'),
        ], 'migrations');

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
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Partners\Composers\SideBarViewComposer');

        $app->bind('TypiCMS\Modules\Partners\Repositories\PartnerInterface', function (Application $app) {
            $repository = new EloquentPartner(new Partner);
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'partners', 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->bind('TypiCMS\Modules\Partners\Services\Form\PartnerForm', function (Application $app) {
            return new PartnerForm(
                new PartnerFormLaravelValidator($app['validator']),
                $app->make('TypiCMS\Modules\Partners\Repositories\PartnerInterface')
            );
        });

    }
}
