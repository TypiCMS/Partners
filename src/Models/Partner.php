<?php

namespace TypiCMS\Modules\Partners\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Core\Models\File;
use TypiCMS\Modules\Core\Traits\Historable;
use TypiCMS\Modules\Partners\Presenters\ModulePresenter;

class Partner extends Base implements Sortable
{
    use HasTranslations;
    use Historable;
    use PresentableTrait;
    use SortableTrait;

    protected string $presenter = ModulePresenter::class;

    protected $guarded = [];

    protected $casts = [
        'homepage' => 'boolean',
    ];

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
