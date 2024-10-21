@extends('pages::public.master')

@section('bodyClass', 'body-partners body-partners-index body-page body-page-' . $page->id)

@section('page')
    <div class="page-body">
        <div class="page-body-container">
            @include('pages::public._main-content', ['page' => $page])
            @include('files::public._document-list', ['model' => $page])
            @include('files::public._image-list', ['model' => $page])

            @include('partners::public._itemlist-json-ld', ['items' => $models])

            @includeWhen($models->count() > 0, 'partners::public._list', ['items' => $models])
        </div>
    </div>
@endsection
