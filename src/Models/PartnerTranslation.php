<?php

namespace TypiCMS\Modules\Partners\Models;

use TypiCMS\Modules\Core\Models\BaseTranslation;

class PartnerTranslation extends BaseTranslation
{
    protected $fillable = [
        'title',
        'slug',
        'status',
        'website',
        'summary',
        'body',
    ];

    /**
     * get the parent model.
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Partners\Models\Partner', 'partner_id');
    }
}
