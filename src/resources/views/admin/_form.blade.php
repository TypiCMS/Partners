@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
@endsection

@component('core::admin._buttons-form', ['model' => $model])
@endcomponent

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

{!! BootForm::hidden('homepage')->value(0) !!}
{!! BootForm::checkbox(__('Homepage'), 'homepage') !!}

<div class="row">
    <div class="col-sm-2 form-group @if($errors->has('position'))has-error @endif">
        {!! BootForm::text(__('Position'), 'position')->type('number')->min(1)->required() !!}
    </div>
</div>

@include('core::form._title-and-slug')
{!! TranslatableBootForm::hidden('status')->value(0) !!}
{!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
{!! TranslatableBootForm::text(__('Website'), 'website') !!}
{!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!}
{!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor') !!}
