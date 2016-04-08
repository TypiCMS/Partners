@extends('core::admin.master')

@section('title', trans('partners::global.New'))

@section('main')

    @include('core::admin._button-back', ['module' => 'partners'])
    <h1>
        @lang('partners::global.New')
    </h1>

    {!! BootForm::open()->action(route('admin::index-partners'))->multipart()->role('form') !!}
        @include('partners::admin._form')
    {!! BootForm::close() !!}

@endsection
