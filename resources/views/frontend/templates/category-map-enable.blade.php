@if (SiteSetting()['map_key'] && $category->is_map_enable == 1)

    <div class="map-search">
        <button href="javascript:;" class="d-sm-block" onclick="getCurrentLocation();">
            <img src="https://www.cashblack.com/resources/assets/img/map-pointer.png" alt="">
        </button>
        <div class="search-wrap">
            <div>
                <div class="d-none">
                    <div id="title">Autocomplete search</div>
                    <div id="type-selector" class="pac-controls">
                        <input type="radio" name="type" id="changetype-all" checked="checked">
                        <label for="changetype-all">All</label>

                        <input type="radio" name="type" id="changetype-establishment">
                        <label for="changetype-establishment">establishment</label>

                        <input type="radio" name="type" id="changetype-address">
                        <label for="changetype-address">address</label>

                        <input type="radio" name="type" id="changetype-geocode">
                        <label for="changetype-geocode">geocode</label>

                        <input type="radio" name="type" id="changetype-cities">
                        <label for="changetype-cities">(cities)</label>

                        <input type="radio" name="type" id="changetype-regions">
                        <label for="changetype-regions">(regions)</label>
                    </div>
                    <br>
                    <div id="strict-bounds-selector" class="pac-controls">
                        <input type="checkbox" id="use-location-bias" value="" checked="">
                        <label for="use-location-bias">Bias to map viewport</label>

                        <input type="checkbox" id="use-strict-bounds" value="">
                        <label for="use-strict-bounds">Strict bounds</label>
                    </div>
                </div>
                <div>
                    <input id="pac-input" name="user_address" class="form-control pac-target-input" type="text" placeholder="Enter a location" value=""
                        autocomplete="off">
                </div>
            </div>
        </div>
        <div id="infowindow-content" class="d-none">
            <span id="place-name" class="title"></span><br>
            <span id="place-address"></span>
        </div>
        <button class="icon-btn black d-none"><i class="bi bi-search"></i></button>
    </div>

    <div class="map-area">
        <div id="floating-panel" style="display: none;">
            <b>Mode of Travel:</b>
            <select id="mode">
                <option value="DRIVING" selected="">Driving</option>
                <option value="WALKING">Walking</option>
                <option value="TRANSIT">Transit</option>
            </select>
        </div>
        <div id="map" style="position: relative; overflow: hidden; height: 100%;"></div>
    </div>
@endif
