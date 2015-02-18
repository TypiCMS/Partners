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

    /**
     * Sanitize inputs
     * 
     * @return array
     */
    public function sanitize()
    {
        $input = $this->all();

        // Checkboxes
        $input['homepage'] = $this->has('homepage');
        foreach (config('translatable.locales') as $locale) {
            $input[$locale]['status'] = $this->has($locale . '.status');
        }

        $this->replace($input);
        return $this->all();
    }
}
