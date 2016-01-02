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
                    if ($uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['as' => $lang.'.partners', 'uses' => 'PublicController@index']);
                        $router->get($uri.'/{slug}', $options + ['as' => $lang.'.partners.slug', 'uses' => 'PublicController@show']);
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->get('admin/partners', ['as' => 'admin.partners.index', 'uses' => 'AdminController@index']);
            $router->get('admin/partners/create', ['as' => 'admin.partners.create', 'uses' => 'AdminController@create']);
            $router->get('admin/partners/{partner}/edit', ['as' => 'admin.partners.edit', 'uses' => 'AdminController@edit']);
            $router->post('admin/partners', ['as' => 'admin.partners.store', 'uses' => 'AdminController@store']);
            $router->put('admin/partners/{partner}', ['as' => 'admin.partners.update', 'uses' => 'AdminController@update']);

            /*
             * API routes
             */
            $router->get('api/partners', ['as' => 'api.partners.index', 'uses' => 'ApiController@index']);
            $router->put('api/partners/{partner}', ['as' => 'api.partners.update', 'uses' => 'ApiController@update']);
            $router->delete('api/partners/{partner}', ['as' => 'api.partners.destroy', 'uses' => 'ApiController@destroy']);
        });
    }
}
