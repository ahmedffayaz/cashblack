@extends('frontend.layouts.app')

@section('title', 'Search')

@push('styles')
    <style>
        .pagination {
            justify-content: center !important;
        }
    </style>
@endpush

@section('content')
    <section>
        <div class="container pb-5">
            @include('frontend.components.breadcrumbs', [
                'crumbs' => [],
                'current' => 'Search',
            ])

            {!! resolvePageShortCodes($page->lb_content, $__data) !!}

            @if (isset($stores))
                <div class="row">
                    <div class="content-area">
                        <ul class="category-listing store-listing list-view">
                            @foreach ($stores as $store)
                                <li class="list-item">
                                    <a href="javascript:;" class="fav-icon like-action not-liked" this-store-id="{{ $store->id }}">
                                        <i class="fas fa-heart"></i>
                                    </a>
                                    <div class="category-item__logo">
                                        <a href="{{ route('stores.show', $store->slug) }}">
                                            <img alt="{{ $store->name }}" src="{{ getImageUrl($store->logo->first()) }}" onerror="_logo(this)">
                                        </a>
                                    </div>
                                    <div class="category-item__detail">
                                        <h5 class="brand-name">{{ $store->name }}</h5>
                                        <h6 class="upto-offer">{{ $store->default_cashback }}</h6>
                                        <div class="cta">
                                            <a href="{{ route('stores.show', $store->slug) }}" class="btn btn-primary">View Retailer</a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="page-bottom-actions position-relative mt-5">
                            {!! $stores->appends(request()->input())->links() !!}
                        </div>
                    </div>
                </div>
            @endif
            @if (!isset($stores) || $stores->count() <= 0)
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <h5 class="text-center">No Stores found.</h5>
                        <p class="text-center">Once you start searching stores they will be listed here.</p>
                    </td>
                </tr>
            @endif
        </div>
    </section>
@endsection
