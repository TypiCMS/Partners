<?php

namespace TypiCMS\Modules\Partners\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Laracasts\Presenter\PresentableTrait;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Core\Models\File;
use TypiCMS\Modules\Core\Models\History;
use TypiCMS\Modules\Core\Traits\Historable;
use TypiCMS\Modules\Partners\Presenters\ModulePresenter;

/**
 * @property int $id
 * @property bool $homepage
 * @property int $position
 * @property int|null $image_id
 * @property string $status
 * @property string $title
 * @property string $slug
 * @property string $website
 * @property string $summary
 * @property string $body
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, History> $history
 * @property-read int|null $history_count
 * @property-read File|null $image
 * @property-read mixed $thumb
 * @property-read mixed $translations
 */
class Partner extends Base implements Sortable
{
    use HasTranslations;
    use Historable;
    use PresentableTrait;
    use SortableTrait;

    protected string $presenter = ModulePresenter::class;

    protected $guarded = [];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'homepage' => 'boolean',
        ];
    }

    protected $appends = ['thumb'];

    /** @var array<string> */
    public array $translatable = [
        'title',
        'slug',
        'status',
        'website',
        'summary',
        'body',
    ];

    /** @var array<string> */
    public array $sortable = [
        'order_column_name' => 'position',
    ];

    public function url(?string $locale = null): string
    {
        $locale = $locale ?: app()->getLocale();
        $route = $locale . '::partner';
        $slug = $this->translate('slug', $locale) ?: null;

        return Route::has($route) && $slug ? url(route($route, $slug)) : url('/');
    }

    /** @return Attribute<string, null> */
    protected function thumb(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->present()->image(null, 54),
        );
    }

    /** @return BelongsTo<File, $this> */
    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }
}
