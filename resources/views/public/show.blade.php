@extends('core::public.master')

@section('title', $model->title.' – '.__('Partners').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('ogImage', $model->present()->image(1200, 630))
@section('bodyClass', 'body-partners body-partner-'.$model->id.' body-page body-page-'.$page->id)

@section('content')
    <article class="partner">
        <header class="partner-header">
            <div class="partner-header-container">
                <div class="partner-header-navigator">
                    @include('core::public._items-navigator', ['module' => 'Partners', 'model' => $model])
                </div>
                <h1 class="partner-title">{{ $model->title }}</h1>
                @empty(! $model->website)
                    <p class="partner-website">
                        <a class="partner-website-link" href="{{ $model->website }}" target="_blank" rel="noopener noreferrer">
                            {{ $model->website }}
                        </a>
                    </p>
                @endempty
            </div>
        </header>
        <div class="partner-body">
            @include('partners::public._json-ld', ['partner' => $model])
            <p class="partner-summary">{!! nl2br($model->summary) !!}</p>
            @empty(! $model->image)
                <figure class="partner-picture">
                    <img class="partner-picture-image" src="{{ $model->present()->image(2000) }}" width="{{ $model->image->width }}" height="{{ $model->image->height }}" alt="" />
                    @empty(! $model->image->description)
                        <figcaption class="partner-picture-legend">{{ $model->image->description }}</figcaption>
                    @endempty
                </figure>
            @endempty

            <div class="rich-content">{!! $model->present()->body !!}</div>
        </div>
    </article>
@endsection
