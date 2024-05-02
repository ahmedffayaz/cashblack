@extends('frontend.layouts.app')

@section('title', $store->name)

@push('styles')
    <style>
        .btn {
            text-transform: uppercase;
        }

        .takeaway-content-bs {
            margin: auto 0;
        }

        .store-sub-text {
            color: #3baa34;
            font-size: 1rem;
            font-weight: 700;
        }

        .jq-ry-container {
            padding: 0px;
        }
    </style>
@endpush

@section('content')
    <div class="container pb-5">
        @include('frontend.components.breadcrumbs', [
            'crumbs' => [
                [
                    'url' => route('categories.index'),
                    'title' => 'All Categories',
                ],
            ],
            'current' => $store->name,
        ])

        <div class="category-banner mb-4">
            <img src="{{ getImageUrl($store->images()->where('title', 'cover')->first()) }}" alt="{{ $store->name }}" class="img-fluid" onerror="_banner(this)">
        </div>

        <div class="row main-content">
            <div class="col-md-3">
                <div class="panel rounded-border mb-3 fav-brand text-center takeaway-listing">

                    <a href="javascript:;" class="store-detail-fav-icon {{ !empty(auth()->user()) ? (checkFavorite($store->id) ? 'liked' : '') : '' }} not-liked"
                        this-store-id="{{ $store->id }}" this-store-name="{{ $store->name }}">
                        <i class="fas fa-heart"></i>
                    </a>
                    <div class="brand-logo">
                        <img src="{{ getImageUrl($store->logo->first()) }}" class="img-fluid w-100" alt="{{ $store->name }}" onerror="_logo(this)">
                    </div>
                    <p class="brand-name">{{ $store->name }}</p>
                    <div class="item-name-tags">
                        <ul class="tags">
                            @foreach (getCuisineTags($store) as $tag)
                                <li><a href="javascript:;">{{ $tag }}</a></li>
                            @endforeach
                        </ul>
                        @foreach ($store->storeAddress()->get() as $address)
                            <p class="address">{{ !empty($store->postal_code) ? implode(', ', [$store->postal_code, $address->address]) : $address->address }}</p>
                        @endforeach

                        <h6 class="cashback-val">{{ $store->default_cashback }}</h6>
                    </div>
                </div>

                <div class="d-none d-sm-block">
                    @include('frontend.components.share-this')
                    @include('frontend.components.related-stores')
                </div>
            </div>

            <div class="content-area col-md-9">
                <div class="category-text panel rounded-border mb-3">
                    <h5 class="mb-2">{{ $store->name }}</h5>
                    @if (!$store->override_network && $store->default_cashback != null)
                        <p class="store-sub-text mt-2 mb-2">Get {{ $store->default_cashback }}</p>
                        <div class="cta mb-5">
                            <a @if (!empty(auth()->user()))
                                href="{{ route('click.store', [$store->id, $userRefId->short_ref_id]) }}?cashback_type=cashback&cashback_id={{ $store->cashbacks()->pluck('id')->first() }}" target="_blank"
                            @else
                                href="javascript:;" data-cashback-type="cashback" data-cashback-id="{{ $store->cashbacks()->pluck('id')->first() }}"
                            @endif class="btn btn-primary @if (empty(auth()->user())) get-cashback-btn @endif"
                            data-is-auth="{{ auth()->user() ? 'true' : 'false' }}">
                            Get Cashback
                        </a>
                        </div>
                    @endif
                    <p>{!! $store->description !!}</p>
                </div>

                <div class="promo-banners mb-3">
                    <div class="row"></div>
                </div>

                <div class="title-wrap panel rounded-border mb-3">
                    <h3 class="heading">Cashback Offers</h3>
                </div>

                <div class="offers-coupons-list">
                    @foreach ($store->cashbacks as $cashback)
                        <div class="list-item rounded-border">
                            <div class="item-detail">
                                <div class="local-store-takeways">
                                    @if (!empty($cashback->image))
                                        <div class="category-item__logo">
                                            @if (Storage::exists('public/' . $cashback->image))
                                                <img src="{{ getImageUrl(asset('storage/' . $cashback->image)) }}">
                                            @endif
                                        </div>
                                    @endif
                                    <div class="takeaway-content-bs">
                                        <h5 class="cashback-val">
                                            {{ $cashback->getCashback() }}
                                        </h5>
                                        <p class="tagline cashback-description">{{ $cashback->detail }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="product__footer">
                                <div class="cta">
                                    <a @if (!empty(auth()->user()))
                                            href="{{ route('click.store', [$store->id, $userRefId->short_ref_id]) }}?cashback_type=bonus_cashback&cashback_id={{ $cashback->id }}" target="_blank"
                                        @else
                                            href="javascript:;" data-cashback-type="bonus_cashback" data-cashback-id="{{ $cashback->id }}"
                                        @endif class="btn btn-primary @if (empty(auth()->user())) get-cashback-btn @endif"
                                        data-is-auth="{{ auth()->user() ? 'true' : 'false' }}">
                                        Get Cashback
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if (!empty(strip_tags($store->terms_conditions)))
                    <div class="panel rounded-border mb-3 list-style">
                        <h3 class="heading mb-2">Terms & Conditions</h3>
                        <p>{!! $store->terms_conditions !!}</p>
                    </div>
                @endif
                <div class="track-panel panel rounded-border bg-gray mb-4 mt-4 d-none">
                    <h5 class="title text-center">When Will I Get My Cashback?</h5>
                    <div class="row steps">
                        <div class="col">Purchase today</div>
                        <div class="col">Tracked in 5 to 10 days</div>
                        <div class="col">Claim in 15 to 30 days</div>
                        <div class="col">Get in 45 to 60 days</div>
                    </div>
                    <p class="more">Have more questions? visit our <a href="https://www.cashblack.com/faqs">FAQ's Page</a></p>
                </div>

                @if ($store->activeReviews->count() > 0)
                    <div class="reviews-container mt-3" data-count="{{ $store->activeReviews->count() }}" id="reviews">
                        <div class="rounded-border px-4 pt-4 pb-1">
                            @foreach ($store->activeReviews->take(10) as $key => $review)
                                <div class="row review-text mb-3">
                                    <div class="col-md-3">
                                        <div class="img-h row">
                                            <img src="{{ getAvatar($review->user->avatar) }}"
                                                class="reviewer-image" onerror="defaultAvatar(this)">
                                            <span class="p-0 ms-2">{{ !isset($review->user) ? '' : $review->user->first_name . ' ' . $review->user->last_name }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-7 mt-3">
                                        <div id="review-{{ $key }}" class="pl-0 jq-ry-container {{ $review->review ? '' : 'pt-md-3' }}" readonly="readonly"
                                            style="width: 100px;">
                                            <div class="jq-ry-group-wrapper">
                                                <div class="jq-ry-normal-group jq-ry-group">
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px"
                                                        xml:space="preserve" width="20px" height="20px" fill="gray">
                                                        <polygon
                                                            points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 ">
                                                        </polygon>
                                                    </svg>
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px"
                                                        xml:space="preserve" width="20px" height="20px" fill="gray" style="margin-left: 0px;">
                                                        <polygon
                                                            points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 ">
                                                        </polygon>
                                                    </svg>
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px"
                                                        xml:space="preserve" width="20px" height="20px" fill="gray" style="margin-left: 0px;">
                                                        <polygon
                                                            points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 ">
                                                        </polygon>
                                                    </svg>
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px"
                                                        xml:space="preserve" width="20px" height="20px" fill="gray" style="margin-left: 0px;">
                                                        <polygon
                                                            points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 ">
                                                        </polygon>
                                                    </svg>
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px"
                                                        xml:space="preserve" width="20px" height="20px" fill="gray" style="margin-left: 0px;">
                                                        <polygon
                                                            points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 ">
                                                        </polygon>
                                                    </svg>
                                                </div>
                                                <div class="jq-ry-rated-group jq-ry-group" style="width: 100%;">
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px"
                                                        xml:space="preserve" width="20px" height="20px" fill="#f39c12">
                                                        <polygon
                                                            points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 ">
                                                        </polygon>
                                                    </svg>
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px"
                                                        xml:space="preserve" width="20px" height="20px" fill="#f39c12" style="margin-left: 0px;">
                                                        <polygon
                                                            points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 ">
                                                        </polygon>
                                                    </svg>
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px"
                                                        xml:space="preserve" width="20px" height="20px" fill="#f39c12" style="margin-left: 0px;">
                                                        <polygon
                                                            points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 ">
                                                        </polygon>
                                                    </svg>
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px"
                                                        xml:space="preserve" width="20px" height="20px" fill="#f39c12" style="margin-left: 0px;">
                                                        <polygon
                                                            points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 ">
                                                        </polygon>
                                                    </svg>
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px"
                                                        xml:space="preserve" width="20px" height="20px" fill="#f39c12" style="margin-left: 0px;">
                                                        <polygon
                                                            points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 ">
                                                        </polygon>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            setTimeout(function() {
                                                $("#review-{{ $key }}").rateYo({
                                                    rating: Number(`{{ $review->rating }}`),
                                                    starWidth: "20px",
                                                    readOnly: true
                                                });
                                            }, 1000);
                                        </script>
                                        @if (!empty($review->review))
                                            <p class="pt-4">{!! $review->review !!}</p>
                                        @endif
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                @if ($key + 1 < $store->activeReviews->count())
                                    <hr>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="messageBox mt-4" id="error-message" style="display: none;">
                    <div class="alert alert-danger alert-dismissible"></div>
                </div>

                <div class="messageBox mt-4" id="success-message" style="display: none;">
                    <div class="alert alert-success alert-dismissible"></div>
                </div>

                @auth
                    <div class="reviews-container mt-3">
                        <div class="rounded-border px-4 pt-3 pb-4">
                            <form action="{{ route('stores-reviews.store') }}" method="post" id="review-form">
                                @csrf()

                                <input type="hidden" name="rating" value="5">
                                <input type="hidden" name="store_id" value="{{ $store->id }}">

                                <div class="mt-2">
                                    <div class="rating-star get-star-rating jq-ry-container mb-1" data-rateyo-rating="5" style="width: 100px;">
                                        <div class="jq-ry-group-wrapper">
                                            <div class="jq-ry-normal-group jq-ry-group">
                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px"
                                                    xml:space="preserve" width="20px" height="20px" fill="gray">
                                                    <polygon
                                                        points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 ">
                                                    </polygon>
                                                </svg>
                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px"
                                                    xml:space="preserve" width="20px" height="20px" fill="gray" style="margin-left: 0px;">
                                                    <polygon
                                                        points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 ">
                                                    </polygon>
                                                </svg>
                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px"
                                                    xml:space="preserve" width="20px" height="20px" fill="gray" style="margin-left: 0px;">
                                                    <polygon
                                                        points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 ">
                                                    </polygon>
                                                </svg>
                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px"
                                                    xml:space="preserve" width="20px" height="20px" fill="gray" style="margin-left: 0px;">
                                                    <polygon
                                                        points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 ">
                                                    </polygon>
                                                </svg>
                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px"
                                                    xml:space="preserve" width="20px" height="20px" fill="gray" style="margin-left: 0px;">
                                                    <polygon
                                                        points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 ">
                                                    </polygon>
                                                </svg>
                                            </div>
                                            <div class="jq-ry-rated-group jq-ry-group" style="width: 100%;">
                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px"
                                                    xml:space="preserve" width="20px" height="20px" fill="#f39c12">
                                                    <polygon
                                                        points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 ">
                                                    </polygon>
                                                </svg>
                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px"
                                                    xml:space="preserve" width="20px" height="20px" fill="#f39c12" style="margin-left: 0px;">
                                                    <polygon
                                                        points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 ">
                                                    </polygon>
                                                </svg>
                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px"
                                                    xml:space="preserve" width="20px" height="20px" fill="#f39c12" style="margin-left: 0px;">
                                                    <polygon
                                                        points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 ">
                                                    </polygon>
                                                </svg>
                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px"
                                                    xml:space="preserve" width="20px" height="20px" fill="#f39c12" style="margin-left: 0px;">
                                                    <polygon
                                                        points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 ">
                                                    </polygon>
                                                </svg>
                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px"
                                                    xml:space="preserve" width="20px" height="20px" fill="#f39c12" style="margin-left: 0px;">
                                                    <polygon
                                                        points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 ">
                                                    </polygon>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($store->activeReviews->count() <= 0)
                                        <h6>No Review Yet.</h6>
                                        <p>Be the first to review <i>{{ $store->name }}</i></p>
                                    @endif
                                </div>
                                <div class="mt-2">
                                    <textarea class="form-control" name="review" id="review" rows="6" placeholder="Write you comments here..."></textarea>
                                </div>
                                <div class="mt-2">
                                    <div class="cta">
                                        <button type="submit" class="btn btn-primary">
                                            Post Review
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Tracker Feedback Modal --->
    <div class="modal md-custom show fade" id="tracker-feedback-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="modal">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between px-4">
                    <div class="modal-title">
                        <h6><i class="bi bi-check-circle-fill secondary-text-color"></i> Your store visit has been recorded</h6>
                        <p>Please allow 24 hours for any transaction to be shown in your account.</p>
                    </div>
                    <div class="store-logo m-4 w-50">
                        <img src="{{ getImageUrl($store->logo->first()) }}" class="img-fluid" alt="805 Restaurants - Hendon" onerror="_logo(this)">
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if (isset($store) && optional(similarStores($store))->count() > 0)
                    <div class="modal-body bg-gray rounded-bottom px-4">
                        <h6>You might also like...</h6>
                        <ul class="category-listing list-view other-offers">
                            @foreach (similarStores($store)->take(10) as $relatedStore)
                                <li class="list-item">
                                    <div class="category-item__logo">
                                        <a href="{{ route('stores.show', $relatedStore->slug) }}">
                                            <img src="{{ getImageUrl($relatedStore->logo->first()) }}" alt="" class="" onerror="_logo(this)">
                                        </a>
                                    </div>
                                    <div class="category-item__detail">
                                        <h6 class="upto-offer">
                                            <span class="brand-name">{{ $relatedStore->name }}</span>
                                            {{ $relatedStore->default_cashback }}
                                        </h6>
                                        <div class="cta"><a href="{{ route('stores.show', $relatedStore->slug) }}" class="btn btn-primary">View Store</a></div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Signin suggestion Modal --->
    <div class="modal fade" id="signin-suggestion-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-5">
                    <h4>
                        Do you want to receive cashback with
                        <br>
                        <span class="color-primary">{{ $store->name }}?</span>
                    </h4>

                    <img style="max-width: 100px;" class="mx-auto mt-4 d-block" alt="logo" src="{{ getImageUrl($store->logo->first()) }}" onerror="_logo(this)">
                </div>
                <div class="modal-footer">
                    <a href="{{ route('login') }}" class="btn btn-primary" id="loginLink"
                        onclick="event.preventDefault(); window.location.href='{{ route('login') }}?prvUrl='+window.location.href;">
                        Yes, of course
                    </a>
                    <a href="javascript:;" id="without-cashback-btn" class="btn btn btn-primary btn-dim without-cashback-btn">
                        No, Continue without cashback
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Favorite Signin Modal --->
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
@endsection

@push('scripts')
    <script>
        $('#review-form').validate({
            rules: {
                review: {
                    required: true,
                },
            },
            messages: {
                review: {
                    required: 'Review field is required',
                },
            },
        });
        $(document).ready(function() {

            var tagline = $(".cashback-description").text();
            var showChar = 250;
            var ellipsestext = "...";
            var moretext = "Show more";
            var lesstext = "Show less";

            if (tagline.length > showChar) {
                var c = tagline.substr(0, showChar);
                var h = tagline.substr(showChar, tagline.length - showChar);
                var html = c + '<span class="moreellipses" style="display: none;">' + ellipsestext +
                    '&nbsp;</span><span class="morecontent"><span style="display: none;">' + h +
                    '</span>&nbsp;&nbsp;<a href="" class="morelink less" style="color: black">' + moretext + '</a></span>';
                $(".cashback-description").html(html);
            }

            $(".morelink").click(function(event) {
                event.preventDefault();
                if ($(this).hasClass("less")) {
                    $(this).removeClass("less");
                    $(this).html(lesstext);
                } else {
                    $(this).addClass("less");
                    $(this).html(moretext);
                }
                $(this).parent().prev().toggle();
                $(this).prev().toggle();
                return false;
            });

            let targetForm = null;

            $('.get-cashback-btn').on('click', function(e) {
                e.preventDefault();

                let _self = $(this);


                if (_self.data('is-auth') == false) {
                    var exit_click_url = "{{ route('click.store', [$store->id, $userRefId]) }}" + '?cashback_type=' + _self.data('cashback-type') + '&cashback_id=' + _self.data('cashback-id');
                    targetCashback = $('.without-cashback-btn');
                    targetCashback.removeAttr('href');
                    targetCashback.attr('href', exit_click_url);
                    targetCashback.attr('target', '_blank');
                    $('#signin-suggestion-modal').modal('show');
                }
            });

            setTimeout(function() {
                $('.rating-star').rateYo({
                    fullStar: true,
                    starWidth: '20px'
                }).on('rateyo.change', function(e, data) {
                    var rating = data.rating;
                    $('[name="rating"]').val(rating);
                });
            }, 1000);

            $('#review-form').on('submit', function(e) {
                if($(this).valid()){
                    e.preventDefault();

                    let _self = $(this);
                    let submitBtn = _self.find('[type=submit]');
                    let submitBtnHtml = submitBtn.html();
                    let errorMessage = $('#error-message');
                    let successMessage = $('#success-message');

                    submitBtn.attr('disabled', 'disabled')
                        .html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>&nbsp;${submitBtnHtml}`);

                    errorMessage.find('.alert').text('').end().slideUp(300);
                    successMessage.find('.alert').text('').end().slideUp(300);

                    $.ajax({
                        url: _self.attr('action'),
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        data: new FormData(this),
                        success: function(response) {
                            _self.trigger('reset');

                            submitBtn.removeAttr('disabled').html(`${submitBtnHtml}`);
                            successMessage.find('.alert').text(response.success).end().slideDown(300);
                        },
                        error: function(response) {
                            submitBtn.removeAttr('disabled').html(`${submitBtnHtml}`);
                            errorMessage.find('.alert').text(response.responseJSON.error).end().slideDown(300);
                        }
                    })
                }
            });
            const loginLink = document.querySelector('#loginLink');
            const baseUrl = new URL(loginLink.href).origin + loginLink.pathname;
            loginLink.addEventListener('mouseover', () => {
                window.status = baseUrl;
            });
            loginLink.addEventListener('mouseout', () => {
                window.status = "";
            });
        });
    </script>
@endpush
