@extends('core::admin.master')

@section('title', __('Partners'))

@section('content')

<item-list
    url-base="{{ route('api::index-partners') }}"
    locale="{{ config('typicms.content_locale') }}"
    fields="id,position"
    translatable-fields="status,title"
    table="partners"
    title="partners"
    :searchable="['id']"
    :sorting="['position']">

    <template slot="add-button">
        @include('core::admin._button-create', ['module' => 'partners'])
    </template>

    <template slot="buttons">
        @include('core::admin._lang-switcher-for-list')
    </template>

    <template slot="columns" slot-scope="{ sortArray }">
        <item-list-column-header name="checkbox"></item-list-column-header>
        <item-list-column-header name="edit"></item-list-column-header>
        <item-list-column-header name="status_translated" sortable :sort-array="sortArray" :label="$t('Status')"></item-list-column-header>
        <item-list-column-header name="image" :label="$t('Image')"></item-list-column-header>
        <item-list-column-header name="position" sortable :sort-array="sortArray" :label="$t('Position')"></item-list-column-header>
        <item-list-column-header name="title_translated" sortable :sort-array="sortArray" :label="$t('Title')"></item-list-column-header>
    </template>

    <template slot="table-row" slot-scope="{ model, checkedModels, loading }">
        <td class="checkbox"><item-list-checkbox :model="model" :checked-models-prop="checkedModels" :loading="loading"></item-list-checkbox></td>
        <td>@include('core::admin._button-edit', ['module' => 'partners'])</td>
        <td><item-list-status-button :model="model"></item-list-status-button></td>
        <td><img :src="model.thumb" alt=""></td>
        <td>@{{ model.position }}</td>
        <td>@{{ model.title_translated }}</td>
    </template>

</item-list>

@endsection
