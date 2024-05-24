<div class="modal fade" id="select-web-platform-modal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-md" role="modal">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <div class="row">
                    <div class="col-md-12">
                        <img src="
                            @if (isset($settings['website_logo']) && $settings['website_logo'] != 'cashblack-default.png') {{ asset('storage/dashboard/images/logo/' . $settings['website_logo']) }}
                            @else
                                {{ asset('storage/__asset/img/logo.png') }} @endif
                        "
                        alt="Cashblack" class="img-fluid">
                        <p class="text-center mt-3">Please choose your location</p>
                    </div>
                </div>
                <div class="d-flex justify-content-around">
                    <div>
                        <a href="{{ "https://cashblack.com/" }}" id="uk-link"><img src="{{ asset('storage/__asset/img/uk-flag.png') }}" alt="" style="width: 70px; height:50px; text-decoration:none" class="mt-5"></a>
                        <a href="{{ "https://cashblack.com/" }}" id="uk-link" style="text-decoration: none"><p class="fw-bold mt-3 text-danger">United Kingdom</p></a>
                    </div>
                    <div>
                        <a href="#" id="us-link"><img src="{{ asset('storage/__asset/img/us-flag.png') }}" alt="" style="width: 70px; height:50px; text-decoration:none" class="mt-5"></a>
                        <a href="#" id="us-link"><p class="fw-bold mt-3 text-danger">United States</p></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
