<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}">Home</a>
        </li>
        @if (isset($crumbs))
            @foreach ($crumbs as $crumb)
                @if (arrayValueExists($crumb, 'url') && arrayValueExists($crumb, 'title'))
                    <li class="breadcrumb-item">
                        <a href="{{ $crumb['url'] }}">{{ $crumb['title'] }}</a>
                    </li>
                @endif
            @endforeach
        @endif
        <li class="breadcrumb-item active" aria-current="page">{{ $current }}</li>
    </ol>
</nav>
