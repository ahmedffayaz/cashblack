<div class="col-md-3 sidebar">
    <button type="button" class="offcanvas-close d-lg-none" data-bs-dismiss="navbar" aria-label="Close">
        <i class="bi bi-x-lg"></i>
    </button>
    <div class="dashboard__panel border">
        <div class="panel-body">
            <div class="user-panel">
                <div class="userpic">
                        <img src="{{ getAvatar(auth()->user()->avatar) }}" alt="User Avatar" onerror="defaultAvatar(this)">
                </div>
                <h5 class="user-title">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h5>
                <p class="user-join-date">Member since {{ auth()->user()->created_at->format('d M, Y') }}</p>
            </div>
        </div>
        <div class="dashboard__navbar">
            <ul>
                <li class="{{ isset($page) && $page == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('account.dashboard') }}" class="nav-link">Dashboard</a>
                </li>

                <li>
                    <a href="#" class="nav-link dropdown" data-bs-toggle="collapse" data-bs-target="#myaccount" aria-expanded="false">Personal</a>
                    <ul class="collapse sub-menu {{ isset($page) && in_array($page, ['profile', 'password', 'favorite_stores', 'favorite_cashblack_to_door']) ? 'show' : '' }}" id="myaccount">
                        <li class="{{ isset($page) && $page == 'profile' ? 'active' : '' }}">
                            <a href="{{ route('account.profile') }}" class="nav-link">Profile</a>
                        </li>
                        <li class="{{ isset($page) && $page == 'favorite_stores' ? 'active' : '' }}">
                            <a href="{{ route('account.favorite-stores') }}" class="nav-link">Favorite Stores</a>
                        </li>
                        <li class="{{ isset($page) && $page == 'favorite_cashblack_to_door' ? 'active' : '' }}">
                            <a href="{{ route('account.favorite-cashblack-to-door') }}" class="nav-link">Favorite Cashback to Your Door</a>
                        </li>
                        <li class="{{ isset($page) && $page == 'password' ? 'active' : '' }}">
                            <a href="{{ route('account.change_password') }}" class="nav-link">Password</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="nav-link dropdown" data-bs-toggle="collapse" data-bs-target="#mycashback" aria-expanded="false">Activity</a>
                    <ul class="collapse sub-menu {{ isset($page) && in_array($page, ['cashback', 'store-visits', 'wallet', 'payment-details']) ? 'show' : '' }}"
                        id="mycashback">
                        <li class="{{ isset($page) && $page == 'cashback' ? 'active' : '' }}">
                            <a href="{{ route('account.cashback') }}" class="nav-link">Cashback</a>
                        </li>
                        <li class="{{ isset($page) && $page == 'store-visits' ? 'active' : '' }}">
                            <a href="{{ route('account.clicks') }}" class="nav-link">Store Visits</a>
                        </li>
                        <li class="{{ isset($page) && $page == 'cashouts' ? 'active' : '' }}">
                            <a href="{{ route('account.cashouts') }}" class="nav-link">Cashouts</a>
                        </li>
                        <li class="{{ isset($page) && $page == 'payment-details' ? 'active' : '' }}">
                            <a href="{{ route('account.payment_details') }}" class="nav-link">Cashout Method</a>
                        </li>
                        <li class="{{ isset($page) && $page == 'wallet' ? 'active' : '' }}">
                            <a href="{{ route('account.withdraw.index') }}" class="nav-link">Request Cashout</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="nav-link dropdown" data-bs-toggle="collapse" data-bs-target="#referfriend" aria-expanded="false">Refer &amp; Earn</a>
                    <ul class="collapse sub-menu {{ isset($page) && in_array($page, ['refer-and-earn']) ? 'show' : '' }}" id="referfriend">
                        <li><a href="{{ route('account.referral.my-referral') }}" class="nav-link">My Referrals</a></li>
                        <li class="{{ isset($page) && $page == 'refer-and-earn' ? 'active' : '' }}">
                            <a href="{{ route('account.referral.index') }}" class="nav-link">Refer &amp; Earn</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="nav-link dropdown" data-bs-toggle="collapse" data-bs-target="#support" aria-expanded="false">Support</a>
                    <ul class="collapse sub-menu {{ isset($page) && in_array($page, ['tickets']) ? 'show' : '' }}" id="support">
                        <li><a href="{{ url('pages/faqs') }}" class="nav-link">FAQs</a></li>
                        <li class="{{ isset($page) && $page == 'tickets' ? 'active' : '' }}">
                            <a href="{{ route('account.tickets.index') }}" class="nav-link">Tickets</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:;" onclick="showLogoutConfirmation();" class="nav-link">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</div>
