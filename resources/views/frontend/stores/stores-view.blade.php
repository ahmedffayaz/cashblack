<ul class="category-listing store-listing {{ $viewType }}">
    @foreach ($allStores as $store)
    <li class="list-item my-cards">
        <div class="hover-content d-none">{{ addEllipsis(strip_tags($store->description), 70) }}</div>
        <a href="javascript:;"
            class="ui-notify  fav-icon {{ !empty(auth()->user()) ? (checkFavorite($store->id) ? 'liked' : '') : '' }} not-liked"
            this-store-id="{{ $store->id }}" this-store-name="{{ $store->description }}">
            <i class="fas fa-heart"></i>
        </a>
        <div class="category-item__logo store-grid-img {{ $viewType === 'grid-view' ? 'img-fix-size' : '' }}">
            <a href="{{ route('stores.show', $store->slug) }}">
                <img alt="{{ $store->name }}" src="{{ getImageUrl($store->logo->first()) }}" class="img-height"
                    onerror="_logo(this)">
            </a>
        </div>
        <div class="category-item__detail">
            <div class="store-title">
                <a href="{{ route('stores.show', $store->slug) }}">
                    <h5 class="brand-name {{ $viewType === 'grid-view' ? '' : 'name-fixed-size' }}">{{ $store->name }}</h5>
                </a>
            </div>
            <div class="list-view-hover-content d-none">{{ addEllipsis(strip_tags($store->description), 70) }}</div>
            <h6 class="upto-offer">{{ $store->default_cashback }}</h6>
            <div class="cta">
                <a href="{{ route('stores.show', $store->slug) }}" class="btn btn-primary">
                    View Retailer
                </a>
            </div>
        </div>
    </li>
    @endforeach
</ul>

<div class="page-bottom-actions position-relative mt-5">
    {!! $allStores->links() !!}
</div>
@if ($allStores->count() <= 0) <div class="text-center py-3">
    <h3>No store found.</h3>
    <p>It looks like there is no data matching your request.</p>
    </div>
    @endif

    <div class="modal fade" id="signin-favorite-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-5">
                    <h4>
                        Do you want to favourite this store?
                    </h4>
                    <h6 class="mt-2 font-weight-normal" style="font-weight: 500;">
                        Signup to your account to perform this action.
                    </h6>
                </div>
                <div class="modal-footer">
                    <a href="javascript:;" data-bs-dismiss="modal" aria-label="Close" class="btn btn-warning">
                        Cancel
                    </a>
                    <a href="{{ route('login') }}?prvUrl={{ request()->fullUrl() }}" class="btn btn-primary">
                        Signup
                    </a>
                </div>
            </div>
        </div>
    </div>

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
