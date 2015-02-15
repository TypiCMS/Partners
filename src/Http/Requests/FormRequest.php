<?php
namespace TypiCMS\Modules\Partners\Http\Requests;

use TypiCMS\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest {

    public function rules()
    {
        $rules = [
            'position'       => 'required|integer|min:1',
            'logo'           => 'image|image_aspect:1|image_size:>=200,>=200|max:2000',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules[$locale . '.website'] = 'url';
        }
        return $rules;
    }
}
