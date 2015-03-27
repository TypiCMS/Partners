<li>
    <a href="{{ route($lang.'.partners.slug', $partner->slug) }}" title="{{ $partner->title }}">
    {{-- <a href="{{ $partner->website }}" title="{{ $partner->title }}" target="_blank"> --}}
        {!! $partner->present()->thumb(null, 200) !!}
    </a>
</li>
