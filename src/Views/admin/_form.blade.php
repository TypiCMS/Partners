@section('js')
    <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
    <script src="{{ asset('js/admin/form.js') }}"></script>
@stop

@section('otherSideLink')
    @include('core::admin._navbar-public-link')
@stop


@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

@include('core::admin._tabs-lang-form', ['target' => 'content'])

<div class="tab-content">

<div class="checkbox">
    <label>
        {{ Form::checkbox('homepage', 1, $model->homepage) }} @lang('validation.attributes.homepage')
    </label>
</div>

<div class="row">
    <div class="col-sm-2 form-group @if($errors->has('position'))has-error @endif">
        {!! BootForm::text(trans('labels.position'), 'position') !!}
    </div>
</div>

@foreach ($locales as $lang)

    <div class="tab-pane fade @if($locale == $lang)in active @endif" id="content-{{ $lang }}">
        <div class="row">
            <div class="col-md-6 form-group">
                {!! BootForm::text(trans('labels.title'), $lang.'[title]') !!}
            </div>
            <div class="col-md-6 form-group @if($errors->has($lang.'.slug'))has-error @endif">
                {{ Form::label($lang.'[slug]', trans('validation.attributes.slug'), array('class' => 'control-label')) }}
                <div class="input-group">
                    {{ Form::text($lang.'[slug]', $model->translate($lang)->slug, array('class' => 'form-control')) }}
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-slug @if($errors->has($lang.'.slug'))btn-danger @endif" type="button">@lang('validation.attributes.generate')</button>
                    </span>
                </div>
                {{ $errors->first($lang.'.slug', '<p class="help-block">:message</p>') }}
            </div>
        </div>
        {!! BootForm::checkbox(trans('labels.online'), $lang.'[status]') !!}
        <div class="form-group @if($errors->has($lang.'.website'))has-error @endif">
            {{ Form::label($lang.'[website]', trans('validation.attributes.website'), array('class' => 'control-label')) }}
            {{ Form::text($lang.'[website]', $model->translate($lang)->website, array('class' => 'form-control', 'placeholder' => 'http://')) }}
            {{ $errors->first($lang.'.website', '<p class="help-block">:message</p>') }}
        </div>
        {!! BootForm::textarea(trans('labels.body'), $lang.'[body]')->addClass('editor') !!}
    </div>

@endforeach

</div>
