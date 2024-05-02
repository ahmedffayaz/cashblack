@if (Session::has('welcome'))
    <div class="modal fade" tabindex="-1" role="dialog" id="welcome-message" aria-labelledby="trackerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center py-5">
                    <svg style="width: 40px" class="fill-primary mb-3 mx-auto" id="icon-recorded-tick" viewBox="0 0 40 40">
                        <path
                            d="M17 27.556c-.444 0-.889-.112-1.222-.445-.667-.667-.667-1.667 0-2.333l11.889-11.89c.666-.666 1.666-.666 2.333 0 .667.668.667 1.668 0 2.334l-11.889 11.89c-.222.332-.667.444-1.111.444z">
                        </path>
                        <path
                            d="M17 27.556c-.444 0-.889-.112-1.222-.445l-5.89-5.889c-.666-.666-.666-1.666 0-2.333.668-.667 1.668-.667 2.334 0l5.89 5.889c.666.666.666 1.666 0 2.333-.223.333-.668.445-1.112.445z">
                        </path>
                        <path
                            d="M20 0C9 0 0 9 0 20s9 20 20 20 20-9 20-20S31 0 20 0zm0 35.556c-8.556 0-15.556-7-15.556-15.556S11.444 4.444 20 4.444s15.556 7 15.556 15.556-7 15.556-15.556 15.556z">
                        </path>
                    </svg>
                    <h3 class="color-primary my-3">Thank you for registering</h3>
                    <p>
                        Please verify your email address. Don’t Forget to check your junk folder.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('#welcome-message').modal('show');
        });
    </script>
@endif

@if (Session::has('social-login-welcome'))
    <div class="modal fade" tabindex="-1" role="dialog" id="welcome-message" aria-labelledby="trackerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center py-5">
                    <svg style="width: 40px" class="fill-primary mb-3 mx-auto" id="icon-recorded-tick" viewBox="0 0 40 40">
                        <path
                            d="M17 27.556c-.444 0-.889-.112-1.222-.445-.667-.667-.667-1.667 0-2.333l11.889-11.89c.666-.666 1.666-.666 2.333 0 .667.668.667 1.668 0 2.334l-11.889 11.89c-.222.332-.667.444-1.111.444z">
                        </path>
                        <path
                            d="M17 27.556c-.444 0-.889-.112-1.222-.445l-5.89-5.889c-.666-.666-.666-1.666 0-2.333.668-.667 1.668-.667 2.334 0l5.89 5.889c.666.666.666 1.666 0 2.333-.223.333-.668.445-1.112.445z">
                        </path>
                        <path
                            d="M20 0C9 0 0 9 0 20s9 20 20 20 20-9 20-20S31 0 20 0zm0 35.556c-8.556 0-15.556-7-15.556-15.556S11.444 4.444 20 4.444s15.556 7 15.556 15.556-7 15.556-15.556 15.556z">
                        </path>
                    </svg>
                    <h3 class="color-primary my-3">Thank you for registering</h3>
                    <p>You're in! Enjoy your seamless shopping and cashback experience on our platform.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('#welcome-message').modal('show');
        });
    </script>
@endif
