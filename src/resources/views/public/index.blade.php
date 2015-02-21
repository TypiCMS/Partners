@extends('core::public.master')

@section('title', trans('partners::global.name') . ' – ' . $websiteTitle)
@section('ogTitle', trans('partners::global.name'))

@section('main')

    <h2>@lang('partners::global.name')</h2>

    <div class="row partners">
        @foreach ($partners as $partner)
        <div class="col-xs-4 col-sm-3 col-md-2">
            <a href="{{ route($lang.'.partners.slug', $partner->slug) }}" class="thumbnail">
                <div class="img-container">
                    {!! $partner->present()->thumb(null, 200) !!}
                </div>
                <div class="caption">
                    <p><small>{{ $partner->title }}</small></p>
                </div>
            </a>
        </div>
        @endforeach
    </div>

@stop
