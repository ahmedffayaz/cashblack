@extends('frontend.layouts.app')

@section('title', 'Dashboard')

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

                @include('frontend.client-dashboard.side-menu', ['page' => 'dashboard'])

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
                        <h4 class="section-title">Dashboard</h4>
                        <p class="section-para">On this page, you'll find a snapshot of your funds and account activity.</p>
                    </div>

                    <div class="stats-overview">
                        <div class="items-row">
                            <div class="stats-overview__item">
                                <div class="info-box box-red">
                                    <h4 class="info-box__title">Pending</h4>
                                    <p class="short-info">Transactions tracked by Cashblack and awaiting retailer confirmation.</p>
                                    <div class="totals">
                                        <h5 class="amount-number">{{ currency(auth()->user()->availableBalance(1)) }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="stats-overview__item">
                                <div class="info-box box-olive">
                                    <h4 class="info-box__title">Confirmed</h4>
                                    <p class="short-info">Transactions confirmed by the retailer and awaiting cashouts.</p>
                                    <div class="totals">
                                        <h5 class="amount-number">{{ currency(auth()->user()->availableBalance(3)) }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="stats-overview__item">
                                <div class="info-box box-blue">
                                    <h4 class="info-box__title">Processing</h4>
                                    <p class="short-info">Transactions in process of cashouts or donation.</p>
                                    <div class="totals">
                                        <h5 class="amount-number">{{ currency(auth()->user()->availableBalance(5)) }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="stats-overview__item">
                                <div class="info-box box-green">
                                    <h4 class="info-box__title">Total</h4>
                                    <p class="short-info">Total sum of all your debit and credit amounts. </p>
                                    <div class="totals">
                                        <h5 class="amount-number">{{ currency(auth()->user()->availableBalance()) }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="total_cashback_payout_">
                        <div class="text-actions mt-3 mb-4">
                            <div class="text-wrap">
                                <h5 class="title-md">Total Cashback Due: {{ currency(auth()->user()->availableBalance(3)) }}</h5>
                            </div>
                            @if (
                                $user->cashouts->count() == 0 &&
                                    auth()->user()->availableBalance(3) < getSpecificSetting('min_cashout_amount'))
                                <p>
                                    <small>You did not reach at cashout limit. You need {{ currency(getMinimumCashoutAmount()) }} more cashback to get cashout</small>
                                </p>
                            @else
                                <div class="actions">
                                    <a href="{{ route('account.withdraw.index') }}" class="btn btn-secondary btn-md text-uppercase">Request Cashout</a>
                                </div>
                            @endif

                        </div>

                    </div>

                    <div class="dashboard__panel border table-responsive mb-4">
                        <div class="text-actions p-4">
                            <div class="text-wrap">
                                <h5 class="title-md d-flex align-items-center">
                                    <span class="title-icon me-2">
                                        <img src="{{ asset('storage/__asset/img/dashboard-icons/history-icon.png') }}" alt="History icon">
                                    </span>
                                    Recent Cashback
                                </h5>
                            </div>
                            <div class="actions">
                                <a href="{{ route('account.cashback') }}" class="btn btn-primary text-uppercase">View All</a>
                            </div>
                        </div>

                        @if ($items->count() > 0)
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Store</th>
                                        <th>Order Amount</th>
                                        <th>Cashback</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td width="33%" class="ps-4">
                                                @if ($item->store_id)
                                                    <a href="{{ route('stores.show', $item->store->slug) }}" target="_blank">{{ $item->store->name }}</a>
                                                @else
                                                    {{ ucfirst(str_replace('_', ' ', $item->type)) }}
                                                @endif
                                            </td>
                                            <td class="text-blue">{{ currency($item->order_value) }}</td>
                                            <td>{{ currency($item->amount) }}</td>
                                            <td class="pe-4 text-center">{{ formatDateTimezone($item->event_date, 'Do MMMM YYYY') }}</td>
                                            <td>{{ formatDateTimezone($item->event_date, 'h:mm A') }}</td>
                                            <td>
                                                @if ($item->type == 'welcome_bonus')
                                                    <span class="badge badge-primary">confirmed</span>
                                                @elseif ($item->statusMap)
                                                    {!! statusBadges($item->statusMap->status) !!}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-12 mb-4">
                            <div class="dashboard__panel border">
                                <div class="text-actions p-4">
                                    <div class="text-wrap">
                                        <h5 class="title-md d-flex align-items-center">
                                            <span class="title-icon me-2">
                                                <img src="{{ asset('storage/__asset/img/dashboard-icons/click-history-icon.png') }}" alt="History icon">
                                            </span>
                                            Latest Store Visits
                                        </h5>
                                    </div>
                                    <div class="actions">
                                        <a href="{{ route('account.clicks') }}" class="btn btn-primary text-uppercase">View All</a>
                                    </div>
                                </div>
                                @if (auth()->user()->clicks->count() > 0)
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th>Store</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (auth()->user()->clicks()->whereHas('store')->limit(5)->get() as $click)
                                                <tr>
                                                    <td width="50%" class="ps-4">
                                                        <a href="{{ route('stores.show', $click->store->slug) }}" target="_blank">{{ $click->store->name }}</a>
                                                    </td>
                                                    <td>{{ formatDateTimezone($click->created_at, 'Do MMMM YYYY, h:mm A') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 col-lg-12 mb-4">
                            <div class="dashboard__panel border">
                                <div class="text-actions p-4">
                                    <div class="text-wrap">
                                        <h5 class="title-md d-flex align-items-center">
                                            <span class="title-icon me-2">
                                                <img src="{{ asset('storage/__asset/img/dashboard-icons/latest-cashout-icon.png') }}" alt="History icon">
                                            </span>
                                            Latest Cashouts
                                        </h5>
                                    </div>
                                    <div class="actions">
                                        <a href="{{ route('account.cashouts') }}" class="btn btn-primary text-uppercase">View All</a>
                                    </div>
                                </div>
                                @if ($user->cashouts->count() > 0)
                                    <table class="table align-middle">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Amount</th>
                                                <th>Type</th>
                                                <th>Payment Method</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user->cashouts()->latest()->limit(5)->get() as $cashout)
                                                <tr class="text-center">
                                                    <td>{{ currency($cashout->amount) }}</td>
                                                    @if($cashout->payment_method == 'paypal')
                                                        <td>PayPal</td>
                                                        <td>PayPal</td>
                                                    @else
                                                        <td>{{ ucfirst(str_replace('charity', 'Giveback', $cashout->payment_method)) }}</td>
                                                        <td>{{ ucfirst(str_replace('charity', 'Giveback', $cashout->payment_method)) }}</td>
                                                    @endif
                                                    <td>{{ formatDateTimezone($cashout->created_at, 'Do MMMM YYYY, h:mm A') }}</td>
                                                    <td>
                                                        @if ($cashout->status)
                                                            {!! statusBadges($cashout->status) !!}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
