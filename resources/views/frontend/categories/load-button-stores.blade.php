  @foreach ($allStores as $store)
      <li class="list-item col">
          <a href="{{ route('stores.show', $store->slug) }}">
              <div class="takeaway-item__logo">
                  <img src="{{ getImageUrl($store->images()->where('title', 'cover')->first()) }}" alt="{{ $store->name }}" class="img-fluid" onerror="_banner(this)">
                  <span class="logo-wrap">
                      <img src="{{ getImageUrl($store->logo->first()) }}" alt="{{ $store->name }}" onerror="_logo(this)">
                  </span>
              </div>
          </a>
          <div class="category-item__detail">
              <div class="item-name-tags">
                  <a href="{{ route('stores.show', $store->slug) }}">
                      <h5 class="store-name mb-2">{{ $store->name }}</h5>
                  </a>
                  <ul class="tags">
                      @foreach (getCuisineTags($store) as $tag)
                          <li><a href="{{ url('categories/cashblack-to-your-door?cuisine=' . $tag) }}">{{ $tag }}</a></li>
                      @endforeach
                  </ul>
                  @foreach ($store->storeAddress()->get() as $address)
                      <p class="address mb-1">{{ !empty($store->postal_code) ? implode(', ', [$store->postal_code, $address->address]) : $address->address }}</p>
                  @endforeach
                  <div class="distance calculatedDistance" id="distance">{{ $store->distance . ' miles away' }}</div>
              </div>
          </div>
      </li>
      <input type="hidden" id="destinationLat" value="">
      <input type="hidden" id="destinationLng" value="">
  @endforeach
