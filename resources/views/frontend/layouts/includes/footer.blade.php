<footer id="footer" class="bg-dark">

    @include('frontend.layouts.includes.cookie-notice')

    @php
        $menus = Harimayco\Menu\Models\Menus::where('name', 'like', '%Footer Menu%')
            ->with('items')
            ->get();

        $settings = SiteSetting();
    @endphp

    @if ($menus->count() > 0)
        <div class="container text-white">
            <div class="footer-mid">
                <div class="row">
                    @foreach ($menus as $menu)
                        <div class="col footer-nav__header">
                            <h5 class="secondary-text-color">{{ $menu->title }}</h5>
                            <ul class="footer-nav">
                                @foreach ($menu->items as $item)
                                    <li><a href="{{ url($item->link) }}">{{ $item->label }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
                <div class="row mt-4 mt-md-2">
                    <div class="col newsletter-col">
                        <form id="newsletter_form" action="" method="GET">
                            @csrf
                            <div class="footer-newsletter">
                                <h4 class="newsletter-title secondary-text-color">
                                    Subscribe Newsletter
                                </h4>
                                <p>Get cashback deals in your inbox</p>
                                <div class="form-row mt-3">
                                    <div class=" newsletter-form">
                                        <div class="col input-fields">
                                            <input type="text" name="newsletter_name" id="newsletter_name" class="form-control" placeholder="Enter name">
                                        </div>
                                        <div class="col input-fields">
                                            <input type="text" name="newsletter_email" id="newsletter_email" class="form-control" placeholder="Enter email">
                                        </div>
                                        <input type="hidden" name="profile_user_id" id="profile_user_id" value="{{ auth()->user() ? auth()->user()->id : '' }}  ">
                                        <div class="error-feedback"></div>
                                        <div class="col">
                                            <button type="submit" id="submit_newsletter" class="btn btn-lg btn-primary btn-subscribe text-uppercase">subscribe</button>
                                        </div>

                                    </div>
                                    <div class="messageBox mt-4"></div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="col sm-col mt-4 mt-md-0 pt-3">
                        <h5 class="secondary-text-color mb-3">Follow us on</h5>
                        <ul class="social-links">
                            @if (isset($settings['facebook']) && !empty($settings['facebook']))
                                <li>
                                    <a href="{{ $settings['facebook'] }}" class="primary-text-color" target="_blank">
                                        <img src="{{ asset('storage/__asset/img/social/facebook.png') }}" alt="Facebook">
                                    </a>
                                </li>
                            @endif
                            @if (isset($settings['twitter']) && !empty($settings['twitter']))
                                <li>
                                    <a href="https://twitter.com/CashblackHQ" class="primary-text-color" target="_blank">
                                        <img src="{{ asset('storage/__asset/img/social/twitter-x.png') }}" alt="Twitter">
                                    </a>
                                </li>
                            @endif
                            @if (isset($settings['instagram']) && !empty($settings['instagram']))
                                <li>
                                    <a href="https://instagram.com/CashblackHQ" class="primary-text-color" target="_blank">
                                        <img src="{{ asset('storage/__asset/img/social/instagram.png') }}" alt="Instagram">
                                    </a>
                                </li>
                            @endif
                            @if (isset($settings['tiktok']) && !empty($settings['tiktok']))
                                <li>
                                    <a href="http://www.tiktok.com/@CashblackHQ" class="primary-text-color" target="_blank">
                                        <img src="{{ asset('storage/__asset/img/social/tiktok.png') }}" alt="Tiktok">
                                    </a>
                                </li>
                            @endif
                            @if (isset($settings['linkedin']) && !empty($settings['linkedin']))
                                <li>
                                    <a href="http://www.linkedin.com/company/cashblack" class="primary-text-color" target="_blank">
                                        <img src="{{ asset('storage/__asset/img/social/linkedin.png') }}" alt="Linkedin">
                                    </a>
                                </li>
                            @endif
                            @if (isset($settings['pinterest']) && !empty($settings['pinterest']))
                                <li>
                                    <a href="https://www.pinterest.co.uk/CashblackHQ/" class="primary-text-color" target="_blank">
                                        <img src="{{ asset('storage/__asset/img/social/pinterest.png') }}" alt="Pinterest">
                                    </a>
                                </li>
                            @endif
                            @if (isset($settings['youtube']) && !empty($settings['youtube']))
                                <li>
                                    <a href="https://www.youtube.com/channel/UCxTrkgiu_9wIoOImumbjzwQ?app=desktop" class="primary-text-color" target="_blank">
                                        <img src="{{ asset('storage/__asset/img/social/youtube.png') }}" alt="Youtube">
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <span class="copyright">
                        {{ arrayValueExists($settings, 'footer_text') ? $settings['footer_text'] : 'Cashblack &copy; ' . date('Y') . ' All rights reserved.' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#newsletter_form').submit(function(event) {
                event.preventDefault();
                let newsletterBtn = $('#submit_newsletter');
                let submitBtnHtml = newsletterBtn.html();
                addButtonSpinner(newsletterBtn, submitBtnHtml);

                var form = $(this);
                var emailInput = $('#newsletter_email');
                var email = emailInput.val();

                // Clear previous error feedback
                $('.error-feedback').removeClass('d-block').empty();

                // Email format validation
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (email.trim() === '') {
                    var errorFeedback = emailInput.next('.error-feedback');
                    if (errorFeedback.length === 0) {
                        errorFeedback = $('<div>').addClass('error-feedback');
                        emailInput.after(errorFeedback);
                    }
                    errorFeedback.text('This field is required.').addClass('invalid-feedback d-block');
                    removeBtnDisabledClass(newsletterBtn, submitBtnHtml);
                } else if (!emailRegex.test(email)) {
                    var errorFeedback = emailInput.next('.error-feedback');
                    if (errorFeedback.length === 0) {
                        errorFeedback = $('<div>').addClass('error-feedback');
                        emailInput.after(errorFeedback);
                    }
                    errorFeedback.text('Please enter a valid email address.').addClass('invalid-feedback d-block');
                    removeBtnDisabledClass(newsletterBtn, submitBtnHtml);
                } else if (!form.data('submitted')) {
                    var name = $('#newsletter_name').val();
                    var userId = $("#profile_user_id").val();
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: "{{ route('subscribe-newsletter') }}",
                        method: 'POST',
                        data: {
                            _token: csrfToken,
                            email: email,
                            name: name,
                            profile_user_id: userId,
                            type: 'subscribe-newsletter'
                        },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            if (response.status === 200) {
                                var newsletterSuccess = $('#newsletter_success');
                                setTimeout(function () {
                                    newsletterSuccess.addClass('d-block');
                                }, 1000);
                                setTimeout(function () {
                                    newsletterSuccess.removeClass('d-block');
                                }, 3000);
                            }

                            form[0].reset(); // Reset the flag
                            removeBtnDisabledClass(newsletterBtn, submitBtnHtml);
                        },
                        error: function(error) {
                            var newsletterSuccess = $('#newsletter_error');
                            setTimeout(function () {
                                newsletterSuccess.addClass('d-block');
                            }, 1000);
                            setTimeout(function () {
                                newsletterSuccess.removeClass('d-block');
                            }, 3000);
                            form[0].reset(); // Reset the flag
                            removeBtnDisabledClass(newsletterBtn, submitBtnHtml);
                        }
                    });
                }
            });

            $('.toast-close').click(function(e) {
                e.preventDefault();
                $('.toast').removeClass("d-block");
            });
        });
    </script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
@endpush
