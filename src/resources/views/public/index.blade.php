@extends('core::public.master')

@section('title', trans('partners::global.name') . ' – ' . $websiteTitle)
@section('ogTitle', trans('partners::global.name'))
@section('bodyClass', 'body-partners')

@section('main')

    <h1>@lang('partners::global.name')</h1>

    @if ($models->count())
    @include('partners::public._list', ['items' => $models])
    @endif

@stop
