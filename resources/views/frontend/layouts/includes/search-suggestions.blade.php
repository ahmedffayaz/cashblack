@if ($stores->count() > 0)
    <ul class="search-suggestions ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all_new" role="listbox"
        style="left: 609px; width: 409px; top: 204px; z-index: 1001; height: {{ $stores->count() <= 12 ? $stores->count() * 29 : 336 }}px; overflow: auto;">
        @foreach ($stores as $store)
            <a class="ui-corner-all_new" href="{{ route('stores.show', $store->slug) }}">
                <li class="ui-menu-item" role="menuitem">
                    {{ $store->name }} — <small>{{ $store->default_cashback }}</small>
                </li>
            </a>
        @endforeach
    </ul>
@endif
