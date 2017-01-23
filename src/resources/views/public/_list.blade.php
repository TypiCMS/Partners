<ul class="partners-list">
    @foreach ($items as $partner)
    @include('partners::public._list-item')
    @endforeach
</ul>
