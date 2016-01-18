<?php

namespace TypiCMS\Modules\Partners\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'position'  => 'required|integer|min:1',
            'image'     => 'image|max:2000',
            '*.title'   => 'max:255',
            '*.slug'    => 'max:255',
            '*.website' => 'url',
        ];
    }
}
