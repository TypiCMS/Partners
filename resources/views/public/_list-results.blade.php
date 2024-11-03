<ul class="partner-list-results-list">
    @foreach ($items as $partner)
        <a class="partner-list-results-item-link" href="{{ $partner->url() }}" title="{{ $partner->title }}">
            {{-- <a class="partner-list-results-item-link" href="{{ $partner->website }}" title="{{ $partner->title }}" target="_blank" rel="noopener noreferrer"> --}}
            {{ $partner->title }}
        </a>
    @endforeach
</ul>
