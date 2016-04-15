<?php

namespace TypiCMS\Modules\Partners\Models;

use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;

class Partner extends Base
{
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Partners\Presenters\ModulePresenter';

    protected $guarded = ['id'];

    public $translatable = [
        'title',
        'slug',
        'status',
        'website',
        'summary',
        'body',
    ];

    protected $appends = ['thumb', 'website'];

    public $attachments = [
        'image',
    ];

    /**
     * Append thumb attribute.
     *
     * @return string
     */
    public function getThumbAttribute()
    {
        return $this->present()->thumbSrc(null, 22);
    }

    /**
     * Append website attribute from translation table.
     *
     * @return string
     */
    public function getWebsiteAttribute()
    {
        return $this->website;
    }
}
