<li class="partners-item">
    <a class="partners-item-link" href="{{ route($lang.'::partner', $partner->slug) }}" title="{{ $partner->title }}">
    {{-- <a class="partners-item-link" href="{{ $partner->website }}" title="{{ $partner->title }}" target="_blank" rel="noopener noreferrer"> --}}
        {!! $partner->present()->thumb(null, 200) !!}
    </a>
</li>
