@extends('core::public.master')

@section('title', $model->title . ' – ' . trans('news::global.name') . ' – ' . $websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->thumbAbsoluteSrc())

@section('main')

    <h2>{{ $model->title }}</h2>
    {!! $model->present()->thumb(null, 200) !!}
    <p><a href="{{ $model->website }}" target="_blank">{{ $model->website }}</a></p>
    <p class="summary">{{ nl2br($model->summary) }}</p>
    <div class="body">{!! $model->body !!}</div>

@stop
