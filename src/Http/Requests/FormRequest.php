<?php
namespace TypiCMS\Modules\Partners\Http\Requests;

use TypiCMS\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest {

    public function rules()
    {
        $rules = [
            'position' => 'required|integer|min:1',
            'image'    => 'image|max:2000|image_size:>=500',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules[$locale . '.website'] = 'url';
        }
        return $rules;
    }
}
