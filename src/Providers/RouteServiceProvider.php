<?php
namespace TypiCMS\Modules\Partners\Providers;

use Config;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Partners\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        $router->model('partners', 'TypiCMS\Modules\Partners\Models\Partner');
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function($router) {

            /**
             * Front office routes
             */
            $routes = $this->app->make('TypiCMS.routes');
            foreach (Config::get('translatable.locales') as $lang) {
                if (isset($routes['partners'][$lang])) {
                    $uri = $routes['partners'][$lang];
                    $router->get($uri, array('as' => $lang.'.partners', 'uses' => 'PublicController@index'));
                    $router->get($uri.'/{slug}', array('as' => $lang.'.partners.slug', 'uses' => 'PublicController@show'));
                }
            }

            /**
             * Admin routes
             */
            $router->resource('admin/partners', 'AdminController');

            /**
             * API routes
             */
            $router->resource('api/partners', 'ApiController');
        });
    }

}
