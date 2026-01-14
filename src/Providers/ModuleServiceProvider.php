<?php

declare(strict_types=1);

namespace TypiCMS\Modules\Partners\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Core\Observers\TipTapHTMLObserver;
use TypiCMS\Modules\Partners\Composers\SidebarViewComposer;
use TypiCMS\Modules\Partners\Facades\Partners;
use TypiCMS\Modules\Partners\Models\Partner;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/partners.php', 'typicms.modules.partners');

        $this->loadRoutesFrom(__DIR__ . '/../routes/partners.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views/', 'partners');

        $this->publishes([
            __DIR__ . '/../../database/migrations/create_partners_table.php.stub' => getMigrationFileName(
                'create_partners_table',
            ),
        ], 'typicms-migrations');
        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/partners'),
        ], 'typicms-views');
        $this->publishes([__DIR__ . '/../../resources/scss' => resource_path('scss')], 'typicms-resources');

        AliasLoader::getInstance()->alias('Partners', Partners::class);

        // Observers
        Partner::observe(new SlugObserver());
        Partner::observe(new TipTapHTMLObserver());

        View::composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        View::composer('partners::public.*', function ($view): void {
            $view->page = getPageLinkedToModule('partners');
        });
    }

    public function register(): void
    {
        $this->app->bind('Partners', Partner::class);
    }
}
