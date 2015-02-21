<?php
namespace TypiCMS\Modules\Partners\Http\Controllers;

use Illuminate\Support\Str;
use View;
use TypiCMS;
use TypiCMS\Modules\Partners\Repositories\PartnerInterface;
use TypiCMS\Http\Controllers\BasePublicController;

class PublicController extends BasePublicController
{

    public function __construct(PartnerInterface $partner)
    {
        parent::__construct($partner);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        TypiCMS::setModel($this->repository->getModel());

        $partners = $this->repository->getAll();

        return view('partners::public.index')
            ->with(compact('partners'));
    }

    /**
     * Show news.
     *
     * @return Response
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug);

        TypiCMS::setModel($model);

        return view('partners::public.show')
            ->with(compact('model'));
    }
}
