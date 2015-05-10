<?php
namespace TypiCMS\Modules\Partners\Models;

use Dimsav\Translatable\Translatable;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;

class Partner extends Base
{

    use Historable;
    use PresentableTrait;
    use Translatable;

    protected $presenter = 'TypiCMS\Modules\Partners\Presenters\ModulePresenter';

    protected $fillable = array(
        'image',
        // Translatable columns
        'title',
        'slug',
        'position',
        'homepage',
        'status',
        'website',
        'summary',
        'body',
    );

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = array(
        'title',
        'slug',
        'status',
        'website',
        'summary',
        'body',
    );

    protected $appends = ['status', 'title', 'thumb', 'website'];

    /**
     * Columns that are file.
     *
     * @var array
     */
    public $attachments = array(
        'image',
    );

    /**
     * Get attribute from translation table
     * and append it to main model attributes
     * @return string title
     */
    public function getWebsiteAttribute()
    {
        return $this->website;
    }
}
