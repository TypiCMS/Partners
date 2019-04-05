<li class="partner-list-item">
    <a class="partner-list-item-link" href="{{ $partner->uri() }}" title="{{ $partner->title }}">
    {{-- <a class="partner-list-item-link" href="{{ $partner->website }}" title="{{ $partner->title }}" target="_blank" rel="noopener noreferrer"> --}}
        {!! $partner->present()->thumb(null, 200) !!}
    </a>
</li>
