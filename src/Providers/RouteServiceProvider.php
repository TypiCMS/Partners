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
        Route::group(['namespace' => $this->namespace], function (Router $router) {

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('partners')) {
                $options = $page->private ? ['middleware' => 'auth'] : [];
                foreach (config('translatable-bootforms.locales') as $lang) {
                    if ($page->translate('status', $lang) && $uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['as' => $lang.'.partners', 'uses' => 'PublicController@index']);
                        $router->get($uri.'/{slug}', $options + ['as' => $lang.'.partners.slug', 'uses' => 'PublicController@show']);
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->group(['middleware' => 'admin', 'prefix' => 'admin'], function (Router $router) {
                $router->get('partners', 'AdminController@index')->name('admin::index-partners');
                $router->get('partners/create', 'AdminController@create')->name('admin::create-partner');
                $router->get('partners/{partner}/edit', 'AdminController@edit')->name('admin::edit-partner');
                $router->post('partners', 'AdminController@store')->name('admin::store-partner');
                $router->put('partners/{partner}', 'AdminController@update')->name('admin::update-partner');
                $router->patch('partners/{partner}', 'AdminController@ajaxUpdate');
                $router->delete('partners/{partner}', 'AdminController@destroy')->name('admin::destroy-partner');
            });
        });
    }
}
