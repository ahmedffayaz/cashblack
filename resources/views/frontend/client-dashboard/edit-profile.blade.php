@extends('frontend.layouts.app')

@section('title', 'Dashboard')

@push('styles')
    <style>
        input[type=file]::file-selector-button {
            margin: -4px -10px !important;
        }
    </style>
@endpush
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

                @include('frontend.client-dashboard.side-menu', ['page' => 'profile'])

                <div class="col main-content">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary d-none mb-3">
                        <svg class="svg-inline--fa fa-align-left fa-w-14 pe-1" aria-hidden="true" data-prefix="fa" data-icon="align-left" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                d="M288 44v40c0 8.837-7.163 16-16 16H16c-8.837 0-16-7.163-16-16V44c0-8.837 7.163-16 16-16h256c8.837 0 16 7.163 16
                                16zM0 172v40c0 8.837 7.163 16 16 16h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16
                                16zm16 312h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16
                                16zm256-200H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16h256c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16z">
                            </path>
                        </svg>
                        Menu
                    </button>

                    <div class="section-title-wrap">
                        <h4 class="section-title">Edit Profile</h4>
                        <p class="section-para">On this page, you can update your profile details.</p>
                    </div>

                    @include('flash::message')

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="dashboard__panel border table-responsive mb-4">
                        <div class="row p-4">
                            <div class="col-lg-6 col-md-6 mb-2">
                                <button type="button" id="update-profile" data-bs-toggle="modal" data-bs-target="#update-profile-modal" class="btn btn-primary text-uppercase">Update Profile</button>
                            </div>
                            <div class="col-lg-6 col-md-6 d-flex justify-content-end mb-2 cashout-button">
                                <a type="button" href="{{ route('account.withdraw.index') }}" class="btn btn-primary text-uppercase">Request Cashout</a>
                            </div>
                        </div>

                        <table class="table align-middle table-verticle">
                            <tbody>
                                <tr>
                                    <th width="30%" class="ps-4">Title</th>
                                    <td id="user-profile-title">{{ auth()->user()->title }}</td>
                                </tr>
                                <tr>
                                    <th width="30%" class="ps-4">First Name</th>
                                    <td>{{ auth()->user()->first_name }}</td>
                                </tr>
                                <tr>
                                    <th width="30%" class="ps-4">Last Name</th>
                                    <td>{{ auth()->user()->last_name }}</td>
                                </tr>
                                <tr>
                                    <th width="30%" class="ps-4">Email</th>
                                    <td>{{ auth()->user()->email }}</td>
                                </tr>
                                <tr>
                                    <th width="30%" class="ps-4">Date of Birth</th>
                                    <td id="date-of-birth">{{ !empty(auth()->user()->date_of_birth) ? Carbon\Carbon::parse(auth()->user()->date_of_birth)->isoFormat('Do MMMM YYYY') : '' }}</td>
                                </tr>
                                <tr>
                                    <th width="30%" class="ps-4">Phone Number</th>
                                    <td>{!! empty(auth()->user()->phone) ? '<small>Not Available</small>' : auth()->user()->phone !!}</td>
                                </tr>
                                <tr>
                                    <th width="30%" class="ps-4">Address</th>
                                    <td>{{ auth()->user()->formattedAddress() }}</td>
                                </tr>
                                <tr>
                                    <th width="30%" class="ps-4">Email Preference</th>
                                    <td id="user-profile-email-prefrence">{{ auth()->user()->email_preference == 0 ? 'NO' : 'YES' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" id="phone-number" value="{{ auth()->user()->phone }}">
                    <input type="hidden" id="country" value="{{ !empty(auth()->user()->country_id) ? optional(auth()->user()->country)->name : '' }}">

                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="form-container py-4">
                                <div class="form">
                                    <div class="form-check">
                                        <label class="form-check-label" for="subscribeNewsletter" id="newsletterLabel">
                                            <input type="hidden" id="s_user_id" value="{{ auth()->user()->id }}">
                                            <input type="hidden" id="s_firstname" value="{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}">
                                            <input type="hidden" id="s_email" value="{{ auth()->user()->email }}">
                                            <input class="form-check-input" type="checkbox" value="" id="subscribeNewsletter">
                                            <span class="checkmark">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                    <path
                                                        d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z">
                                                    </path>
                                                </svg>
                                            </span>
                                            Subscribe for our newsletters and offer emails
                                        </label>

                                        <div class="messageBox"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-end">
                                <a href="javascript:void();" class="btn btn-danger delete-account">DELETE ACCOUNT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="update-profile-modal" tabindex="-1" role="dialog" aria-labelledby="update-profile-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('account.profile.update', $user) }}" id="edit-profile-form" enctype="multipart/form-data" method="post" novalidate="novalidate">
                    <div class="modal-body">
                        @csrf
                        @method('put')
                        <input type="hidden" name="profile-user-id" id="profile-user-id" value="{{ auth()->user()->id }}">
                        <div class="row no-gutters">
                            <input type="hidden" id="sessionReceived" name="sessionReceived" value="{{ session('allowSendgrid') !== null ? '1' : '0' }}">
                            <div class="col-lg-12 text-center">
                                <div class="text-center">
                                        <img src="{{ getAvatar(auth()->user()->avatar) }}" id="image_avatar" width="100"
                                            style="border-radius: 50%; height: 100px" onerror="defaultAvatar(this)">
                                    <input type="file" class="form-control my-3 w-50 mx-auto" name="avatar" accept="image/*" value="{{ old('avatar') ?? null }}"
                                        onchange="readURL(this);">
                                </div>
                            </div>
                            <div class="col-12 col-lg-7 col-xl-6 mb-2">
                                <div class="form-group px-1">
                                    <label for="title">Title </label>
                                    <select class="form-control title" name="title">
                                        <option value="Mr" {{ 'Mr' == auth()->user()->title ? 'selected' : '' }}>Mr</option>
                                        <option value="Mrs" {{ 'Mrs' == auth()->user()->title ? 'selected' : '' }}>Mrs</option>
                                        <option value="Miss" {{ 'Miss' == auth()->user()->title ? 'selected' : '' }}>Miss</option>
                                        <option value="Mx" {{ 'Mx' == auth()->user()->title ? 'selected' : '' }}>Mx</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-7 col-xl-6 mb-2">
                                <div class="form-group px-1">
                                    <label for="profile-first-name">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="profile-first-name" name="firstname" placeholder="First Name"
                                        value="{{ auth()->user()->first_name }}" required>
                                </div>
                            </div>
                            <div class="col-12 col-lg-7 col-xl-6 mb-2">
                                <div class="form-group px-1">
                                    <label for="profile-last-name">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="profile-last-name" name="lastname" placeholder="Last Name"
                                        value="{{ auth()->user()->last_name }}" required>
                                </div>
                            </div>
                            <div class="col-12 col-lg-7 col-xl-6 mb-2">
                                <div class="form-group px-1">
                                    <label for="profile-email">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="profile-email" placeholder="Email Address" value="{{ auth()->user()->email }}" required
                                        disabled>
                                    <input type="hidden" name="profile-email" id="profile-email-hidden" value="{{ auth()->user()->email }}">

                                </div>
                            </div>
                            <input type="hidden" id="user_email" name="user_email" value="{{ auth()->user()->email !== null ? auth()->user()->email : '' }}">
                            <div class="col-12 col-lg-7 col-xl-6 mb-2">
                                <div class="form-group px-1">
                                    <label for="date_of_birth">Date of Birth</label>
                                    <div id="date_wrapper">
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ auth()->user()->date_of_birth }}">

                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-7 col-xl-6 mb-2">
                                <div class="form-group px-1">
                                    <label for="profile-phone">Phone Number</label>
                                    <input type="text" class="form-control" id="profile-phone" placeholder="1234567890" name="phone"
                                        value="{{ auth()->user()->phone }}">
                                    <input type="hidden" name="phoneNumber" id="phoneNumber">
                                </div>
                            </div>
                            <div class="col-12 col-lg-12 col-xl-12 mb-2">
                                <div class="form-group px-1">
                                    <label for="profile-address">Address Line 1</label>
                                    <textarea name="address" id="address" class="form-control" rows="1">{{ auth()->user()->address }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 col-lg-12 col-xl-12 mb-2">
                                <div class="form-group px-1">
                                    <label for="profile-address-2">Address Line 2 (Optional)</label>
                                    <textarea name="address_2" id="address_2" class="form-control" rows="1">{{ auth()->user()->address_2 }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 col-lg-7 col-xl-6 mb-2">
                                <div class="form-group px-1">
                                    <label for="street">Town/City</label>
                                    <input type="text" class="form-control" id="street" placeholder="" name="street" value="{{ auth()->user()->street }}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-7 col-xl-6 mb-2">
                                <div class="form-group px-1">
                                    <label for="state">County/State/Province</label>
                                    <input type="text" class="form-control" id="state" placeholder="" name="state" value="{{ auth()->user()->metaData->where('type', 'state')->pluck('value')->first() }}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-7 col-xl-6 mb-2">
                                <div class="form-group px-1">
                                    <label for="country_id">Country</label>
                                    <select class="form-control country_id" name="country_id">
                                        <option value="">Other</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ $country->id == auth()->user()->country_id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-7 col-xl-6 mb-2">
                                <div class="form-group px-1">
                                    <label for="postal_code">Post Code</label>
                                    <input type="text" class="form-control" id="postal_code" placeholder="" name="postal_code" value="{{ auth()->user()->postal_code }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary text-uppercase" id="edit-profile-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-account-modal" tabindex="-1" role="dialog" aria-labelledby="delete-account-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center">Delete Account?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('account.users.destroy', $user->id) }}" class="delete-account-form" enctype="multipart/form-data" method="post" novalidate="novalidate">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="profile_user_id" id="profile-user-id" value="{{ auth()->user()->id }}">
                        <div class="row no-gutters">
                            <div class="col-12 mb-2">
                                <p class="mb-3">Once you delete your account, there's no getting it back. Make sure you want to do this.</p>
                                <div class="form-row">
                                    <div class="input-group-append float-end">
                                        <i class="far fa-eye toggle-password password-eye-icon show-hide-password" data-target="#password"></i>
                                    </div>
                                    <input id="password" type="password" name="password" class="form-control " placeholder="Confirm password" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div>
                            <button type="cancel" class="btn btn-primary text-uppercase cancel">CANCEL</button>
                        </div>
                        <div>
                        <button type="submit" class="btn btn-danger text-uppercase delete-account-confirm">YES, DELETE IT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    {{-- Vanilla JS and its jquery plugin for telephone input --}}

    <script src="{{ asset('admin-dashboard/telephone-dropdown/js/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('admin-dashboard/telephone-dropdown/js/intlTelInput-jquery.min.js') }}"></script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image_avatar')
                        .attr('src', e.target.result)
                        .css('border-radius', '50%').css('height', 100);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function checkValidPhone() {
            var regex = /^(\+1)?[-. ]?\(?[0-9]{3}\)?[-. ]?[0-9]{3}[-. ]?[0-9]{4}$/;
            $('#profile-phone').next(".error-message").remove();
            if (!regex.test($('#profile-phone').val())) {
                if (!$('#profile-phone').next(".error-message").length) {
                    $('#profile-phone').after("<div class='error-message error'>Please enter a valid phone number</div>");
                    $('.iti__flag-container').css('padding-bottom', '26px');
                }
                return 0;
            } else {
                $('#profile-phone').removeClass("error");
                $('#profile-phone').next(".error-message").remove();
                $("#edit-profile-submit").prop('disabled', false);
                $("#edit-profile-submit").removeAttr('style');
                $('.iti__flag-container').css('padding-bottom', '');
                return 1;
            }
        }

        function checkValidDateOfBirth() {
            var selectedDate = $("#date_of_birth").val();
            var selectedYear = parseInt(selectedDate.split("/")[2]);
            var currentDate = new Date();
            var currentYear = currentDate.getFullYear();

            $('#date_of_birth').next(".error-message").remove();
            if (currentYear - selectedYear < 18) {
                $('#date_of_birth').after("<div class='error-message error'>You must be at least 18 years old to register</div>");
                return false;
            } else {
                return true;
            }
        }

        // Password visibility
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

        // Subscribe newsletter
        function subscribeNewsletter() {
            var _token = $('meta[name="csrf-token"]').attr('content');
            var userId = $('#profile-user-id').val();
            var email = $("#profile-email-hidden").val();
            var type = 'profile-subscribe-newsletter';

            var submitBtn = $('.checkmark');
            var submitBtnHtml = submitBtn.html();
            submitBtnHtml = $(submitBtnHtml).hide();
            submitBtnHtml = submitBtnHtml[0].outerHTML;
            addButtonSpinner(submitBtn, submitBtnHtml);

            $("#user-profile-email-prefrence").html("Yes");
            $.ajax({
                url: "{{ route('subscribe-newsletter') }}",
                method: "POST",
                data: {
                    _token: _token,
                    profile_user_id: userId,
                    email: email,
                    type: type
                },
                success: function (response) {
                    if (response.status === 200) {
                        var newsletterSuccess = $('#newsletter_success');
                        setTimeout(function () {
                            newsletterSuccess.addClass('d-block');
                        }, 1000);
                        setTimeout(function () {
                            newsletterSuccess.removeClass('d-block');
                        }, 3000);
                    }
                    submitBtnHtml = $(submitBtnHtml).show();
                    submitBtnHtml = submitBtnHtml[0].outerHTML;
                    removeBtnDisabledClass(submitBtn, submitBtnHtml);
                },
                error: function (error) {
                    var newsletterSuccess = $('#newsletter_error');
                    setTimeout(function () {
                        newsletterSuccess.addClass('d-block');
                    }, 1000);
                    setTimeout(function () {
                        newsletterSuccess.removeClass('d-block');
                    }, 3000);
                    submitBtnHtml = $(submitBtnHtml).show();
                    submitBtnHtml = submitBtnHtml[0].outerHTML;
                    removeBtnDisabledClass(submitBtn, submitBtnHtml);
                }
            });
        }

        // Unsubscribe newsletter
        function unsubscribeNewsletter() {
            var _token = $('meta[name="csrf-token"]').attr('content');
            var userId = $('#profile-user-id').val();
            var email = $("#profile-email-hidden").val();
            var type = 'profile-unsubscribe-newsletter';

            var submitBtn = $('.checkmark');
            var submitBtnHtml = submitBtn.html();
            addButtonSpinner(submitBtn, submitBtnHtml);

            $("#user-profile-email-prefrence").html("NO");
            $.ajax({
                url: "{{ route('subscribe-newsletter') }}",
                method: "POST",
                data: {
                    _token: _token,
                    profile_user_id: userId,
                    email: email,
                    type: type
                },
                success: function (response) {
                    if (response.status === 200) {
                        var newsletterSuccess = $('#unsubscribe_success');
                        setTimeout(function () {
                            newsletterSuccess.addClass('d-block');
                        }, 1000);
                        setTimeout(function () {
                            newsletterSuccess.removeClass('d-block');
                        }, 3000);
                    }
                    removeBtnDisabledClass(submitBtn, submitBtnHtml);
                },
                error: function (error) {
                    var newsletterSuccess = $('#newsletter_error');
                    setTimeout(function () {
                        newsletterSuccess.addClass('d-block');
                    }, 1000);
                    setTimeout(function () {
                        newsletterSuccess.removeClass('d-block');
                    }, 3000);
                    removeBtnDisabledClass(submitBtn, submitBtnHtml);
                }
            });
        }

        // Update newsllet data
        function updateNewsletter() {
            var _token = $('meta[name="csrf-token"]').attr('content');
            var userId = $('#profile-user-id').val();
            var email = $("#profile-email-hidden").val();
            var type = 'update-newsletter';

            $.ajax({
                url: "{{ route('subscribe-newsletter') }}",
                method: "POST",
                data: {
                    _token: _token,
                    profile_user_id: userId,
                    email: email,
                    type: type
                },
                success: function(response) {},
                error: function(error) {}
            });
        }

        $("#edit-profile-submit").on("click", function(event) {
            event.preventDefault();
            phoneValidator = checkValidPhone();
            var validDateOfBirth = checkValidDateOfBirth();
            if (!phoneValidator || !validDateOfBirth) {
                event.preventDefault();
            } else {
                $("#edit-profile-form").submit();
            }
        });
        if ($("#user-profile-email-prefrence").html() === 'YES') {
            $('#subscribeNewsletter').prop('checked', true);
        }

        $(document).ready(function() {
            $("#subscribeNewsletter").on("change", function(event) {
                if ($('#subscribeNewsletter').is(":checked")) {
                    subscribeNewsletter();
                }

                if (!$('#subscribeNewsletter').is(":checked")) {
                    unsubscribeNewsletter();
                }
            });

            var sessionReceived = $('#sessionReceived').val();
            if (sessionReceived === '1' && $('#subscribeNewsletter').is(':checked')) {
                updateNewsletter();
            }

            $('.delete-account').on('click', function(event) {
                event.preventDefault();

                $('#delete-account-modal').modal('show');
                $('.toggle-password').click(togglePasswordVisibility);
            });

            $('#delete-account-modal').on('hidden.bs.modal', function (e) {
                $(this)
                    .find("input,textarea,select")
                    .val('')
                    .end()
                    .find("input[type=checkbox], input[type=radio]")
                    .prop("checked", "")
                    .end();
            });

            $('.cancel').on('click', function(event) {
                event.preventDefault();
                // $('.delete-account-form')[0].reset();
                $('#delete-account-modal').modal('hide');
            });

            // Validate and delete account
            $('.delete-account-form').validate({
                rules: {
                    password: {
                        required: true
                    },
                    message: {
                        password: {
                            required: "Password is required"
                        }
                    },
                    submitHandler: function (form) {
                        // Make subit button disabled
                        let newsletterBtn = $('.delete-account-confirm');
                        let submitBtnHtml = newsletterBtn.html();
                        addButtonSpinner(newsletterBtn, submitBtnHtml);

                        var _self = $(this);
                        var url = _self.attr('action');

                        // Use native DOM element to create FormData
                        var formdata = new FormData(this);

                        $.ajax({
                            url: url,
                            type: _self.attr('method'),
                            data: formdata,
                            processData: false, // Important to prevent jQuery from automatically processing the data
                            contentType: false, // Important to prevent jQuery from setting the Content-Type header
                            success: function(response) {
                                removeBtnDisabledClass(newsletterBtn, submitBtnHtml); // Make submit button enable
                            },
                            error: function(response) {
                                removeBtnDisabledClass(newsletterBtn, submitBtnHtml); // Make submit button enable
                            }
                        });
                    }
                }
            });
        });
    </script>
    <script>
        $(function() {
            var dateOfBirth = "{{ auth()->user()->date_of_birth }}";
            var formattedDate = formatDate(dateOfBirth);
            $("#date_of_birth").val(formattedDate);
        });
        flatpickr("#date_of_birth", {
            dateFormat: "d/m/Y",
            maxDate: "today",
            onChange: function(selectedDates, dateStr, instance) {
                var formattedValue = dateStr.split('/').reverse().join('-');
                document.getElementById('date_of_birth').setAttribute('data-display-value', dateStr);
                document.getElementById('date_of_birth').setAttribute('value', formattedValue);
            }
        });

        $('#profile-phone').on('keyup', function() {
            checkValidPhone();
        });

        $("#date_of_birth").on('change', function() {
            checkValidDateOfBirth();
        });

        function formatDate(date) {
            var parts = date.split("-");
            var year = parts[0];
            var month = parts[1];
            var day = parts[2];
            return day + "/" + month + "/" + year;
        }
        var flatpickrInstance = flatpickr("#date_of_birth", {
            dateFormat: "d/m/Y"
        });

        $('#update-profile-modal').on('show.bs.modal', function() {
            var selectedDate = $("#date_of_birth").val();
            flatpickrInstance.setDate(selectedDate, false);
            var input = document.querySelector("#profile-phone");
            const iti = window.intlTelInput(input, ({
                onlyCountries: ["us"],
                nationalMode:true,
                preferredCountries: [],
                utilsScript: "{{ asset('admin-dashboard/telephone-dropdown/js/utils.js') }}",
                separateDialCode:true,

            }));
            $('.iti').css('width', '100%');
            const handleChange = () => {
                let phoneNumber;
                if(input.value) {
                    if(iti.isValidNumber()){
                        phoneNumber = iti.getNumber();
                        $("#phoneNumber").val(phoneNumber);
                    }
                }
            }
            input.addEventListener('change', handleChange);
            input.addEventListener('keyup', handleChange);
            document.querySelector('#update-profile').addEventListener('click', handleChange);
        });

        $('#update-profile-btn').on('click', function() {
            var selectedDate = $("#date_of_birth").val();
            flatpickrInstance.setDate(selectedDate, false);
        });
        $('#update-profile-modal').on('hidden.bs.modal', function(){
                $('#profile-phone').removeClass("error");
                $('#profile-phone').next(".error-message").remove();
                $('#profile-phone').val("{{ auth()->user()->phone }}");
                $("#edit-profile-submit").prop('disabled', false);
                $("#edit-profile-submit").removeAttr('style');
                $('.iti__flag-container').css('padding-bottom', '');
        });
    </script>
@endpush
