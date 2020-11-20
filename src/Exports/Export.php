<?php

namespace TypiCMS\Modules\Partners\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Partners\Models\Partner;

class Export implements WithColumnFormatting, ShouldAutoSize, FromCollection, WithHeadings, WithMapping
{
    protected $collection;

    public function __construct($request)
    {
        $this->collection = QueryBuilder::for(Partner::class)
            ->selectFields($request->input('fields.partners'))
            ->allowedSorts(['status_translated', 'position', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->get();
    }

    public function map($model): array
    {
        return [
            Date::dateTimeToExcel($model->created_at),
            Date::dateTimeToExcel($model->updated_at),
            $model->status_translated,
            $model->homepage,
            $model->position,
            $model->website_translated,
            $model->title_translated,
            $model->summary_translated,
            $model->body_translated,
        ];
    }

    public function headings(): array
    {
        return [
            'Created at',
            'Updated at',
            'Published',
            'Homepage',
            'Position',
            'Website',
            'Title',
            'Summary',
            'Body',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DATETIME,
            'B' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }

    public function collection()
    {
        return $this->collection;
    }
}
