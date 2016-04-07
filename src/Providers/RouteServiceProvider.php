<?php

namespace TypiCMS\Modules\Partners\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
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
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function (Router $router) {

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('partners')) {
                $options = $page->private ? ['middleware' => 'auth'] : [];
                foreach (config('translatable.locales') as $lang) {
                    if ($page->translate($lang)->status && $uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['as' => $lang.'.partners', 'uses' => 'PublicController@index']);
                        $router->get($uri.'/{slug}', $options + ['as' => $lang.'.partners.slug', 'uses' => 'PublicController@show']);
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->get('admin/partners', 'AdminController@index')->name('admin::index-partners');
            $router->get('admin/partners/create', 'AdminController@create')->name('admin::create-partner');
            $router->get('admin/partners/{partner}/edit', 'AdminController@edit')->name('admin::edit-partner');
            $router->post('admin/partners', 'AdminController@store')->name('admin::store-partner');
            $router->put('admin/partners/{partner}', 'AdminController@update')->name('admin::update-partner');

            /*
             * API routes
             */
            $router->get('api/partners', 'ApiController@index')->name('api::index-partners');
            $router->put('api/partners/{partner}', 'ApiController@update')->name('api::update-partner');
            $router->delete('api/partners/{partner}', 'ApiController@destroy')->name('api::destroy-partner');
        });
    }
}
