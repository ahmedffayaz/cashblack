@if (Session::has('login-welcome'))
    <div class="toast bg-success m-2 toaster-position" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header p-3 d-md-flex flex-grow-1 justify-content-between d-md-flex flex-grow-1 justify-content-between">
            <p>Welcome back {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}.</p>
            <button type="button" class="ml-2 mb-1 toast-close close" data-bs-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif

@if (Session::has('social-login'))
    <div class="toast bg-danger m-2 toaster-position" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header p-3 d-md-flex flex-grow-1 justify-content-between">
            <p>Please login with social media instead of.</p>
            <button type="button" class="ml-2 mb-1 toast-close close" data-bs-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif

@if (Session::has('login-expired'))
    <div class="toast bg-danger m-2 toaster-position" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header p-3 d-md-flex flex-grow-1 justify-content-between">
            <p>Your Session has expired! Please login again.</p>
            <button type="button" class="ml-2 mb-1 toast-close close" data-bs-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif

@if (Session::has('email-not-verified'))
    <div class="toast bg-danger m-2 toaster-position" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header p-3 d-md-flex flex-grow-1 justify-content-between">
            <p>You need to confirm your account. Please check your email.</p>
            <button type="button" class="ml-2 mb-1 toast-close close" data-bs-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif

@if (Session::has('success'))
    <div class="toast bg-success m-2 toaster-position" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header p-3 d-md-flex flex-grow-1 justify-content-between">
            <p>{{ Session::get('success') }}</p>
            <button type="button" class="ml-2 mb-1 toast-close close" data-bs-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif
@if (Session::has('error'))
    <div class="toast bg-danger m-2 toaster-position" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header p-3 d-md-flex flex-grow-1 justify-content-between">
            <p>{{ Session::get('error') }}</p>
            <button type="button" class="ml-2 mb-1 toast-close close" data-bs-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif

@if (Session::has('message'))
    <div class="toast bg-danger m-2 toaster-position" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header p-3 d-md-flex flex-grow-1 justify-content-between">
            <p>{{ Session::get('message') }}</p>
            <button type="button" class="ml-2 mb-1 toast-close close" data-bs-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif

<div class="toast bg-success m-2 d-none toaster-position" id="newsletter_success" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header p-3 d-md-flex flex-grow-1 justify-content-between">
        <p>Thanks for joining our newsletter</p>
        <button type="button" class="ml-2 mb-1 toast-close close" data-bs-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>

<div class="toast bg-danger m-2 d-none toaster-position" id="newsletter_error" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header p-3 d-md-flex flex-grow-1 justify-content-between">
        <p>Something went wrong while subscribing to newsletter</p>
        <button type="button" class="ml-2 mb-1 toast-close close" data-bs-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>

<div class="toast bg-success m-2 d-none toaster-position" id="unsubscribe_success" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header p-3 d-md-flex flex-grow-1 justify-content-between">
        <p>You have unsubscribed to our newsletter</p>
        <button type="button" class="ml-2 mb-1 toast-close close" data-bs-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>