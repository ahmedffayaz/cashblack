@if (!Auth::user())
    <section id="hero" class="hero animate__animated animate__fadeIn wow">
        <div class="hero-img-wrap">
            <video width="100%" height="100%" preload="auto" autoplay loop muted playsinline>
                <source src="{{ asset('storage/__asset/videos/intro.mp4?v=1') }}" type="video/mp4" />
            </video>
        </div>
        <div class=" ms-auto hero-form-container">
            <h2>Join Cashblack For Free and <span>Get a £{{ !empty(getSpecificSetting('welcome_bonus')) ? getSpecificSetting('welcome_bonus') : '5' }} Sign-Up Bonus</span>
            </h2>
            <form class="signup-form" method="post" action="{{ route('register') }}">
                @csrf
                <div class="col-12 mb-2">
                    <input type="text" class="form-control icon user-icon" name="firstname" id="firstname" aria-label="First Name" value="{{ old('firstname') }}"
                        data-msg-required="Please enter your first name" required="required" placeholder="First Name" aria-invalid="false">
                    @error('firstname')
                        <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-12 mb-2">
                    <input type="text" class="form-control icon user-icon" name="lastname" id="lastname" aria-label="Last Name" value="{{ old('lastname') }}"
                        data-msg-required="Please enter your last name" required="required" placeholder="Last Name" aria-invalid="false">
                    @error('lastname')
                        <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-row">
                    <input type="email" class="form-control email" name="email" placeholder="Email Address" aria-label="Email Address" required
                        value="{{ old('email') }}">
                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-row">
                    <div class="input-group-append">
                        <i class="far fa-eye home-icon-style toggle-password" data-target="#password"></i>
                    </div>
                    <input type="password" class="form-control icon password eye-icon" name="password" id="password" placeholder="Password" aria-label="Password"
                        autocomplete="off" minlength="8" required>
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="input-group-append">
                        <i class="far fa-eye home-icon-style2 toggle-password" data-target="#confirm-password"></i>
                    </div>
                    <input type="password" class="form-control eye-icon icon password" name="password_confirmation" id="confirm-password"
                        aria-label="confirm password" required="required" autocomplete="off" data-msg-required="Please enter confirm password"
                        data-msg-equalto="Repeat password did not match with your password" equalto="#password" placeholder="Confirm Password">
                </div>

                <div class="col-12 mb-2">
                    <input type="text" class="form-control icon user-icon" name="ref_code" id="ref_code" placeholder="Referral Code">
                </div>

                <div class="form-row grid mb-3 justify-content-center {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                    {!! app('captcha')->display() !!}
                    @error('g-recaptcha-response')
                        <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row grid">
                    <button class="btn btn-secondary">Join Free Now</button>
                </div>

                <div class="messageBox mt-4"></div>

                <div class="form-row">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="terms-checkbox" checked>
                        <label class="form-check-label" for="terms-checkbox">
                            Click here if you would like to receive exclusive offers. <br />
                            By registering, you agree to <a href="{{ url('pages/terms-conditions') }}" class="primary-text-color">Cashblack's Terms.</a>
                        </label>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endif
@push('scripts')
    <script>
        function togglePasswordVisibility() {
            var target = $($(this).data('target'));
            var fieldType = target.attr('type');

            if (fieldType === 'password') {
                target.attr('type', 'text');
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                target.attr('type', 'password');
                $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            }
        }

        $(document).ready(function() {
            $('.toggle-password').click(togglePasswordVisibility);
        });
    </script>
@endpush
