@extends('frontend.layouts.app')

@section('title', 'Refer a friend')

@section('content')
    <div class="container">
        <div class="page-header">
            <div class="icon-wrap">
                <img src="{{ asset('storage/__asset/img/dashboard-icons/dashboard.png') }}" alt="dashboard-icon">
            </div>
            <div class="title-wrap">
                <h1 class="page-title">My Account</h1>
            </div>
        </div>

        <div class="dashboard__content-area">
            <div class="row">

                @include('frontend.client-dashboard.side-menu', ['page' => 'refer-and-earn'])

                <div class="col main-content">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary d-lg-none mb-3">
                        <i class="fa fa-align-left pr-2"></i>
                    </button>

                    <div class="section-title-wrap">
                        <h4 class="section-title text-center">
                            Invite your friends and earn {{ currency($referralBonus) }} referral bonus.
                        </h4>
                    </div>

                    @if (session('flash_notification'))
                        <div class="row mt-5">
                            @include('flash::message')
                        </div>
                    @endif

                    <div class="row g-3 align-items-center mt-4">
                        <form action="{{ route('account.send-referral-link') }}" method="post" novalidate="novalidate">
                            @csrf
                            <div class="col custom-inline-form mx-auto">
                                <label class="label-md">Invite Your Friends by Email</label>
                                <div class="input-group multi-entry-control">
                                    <input type="text" class="form-control" name="referral_email" id="referral_email" placeholder="Enter invitation email">
                                    <div class="input-group-button">
                                        <button type="submit" class="btn btn-secondary">Send Email</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="row g-3 align-items-center mt-4 pb-4">
                        <form action="javascript:;" novalidate="novalidate">
                            <div class="col custom-inline-form mx-auto">
                                <label class="label-md">Share Your Invite Link</label>
                                <div class="input-group multi-entry-control">
                                    <input type="text" class="form-control" id="ref_link" value="{{ url('/register-form?referby=' . auth()->user()->short_ref_id) }}" readonly>
                                    <div class="input-group-button">
                                        <button class="btn btn-primary copyText refererLink" data-clipboard-target="#ref_link" data-clipboard-action="copy">
                                            Copy Link
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel rounded-border mb-3">
                        <h3 class="heading mb-2 pb-2">Terms & Conditions</h3>
                        <ol>
                            <li>Your referral bonus will be paid into your Cashblack account once your referred friend has earned £10 'confirmed' cashback with Cashblack.
                                The cashback amount can be spread over multiple purchases and does not have to be earned in one single transaction.</li> <br>
                            <li>If applicable, any referral bonus that's owed to your friend will also be paid into their Cashblack account at this time</li> <br>
                            <li>Your referred friend must sign up via your referral link to receive their referral bonus</li> <br>
                            <li>The Cashblack referral bonus amount may increase or decrease at any time. When the referral bonus amount has changed, you will be eligible
                                to receive the amount that was advertised on the site at the time your friend signed up from your link, which may be different from the
                                amount offered when you sent the link to your friend or when the bonus was applied to your account</li> <br>
                            <li>Referral bonuses may occasionally differ between the Cashblack website and Cashblack mobile app</li> <br>
                         <li> We reserve all rights to award and decline bonuses. Any user suspected of bonus abuse will have their Cashblack account(s) terminated.</li> <br>
                        <li>View our standard <a href="{{ url('pages/terms-conditions') }}">Terms and Conditions</a> for more information.</li> <br>
                        </ol>
                    </div>
                    <div class="share-buttons mt-5 text-center">
                        <a href="javascript:;" id="share-facebook" class="btn btn-outline-primary mb-2">
                            <i class="fab fa-facebook-f me-2 fb-icon"></i>
                            Share on Facebook
                        </a>
                        <a href="javascript:;" id="share-twitter" class="btn btn-outline-primary mb-2">
                            <i class="fab fa-twitter me-2 tw-icon"></i>
                            Share on Twitter
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v12.0&appId=3200039003655128&autoLogAppEvents=1" nonce="TzGvgT9f">
    </script>
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    <script>
        $(document).ready(function() {
            $('#share-facebook').click(function() {
                FB.ui({
                    method: 'share',
                    href: "{{ url('/register-form?referby=' . md5(auth()->user()->id)) }}",
                }, function(response) {});

                return false;
            });
            $('#share-twitter').click(function() {
                var url = '{{ url('/register-form') }}?referby={{ md5(auth()->user()->id) }}';
                var tweetText = 'Check out my website at ' + url + '\r\n';
                var tweetUrl = 'https://twitter.com/intent/tweet?text=' + encodeURI(tweetText);
                window.open(tweetUrl, '_blank');

                return false;
            });

        });

    </script>
@endpush
