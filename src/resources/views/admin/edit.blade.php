@extends('core::admin.master')

@section('title', $model->present()->title)

@section('main')

    @include('core::admin._button-back', ['module' => 'partners'])
    <h1 class="@if(!$model->present()->title)text-muted @endif">
        {{ $model->present()->title ?: __('core::global.Untitled') }}
    </h1>

    {!! BootForm::open()->put()->action(route('admin::update-partner', $model->id))->multipart()->role('form') !!}
    {!! BootForm::bind($model) !!}
        @include('partners::admin._form')
    {!! BootForm::close() !!}

@endsection
