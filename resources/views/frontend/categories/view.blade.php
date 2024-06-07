<style>
    .hover-content {
        width: 200px !important;
    }
</style>

@if ($slug === 'cashblack-to-your-door' || checkCashbackChildCategories($slug, '143'))
<div  id="item-container">
    <ul class="category-listing takeaway-listing {{ $viewType }}" id="storesListN">
        @include('frontend.categories.load-button-stores', ['allStores' => $allStores])
    </ul>
</div>
<button id="load-more-btn" class="btn btn-primary">Load More</button>
@else
    <ul class="category-listing {{ $viewType }}">
        @foreach ($allStores as $store)
            <li class="list-item my-cards">
                <div class="hover-content text-center py-3 px-3 ms-1 card-grid">{{ addEllipsis(strip_tags($store->description), 70) }}</div>
                <div class="category-item__logo">
                    <a href="{{ route('stores.show', $store->slug) }}">
                        <img src="{{ getImageUrl($store->logo->first()) }}" alt="{{ $store->name }}" onerror="_logo(this)">
                    </a>
                </div>
                <div class="category-item__detail">
                    <div class="list-view-hover-content d-none">{{ addEllipsis(strip_tags($store->description), 70) }}</div>
                    <h6 class="upto-offer">
                        <a href="{{ route('stores.show', $store->slug) }}">
                            <span class="brand-name">{{ $store->name }}</span>
                        </a>
                        <ul class="tags" style="">
                            @foreach (getCuisineTags($store) as $tag)
                                <li class="cuisine-li"><a class="cuisine-a" href="javascript:;">{{ $tag }}</a></li>
                            @endforeach
                        </ul>
                        {{ $store->default_cashback }}
                    </h6>
                    <div class="cta"><a href="{{ route('stores.show', $store->slug) }}" class="btn btn-primary">View Retailer</a></div>
                </div>
            </li>
        @endforeach
    </ul>
    <div class="position-relative justify-content-between flex-wrap flex-sm-nowrap pagination-wrap mb-3">
        {!! $allStores->links() !!}
    </div>
    @if ($allStores->count() <= 0)
        <div class="text-center py-3">
            <h3>No store found.</h3>
            <p>It looks like there is no data matching your request.</p>
        </div>
    @endif
@endif

<script>
    $(document).ready(function() {
    let viewType = "{{ $viewType }}";

    if (viewType === 'grid-view') {
        $('.hover-content').removeClass('d-none');
        $('.list-view-hover-content').addClass('d-none');
    }

    if (viewType === 'list-view') {
        $('.list-view-hover-content').removeClass('d-none');
        $('.hover-content').addClass('d-none');
    }

    $('.grid-view').on('click', function(event) {
        console.log('ds');
        $('.hover-content').removeClass('d-none');
        $('.list-view-hover-content').addClass('d-none');
    });

    $('.list-view').on('click', function(event) {
        $('.hover-content').addClass('d-none');
        $('.list-view-hover-content').removeClass('d-none');
    });
})
</script>
