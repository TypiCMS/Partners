<ul class="list-partners">
    @foreach ($items as $partner)
    @include('partners::public._list-item')
    @endforeach
</ul>
