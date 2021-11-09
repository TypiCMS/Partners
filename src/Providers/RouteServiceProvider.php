<?php

namespace TypiCMS\Modules\Partners\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Partners\Http\Controllers\AdminController;
use TypiCMS\Modules\Partners\Http\Controllers\ApiController;
use TypiCMS\Modules\Partners\Http\Controllers\PublicController;

class RouteServiceProvider extends ServiceProvider
{
    public function map(): void
    {
        /*
         * Front office routes
         */
        if ($page = TypiCMS::getPageLinkedToModule('partners')) {
            $middleware = $page->private ? ['public', 'auth'] : ['public'];
            foreach (locales() as $lang) {
                if ($page->isPublished($lang) && $uri = $page->uri($lang)) {
                    Route::middleware($middleware)->prefix($uri)->name($lang.'::')->group(function (Router $router) {
                        $router->get('/', [PublicController::class, 'index'])->name('index-partners');
                        $router->get('{slug}', [PublicController::class, 'show'])->name('partner');
                    });
                }
            }
        }

        /*
         * Admin routes
         */
        Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router) {
            $router->get('partners', [AdminController::class, 'index'])->name('index-partners')->middleware('can:read partners');
            $router->get('partners/export', [AdminController::class, 'export'])->name('export-partners')->middleware('can:read partners');
            $router->get('partners/create', [AdminController::class, 'create'])->name('create-partner')->middleware('can:create partners');
            $router->get('partners/{partner}/edit', [AdminController::class, 'edit'])->name('edit-partner')->middleware('can:read partners');
            $router->post('partners', [AdminController::class, 'store'])->name('store-partner')->middleware('can:create partners');
            $router->put('partners/{partner}', [AdminController::class, 'update'])->name('update-partner')->middleware('can:update partners');
        });

        /*
         * API routes
         */
        Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router) {
            $router->get('partners', [ApiController::class, 'index'])->middleware('can:read partners');
            $router->patch('partners/{partner}', [ApiController::class, 'updatePartial'])->middleware('can:update partners');
            $router->delete('partners/{partner}', [ApiController::class, 'destroy'])->middleware('can:delete partners');
        });
    }
}
