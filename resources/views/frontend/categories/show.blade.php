@extends('frontend.layouts.app')

@section('title', $category->name)

@push('styles')
    <link rel="stylesheet" href="{{ asset('storage/__asset/vendors/select2/dist/css/select2.min.css') }}">
    <style>
        .pagination {
            justify-content: center !important;
        }
    </style>
@endpush
<style>

</style>

@section('content')
    <div class="container pb-5">
        @php
            $crumbs = [
                [
                    'url' => route('categories.index'),
                    'title' => 'All Categories',
                ],
            ];

            if ($category->parent) {
                $crumbs[] = [
                    'url' => route('categories.show', ['slug' => $category->parent->slug]),
                    'title' => $category->parent->name,
                ];
            }
        @endphp

        @include('frontend.components.breadcrumbs', [
            'crumbs' => $crumbs,
            'current' => $category->name,
        ])

        <div class="category-banner mb-4">
            <img class="img-fluid" alt="{{ $category->name }}" onerror="_banner(this)"
                @if ($category->banner_type != 'link') src="{{ getBannerImageUrl($category->banner_upload, 'upload', $category) }}"
                @elseif (!empty($category->banner_link))
                    src="{{ $category->banner_link }}" @endif>
            <h2 class="category-name">{{ $category->name }}</h2>
        </div>

        @if (!empty($category->description))
            <div class="category-text panel rounded-border mb-4">
                <p>{!! $category->description !!}
                    @if ($category->slug === 'cashblack-to-your-door')
                        <br><b>You can go to <a href="{{ asset('categories/grocery-stores') }}">Grocery Stores</a> or <a
                                href="{{ asset('categories/restaurants') }}">Restaurants</a>.</b>
                    @endif
                </p>
            </div>
        @endif

        @if ($category->slug === 'cashblack-to-your-door' || checkCashbackChildCategories($category->slug, '143'))
            <div class="row">
                <div class="content-area">
                    <div class="title-filter">
                        <div class="title-area">
                            <h4 class="category-title">Search For {{ $category->name }}</h4>
                        </div>
                        <div class="filter-sort takeaways">
                            <div class="listing-actions">

                                <form class="search_form" action="{{ route('categories.show', $slug) }}" method="GET">
                                    @csrf
                                    <input type="hidden" name="perPage" id="perPage" value="12">
                                    <input type="hidden" name="cuisine" id="cuisine" value="{{ $cuisine }}">
                                    <input type="hidden" name="viewType" id="viewType" value="grid-view">
                                    <input type="hidden" name="orderBy" id="" value="">
                                </form>
                                @php
                                    $childCuisines = getCuisineChilds();
                                @endphp

                                <form class="filter-form" action="{{ url('categories/cashblack-to-your-door') }}" method="GET">
                                    <div class="sort-option">
                                        <select class="form-control filter-by btn sort-btn cuisine-select" name="cuisine[]" id="cuisine-select" multiple>
                                            <option value="all">All</option>
                                            @foreach ($childCuisines as $cuisine)
                                                <option value="{{ $cuisine }}" {{ request('cuisine') === $cuisine ? 'selected' : '' }}>{{ $cuisine }}
                                            @endforeach
                                        </select>
                                    </div>
                                </form>

                                <div class="result-preview-option ms-2 d-none d-sm-block">
                                    <a href="javascript:;" id="gridview" class="grid-view view-btn active"></a>
                                    <a href="javascript:;" id="listview" class="list-view view-btn"></a>
                                </div>

                            </div>
                        </div>
                    </div>
                    @include('frontend.templates.category-map-enable')

                    <div id="stores-view"></div>

                </div>
            </div>
        @else
            @include('frontend.templates.category-map-enable')
            <div class="row">
                <div class="col-md-3 mb-md-0">
                    <div class="panel rounded-border mb-4 sidebar-cat-menu">
                        <h5 class="sidebar-title">
                            <a href="{{ route('categories.show', $category->slug) }}">{{ $category->name }}</a>
                        </h5>
                        @if (count($category->childs))
                            <ul class="sub-cat-links">
                                @foreach ($category->childs as $childCategory)
                                    @if ($childCategory->status === 1)
                                        <li><a href="{{ route('categories.show', $childCategory->slug) }}">{{ $childCategory->name }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    @if ($category->picks->isNotEmpty())
                        @foreach ($category->picks->take(5) as $picks)
                            @if (isset($picks->store))
                                <div class="panel rounded-border text-center d-none d-sm-block mb-3">
                                    <a href="{{ route('stores.show', $picks->store->slug) }}"><img src="{{ getImageUrl($picks->store->logo->first()) }}"
                                            alt="{{ $picks->store->name }}" class="img-fluid" alt="Sidebar Banner" onerror="_square(this)"></a>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>

                <div class="content-area col-md-9">
                    <div class="rounded-border mb-5">
                        <div class="category-list-header">
                            <div class="title-area">
                                <h4 class="category-title">
                                    {{ $category->name }}
                                    <span>Cashback Offers</span>
                                </h4>
                            </div>
                            <div class="listing-actions">
                                <form action="{{ route('categories.view', $slug) }}" class="is-alter  search_form filter_by {{ isset($letter) ? 'd-none' : '' }}" method="GET">
                                    @csrf
                                    <div class="sort-option dropdown">
                                        <select class="form-control filter-by btn sort-btn select_search" name="orderBy" id="">
                                            <option value="">Default</option>
                                            <option value="name-asc" id="name-asc">Name (A-Z)</option>
                                            <option value="name-desc" id="name-desc">Name (Z-A)</option>
                                            <option value="id-desc" id="new-desc">Newest to Oldest</option>
                                            <option value="popularity" id="popularity">Popularity</option>
                                            <option value="cashback-amount-desc" id="cashback-amount-desc">Cashback Amount</option>
                                            <option value="cashback-percentage-desc" id="cashback-percentage-desc">Cashback Percentage</option>
                                        </select>
                                    </div>
                                </form>
                                <div class="result-preview-option">
                                    <a href="javascript:;" id="gridview" class="grid-view view-btn active"></a>
                                    <a href="javascript:;" id="listview" class="list-view view-btn"></a>
                                </div>
                                <form class="search_form" action="{{ route('categories.show', $slug) }}" method="GET">
                                    @csrf
                                    <input type="hidden" name="perPage" id="perPage" value="12">
                                    <input type="hidden" name="viewType" id="viewType" value="grid-view">
                                    <input type="hidden" name="cuisine" id="cuisine" value="">
                                    <input type="hidden" name="orderBy" id="" value="">
                                </form>
                            </div>
                        </div>
                        <div id="stores-view"></div>
                    </div>

                    <div class="position-relative d-flex justify-content-between flex-wrap flex-sm-nowrap pagination-wrap">
                        <nav aria-label="Page navigation example"></nav>
                        <div class="per-page-select">
                            <label>Stores per page</label>
                            <select id="stores_per_page">
                                <option value="12" selected="">12</option>
                                <option value="24">24</option>
                                <option value="48">48</option>
                            </select>
                        </div>
                    </div>

                    <div class="panel rounded-border text-center mt-5 d-sm-none">
                        <img src="{{ asset('storage/__asset/img/sidebar-banner.jpg') }}" class="img-fluid" alt="Sidebar Banner" onerror="_square(this)">
                    </div>
                </div>
            </div>
        @endif

    </div>
    @if ($category->slug === 'cashblack-to-your-door' || checkCashbackChildCategories($category->slug, '143'))
        @include('frontend.templates.home-page-featured-stores', ['category_slug' => $category->slug])
    @endif
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('storage/__asset/vendors/select2/dist/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.cuisine-select').select2();
            $("select.store").change(function() {
                var selectedStore = $(this).children("option:selected").val();
                if (selectedStore != "default_option") {
                    $(".all_stores").css("display", "none");
                    $(selectedStore + "_store").css("display", "block");
                } else {
                    $(".all_stores").css("display", "block");
                }
            });
        });

        var map;
        var directionsService;
        var directionsRenderer;
        var stores = [];
        var mapStores = [];
        var favicon = "{{ getSiteFavicon() }}";
        var storesPerPage = 12;
        var offset = 0;
        var filteredLoadedStores = 0;

        // Stores Data Show
        function storesView(page, withMapScript = false) {
            var searchFormData = $('.search_form').serialize();
            var orderByValue = $('.filter_by select[name="orderBy"]').val();
            if (orderByValue) {
                searchFormData += encodeURIComponent(orderByValue);
            }
            var requestUrl = '{{ route('categories.view', $slug) }}';
            if (page != 0) {
                requestUrl += '?page=' + page;
            }
            $('#stores-view').html(
                `<div class="text-center">
                    <img src="{{ asset('storage/__asset/img/loading_light_mode.gif') }}" alt="Loading..." style="margin: 100px; width: 60px; height: 60px;">
                </div>`
            );

            $.ajax({
                type: 'get',
                url: requestUrl,
                data: searchFormData,
                dataType: 'json',
                success: function(data) {
                    $('#stores-view').html(data.view);

                    stores = data.stores.data;
                    mapStores = Object.keys(stores).map((key) => [key, stores[key]]);

                    if (stores.length === 0) {
                        $('#load-more-btn').addClass("d-none");
                    }
                    if (withMapScript)
                        loadMapScript();
                    else
                        initMap();
                },
                error: function(error) {
                    console.error(error);
                }
            });

        }


        function loadMapScript(callback) {
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = "https://maps.google.com/maps/api/js?key={{ SiteSetting()['map_key'] }}&callback=initMap&libraries=places&v=weekly";
            script.onload = callback;
            document.body.appendChild(script);
        }

        // Get location
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, errorCashback);
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        }

        // Success callback function
        function showPosition(position) {
            myLat = position.coords.latitude;
            myLng = position.coords.longitude;

            if (getCookie('position_latitude') && getCookie('position_longitude')) {} else {
                setCookie("position_latitude", myLat);
                setCookie("position_longitude", myLng);
                window.location.reload();
            }
        }

        // Error callback function
        function errorCashback(error) {
            if (error.code == error.PERMISSION_DENIED) {
                myLat = 51.509865;
                myLng = -0.118092;

                if (getCookie('position_latitude') && getCookie('position_longitude')) {} else {
                    setCookie("position_latitude", myLat);
                    setCookie("position_longitude", myLng);
                    window.location.reload();
                }
            }
        }

        // Set cookies
        function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        // Get cookies
        function getCookie(cname) {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        // Google map initialize
        function initMap() {
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();
            mapDiv = document.getElementById("map");
            // Check map ID
            if (!mapDiv) {
                return;
            }
            getLocation();
            setTimeout(function() {
                center = new google.maps.LatLng(myLat, myLng);
                infowindow = new google.maps.InfoWindow();

                map = new google.maps.Map(mapDiv, {
                    zoom: 7,
                    center: center,
                    mapTypeControl: false,
                });

                // Search store on google map
                addressLocationSearch();

                var markerTime = 2000;
                setTimeout(function() {
                    directionRenderFn();
                }, markerTime);
            }, 1000);

            document.getElementById("mode").addEventListener("change", () => {
                calculateAndDisplayRoute();
            });
        }

        window.initMap = initMap;

        function getCurrentLocation() {
            infoWindow = new google.maps.InfoWindow({
                content: "<img src=<?= url('') ?>/frontend/images/human1.png>"
            });

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };

                        myLat = position.coords.latitude;
                        myLng = position.coords.longitude;
                        center = new google.maps.LatLng(myLat, myLng);

                        infoWindow.setPosition(pos);

                        infoWindow.open(map);

                        map.setCenter(pos);
                    },
                    () => {
                        handleLocationError(true, infoWindow, map.getCenter());
                    }
                );
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }
        }

        function calculateAndDisplayRoute(dLat = null, dLng = null) {
            if (dLat != null && dLng != null) {
                $("#destinationLat").val(dLat);
                $("#destinationLng").val(dLng);
            }

            if ((dLat == null && $("#destinationLat").val() == "") && (dLng == null && $("#destinationLng").val() == "")) {
                window.alert('Please Select Destination First ');
                return false;
            }

            var pointA = center;
            var pointB = new google.maps.LatLng(dLat, dLng);

            service = new google.maps.DistanceMatrixService();
            const selectedMode = document.getElementById("mode").value;

            var pointBB = new google.maps.LatLng($("#destinationLat").val(), $("#destinationLng").val());

            var start = pointA;
            var end = pointBB;

            var request = {
                origin: start,
                destination: end,
                travelMode: google.maps.TravelMode[selectedMode]
            };

            var travelModeIcon = "fa fa-car";
            if (selectedMode == "WALKING") {
                var travelModeIcon = "fa fa-male";
            }

            directionsService.route(request, function(result, status) {
                if (status == 'OK') {
                    directionsRenderer.setDirections(result);
                    var request = {
                        origins: [start],
                        destinations: [end],
                        travelMode: google.maps.TravelMode[selectedMode],
                        unitSystem: google.maps.UnitSystem.METRIC,
                        avoidHighways: false,
                        avoidTolls: false,

                    };
                    directionsRenderer.setMap(map);
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            });
        }

        // Get direction and display site favicon on store point
        function directionRenderFn() {
            directionsRenderer.setMap(map);
            infowindow = new google.maps.InfoWindow();

            var marker, i;
            var origins = [];
            var destinations = [];
            var favicon = "{{ asset('storage/__asset/img/icons/restaurant.png') }}";

            for (i = 0; i < mapStores.length; i++) {
                for (j = 0; j < mapStores[i][1]['store_address'].length; j++) {
                    var address = mapStores[i][1]['store_address'];
                    origins.push(new google.maps.LatLng(myLat, myLng));
                    destinations.push(new google.maps.LatLng(address[j]['latitude'], address[j]['longitude']));

                    // Google map pointer size
                    const icon = {
                        url: favicon, // url
                        scaledSize: new google.maps.Size(30, 30), // scaled size
                    };

                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(address[j]['latitude'], address[j]['longitude']),
                        map: map,
                        icon: icon
                    });

                    var origin = window.location.origin;
                    var storeLogo = mapStores[i][1].logo[0];
                    const contentString =
                        '<div id="content">' +
                        '<div id="siteNotice">' +
                        "</div>" +
                        '<div id="mapPopupHeader">' +
                        '<a href="' + origin + '/cashback/' + mapStores[i][1]['slug'] +
                        '"><img src="' + getImageUrl(storeLogo) +
                        '" onerror="_logo(this)" style="width: 100px;" /><div id="headerTitleAddress"><h4 id="firstHeading" class="firstHeading">' + mapStores[i][1][
                            'name'
                        ] + '</h4></a>' +
                        '<p><span class="addressIcon"><i class="ion-location mr2" aria-hidden="true"></i></span>' +
                        mapStores[i][1]['store_address'][j]['address'] + '</p>' +
                        "</div></div>" +
                        '<div id="bodyContent">' +
                        '<div class="storeTimings d-none">' +
                        '<h4><span><i class="ion-clock mr2" aria-hidden="true"></i></i></span>Timings</h4>' +
                        '<ul>12PM</ul>' +
                        '</div>' +
                        '<p id="directionBtn"><button class="btn btn-primary" onclick="calculateAndDisplayRoute(' +
                        mapStores[i][1]['store_address'][j]['latitude'] + ',' + mapStores[i][1]['store_address'][j]['longitude'] +
                        ')">GET DIRECTION</button></p>' +
                        "</div>" +
                        "</div>";

                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            infowindow.setContent(contentString);
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                }
            }
        }

        // serach location on field
        function addressLocationSearch() {
            /*****For Address Search input field Starts*****/

            const card = document.getElementById("pac-card");
            const input = document.getElementById("pac-input");
            const biasInputElement = document.getElementById("use-location-bias");
            const strictBoundsInputElement = document.getElementById("use-strict-bounds");
            const options = {
                fields: ["formatted_address", "geometry", "name"],
                strictBounds: false,
                types: ["establishment"],
            };
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(card);

            const autocomplete = new google.maps.places.Autocomplete(input, options);

            // Bind the map's bounds (viewport) property to the autocomplete object,
            // so that the autocomplete requests use the current map bounds for the
            // bounds option in the request.
            autocomplete.bindTo("bounds", map);

            var infowindow = new google.maps.InfoWindow();
            var infowindowContent = document.getElementById("infowindow-content");

            infowindow.setContent(infowindowContent);

            const marker = new google.maps.Marker({
                map,
                anchorPoint: new google.maps.Point(0, -29),
            });

            autocomplete.addListener("place_changed", () => {
                infowindow.close();
                marker.setVisible(false);

                const place = autocomplete.getPlace();
                let pos = place.geometry.location;
                var cur_lat = place.geometry.location.lat();
                var cur_lng = place.geometry.location.lng();
                myLat = cur_lat;
                myLng = cur_lng;
                center = new google.maps.LatLng(myLat, myLng);


                map.panTo(pos);

                if (!place.geometry || !place.geometry.location) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("No details available for input: '" + place.name + "'");
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.setZoom(8);
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(8);
                }

                marker.setPosition(place.geometry.location);
                marker.setVisible(true);
                infowindowContent.children["place-name"].textContent = place.name;
                infowindowContent.children["place-address"].textContent =
                    place.formatted_address;
                infowindow.open(map, marker);
            });

            // Sets a listener on a radio button to change the filter type on Places
            // Autocomplete.
            function setupClickListener(id, types) {
                const radioButton = document.getElementById(id);

                radioButton.addEventListener("click", () => {
                    autocomplete.setTypes(types);
                    input.value = "";
                });
            }

            setupClickListener("changetype-all", []);
            setupClickListener("changetype-address", ["address"]);
            setupClickListener("changetype-establishment", ["establishment"]);
            setupClickListener("changetype-geocode", ["geocode"]);
            setupClickListener("changetype-cities", ["(cities)"]);
            setupClickListener("changetype-regions", ["(regions)"]);

            biasInputElement.addEventListener("change", () => {
                if (biasInputElement.checked) {
                    autocomplete.bindTo("bounds", map);
                } else {
                    // User wants to turn off location bias, so three things need to happen:
                    // 1. Unbind from map
                    // 2. Reset the bounds to whole world
                    // 3. Uncheck the strict bounds checkbox UI (which also disables strict bounds)
                    autocomplete.unbind("bounds");
                    autocomplete.setBounds({
                        east: 180,
                        west: -180,
                        north: 90,
                        south: -90
                    });
                    strictBoundsInputElement.checked = biasInputElement.checked;
                }

                input.value = "";
            });

            strictBoundsInputElement.addEventListener("change", () => {
                autocomplete.setOptions({
                    strictBounds: strictBoundsInputElement.checked,
                });
                if (strictBoundsInputElement.checked) {
                    biasInputElement.checked = strictBoundsInputElement.checked;
                    autocomplete.bindTo("bounds", map);
                }

                input.value = "";
            });

            /*****For Address Search input field End********/
        }

        $(document).ready(function() {
            storesView(0, true)
            $(document).on('change', '.select_search', function() {
                storesView(0);
            });
            $(document).on('change', '.filter_by', function() {
                storesView(0);
            });
            $(document).on('click', '.page-link', function(event) {
                event.preventDefault();
                var pageurl = new URL($(this).attr('href'));
                const page = pageurl.searchParams.get("page");
                storesView(page);
            });

            $(document).on('change', "#stores_per_page", function(e) {
                $('#perPage').val($("#stores_per_page").val());
                storesView(0);
            });

            $(document).on('change', '.cuisine-select', function(event) {
                event.preventDefault();

                offset = 0;
                storesPerPage = 12;


                var form = $('.filter-form')
                var formData = form.serialize();

                if (formData === '') {
                    // If the form data is empty, manually set the cuisines value
                    formData = $('#cuisine-select').val('all');
                }
                $.ajax({
                    url: form.attr('action'),
                    type: 'GET',
                    data: {
                        cuisines: $('#cuisine-select').val(),
                        perPage: storesPerPage,
                    },
                    success: function(response) {
                        $('#stores-view').html(response.view);

                        // Hide load more button if stores less than per page stores
                        if (response.storesCount <= response.stores.per_page) {
                            $('#load-more-btn').addClass("d-none");
                        }
                        stores = response.stores.data;
                        mapStores = Object.keys(stores).map((key) => [key, stores[key]]);
                        initMap();
                        filteredStoresCount = response.storesCount;
                        offset = 12;
                        storesPerPage = 12;
                        filteredLoadedStores = 12;
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            });
        });

        $(document).ready(function() {
            offset = 12;
            var storesLoaded = 12;
            storesPerPage = 12;
            var totalStores = {{ $totalCount }};

            function loadMoreItems() {
                if (storesLoaded === 0) {
                    storesLoaded += storesPerPage;
                    offset += storesPerPage;
                    return;
                }
                var diff = totalStores - storesLoaded;
                var perpage = 12;
                if (diff < 12) {
                    perpage = diff;
                }
                if ($('#cuisine-select').val() == "") {
                    if (storesLoaded < totalStores) {
                        stores = Object.entries(stores);
                        $.ajax({
                            url: "{{ route('load-more') }}",
                            type: "GET",
                            data: {
                                offset: offset,
                                perpage: perpage
                            },
                            success: function(response) {
                                $('#storesListN').append(response.html);
                                Object.entries(response.stores).forEach(newStores => {
                                    stores = [...stores, newStores[1]];
                                    mapStores.push(newStores);
                                });
                                initMap();
                                offset = response.nextOffset;
                                storesLoaded += storesPerPage;
                                if (storesLoaded >= totalStores) {
                                    $('#load-more-btn').addClass("d-none");
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                            }
                        });
                    }
                } else {
                    if (filteredLoadedStores < filteredStoresCount) {
                        stores = Object.entries(stores);
                        $.ajax({
                            url: "{{ route('load-more') }}",
                            type: "GET",
                            data: {
                                cuisines: $('#cuisine-select').val(),
                                offset: offset,
                                perpage: perpage
                            },
                            success: function(response) {
                                $('#storesListN').append(response.html);
                                Object.entries(response.stores).forEach(newStores => {
                                    stores = [...stores, newStores[1]];
                                    mapStores.push(newStores);
                                });
                                initMap();
                                offset = response.nextOffset;
                                filteredLoadedStores += storesPerPage;
                                if (filteredLoadedStores >= filteredStoresCount) {
                                    $('#load-more-btn').addClass("d-none");
                                }
                            },
                            error: function(response) {
                                console.log(response);
                            }
                        });
                    }
                }
            }

            $(document).on('click', '#load-more-btn', function(event) {
                event.preventDefault();
                loadMoreItems();
            });
            if (totalStores === 0 || storesLoaded >= totalStores) {
                $('#load-more-btn').addClass("d-none");
            }
        });
    </script>
@endpush
