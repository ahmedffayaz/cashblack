<style>
    /* Media query for smaller screens (mobile devices) */
    @media (max-width: 767px) {
        .image-container .img-afrobot {
            width: 65%;
            height: auto;
            padding-bottom: 0%;

        }
        .right-contents{
            margin-top:30%;
        }
        .containers{
            text-align: center;
            margin-top: 10%;
            margin-bottom: 0px;
            padding: 0;
        }
    }
    .containers {
        margin-bottom: 100px;
    }

    .rows {
        margin-top: 170px;
    }

    .specific-color {
        color: #45a049;
    }

    .paragraph {
        font-size: large;
        height: auto;
        line-height: 28px;
        text-overflow: ellipsis;
        font-weight: 100;
        color: #605f5f;
    }
    .img-afrobot{
        max-width: 390px;
    }

</style>

<section class="section bg-white">
    <div class="container containers">
        <div class="row rows">
            <div class="position-relative col-md-6 text-center image-container px-md-5 my-sm-5">
                <img src="{{ asset('storage/__asset/img/home/afrobot-logo.png') }}" alt="" class="position-absolute top-50 start-50 translate-middle img-afrobot">
            </div>
            <div class="col-md-6 right-contents mt-md-5 px-md-5">
                <h3 class="mb-3"><b>Cashblack <b class="specific-color">A.F.R.O.B.O.T</b></h3>
                <p class="paragraph" style="">The Cashblack A.F.R.O.B.O.T is our Algorithm For Redirection
                    Of Black-Owned Traffic. Our Chrome, Firefox and Safari
                    web browser extension uses a bespoke algorithm and
                    cutting edge artificial intelligence to learn how you usually
                    shop and help you find and purchase those same goods
                    and services at Black-owned retailers..</p>
                    <a href="{{ url('/pages/extensions') }}"><button class="btn btn-secondary my-4 px-5 text-white">More Info</button></a>
            </div>
        </div>
    </div>
</section>
