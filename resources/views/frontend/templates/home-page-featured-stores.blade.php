
@php $stores = getFeaturesStores('featured_homepage') @endphp
@if(count($stores))
<section id="takeaway-brands" class="{{ !isset($category_slug) ? 'landing-section-bg  landing-bg-1  animate__animated animate__fadeInUp': '' }} section text-center wow">
    <div class="background-image-overlay"></div>
    <div class="container position-relative">
        <div class="section-title-wrap">
            <h2 class="section-title">
                Discover Local Black-Owned Restaurants and Grocery Stores and Earn Cashback on Your Orders with Cashblack To Your Door
            </h2>
        </div>
        <div class="row">
            @foreach($stores as $store)
                @php $store_logo = $store->logo()->pluck('image')->first(); @endphp
                @if(isset($store_logo) && File::exists(public_path( $store_logo)))
                    <div class="col-6 col-md-3">
                        <a href=" {{$store->store_url  }}" target="_blank">
                            <div class="takeaway-brands__item">
                                <img src="{{ asset($store_logo) }}" alt="Deliveroo" onerror="_logo(this)">
                            </div>
                        </a>
                       
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif
