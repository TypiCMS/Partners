@extends('pages::public.master')
<?php $page = TypiCMS::getPageLinkedToModule('partners') ?>

@section('bodyClass', 'body-partners body-partners-index body-page body-page-' . $page->id)

@section('main')

    {!! $page->body !!}

    @include('galleries::public._galleries', ['model' => $page])

    @if ($models->count())
    @include('partners::public._list', ['items' => $models])
    @endif

@stop
