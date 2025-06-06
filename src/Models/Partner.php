<?php

namespace TypiCMS\Modules\Partners\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Laracasts\Presenter\PresentableTrait;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Core\Models\File;
use TypiCMS\Modules\Core\Traits\Historable;
use TypiCMS\Modules\Partners\Presenters\ModulePresenter;

/**
 * @property-read int $id
 * @property-read string $thumb
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class Partner extends Base implements Sortable
{
    use HasTranslations;
    use Historable;
    use PresentableTrait;
    use SortableTrait;

    protected string $presenter = ModulePresenter::class;

    protected $guarded = [];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'homepage' => 'boolean',
        ];
    }

    protected $appends = ['thumb'];

    public array $translatable = [
        'title',
        'slug',
        'status',
        'website',
        'summary',
        'body',
    ];

    public $sortable = [
        'order_column_name' => 'position',
    ];

    public function url($locale = null): string
    {
        $locale = $locale ?: app()->getLocale();
        $route = $locale . '::partner';
        $slug = $this->translate('slug', $locale) ?: null;

        return Route::has($route) && $slug ? url(route($route, $slug)) : url('/');
    }

    protected function thumb(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->present()->image(null, 54),
        );
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }
}
