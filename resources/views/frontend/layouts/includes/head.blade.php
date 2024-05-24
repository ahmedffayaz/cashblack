@php
    $currentUrl = url()->full();

    $SeoRule = checkSeoPageRule($currentUrl);
    if (checkSeoPageRule($currentUrl) != null) {
        $title = isset($SeoRule['name']) ? $SeoRule['name'] : $SeoRule['title'];
        $seoTitle = $SeoRule['meta_title'];
        $keyword = $SeoRule['meta_keyword'];
        $description = $SeoRule['meta_description'];

        if (!empty(auth()->user()) && is_null(auth()->user()->short_ref_id)) uniqueRefLinkGenerator();
    }

    $socialSEORules = getSocialSeo($SeoRule, $currentUrl);
@endphp

<head>
    @if ($SeoRule != null)
        @if (!empty($seoTitle))
            <title>{{ $seoTitle }} — {{ $settings['website_title'] }}</title>
        @endif
        @if (!empty($description))
            <meta name="description" content="{{ $description }}" />
        @endif
        @if (!empty($keyword))
            <meta name="keywords" content="{{ $keyword }}" />
        @endif
        @if (!empty($title) && empty($seoTitle))
            <title>{{ $title }} — {{ $settings['website_title'] }}</title>
        @endif
    @else
        <title>@yield('title') — {{ $settings['website_title'] }}</title>
    @endif
    {{-- Social SEOs logic --}}

	<link rel="canonical" href="{{ $socialSEORules['url'] }}"/>
	<meta property="og:locale" content="en_US"/>
	<meta property="og:type" content="{{ $socialSEORules['type'] }}"/>
	<meta property="og:title" content="{{ $socialSEORules['title'] . ' — ' . SiteSetting()['website_title'] }}"/>
	<meta property="og:url" content="{{ $socialSEORules['url'] }}"/>
	<meta property="og:site_name" content="{{ SiteSetting()['website_title'] }}"/>
	<meta name="twitter:card" content="summary_large_image"/>
    <meta name="is_authenticated" content="{{ Auth::check() ? 'true' : 'false' }}">
    @if(getSlug($currentUrl) != "/")
        <meta property="og:description" content="{{ $socialSEORules['description'] }}"/>
        <meta property="article:published_time" content="{{ $socialSEORules['published_time'] }}"/>
        <meta property="article:modified_time" content="{{ $socialSEORules['modified_time'] }}"/>
        <meta property="og:image" content="{{ $socialSEORules['image'] }}"/>
        <meta property="og:image:width" content="{{ $socialSEORules['width'] }}"/>
        <meta property="og:image:height" content="{{ $socialSEORules['height'] }}"/>
        <meta property="og:image:type" content="{{ $socialSEORules['image_type'] }}"/>
        <meta name="author" content="{{ SiteSetting()['website_title'] }}"/>
        <meta name="twitter:label1" content="Written by"/>
        <meta name="twitter:data1" content="{{ SiteSetting()['website_title'] }}"/>
        <meta name="twitter:label2" content="Est. reading time"/>
        <meta name="twitter:data2" content="3 minutes"/>
    @endif

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" type="image/png" href="{{ getSiteFavicon() }}">

    <link rel="apple-touch-icon" href="{{ asset('storage/__asset/img/apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;500;600;700;800&display=swap" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.3/themes/hot-sneaks/jquery-ui.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('storage/__asset/vendors/bootstrap@5.1.3/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/__asset/vendors/owl-carousel@2.3.4/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/__asset/vendors/jquery.magnific-popup@1.1.0/jquery.magnific-popup.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/__asset/vendors/jquery.rateyo@2.3.2/jquery.rateyo.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/__asset/vendors/jquery.fancybox@3.5.7/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/__asset/vendors/jquery.timepicker/jquery.timepicker.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('storage/__asset/css/styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('storage/__asset/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-dashboard/telephone-dropdown/css/intlTelInput.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        ul.search-suggestions>a>li:hover {
            background-color: #3baa34 !important;
            color: white;
        }
    </style>

    <script>
        let _logo = (e) => e.src = `{{ asset('storage/__asset/img/no-logo.png') }}`;
        let _square = (e) => e.src = `{{ asset('storage/__asset/img/no-logo-254x254.png') }}`;
        let _banner = (e) => e.src = `{{ asset('storage/__asset/img/no-banner.png') }}`;
        let firebaseMsgJsFilePath = "{{ asset('storage/__asset/js/firebase-messaging-sw.js') }}";
        let defaultAvatar = (e) => e.src = `{{ asset('storage/__asset/img/default-avatar.png') }}`
    </script>

    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register(firebaseMsgJsFilePath)
                .then(function(registration) {
                    console.log('Service Worker registered with scope:', registration.scope);
                }).catch(function(error) {
                    console.error('Service Worker registration failed:', error);
                });
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {!! isset($settings['analytics_code']) ? $settings['analytics_code'] : '' !!}
    <script src="https://www.gstatic.com/firebasejs/9.10.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.10.0/firebase-messaging-compat.js"></script>
    <script>
        const firebaseConfig = {
            apiKey: "AIzaSyBxf7TAT2ICR8z_qg95_axtTawkrJVCZfk",
            authDomain: "cashblack-ed76c.firebaseapp.com",
            projectId: "cashblack-ed76c",
            storageBucket: "cashblack-ed76c.appspot.com",
            messagingSenderId: "717732012935",
            appId: "1:717732012935:web:cc92e27b44ce1f8071e922",
            measurementId: "G-GJMHSFRJYM"
        };
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();
        navigator.serviceWorker.register(firebaseMsgJsFilePath)
            .then((registration) => {
                return messaging.getToken({
                    vapidKey: 'BJXFogKusnyY0eGmsGla3EhY6xF5FkeLNAqH93kyLR7MBjeBa-hLrQTOSet0OBTUvTXzw7rdKav7S52eDQYIkaE',
                    serviceWorkerRegistration: registration
                });
            })
            .then((currentToken) => {
                if (currentToken) {
                    $.ajax({
                        url: `{{ route('fcmregistration') }}`,
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            token: currentToken,
                        },
                        success: function(response) {}
                    });
                } else {
                    console.log('No registration token available. Request permission to generate one.');
                }
            })
            .catch((err) => {
                console.log('An error occurred while retrieving token. ', err);
            });
        messaging.onMessage((payload) => {
            if (payload.data.to == '' || payload.data.to == "{{ auth()->check() ? auth()->user()->id : null }}") {
                appendNotification(payload.fcmOptions.link, payload.data.title, payload.data.body, '1 second ago.');
            }
        });
    </script>

    <script type="text/javascript" src="{{ asset('storage/__asset/js/firebase-messaging-sw.js') }}"></script>
    @stack('styles')
</head>
