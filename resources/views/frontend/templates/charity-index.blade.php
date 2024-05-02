<div class="row">
    @if ($charities->count())
        @foreach ($charities as $charity)
            <div class="col-lg-3 col-6 charity-div">
                <div class="b-r12">
                    <a href="javascript:;" class="charity-card" data-slug="{{ $charity->slug }}">
                        <div class="charity_large_banner">
                            <img src="{{ getImageUrl(isset($charity->banner_upload) ? $charity->banner_upload : $charity->banner_link) }}" alt="{{ $charity->title }}"
                                class="set-size" onerror="_banner(this)">
                        </div>
                        <div class="small_banner">
                            <img src="{{ getImageUrl(isset($charity->logo_upload) ? $charity->logo_upload : $charity->logo_link) }}" alt="{{ $charity->title }}"
                                class="img-fluid set-image" onerror="_logo(this)">
                            <p class="mt-3">{{ $charity->title }}</p>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    @else
        <p>No Charity Found</p>
    @endif
</div>
<div class="row">
    <div class="pagination col-md-12 mt-4 mb-3">
        {!! $charities->links() !!}
    </div>
</div>
