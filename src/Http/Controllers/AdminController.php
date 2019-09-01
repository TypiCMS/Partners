<?php

namespace TypiCMS\Modules\Partners\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Partners\Http\Requests\FormRequest;
use TypiCMS\Modules\Partners\Models\Partner;

class AdminController extends BaseAdminController
{
    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('partners::admin.index');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = new;

        return view('partners::admin.create')
            ->with(compact('model'));
    }

    /**
     * Edit form for the specified resource.
     *
     * @param \TypiCMS\Modules\Partners\Models\Partner $partner
     *
     * @return \Illuminate\View\View
     */
    public function edit(Partner $partner)
    {
        return view('partners::admin.edit')
            ->with(['model' => $partner]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \TypiCMS\Modules\Partners\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $partner = ::create($request->all());

        return $this->redirect($request, $partner);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\Partners\Models\Partner            $partner
     * @param \TypiCMS\Modules\Partners\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Partner $partner, FormRequest $request)
    {
        ::update($request->id, $request->all());

        return $this->redirect($request, $partner);
    }
}
