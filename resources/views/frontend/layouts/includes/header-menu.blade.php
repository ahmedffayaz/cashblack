<div class="header__main-menu">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="navbar-nav me-auto mb-2 mb-lg-0">
                    <ul class="main-nav">
                        <li class="nav-item d-lg-none"><a href="{{ url('/') }}" class="nav-link">Home</a></li>

                        <h6 class="d-lg-none submenu-title">Categories <i class="bi bi-chevron-down ms-auto"></i></h6>

                        <div class="submenu">
                            @foreach (getCategories(6) as $parentCategory)
                                <li class="nav-item dropdown">
                                    <a class="nav-link d-none d-lg-block {{ $parentCategory->name }}" aria-current="page"
                                        href="{{ route('categories.show', $parentCategory->slug) }}"
                                        style="{{ $parentCategory->slug == 'cashblack-to-your-door' ? 'font-weight: 700;' : ' ' }}">
                                        {{ $parentCategory->name }}
                                    </a>

                                    <a class="nav-link dropdown-toggle d-lg-none" data-bs-toggle="dropdown" aria-current="page" aria-haspopup="true" aria-expanded="false"
                                        href="{{ route('categories.show', $parentCategory->slug) }}" id="navbarDropdown" role="button" data-toggle="dropdown">
                                        {{ $parentCategory->name }}
                                    </a>

                                    @if ($parentCategory->childs->count() > 0 && $parentCategory->childs->where('status', 1)->count() > 0)
                                        @php
                                            $sortedChildCategories = $parentCategory->childs
                                                ->where('status', 1)
                                                ->sortBy('sort');
                                        @endphp

                                        <ul class="dropdown-menu on-hover" aria-labelledby="navbarDropdown">
                                            @foreach ($sortedChildCategories  as $subCategory)
                                                    <li><a class="dropdown-item" href="{{ route('categories.show', $subCategory->slug) }}">{{ $subCategory->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                            @php $moreCategories = getMoreCategories(); @endphp
                            @if (count($moreCategories))
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle more-link" href="#" id="moreMenuDD" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        More <i class="bi bi-chevron-down"></i>
                                    </a>
                                    <div class="dropdown-menu mega-menu dropdown-menu-end" aria-labelledby="moreMenuDD">
                                        <div class="row">
                                            @foreach ($moreCategories as $parentCategory)
                                                <div class="col">
                                                    <h6 class="mb-2 mt-3">
                                                        <a href="{{ route('categories.show', $parentCategory->slug) }}">{{ $parentCategory->name }}</a>
                                                    </h6>
                                                    <ul>
                                                        @foreach ($parentCategory->childs as $subCategory)
                                                            @if ($subCategory->status === 1)
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route('categories.show', $subCategory->slug) }}">
                                                                        {{ $subCategory->name }}
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </li>
                            @endif
                        </div>
                    </ul>

                    <div class="d-lg-none">
                        <li class="nav-item">
                            <a href="{{ route('account.dashboard') }}" class="nav-link">My Account</a>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:;" onclick="showLogoutConfirmation();" class="nav-link">Logout</a>
                        </li>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>
