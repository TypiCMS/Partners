<?php

namespace TypiCMS\Modules\Partners\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\FileObserver;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Partners\Models\Partner;
use TypiCMS\Modules\Partners\Repositories\EloquentPartner;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.partners'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['partners' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'partners');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'partners');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/partners'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');

        AliasLoader::getInstance()->alias(
            'Partners',
            'TypiCMS\Modules\Partners\Facades\Partners'
        );

        // Observers
        Partner::observe(new SlugObserver());
        Partner::observe(new FileObserver());
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Partners\Providers\RouteServiceProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Partners\Composers\SidebarViewComposer');

        /*
         * Add the page in the view.
         */
        $app->view->composer('partners::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('partners');
        });

        $app->bind('Partners', EloquentPartner::class);
    }
}
