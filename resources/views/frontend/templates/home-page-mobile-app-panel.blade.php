<style>
    /* Media query for smaller screens (mobile devices) */
    @media (max-width: 767px) {
        .image-container .img-mobile {
            width: 35%;
            height: auto;
        }

        .image-container .img-circle {
            width: 55%;
            height: auto;
        }
        .containers{
            text-align: center;
        }
    }

    .img-circle {
        max-width: 320px;
    }

    .img-mobile {
        max-width: 240px;
    }

    .specific-color {
        color: #45a049;
    }

    .google-play {
        max-width: 131px;
        max-height: auto;
    }

    .playstore-icon {
        max-width: 150px;
    }

    .paragraph {
        font-size: large;
        height: auto;
        line-height: 28px;
        text-overflow: ellipsis;
        font-weight: 100;
        color: #605f5f;
    }
    b{
        font-size: 2rem;
    }
    .containers{
            margin-top: 100px;
        }
</style>

<section class="section bg-gray">
    <div class="container containers">
        <div class="row">
            <div class="position-relative col-md-6 text-center order-md-1 image-container containers">
                <img src="{{ asset('storage/__asset/img/home/Ellipse 9.png') }}" alt="" class="img-circle">
                <img src="{{ asset('storage/__asset/img/home/gif-mobile.jpeg') }}" alt="" class="position-absolute top-50 start-50 translate-middle img-mobile">
            </div>
            <div class="col-md-6 col-sm-12 right-content mt-md-5 pt-md-5">
                <h3 class="mb-3 heading"><b>Cashblack <b class="specific-color">Mobile</b> Businesses App</b> </h3>
                <p class="paragraph" style="">With the Cashblack
                    mobile app, you can use your
                    Android or iOS device to browse, shop and earn cashback
                    just as you would on your computer. Download to receive
                    exclusive offers and promotions.</p>

               <a href="{{ url('/pages/apps') }}"> <button class="btn btn-secondary my-4 px-5 text-white">More Info</button></a>
                <div class="mt-3">
                    <img src="{{ asset('storage/__asset/img/home/google-play-badge-logo 1.png') }}" class="google-play" alt="">
                    <img src="{{ asset('storage/__asset/img/home/download-on-the-app-store4659 1.png') }}" class="playstore-icon ms-2" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
