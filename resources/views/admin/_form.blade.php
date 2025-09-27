<div class="header">
    <x-core::back-button :url="$model->indexUrl()" :title="__('Partners')" />
    <x-core::title :$model :default="__('New partner')" />
    <x-core::form-buttons :$model :locales="locales()" />
</div>

<div class="content">
    <x-core::form-errors />

    <file-manager></file-manager>
    <file-field type="image" field="image_id" :init-file="{{ $model->image ?? 'null' }}"></file-field>

    <div class="mb-3">
        {!! BootForm::hidden('homepage')->value(0) !!}
        {!! BootForm::checkbox(__('Homepage'), 'homepage') !!}
    </div>

    <x-core::title-and-slug-fields :locales="locales()" />
    <div class="mb-3">
        {!! TranslatableBootForm::hidden('status')->value(0) !!}
        {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
    </div>
    {!! TranslatableBootForm::text(__('Website'), 'website')->placeholder('https://') !!}
    {!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!}
    <x-core::tiptap-editors :model="$model" name="body" :label="__('Body')" />
</div>
