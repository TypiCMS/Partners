@extends('core::admin.master')

@section('title', __('New partner'))

@section('content')

    @include('core::admin._button-back', ['module' => 'partners'])
    <h1>
        @lang('New partner')
    </h1>

    {!! BootForm::open()->action(route('admin::index-partners'))->multipart()->role('form') !!}
        @include('partners::admin._form')
    {!! BootForm::close() !!}

@endsection
