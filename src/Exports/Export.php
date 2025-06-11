<?php

namespace TypiCMS\Modules\Partners\Exports;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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

/**
 * @implements WithMapping<mixed>
 */
class Export implements FromCollection, ShouldAutoSize, WithColumnFormatting, WithHeadings, WithMapping
{
    /** @return Collection<int, Model> */
    public function collection(): Collection
    {
        return QueryBuilder::for(Partner::class)
            ->allowedSorts(['status_translated', 'position', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->get();
    }

    /** @return array<int, mixed> */
    public function map(mixed $row): array
    {
        return [
            Date::dateTimeToExcel($row->created_at),
            Date::dateTimeToExcel($row->updated_at),
            $row->status,
            $row->homepage,
            $row->position,
            $row->website,
            $row->title,
            $row->summary,
            $row->body,
        ];
    }

    /** @return string[] */
    public function headings(): array
    {
        return [
            __('Created at'),
            __('Updated at'),
            __('Published'),
            __('Homepage'),
            __('Position'),
            __('Website'),
            __('Title'),
            __('Summary'),
            __('Body'),
        ];
    }

    /** @return array<string, string> */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DATETIME,
            'B' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }
}
