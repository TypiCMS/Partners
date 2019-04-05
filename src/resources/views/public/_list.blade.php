<ul class="partner-list-list">
    @foreach ($items as $partner)
    @include('partners::public._list-item')
    @endforeach
</ul>
