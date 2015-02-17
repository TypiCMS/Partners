<?php
Route::bind('partners', function ($value) {
    return TypiCMS\Modules\Partners\Models\Partner::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

if (! App::runningInConsole()) {
    Route::group(
        array(
            'before'    => 'visitor.publicAccess',
            'namespace' => 'TypiCMS\Modules\Partners\Http\Controllers',
        ),
        function () {
            $routes = app('TypiCMS.routes');
            foreach (Config::get('translatable.locales') as $lang) {
                if (isset($routes['partners'][$lang])) {
                    $uri = $routes['partners'][$lang];
                } else {
                    $uri = 'partners';
                    if (Config::get('app.fallback_locale') != $lang || config('typicms.main_locale_in_url')) {
                        $uri = $lang . '/' . $uri;
                    }
                }
                Route::get($uri, array('as' => $lang.'.partners', 'uses' => 'PublicController@index'));
                Route::get($uri.'/{slug}', array('as' => $lang.'.partners.slug', 'uses' => 'PublicController@show'));
            }
        }
    );
}

Route::group(
    array(
        'namespace' => 'TypiCMS\Modules\Partners\Http\Controllers',
        'prefix'    => 'admin',
    ),
    function () {
        Route::resource('partners', 'AdminController');
        Route::post('partners/sort', array('as' => 'admin.partners.sort', 'uses' => 'AdminController@sort'));
    }
);

Route::group(['prefix'=>'api'], function() {
    Route::resource('partners', 'ApiController');
});
