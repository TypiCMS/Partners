@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
@endsection

@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

{!! BootForm::hidden('homepage')->value(0) !!}
{!! BootForm::checkbox(__('validation.attributes.homepage'), 'homepage') !!}

<div class="row">
    <div class="col-sm-2 form-group @if($errors->has('position'))has-error @endif">
        {!! BootForm::text(__('validation.attributes.position'), 'position') !!}
    </div>
</div>

@include('core::form._title-and-slug')
{!! TranslatableBootForm::hidden('status')->value(0) !!}
{!! TranslatableBootForm::checkbox(__('validation.attributes.online'), 'status') !!}
{!! TranslatableBootForm::text(__('validation.attributes.website'), 'website') !!}
{!! TranslatableBootForm::textarea(__('validation.attributes.summary'), 'summary')->rows(4) !!}
{!! TranslatableBootForm::textarea(__('validation.attributes.body'), 'body')->addClass('ckeditor') !!}
