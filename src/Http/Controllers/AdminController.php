<?php

namespace TypiCMS\Modules\Partners\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Partners\Http\Requests\FormRequest;
use TypiCMS\Modules\Partners\Models\Partner;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('partners::admin.index');
    }

    public function create(): View
    {
        $model = new Partner();

        return view('partners::admin.create')
            ->with(compact('model'));
    }

    public function edit(Partner $partner): View
    {
        return view('partners::admin.edit')
            ->with(['model' => $partner]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $partner = Partner::create($request->all());

        return $this->redirect($request, $partner);
    }

    public function update(Partner $partner, FormRequest $request): RedirectResponse
    {
        $partner->update($request->all());

        return $this->redirect($request, $partner);
    }
}
