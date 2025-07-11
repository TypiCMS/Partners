<?php

namespace TypiCMS\Modules\Partners\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Partners\Models\Partner;

class ApiController extends BaseApiController
{
    /** @return LengthAwarePaginator<int, mixed> */
    public function index(Request $request): LengthAwarePaginator
    {
        $query = Partner::query()->selectFields();
        $data = QueryBuilder::for($query)
            ->allowedSorts(['status_translated', 'position', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->integer('per_page'));

        return $data;
    }

    protected function updatePartial(Partner $partner, Request $request): void
    {
        foreach ($request->only('status', 'position') as $key => $content) {
            if ($partner->isTranslatableAttribute($key)) {
                foreach ($content as $lang => $value) {
                    $partner->setTranslation($key, $lang, $value);
                }
            } else {
                $partner->{$key} = $content;
            }
        }

        $partner->save();
    }

    public function destroy(Partner $partner): JsonResponse
    {
        $partner->delete();

        return response()->json(status: 204);
    }
}
