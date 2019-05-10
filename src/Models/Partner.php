<?php

namespace TypiCMS\Modules\Partners\Models;

use Laracasts\Presenter\PresentableTrait;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\History\Traits\Historable;
use TypiCMS\Modules\Partners\Presenters\ModulePresenter;

class Partner extends Base implements Sortable
{
    use HasTranslations;
    use Historable;
    use PresentableTrait;
    use SortableTrait;

    protected $presenter = ModulePresenter::class;

    protected $guarded = ['id', 'exit'];

    protected $appends = ['thumb'];

    public $translatable = [
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

    /**
     * Append thumb attribute.
     *
     * @return string
     */
    public function getThumbAttribute()
    {
        return $this->present()->image(null, 54);
    }

    /**
     * This model belongs to one image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(File::class, 'image_id');
    }
}
