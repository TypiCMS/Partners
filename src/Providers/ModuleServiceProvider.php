<?php

declare(strict_types=1);

namespace TypiCMS\Modules\Partners\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Override;
use TypiCMS\Modules\Partners\Composers\SidebarViewComposer;

class ModuleServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/partners.php', 'typicms.modules.partners');
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/partners.php');

        $this->loadViewsFrom([
            resource_path('views/admin'),
            __DIR__.'/../../resources/views/admin',
        ], 'admin');

        $this->loadViewsFrom([
            resource_path('views/public'),
            __DIR__.'/../../resources/views/public',
        ], 'public');

        $this->publishes([
            __DIR__.'/../../database/migrations/create_partners_table.php.stub' => getMigrationFileName(
                'create_partners_table',
            ),
        ], 'typicms-migrations');
        $this->publishes([
            __DIR__.'/../../resources/views/admin/partners' => resource_path('views/admin/partners'),
        ], ['typicms-views', 'typicms-admin-views', 'typicms-admin-partners-views']);
        $this->publishes([
            __DIR__.'/../../resources/views/public/partners' => resource_path('views/public/partners'),
        ], ['typicms-views', 'typicms-public-views', 'typicms-public-partners-views']);
        $this->publishes([__DIR__.'/../../resources/scss' => resource_path('scss')], 'typicms-resources');

        View::composer('admin::core._sidebar', SidebarViewComposer::class);

    }
}
