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
        $this->title['parent'] = Str::title(trans_choice('partners::global.partners', 2));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        TypiCMS::setModel($this->repository->getModel());

        $this->title['child'] = '';

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

        $this->title['parent'] = $model->title;

        return view('partners::public.show')
            ->with(compact('model'));
    }
}
