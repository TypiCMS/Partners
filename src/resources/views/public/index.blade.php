@extends('pages::public.master')

@section('bodyClass', 'body-partners body-partners-index body-page body-page-'.$page->id)

@section('content')

    {!! $page->present()->body !!}

    @include('files::public._files', ['model' => $page])

    @if ($models->count())
    @include('partners::public._list', ['items' => $models])
    @endif

@endsection
