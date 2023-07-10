<li class="partner-list-item">
    <a class="partner-list-item-link" href="{{ $partner->uri() }}" title="{{ $partner->title }}">
        {{-- <a class="partner-list-item-link" href="{{ $partner->website }}" title="{{ $partner->title }}" target="_blank" rel="noopener noreferrer"> --}}
        @empty(!$partner->image)
            <img class="partner-list-item-image" src="{{ $partner->present()->image(null, 200) }}" width="{{ $partner->image->width }}" height="{{ $partner->image->height }}"
                alt="{{ $partner->image->alt_attribute }}" />
        @endempty
    </a>
</li>
