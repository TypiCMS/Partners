<?php

namespace TypiCMS\Modules\Partners\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Partners\Exports\Export;
use TypiCMS\Modules\Partners\Http\Requests\FormRequest;
use TypiCMS\Modules\Partners\Models\Partner;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('partners::admin.index');
    }

    public function export(Request $request): BinaryFileResponse
    {
        $filename = date('Y-m-d') . ' ' . config('app.name') . ' partners.xlsx';

        return Excel::download(new Export(), $filename);
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
        $partner = Partner::query()->create($request->validated());

        return $this->redirect($request, $partner)
            ->withMessage(__('Item successfully created.'));
    }

    public function update(Partner $partner, FormRequest $request): RedirectResponse
    {
        $partner->update($request->validated());

        return $this->redirect($request, $partner)
            ->withMessage(__('Item successfully updated.'));
    }
}
