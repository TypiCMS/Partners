<?php

namespace TypiCMS\Modules\Partners\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Partners\Http\Requests\FormRequest;
use TypiCMS\Modules\Partners\Models\Partner;
use TypiCMS\Modules\Partners\Repositories\EloquentPartner;

class AdminController extends BaseAdminController
{
    public function __construct(EloquentPartner $partner)
    {
        parent::__construct($partner);
    }

    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->repository->findAll();
        app('JavaScript')->put('models', $models);

        return view('partners::admin.index');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->repository->createModel();
        app('JavaScript')->put('model', $model);

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
        app('JavaScript')->put('model', $partner);

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
        $partner = $this->repository->create($request->all());

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
        $this->repository->update($request->id, $request->all());

        return $this->redirect($request, $partner);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \TypiCMS\Modules\Partners\Models\Partner $partner
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Partner $partner)
    {
        $deleted = $this->repository->delete($partner);

        return response()->json([
            'error' => !$deleted,
        ]);
    }
}
