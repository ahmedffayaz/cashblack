<div class="header__top-bar">
    <div class="container">
        <div class="header__top-bar-menu">
            <ul>
                <li>
                    <a href="{{ url('/blogs') }}">Blogs</a>
                </li>
                <li>
                    <a href="{{ url('charities') }}">Cashblack Giveback</a>
                </li>
                <li>
                    <a href="javascript:;" class="down-caret" id="toolsDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tools</a>
                    <div class="dropdown-menu" role="menu" aria-labelledby="toolsDropdown">
                        <a class="dropdown-item" href="{{ url('pages/apps') }}">Mobile App</a>
                        <a class="dropdown-item" href="{{ url('pages/extensions') }}">Cashblack A.F.R.O.B.O.T</a>
                        <a class="dropdown-item" href="{{ route('account.referral.index') }}">Refer a Friend</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
