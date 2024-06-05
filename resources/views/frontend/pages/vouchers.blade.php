@extends('frontend.layouts.app')

@section('title', 'Vouchers')

@push('styles')
@endpush

@section('content')
    <section>
        <div class="container">
            @include('frontend.components.breadcrumbs', [
                'crumbs' => [],
                'current' => 'Vouchers',
            ])
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="d-none d-sm-block">
                        <div class="panel rounded-border mb-4 related-stores">
                            <h5 class="sidebar-title">Featured Stores</h5>
                            <ul class="related-stores__list">
                                @php $featuredStores = similarStores($stores->first()); @endphp
                                @foreach ($featuredStores->take(5) as $store)
                                    <li class="list-item" style="list-style: none;">
                                        <a href="store-detail/3273/mama-africa-nigerian">
                                            <div class="item-logo">
                                                <img alt="{{ $store->name }}" class="img-fluid" src="{{ getImageUrl($store->logo->first()) }}">
                                            </div>
                                            <div class="item-detail">
                                                <h6>{{ $store->name }}</h6>
                                                <p>{{ $store->default_cashback }}</p>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="content-area col-md-9">
                    <div class="rounded-border mb-5">
                        <div class="category-list-header">
                            <div class="title-area">
                                <h4 class="category-title">Vouchers</h4>
                            </div>
                            <div class="listing-actions">
                                <div class="result-preview-option">
                                    <a href="javascript:;" id="gridview" class="grid-view view-btn active"></a>
                                    <a href="javascript:;" id="listview" class="list-view view-btn"></a>
                                </div>
                                <div class="sort-option dropdown">
                                    <select class="form-control filter-by btn sort-btn" id="add-sort">
                                        <option value="">Sort By</option>
                                        <option value="a-z">A-Z</option>
                                        <option value="id">Newest Added</option>
                                        <option value="exit_clicks">Popularity</option>

                                        <option value="hcb_percent">Cashback Percentage (%)</option>
                                        <option value="hcb_pound">Cashback Amount ($)</option>
                                    </select>
                                </div>

                                <div class="sort-option dropdown">
                                    <select class="form-control sort_order btn sort-btn" id="add-order">
                                        <option value="">Sort Order</option>
                                        <option value="asc">Ascending</option>
                                        <option value="desc">Descending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <ul class="category-listing grid-view">
                            @foreach ($stores as $store)
                                <li class="list-item">
                                    <div class="category-item__logo">
                                        <a href="{{ route('store.show', $store->slug) }}">
                                            <img alt="{{ $store->name }}" src="{{ getImageUrl($store->logo->first()) }}">
                                        </a>
                                    </div>
                                    <div class="category-item__detail">
                                        <h6 class="upto-offer">
                                            <span class="brand-name">{{ $store->name }}</span>
                                            {{ implode(', ',$store->vouchers->take(2)->pluck('link_name')->toArray()) }}
                                            @if ($store->vouchers->count() > 2)
                                                <a href="{{ route('store.show', $store->slug) }}">{{ $store->vouchers->count() - 2 }} more</a>
                                            @endif
                                        </h6>
                                        <div class="cta">
                                            <a href="{{ route('store.show', $store->slug) }}" class="btn btn-primary">
                                                View Retailer
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="position-relative d-flex justify-content-between flex-wrap flex-sm-nowrap pagination-wrap">
                        <nav aria-label="Page navigation example"></nav>
                        <div class="per-page-select">
                            <label>Stores per page</label>
                            <select id="stores_par_page">
                                <option value="12" selected="">12</option>
                                <option value="24">24</option>
                                <option value="48">48</option>
                            </select>
                        </div>

                    </div>

                    <div class="panel rounded-border text-center mt-5 d-sm-none">
                        <img src="https://www.cashblack.com/resources/assets/img/sidebar-banner.jpg" class="img-fluid" alt="">
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
