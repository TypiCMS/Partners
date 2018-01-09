<?php

namespace TypiCMS\Modules\Partners\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Facades\TypiCMS;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Partners\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @return null
     */
    public function map()
    {
        Route::namespace($this->namespace)->group(function (Router $router) {

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('partners')) {
                $router->middleware('public')->group(function (Router $router) use ($page) {
                    $options = $page->private ? ['middleware' => 'auth'] : [];
                    foreach (locales() as $lang) {
                        if ($page->translate('status', $lang) && $uri = $page->uri($lang)) {
                            $router->get($uri, $options + ['uses' => 'PublicController@index'])->name($lang.'::index-partners');
                            $router->get($uri.'/{slug}', $options + ['uses' => 'PublicController@show'])->name($lang.'::partner');
                        }
                    }
                });
            }

            /*
             * Admin routes
             */
            $router->middleware('admin')->prefix('admin')->group(function (Router $router) {
                $router->get('partners', 'AdminController@index')->name('admin::index-partners')->middleware('can:see-all-partners');
                $router->get('partners/create', 'AdminController@create')->name('admin::create-partner')->middleware('can:create-partner');
                $router->get('partners/{partner}/edit', 'AdminController@edit')->name('admin::edit-partner')->middleware('can:update-partner');
                $router->post('partners', 'AdminController@store')->name('admin::store-partner')->middleware('can:create-partner');
                $router->put('partners/{partner}', 'AdminController@update')->name('admin::update-partner')->middleware('can:update-partner');
                $router->patch('partners/{ids}', 'AdminController@ajaxUpdate')->name('admin::update-partner-ajax')->middleware('can:update-partner');
                $router->delete('partners/{ids}', 'AdminController@destroyMultiple')->name('admin::destroy-partner')->middleware('can:delete-partner');
            });
        });
    }
}
