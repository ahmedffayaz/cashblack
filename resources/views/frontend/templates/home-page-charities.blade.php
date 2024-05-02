@php $featureCharities = getFeaturesCharities('featured_charities') @endphp
@if (count($featureCharities))
    <section class="section bg-gray donation">
        <div class="container animate__animated animate__fadeInUp wow">
            <div class="section-title-wrap text-center">
                <h2 class="section-title">
                    Or Donate to One of Our Affiliated Goodwill Causes where We'll Match Your Donation 100% with Cashblack Giveback
                </h2>
            </div>
            <div class="affiliate-donation owl-carousel">
                @foreach ($featureCharities as $charity)
                    @if (isset($charity->logo_link) || File::exists(public_path($charity->logo_upload)))
                        <div>
                            <a href="{{ route('charities.index') }}#{{ $charity->slug }}" style="width: 359.598px; margin-right: 20px">
                                <img src="{{ getImageUrl(isset($charity->logo_upload) ? $charity->logo_upload : $charity->logo_link) }}" alt="{{ $charity->title }}"
                                    onerror="_logo(this)" class="" />
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endif
