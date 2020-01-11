<?php

namespace TypiCMS\Modules\Partners\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Partners\Models\Partner;

class PublicController extends BasePublicController
{
    public function index(): View
    {
        $models = Partner::published()
            ->order()
            ->with('image')
            ->get();

        return view('partners::public.index')
            ->with(compact('models'));
    }

    public function show($slug): View
    {
        $model = Partner::published()->whereSlugIs($slug)->firstOrFail();

        return view('partners::public.show')
            ->with(compact('model'));
    }
}
