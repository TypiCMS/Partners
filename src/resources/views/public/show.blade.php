@extends('core::public.master')

@section('title', $model->title.' – '.__('Partners').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->image(1200, 630))
@section('bodyClass', 'body-partners body-partner-'.$model->id.' body-page body-page-'.$page->id)

@section('content')

    @include('core::public._btn-prev-next', ['module' => 'Partners', 'model' => $model])

    @include('partners::public._json-ld', ['partner' => $model])

    <article class="partner">
        <h1 class="partner-title">{{ $model->title }}</h1>
        @empty(!$model->image)
        <img class="partner-image" src="{!! $model->present()->image(null, 1000) !!}" alt="">
        @endempty
        <p class="partner-website">
            <a class="partner-website-link" href="{{ $model->website }}" target="_blank" rel="noopener noreferrer">{{ $model->website }}</a>
        </p>
        <p class="partner-summary">{!! nl2br($model->summary) !!}</p>
        <div class="partner-body">{!! $model->present()->body !!}</div>
    </article>

@endsection
