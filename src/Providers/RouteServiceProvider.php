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
    /**
     * Define the routes for the application.
     */
    public function map()
    {
        Route::namespace($this->namespace)->group(function (Router $router) {
            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('partners')) {
                $middleware = $page->private ? ['public', 'auth'] : ['public'];
                $router->middleware($middleware)->group(function (Router $router) use ($page) {
                    foreach (locales() as $lang) {
                        if ($page->translate('status', $lang) && $uri = $page->uri($lang)) {
                            $router->get($uri, [PublicController::class, 'index'])->name($lang.'::index-partners');
                            $router->get($uri.'/{slug}', [PublicController::class, 'show'])->name($lang.'::partner');
                        }
                    }
                });
            }

            /*
             * Admin routes
             */
            $router->middleware('admin')->prefix('admin')->group(function (Router $router) {
                $router->get('partners', [AdminController::class, 'index'])->name('admin::index-partners')->middleware('can:read partners');
                $router->get('partners/create', [AdminController::class, 'create'])->name('admin::create-partner')->middleware('can:create partners');
                $router->get('partners/{partner}/edit', [AdminController::class, 'edit'])->name('admin::edit-partner')->middleware('can:read partners');
                $router->post('partners', [AdminController::class, 'store'])->name('admin::store-partner')->middleware('can:create partners');
                $router->put('partners/{partner}', [AdminController::class, 'update'])->name('admin::update-partner')->middleware('can:update partners');
            });

            /*
             * API routes
             */
            $router->middleware('api')->prefix('api')->group(function (Router $router) {
                $router->middleware('auth:api')->group(function (Router $router) {
                    $router->get('partners', [ApiController::class, 'index'])->middleware('can:read partners');
                    $router->patch('partners/{partner}', [ApiController::class, 'updatePartial'])->middleware('can:update partners');
                    $router->delete('partners/{partner}', [ApiController::class, 'destroy'])->middleware('can:delete partners');
                });
            });
        });
    }
}
