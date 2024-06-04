@php
    $topCategories = getFeaturesCategories('top_categories');
@endphp
@if (count($topCategories))
    <section id="top-offers" class="section bg-gray">
        <div class="container">
            <div class="section-title-wrap text-center">
                <h2 class="section-title">Top Offers</h2>
            </div>
            <div class="offers-listing">
                <div class="row mb-4">
                    @foreach ($topCategories as $topCategory)
                        <div class="col-md-4 mb-4">
                            <a href="{{ route('categories.show', $topCategory->slug) }}">
                                <div class="offer-cat-banner">
                                    <img src="{{ $topCategory->banner_type != 'link' ? getBannerImageUrl($topCategory->banner_upload, 'upload', $topCategory) : (!empty($topCategory->banner_link) ? $topCategory->banner_link : '') }}"
                                        alt="" class="img-fluid">
                                    <div class="category-title">
                                        <h5>{{ $topCategory->name }}</h5>
                                    </div>
                                </div>
                            </a>
                            @php $topStores = getFeaturesStores('top_stores', $topCategory->slug); @endphp
                            @foreach ($topStores as $topStore)
                                    <ul class="cat-offers-list">
                                        <li class="list-item">
                                            <div class="list-icon">
                                                <a href="{{ route('stores.show', $topStore->slug) }}">
                                                    <img src="{{ getImageUrl($topStore->logo->first()) }}" alt="" class="img-view-size" onerror="_logo(this)">
                                                </a>
                                            </div>
                                            <div class="list-text">
                                                <a href="{{ route('stores.show', $topStore->slug) }}">
                                                    <h6 class="brand-name">{{ $topStore->name }}</h6>
                                                </a>
                                                <h6>{{ $topStore->default_cashback }}</h6>
                                                <p class="secondary-text-color">{{  $topStore->cashback->detail ?? "on successful sale" }}</p>
                                            </div>
                                        </li>
                                    </ul>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
