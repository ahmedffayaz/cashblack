@php
    $favoriteStores = auth()
        ->user()
        ->favoriteStores()
        ->get()
        ->take(5);
@endphp
@if (count($favoriteStores))
    <section class="section">
        <div class="container">
            <div class="section-title-wrap text-center pt-5">
                <h2 class="section-title">Shop At Top Retailers</h2>
            </div>
            <div class="retailers-panel">
                <div class="row">
                    @foreach ($favoriteStores as $favoriteStore)
                        <div class="col mb-4">
                            <a href="{{ route('stores.show', $favoriteStore->slug) }}">
                                <div class="retailers-panel__item">
                                    <span class="icon"><img src="{{ getImageUrl($favoriteStore->logo->first()) }}" alt="{{ $favoriteStore->name }}" onerror="_logo(this)"></span>
                                    <h6 class="brand-name" style="text-align: center; margin-top: 0.5rem;">{{ $favoriteStore->name }}</h6>
                                    <h5 class="retailers-panel__text">{{ $favoriteStore->default_cashback }}</h5>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
