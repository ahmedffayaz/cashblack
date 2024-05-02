<div class="modal-header">
    <h5 class="modal-title">Charity: {{ $charity->title }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="w-50 mx-auto">
        <div class="b-r12">
            <div class="charity_large_banner">
                <img src="{{ getImageUrl(isset($charity->banner_upload) ? $charity->banner_upload : $charity->banner_link) }}" alt="{{ $charity->title }}" class="img-fluid" onerror="_banner(this)" width="100%">
            </div>
            <div class="small_banner">
                <img src="{{ getImageUrl(isset($charity->logo_upload) ? $charity->logo_upload : $charity->logo_upload) }}" alt="{{ $charity->title }}" class="img-fluid" onerror="_logo(this)">
                <p class="mt-3">{{ $charity->title }}</p>
            </div>
        </div>
    </div>
    <p>Charity Type: <span class="text-success">{!! optional($charity->charity_type)->title ?? '<i>Unknown</i>' !!}</span></p>
    <p>Country: {!! optional($charity->Country)->name ?? '<i>Unknown</i>' !!}</p>

    <p class="mt-3">{!! $charity->description !!}</p>
</div>
<div class="modal-footer">
    <button type="button" data-bs-dismiss="modal" class="btn btn-primary text-uppercase">Close</button>
</div>
