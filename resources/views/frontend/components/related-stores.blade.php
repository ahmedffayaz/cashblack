@if (isset($store) && optional(similarStores($store))->count() > 0)
    <div class="panel rounded-border mb-4 related-stores">
        <h5 class="sidebar-title">Related Stores</h5>
        <ul class="related-stores__list">
            @foreach (similarStores($store)->take(5) as $relatedStore)
                <li class="list-item">
                    <a href="{{ route('stores.show', $relatedStore->slug) }}">
                        <div class="item-logo">
                            <img src="{{ getImageUrl($relatedStore->logo->first()) }}" class="img-fluid" alt="{{ $store->name }}" onerror="_logo(this)">
                        </div>
                        <div class="item-detail">
                            <h6 class="break-word">{{ $relatedStore->name }}</h6>
                            <p>{{ $relatedStore->default_cashback }}</p>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
