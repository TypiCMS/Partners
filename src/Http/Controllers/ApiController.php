<?php

namespace TypiCMS\Modules\Partners\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Partners\Models\Partner;
use TypiCMS\Modules\Partners\Repositories\EloquentPartner;

class ApiController extends BaseApiController
{
    public function __construct(EloquentPartner $partner)
    {
        parent::__construct($partner);
    }

    public function index(Request $request)
    {
        $models = QueryBuilder::for(Partner::class)
            ->translated($request->input('translatable_fields'))
            ->paginate($request->input('per_page'));

        return $models;
    }

    protected function updatePartial(Partner $partner, Request $request)
    {
        $data = [];
        foreach ($request->all() as $column => $content) {
            if (is_array($content)) {
                foreach ($content as $key => $value) {
                    $data[$column.'->'.$key] = $value;
                }
            } else {
                $data[$column] = $content;
            }
        }

        foreach ($data as $key => $value) {
            $partner->$key = $value;
        }
        $saved = $partner->save();

        $this->repository->forgetCache();

        return response()->json([
            'error' => !$saved,
        ]);
    }

    public function destroy(Partner $partner)
    {
        $deleted = $this->repository->delete($partner);

        return response()->json([
            'error' => !$deleted,
        ]);
    }
}
