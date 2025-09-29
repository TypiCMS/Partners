<?php

namespace TypiCMS\Modules\Partners\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Partners\Models\Partner;

class PublicController extends BasePublicController
{
    public function index(): View
    {
        $models = Partner::query()
            ->published()
            ->order()
            ->with('image')
            ->get();

        return view('partners::public.index')
            ->with(['models' => $models]);
    }

    public function show(string $slug): View
    {
        $model = Partner::query()
            ->published()
            ->whereSlugIs($slug)
            ->firstOrFail();

        return view('partners::public.show')
            ->with(['model' => $model]);
    }
}
