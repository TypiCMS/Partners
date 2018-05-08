@push('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
@endpush

@component('core::admin._buttons-form', ['model' => $model])
@endcomponent

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

<div class="form-group">
    {!! BootForm::hidden('homepage')->value(0) !!}
    {!! BootForm::checkbox(__('Homepage'), 'homepage') !!}
</div>

<div class="row">
    <div class="col-sm-2">
        {!! BootForm::text(__('Position'), 'position')->type('number')->min(1)->required() !!}
    </div>
</div>

@include('core::form._title-and-slug')
<div class="form-group">
    {!! TranslatableBootForm::hidden('status')->value(0) !!}
    {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
</div>
{!! TranslatableBootForm::text(__('Website'), 'website') !!}
{!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!}
{!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor') !!}
