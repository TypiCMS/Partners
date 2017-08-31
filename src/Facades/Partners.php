<?php

namespace TypiCMS\Modules\Partners\Facades;

use Illuminate\Support\Facades\Facade;

class Partners extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Partners';
    }
}
