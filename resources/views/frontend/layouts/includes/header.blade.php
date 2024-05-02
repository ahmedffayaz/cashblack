<header>

    @auth
        @include('frontend.layouts.includes.top-bar')
    @endauth
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <div class="before-logged-in header__middle-area">
        <div class="container d-flex flex-nowrap align-items-center">

            <div class="navbar-brand">
                <a href="{{ url('/') }}">
                    <img src="
                            @if (isset($settings['website_logo']) && $settings['website_logo'] != 'cashblack-default.png') {{ asset('storage/dashboard/images/logo/' . $settings['website_logo']) }}
                            @else
                                {{ asset('storage/__asset/img/logo.png') }} @endif
                        "
                        alt="Cashblack" class="img-fluid">
                </a>
            </div>

            <div class="header-right d-flex flex-grow-1">
                <a href="#header-search" class="skip-link skip-search">
                    <span class="label">Search</span>
                </a>

                <div class="header-search-col d-md-flex flex-grow-1 justify-content-center {{ !empty(auth()->user()) ? 'header-search-login' : '' }}">
                    <div class="header-search">
                        <form method="get" action="{{ route('search.index') }}">
                            <input type="text" name="search" placeholder="Search for retailers, goods or services" value="{{ request()->input('search') }}"
                                autocomplete="off">
                            <span id="search-results"></span>
                            <button class="btn btn-secondary" type="submit">
                                <span>Search</span>
                            </button>
                        </form>
                    </div>
                </div>

                @guest
                    <div class="header-right-links d-flex">
                        <a href="#header-account" class="skip-link skip-account acc-before-login d-lg-none" id="accDropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <span class="label">Account</span>
                        </a>
                        <div class="acc-dropdown dropdown-menu d-lg-none" aria-labelledby="accDropdown">
                            <a href="{{ route('register') }}" class="btn btn-primary acc-btn">Sign Up</a>
                            <a href="{{ route('login') }}" class="btn btn-primary acc-btn">Log in</a>
                        </div>

                        <div class="acc-btns d-none d-lg-block buttons-margin">
                            <a href="{{ route('register') }}" class="btn btn-primary acc-btn">Sign Up</a>
                            <a href="{{ route('login') }}" class="btn btn-primary acc-btn">Log in</a>
                        </div>
                    </div>
                @endguest
                @auth
                    <?php
                    $user = auth()->user();

                    if ($user) {
                        $offsetValue = 0;
                        $Notifications = retrieveNotification($offsetValue);
                        $nextCount = $user
                            ->notifications()
                            ->whereNull('read_at')
                            ->latest()
                            ->count();
                    } else {
                        $Notifications = [];
                        $nextCount = 0;
                    }
                    ?>

                    <div class="">
                        <div class="dropdown" style="margin-right:30px;">
                            <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <span style="font-size:25px">
                                    <i class="bi bi-bell" id="notificationDropdown"></i>
                                </span>
                                <input type="hidden" id="notification-offset" value="10">
                                <input type="hidden" id="totalNotificationCount" value="{{ $nextCount }}">
                                <div class="indicator {{ count($Notifications) == 0 ? 'd-none' : '' }}" id="notification-indicator-class">
                                    <div class="circle"></div>
                                </div>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                                <section class="notify-panel">
                                    <header class="panel-heading">
                                        <div class="notification-header">
                                            <strong class="p-1">Notifications</strong>
                                            <span class="text-right" id="clearAllNotification">Clear all</span>

                                        </div>
                                    </header>
                                    <div class="notification-dropdown-div">
                                        @include('frontend.layouts.includes.notifications', [
                                            'Notifications' => $Notifications,
                                            'nextCount' => $nextCount,
                                            'offset' => $offsetValue,
                                        ])</div>
                                    <div class="panel-footer d-none" id="footer-notification">
                                        <a href="#" class="pull-right"><i class="fa fa-cog"></i></a>
                                        <a href="javascript:void(0)" id="viewAllNotification" data-toggle="class:show animated fadeInRight">See all the notifications</a>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth
            @auth
                <div class="header-right-links d-flex">
                    <span class="skip-link acc-after-login me-2 d-lg-none">
                        <span class="label"><img src="{{ asset('storage/__asset/img/account-icon.png') }}" /></span>
                    </span>
                    <span class="acc-after-login d-lg-none">
                        <span class="label" style="color: black; display: grid;">
                            <span>Balance</span>
                            {{ currency(auth()->user()->availableBalance(3)) }}
                        </span>
                    </span>

                    <div class="account-dropdown after-login al-menu d-none d-sm-block buttons-margin">
                        <a href="javascript:;" class="down-caret btn btn-primary text-uppercase" id="myAccountDropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">My Account</a>
                        <div class="dropdown-menu account-dropdown" role="menu" aria-labelledby="myAccountDropdown">
                            @if (auth()->user()->hasRole('user'))
                                <a class="dropdown-item" href="{{ route('account.dashboard') }}">Dashboard</a>
                            @endif
                            <a class="dropdown-item" href="{{ route('account.profile') }}">Profile</a>
                            <a class="dropdown-item" href="javascript:;" onclick="showLogoutConfirmation();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            @if (Auth::user()->hasRole('admin'))
                                <hr class="my-2">
                                <a class="dropdown-item" href="{{ route(getAdminPrefix() . '.home.index') }}">Admin Dashboard</a>
                            @endif
                        </div>
                    </div>

                    <div class="payable-balance d-none d-lg-block d-xl-block">
                        <a href="{{ route('account.cashback') }}" style="color: black; display: grid;">
                            <span>Balance</span>
                            {{ currency(auth()->user()->availableBalance(3)) }}
                        </a>
                    </div>
                </div>
            @endauth
        </div>

    </div>
    </div>

    @auth
        @include('frontend.layouts.includes.header-menu')
    @endauth
</header>
