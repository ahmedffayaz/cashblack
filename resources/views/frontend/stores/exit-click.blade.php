@php $settings = SiteSetting(); @endphp

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Redirecting — {{ env('APP_NAME', 'Cashblack') }}</title>

    <link rel="icon" type="image/png"
        href="{{ isset($settings['favicon']) && $settings['favicon'] != 'default.png' ? asset('storage/dashboard/images/logo/' . $settings['favicon']) : asset('cashblack/img/favicon.png') }}">

    <link rel="apple-touch-icon" href="{{ asset('storage/__asset/img/apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;500;600;700;800&display=swap" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.3/themes/hot-sneaks/jquery-ui.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('storage/__asset/vendors/bootstrap@5.1.3/bootstrap.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('storage/__asset/css/styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/__asset/css/custom.css') }}">
    <script>
        let _logo = (e) => e.src = `{{ asset('storage/__asset/img/no-logo.png') }}`;
    </script>
</head>
<style>
    .mr-3 {
        margin-right: 1rem;
    }

    .ml-3 {
        margin-left: 1rem;
    }

    .exitclick-page {
        padding: 50px 0;
        text-align: center;
    }

    .store-logo {
        display: inline-block;
        border: solid 1px #d9d9d9;
        line-height: 100px;
        width: 160px;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .store-logo img {
        max-width: 100px;
        max-height: 60px;
    }

    .cashback {
        font-size: 20px;
        color: #3baa34;
        margin-bottom: 30px;
    }

    .loader-pic {
        margin-bottom: 20px;
    }

    .text {}

    .text h2 {
        font-size: 24px;
        margin-bottom: 5px;
    }

    .text h3 {
        margin-bottom: 20px;
    }

    .text h3,
    .text a {
        font-size: 18px;
    }

    .logo-from {
        position: relative;
    }

    .website_gif {
        margin-top: 24px;
        background-image: url("{{ asset('storage/__asset/img/loading_light_mode.gif') }}");
        background-repeat: no-repeat;
        background-size: cover;
        display: inline-table;
        width: 50px;
        height: 50px;
    }

    @media (min-width: 280px) and (max-width: 359px){
        .website_gif {
            width: 50px;
            height: 50px;
        }
        .store-logo img{
            max-width: 40px;
            max-height: 60px;
        }
        .store-logo {
            width: 50px;
        }
    }

    @media (min-width: 360px) and (max-width: 374px){
        .website_gif {
            width: 100px;
            height: 48px;
        }
    }

    @media (min-width: 375px) and (max-width: 389px){
        .website_gif {
            width: 95px;
            height: 52px;
        }
    }

    @media (min-width: 390px) and (max-width: 411px){
        .website_gif {
            width: 85px;
            height: 54px;
        }
    }

    @media (width: 393px){
        .website_gif {
            width: 85px;
            height: 55px;
        }
    }

    @media (min-width: 412px) and (max-width: 413px){
        .website_gif {
            width: 85px;
            height: 58px;
        }
    }

    @media (min-width: 414px) and (max-width: 539px) {
        .website_gif {
            width: 96px;
            height: 65px;
            background-size: 60px;
        }
    }

    @media (min-width: 540px) and (max-width: 767px){
        .website_gif {
            height: 66px;
            width: 66px;
        }
    }

    @media (min-width: 768px) and (max-width: 819px){
        .website_gif {
            width: 66px;
            height: 66px;
        }
    }

    @media (min-width: 820px) and (max-width: 912px){
        .website_gif {
            width: 64px;
            height: 64px;
        }
    }

    @media(max-width: 767.98px) {
        .exitclick-page {
            padding: 50px;
        }

        .cashback {
            margin-bottom: 20px;
        }

        .text h2 {
            font-size: 20px;
        }

        .text h3,
        .text a {
            font-size: 16px;
        }
    }
</style>

<body>
    <div class="header-box text-center py-3" style="border-bottom:2px solid #3baa34;">
        <div class="container">
            <header class="justify-content-center">
                <div class="logo">
                    <a target="_blank" href="{{ url('/') }}">
                        <img src="{{ getSiteLogo() }}" alt="" width="175">
                    </a>
                </div>
            </header>
        </div>
    </div>
    <div class="exitclick-page">
        <div class="d-flex justify-content-center">
            <div class="store-logo logo-from mr-3">
                <a target="_blank" href="{{ url('/') }}">
                    <img src="{{ getSiteFavIcon() }}" alt="" onerror="_logo(this)">
                </a>
            </div>
            <div class="website_gif"></div>
            <div class="store-logo ml-3">
                <a target="_blank" href="{{ route('stores.show', $store->slug) }}">
                    <img src="{{ getImageUrl($store->logo->first()) }}" alt="{{ $store->name }}" onerror="_logo(this)">
                </a>
            </div>
        </div>
        <div class="cashback">
            {{ $store->default_cashback }} </div>
        <div class="text">
            <h2>You’re now being transferred to {{ $store->name }}.</h2>
            <h2>Complete your purchase and we’ll do the rest.</h2>
            <h3>The browsing ID for this cashback is: #{{ $clickId }}</h3>
            <a target="_blank" href="{{ url('pages/faqs') }}">Need Help?</a>
        </div>

    </div>
    <div class="container">
        @if (!empty(strip_tags($store->terms_conditions)))
            <div class="panel list-bullets rounded-border mb-3">
                <h3 class="heading mb-2">Terms & Conditions</h3>
                <p>{!! $store->terms_conditions !!}</p>
            </div>
        @endif
    </div>
    <script>
        setTimeout(function() {
            window.location = "{!! $url !!}";
        }, 3000);
    </script>
</body>

</html>
