@extends('frontend.layouts.app')

@section('title', 'Favorite Stores')

@push('styles')
    <style>
        input[type=file]::file-selector-button {
            margin: -4px -10px !important;
        }
        .size{
            display: block !important;
            text-align: center;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="page-header">
            <div class="icon-wrap">
                <img src="{{ asset('storage/__asset/img/dashboard-icons/dashboard.png') }}" alt="dashboard-icon">
            </div>
            <div class="title-wrap">
                <h1 class="page-title">My Account</h1>
            </div>
        </div>

        <div class="dashboard__content-area">
            <div class="row">

                @include('frontend.client-dashboard.side-menu', ($title == 'favorite_stores' ? ['page' => 'favorite_stores'] : ['page' => 'favorite_cashblack_to_door']) )
                <div class="col main-content">
                    @if ($title == 'favorite_stores')
                        <div class="section-title-wrap">
                            <h4 class="section-title">Favorite Stores</h4>
                            <p class="section-para">On this page, you will find all the online retailers you have favourited.</p>
                        </div>
                    @else
                        <div class="section-title-wrap">
                            <h4 class="section-title">Favorite Cashback to Your Door</h4>
                            <p class="section-para">On this page, you will find all the online restaurant, delivro, takeaways and grocery stores.</p>
                        </div>
                    @endif
                    <ul class="category-listing fav-stores store-listing list-view">
                        @foreach ($favoriteStores as $store)
                            <li class="list-item li-items">
                                <div class="category-item__logo"><img src="{{ getImageUrl($store->logo->first()) }}"alt="" class="" onerror="_logo(this)"></div>
                                <div class="category-item__detail">
                                    <div class="brand-name">{{ $store->name }} <span class="upto-offer">{{ $store->default_cashback }}</span>
                                    </div>

                                    <div class="cta d-flex align-items-center">
                                        <a href="{{ route('stores.show', $store->slug) }}" class="btn btn-primary">Visit Store</a>
                                        <a href="javascript:;" class="remove-icon ms-4 like-action-remove" this-title="{{ $store->name }}" this-store-id="{{ $store->id }}"><i
                                                class="bi bi-trash"></i></a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        @if ($favoriteStores->count() <= 0)
                        <li class="list-item li-items size">
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <h5>No Favourite Store found.</h5>
                                    <p>Once you start adding favourite stores, they will be listed here.</p>
                                </td>
                            </tr>
                        </li>
                    @endif
                    </ul>
                    <div class="page-bottom-actions position-relative mt-5">
                        {!! $favoriteStores->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
