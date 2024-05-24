<style>
    /* Media query for smaller screens (mobile devices) */
    @media (max-width: 767px) {
        .image-container .img-mobile {
            width: 35%;
            /* Make images take full width of the container */
            height: auto;
        }

        .image-container .img-circle {
            width: 55%;
            /* Make images take full width of the container */
            height: auto;
        }

        .right-content {
            margin-top: 100px;
            padding: 0 20px;
        }
    }
</style>

<div class="container" style="margin-bottom: 170px; width:100%; jsutify-content:center">
    <div class="row" style="margin-top: 150px;">
        <div class="position-relative col-md-6 text-center order-md-1 col-12 image-container container">
            <img src="{{ asset('storage/__asset/img/home/Ellipse 9.png') }}" alt="" style="max-width: 320px;" class="img-circle">
            <img src="{{ asset('storage/__asset/img/home/cashblack 1.png') }}" alt="" style="max-width: 240px;"
                class="position-absolute top-50 start-50 translate-middle img-mobile">
        </div>
        <div class="col-md-6 right-content">
            <div class="d-block ">
                <h3 class="mb-3 contents "><b>Cashblack <b class="specific-color" style="color: #45a049">Mobile</b> Businesses</b> App</h3>
                <p class="" style="font-size:large; height: auto; line-height: 28px; text-overflow: ellipsis; font-weight: 100; color: #605f5f;">With the Cashblack
                    mobile app, you can use your
                    Android or iOS device to browse, shop and earn cashback
                    just as you would on your computer. Download to receive
                    exclusive offers and promotions.</p>

                <button class="btn my-4 px-5 text-white" style="background-color: #45a049;">More Info</button>
                <div class="mt-3">
                    <img src="{{ asset('storage/__asset/img/home/google-play-badge-logo 1.png') }}" alt="" style="max-width: 131px; max-height auto;">
                    <img src="{{ asset('storage/__asset/img/home/download-on-the-app-store4659 1.png') }}" alt="" style="max-width: 150px;" class="ms-2">
                </div>
            </div>
        </div>
    </div>
</div>
