@extends('pages::public.master')

@section('bodyClass', 'body-partners body-partners-index body-page body-page-' . $page->id)

@section('page')
    <div class="page-body">
        <div class="page-body-container">
            @include('pages::public._main-content', ['page' => $page])
            @include('files::public._document-list', ['model' => $page])
            @include('files::public._image-list', ['model' => $page])

            <x-core::json-ld :schema="[
                '@context' => 'https://schema.org',
                '@type' => 'ItemList',
                'itemListElement' => $models->map(fn ($item, $index) => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'url' => $item->url(),
                ])->all(),
            ]" />

            @includeWhen($models->count() > 0, 'partners::public._list', ['items' => $models])
        </div>
    </div>
@endsection
