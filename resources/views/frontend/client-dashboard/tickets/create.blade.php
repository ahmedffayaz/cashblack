@extends('frontend.layouts.app')

@section('title', 'Open a Ticket')

@push('styles')
    <style>
        .form-check-label {
            cursor: pointer;
        }

        .unstyled-list {
            list-style: unset;
            padding: 0 0 0 35px;
            margin: auto;
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

                @include('frontend.client-dashboard.side-menu', ['page' => 'tickets'])

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
                    <div class="col-md-12 row" style="">
                        <div class="col-md-8 mt-2">
                            <p style="margin-right: 10px;">If your query is non-cashback related, please contact us using the contact form.</p>
                        </div>
                        <div class="col-md-4 pr-0 form-ticket">
                            <a href="{{ route('contact.index') }}" class="btn btn-primary btn-xs mb-2">Contact us</a>
                        </div>
                    </div>
                    <div class="section-title-wrap">
                        <h4 class="section-title pt-3">Open a Ticket</h4>
                        <p class="section-para">To start the ticket process, select the retailer and type of ticket you wish to open.</p>
                        <p class="mb-3">Please select the retailer you would like to enquire about.</p>
                    </div>

                    @include('flash::message')

                    <form action="{{ route('account.tickets.step2') }}" method="post">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="store_id" class="mb-2">Select retailer</label>
                                <select id="store_id" class="form-control form-control-select2" name="store_id" required>
                                    <option selected disabled value="">Select a retailer..</option>

                                    @foreach ($clicks->unique('store_id') as $click)
                                        <option value="{{ $click->store_id }}">{{ $click->store->name ?? $click->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="accordion" id="ticket-types-accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="missing-cashback">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-missin-cashback"
                                                aria-expanded="true" aria-controls="collapse-missin-cashback">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="claim_type" value="missing cashback" checked required>
                                                        Missing cashback
                                                        <br>
                                                        <small class="text-muted">You made a purchase more than 1 days ago but it's not showing in your account</small>
                                                    </label>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse-missin-cashback" class="accordion-collapse collapse show" aria-labelledby="missing-cashback"
                                            data-bs-parent="#ticket-types-accordion">
                                            <div class="accordion-body">
                                                <p>
                                                    As your purchase didn't originally track this now becomes a manual process that on average can take up to 6
                                                    months to confirm your cashback.
                                                </p>
                                                <p>
                                                    To help us process your claim as quickly and efficiently as possible we will require certain information from
                                                    your email confirmation receipt, please have this to hand when submitting a claim.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="declined-cashback">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-declined-cashback"
                                                aria-expanded="false" aria-controls="collapse-declined-cashback">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="claim_type" value="declined cashback" required>
                                                        Declined cashback
                                                        <br>
                                                        <small class="text-muted">Your cashback was declined</small>
                                                    </label>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse-declined-cashback" class="accordion-collapse collapse" aria-labelledby="declined-cashback"
                                            data-bs-parent="#ticket-types-accordion">
                                            <div class="accordion-body">
                                                <p>Cashback can be declined for a variety of reasons such as:</p>
                                                <ul class="unstyled-list my-1">
                                                    <li>You used an unauthorised voucher</li>
                                                    <li>You didn't meet the terms set on the retailer page</li>
                                                    <li>Your purchase wasn't covered by the cashback rates</li>
                                                </ul>
                                                <p>If you feel that the above doesn't apply to you please continue to make a claim.</p>
                                                <p>
                                                    To help us process your claim as quickly and efficiently as possible we will require certain information from
                                                    your email confirmation receipt, please have this to hand when submitting a claim.
                                                </p>
                                                <p>
                                                    The claim process is a manual process that on average can take up to 4 months for the retailer to review their
                                                    decision.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="incorrect-amount">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-incorrect-amount"
                                                aria-expanded="false" aria-controls="collapse-incorrect-amount">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="claim_type" value="incorrect amount" required>
                                                        Incorrect Amount
                                                        <br>
                                                        <small class="text-muted">Your cashback is at tracked, confirmed or paid status but it's the wrong amount</small>
                                                    </label>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse-incorrect-amount" class="accordion-collapse collapse" aria-labelledby="incorrect-amount"
                                            data-bs-parent="#ticket-types-accordion">
                                            <div class="accordion-body">
                                                <p> Cashback can be lower than expected for the following reasons:</p>
                                                <ul class="unstyled-list my-1">
                                                    <li>Some retailers don't pay cashback on VAT or additional charges or taxes</li>
                                                    <li>Some retailers don't pay cashback on delivery charges</li>
                                                    <li>Some retailers track purchases at a low rate and then uplift them to the correct rate on confirmation</li>
                                                    <li>
                                                        You used an unauthorised voucher code in your purchase (In some cases a retailer may make a discretionary
                                                        cashback payment for use of codes)
                                                    </li>
                                                </ul>
                                                <p>If you feel that the above doesn't apply to you please continue to make a claim.</p>
                                                <p>
                                                    The claim process is a manual process that on average can take up to 4 months for the retailer to review their
                                                    decision.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-xs mt-4">Next</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.accordion-button').on('click', function(e) {
            e.preventDefault();

            $(this).find('input[name="claim_type"]').prop('checked', true);
        });
    </script>
@endpush
