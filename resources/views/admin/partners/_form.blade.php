<x-core::header :$model :back-url="$model->indexUrl()" :back-label="__('Partners')" :default-title="__('New partner')" />

<div class="form-body">
    <x-core::form-errors />

    <div class="row">
        <div class="col-lg-8">
            <div class="mb-3">
                <x-bootform::checkbox :label="__('Homepage')" name="homepage" :unchecked-value="0" />
            </div>

            <x-core::title-and-slug-fields />
            <div class="mb-3">
                <x-transbootform::checkbox :label="__('Published')" name="status" :unchecked-value="0" />
            </div>
            <x-transbootform::text :label="__('Website')" name="website" placeholder="https://" />

            <x-transbootform::textarea :label="__('Summary')" name="summary" rows="4" />
            <x-core::tiptap-editors :model="$model" name="body" :label="__('Body')" />
        </div>
        <div class="col-lg-4">
            <div class="right-column">
                <file-manager></file-manager>
                <file-field type="image" field="image_id" :init-file="{{ $model->image ?? 'null' }}"></file-field>
                <file-field type="image" field="og_image_id" :init-file="{{ $model->ogImage ?? 'null' }}" label="@lang('Social Share Image')" hint="1200 × 630 px"></file-field>
            </div>
        </div>
    </div>
</div>
