<?php

namespace TypiCMS\Modules\Partners\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Partners\Composers\SidebarViewComposer;
use TypiCMS\Modules\Partners\Facades\Partners;
use TypiCMS\Modules\Partners\Models\Partner;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'typicms.modules');

        $this->loadViewsFrom(__DIR__.'/../../resources/views/', 'partners');

        $this->publishes([__DIR__.'/../../database/migrations/create_partners_table.php.stub' => getMigrationFileName('create_partners_table')], 'typicms-migrations');
        $this->publishes([__DIR__.'/../../resources/views' => resource_path('views/vendor/partners')], 'typicms-views');
        $this->publishes([__DIR__.'/../../resources/scss' => resource_path('scss')], 'typicms-resources');

        AliasLoader::getInstance()->alias('Partners', Partners::class);

        // Observers
        Partner::observe(new SlugObserver());

        View::composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        View::composer('partners::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('partners');
        });
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->bind('Partners', Partner::class);
    }
}
