<style>
    .padding {
        padding: 1.13rem 1.75rem 1.13rem 3rem
    }
</style>
<div class="main-container login-screen">
    <div class="container">

        <div class="row">
            <div class="form-container">
                <div class="inner-container">
                    <div class="form-title mb-4">
                        <h4>Leave us a Message</h4>
                    </div>
                    <div class="form">
                        <form method="POST" action="{{ route('contact.store') }}" class="form-validate" id="contact-form">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <input id="name" type="name" name="name" class="form-control" placeholder="Enter Your Name" value="{{ old('name') }}" required
                                        autofocus data-msg-required="The name field is required.">
                                    @error('name')
                                        <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 mb-2">
                                    <input id="email" type="email" name="email" class="form-control" placeholder="Enter Your Email" value="{{ old('email') }}"
                                        required autofocus data-msg-required="The email field is required.">
                                    @error('email')
                                        <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 mb-2">
                                    <input id="subject" type="subject" name="subject" class="form-control" placeholder="Enter your Subject" value="{{ old('subject') }}"
                                        required data-msg-required="The subject field is required.">
                                    @error('subject')
                                        <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 mb-2">
                                    <textarea class="form-control padding" name="message" id="message" placeholder="Enter your Message" rows="6" aria-label="Description"
                                        data-msg-required="Your Message is required." required aria-invalid="false">{{ old('message') }}</textarea>
                                    @error('message')
                                        <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                    {!! app('captcha')->display() !!}
                                    @error('g-recaptcha-response')
                                        <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="cta text-center d-grid mt-4">
                                <button class="btn btn-primary btn-lg rounded-pill text-uppercase">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if (session()->has('success'))
    <div class="toast bg-success m-2" role="alert" aria-live="assertive" aria-atomic="true" style="position:absolute; top:0; right:0; z-index: 200">
        <div class="toast-header p-3">
            <strong class="mr-auto">
                Thank you!
                <br>
                Your message has been successfully sent. We will contact you very soon!
            </strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif

@push('scripts')
    {!! NoCaptcha::renderJs() !!}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            jQuery.validator.addMethod("regex", function(value, element) {
                return this.optional(element) || /^[A-Za-z ]+$/i.test(value);
            }, "Only alphabetic input is allow");

            $('.form-validate').validate({
                errorClass: 'invalid-feedback d-block',
                rules: {
                    name: {
                        required: true,
                        regex: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    subject: {
                        required: true,
                        regex: true
                    },
                    message: {
                        required: true,
                        minlength: 20
                    },
                },
                submitHandler: function(form) {
                    if ($(form).valid())
                        form.submit();
                    return false;
                }
            });
        });
        
    </script>
@endpush
