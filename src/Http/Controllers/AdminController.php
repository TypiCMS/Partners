<?php
namespace TypiCMS\Modules\Partners\Http\Controllers;

use TypiCMS\Modules\Partners\Http\Requests\FormRequest;
use TypiCMS\Modules\Partners\Repositories\PartnerInterface;
use TypiCMS\Http\Controllers\AdminSimpleController;

class AdminController extends AdminSimpleController
{

    public function __construct(PartnerInterface $partner)
    {
        parent::__construct($partner);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FormRequest $request
     * @return Redirect
     */
    public function store(FormRequest $request)
    {
        $model = $this->repository->create($request->all());
        return $this->redirect($request, $model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $model
     * @param  FormRequest $request
     * @return Redirect
     */
    public function update($model, FormRequest $request)
    {
        $this->repository->update($request->all());
        return $this->redirect($request, $model);
    }
}
