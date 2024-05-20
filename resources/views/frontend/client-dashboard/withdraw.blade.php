@extends('frontend.layouts.app')

@section('title', 'Dashboard')

@push('styles')
    <style>
        @media (min-width: 768px) {
            .category-listing.store-listing.list-view .brand-name {
                flex: 0 0 300px !important;
            }
        }

        .charity_donation {
            position: absolute;
            font-size: 12px;
            top: 22px;
            right: 30px;
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

                @include('frontend.client-dashboard.side-menu', ['page' => 'wallet'])

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
                        <div class="row">
                            <div class="col-lg-8">
                                <h4 class="section-title">Request Cashout</h4>
                                <p class="section-para">You can withdraw your earned cashback in a variety of ways.</p>
                            </div>
                            <div class="col-lg-4 text-center">
                                <h5>
                                    Balance
                                    {{ currency(auth()->user()->availableBalance(3)) }}
                                </h5>
                                </p>Select a payment method</p>
                            </div>
                        </div>
                    </div>

                    @include('flash::message')

                    <ul class="category-listing fav-stores store-listing list-view mt-3">
                        @if (SiteSetting()['payment_method_paypal'])
                            <li class="list-item li-items">
                                <div class="category-item__logo" style="margin: auto;">
                                    <img src="{{ asset('frontend/images/logos/paypal-logo.png') }}" alt="PayPal">
                                </div>
                                <div class="category-item__detail">
                                    <div class="brand-name media-screen-set">
                                        <span>Receive payment using an email address</span>
                                        <span class="upto-offer">Minimum withdrawal {{ currency(getMinimumCashoutAmount()) }}</span>
                                    </div>
                                    <form action="{{ route('account.cashout') }}" id="paypal_withdraw_form" class="m-auto" method="post">
                                        @csrf
                                        <div class="d-flex align-items-center">
                                            <div class="text-center">
                                                <button class="btn btn-primary btn-lg {{ isWithdrawalAllowed() == 2 ? 'withdraw_submit paypal' : 'disabled' }}">
                                                    Withdraw
                                                </button>
                                                @if (isWithdrawalAllowed() != 2)
                                                    <div class="mt-2 mb-0 pb-0 text-danger">{{ isWithdrawalAllowed() }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <input type="hidden" name="payment_method" value="paypal">
                                    </form>
                                </div>
                            </li>
                        @endif
                        @if (SiteSetting()['payment_method_charity'] && getImporterYMLSettings(config('app.charity_yaml_path')))
                            <li class="list-item li-items">
                                <div class="category-item__logo" style="margin: auto;">
                                    <h5>Cashblack Giveback</h5>
                                </div>
                                <div class="category-item__detail">
                                    <div class="brand-name">
                                        <span>Free & Secure</span>
                                        <span class="upto-offer">Minimum withdrawal {{ currency(getMinimumCashoutAmount()) }}</span>
                                    </div>
                                    <div class="d-flex align-items-center  m-auto">
                                        <div class="text-center">
                                            <button class="btn btn-primary btn-lg  {{ isWithdrawalAllowed() == 2 ? 'start_donation' : 'disabled' }}" id="charity-modal-show">
                                                Withdraw
                                            </button>
                                            @if (isWithdrawalAllowed() != 2)
                                                <div class="mt-2 mb-0 pb-0 text-danger">{{ isWithdrawalAllowed() }}</div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div id="charity-modal" class="modal fade run-model" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg ">
            <div class="modal-content" id="quickview-modal-content">
                <div class="quickview pt-5" style="padding: 20px">
                    <h3 class="text-center">Submit Cashout Request</h3>
                    <button type="button" class="btn-close charity_donation" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="container-fluid">

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

                        <form action="{{ route('account.CharityCashout') }}" id="charity_withdraw_form" class="form-validate" method="POST">
                            @csrf
                            <div class="row g-4 pt-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <p>
                                            With Cashblack Giveback, when you choose to donate your cashback to one of your affiliate
                                            charities, goodwill causes or community interests companies, we'll match your donation 100%
                                        </p>
                                        <h5 class="text-center">It Means When You Give, We Give</h5>
                                    </div>
                                </div>
                                <input type="hidden" name="payment_method" value="charity">
                                <div class="col-12 py-3">
                                    <div class="form-group">
                                        <label class="d-inline-block " for="charity_types_id"><strong class="p-2">Select Charity: </strong></label>
                                        <select name="charity_types_id" class="form-control form-select form-control-sm d-inline-block" style="width: auto;"
                                            id="charity_types_id" required>
                                            <option disabled selected>Any</option>
                                            @foreach ($charities as $charity)
                                                <option value="{{ $charity->id }}">
                                                    {{ $charity->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="cart">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Store</th>
                                                    <th> Order Amount</th>
                                                    <th>Cashback</th>
                                                    <th>Date</th>
                                                    <th>Giveback Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($usercashback as $cashback)
                                                    @if ($cashback->user_id == auth()->user()->id)
                                                        <tr>
                                                            <td>
                                                                @if ($cashback->store_id)
                                                                    <p>{{ null !== $cashback->store ? $cashback->store->name : "-" }}</p>

                                                                @else
                                                                    {{ ucfirst(str_replace('_', ' ', $cashback->type)) }}
                                                                @endif
                                                            </td>
                                                            <td> {{ currency($cashback->order_value) }}</td>
                                                            <td> {{ currency($cashback->amount) }}</td>
                                                            <td> {{ Carbon\Carbon::parse($cashback->event_date)->isoFormat('Do MMMM YYYY') }}</td>
                                                            <td class="text-center"> <input type="checkbox" id="cashout_id" class="cashout_id checkbox" name="id[]"
                                                                value="{{ encrypt($cashback->id) }}" data-amount="{{ $cashback->amount }}" required>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="row justify-content-end pt-3">
                                            <div class="col-12 col-md-7 col-lg-6 col-xl-5">
                                                <table class="cart__totals" style="width: 80%">
                                                    <thead class="cart__totals-header">
                                                        <tr>
                                                            <th>
                                                                <strong>Total Donation:</strong>
                                                            </th>
                                                            <td>{{ getCurrencySymbol() }}</td>
                                                            <td id="sum" class="text-center"></td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group float-right">
                                            <button class="btn btn-primary withdraw_submit" type="button">Cashout Now</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.withdraw_submit', function(e) {
            e.preventDefault();
            var form_id = $(this).closest("form").attr('id');
            var action = $(this).closest("form").attr('action');
            var method = $(this).closest("form").attr('method');
            swal({
                title: 'Withdraw',
                text: 'Are you sure you want to withdraw?',
                icon: 'info',
                buttons: {
                    cancel: {
                        text: 'Cancel',
                        value: null,
                        visible: true,
                        className: '',
                        closeModal: true,
                    },
                    confirm: {
                        text: 'Withdraw',
                        value: true,
                        visible: true,
                        className: '',
                        closeModal: true
                    }
                },
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then(function(result) {
                if (result) {
                    $("#" + form_id).submit();
                } else {
                    swal('Withdrawal Cancelled', '', 'error');
                }
            }).catch(function(error) {
                console.log(error);
            });
        });
        $('#charity-modal-show').on('click', function() {
            $('#charity-modal').modal('show');
        });

        $('.cashout_id').on('change', function() {
            var val = parseFloat($(this).data("amount"));
            if ($(this).prop('checked') === true) {
                if ($('#sum').html() != '') {
                    val = parseFloat(val) + parseFloat($('#sum').html());
                }
                $('#sum').html(val.toFixed(2));
            } else {
                val = parseFloat($('#sum').html()) - parseFloat(val);
                $('#sum').html(val.toFixed(2));
            }

        });
    </script>
@endpush
