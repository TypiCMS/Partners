<div class="header">
    @include('core::admin._button-back', ['url' => $model->indexUrl(), 'title' => __('Partners')])
    @include('core::admin._title', ['default' => __('New partner')])
    @component('core::admin._buttons-form', ['model' => $model])
    @endcomponent
</div>

<div class="content">
    @include('core::admin._form-errors')

    <file-manager related-table="{{ $model->getTable() }}" :related-id="{{ $model->id ?? 0 }}"></file-manager>
    <file-field type="image" field="image_id" :init-file="{{ $model->image ?? 'null' }}"></file-field>

    <div class="mb-3">
        {!! BootForm::hidden('homepage')->value(0) !!}
        {!! BootForm::checkbox(__('Homepage'), 'homepage') !!}
    </div>

    @include('core::form._title-and-slug')
    <div class="mb-3">
        {!! TranslatableBootForm::hidden('status')->value(0) !!}
        {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
    </div>
    {!! TranslatableBootForm::text(__('Website'), 'website')->placeholder('https://') !!}
    {!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!}
    @foreach(locales() as $locale)
        <tiptap-editor name="body[{{ $locale }}]" locale="{{ $locale }}" init-content="{{ $model->getTranslation('body', $locale) }}"></tiptap-editor>
    @endforeach
</div>
