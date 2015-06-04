@extends('core::public.master')
@inject('page', 'typicms.partners.page')

@section('title', $model->title . ' – ' . trans('news::global.name') . ' – ' . $websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->thumbAbsoluteSrc())
@section('bodyClass', 'body-partners body-partner-' . $model->id . ' body-page body-page-' . $page->id)

@section('main')

    @include('core::public._btn-prev-next', ['module' => 'Partners', 'model' => $model])
    <article>
        <h1>{{ $model->title }}</h1>
        {!! $model->present()->thumb(null, 200) !!}
        <p><a href="{{ $model->website }}" target="_blank">{{ $model->website }}</a></p>
        <p class="summary">{{ nl2br($model->summary) }}</p>
        <div class="body">{!! $model->body !!}</div>
    </article>

@stop
