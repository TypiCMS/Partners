<?php

namespace TypiCMS\Modules\Partners\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    /** @return array<string, string> */
    public function rules(): array
    {
        return [
            'image_id' => 'nullable|integer',
            'homepage' => 'required|boolean',
            'title.*' => 'nullable|max:255',
            'slug.*' => 'nullable|alpha_dash|max:255|required_if:status.*,1|required_with:title.*',
            'status.*' => 'boolean',
            'summary.*' => 'nullable|max:1000',
            'body.*' => 'nullable|max:20000',
            'website.*' => 'nullable|url',
        ];
    }
}
