@extends('frontend.layouts.app')

@section('title', 'Open a Ticket')

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

                    <div class="section-title-wrap">
                        <h4 class="section-title">Open a Ticket</h4>
                        <p class="section-para">Please follow the instructions below.</p>
                        <p class="mb-3">Please select a record you wish to claim.</p>
                    </div>

                    @include('flash::message')

                    @if ($claim == 'missing cashback')
                        <form action="{{ route('account.tickets.step3') }}" method="POST">
                            @csrf

                            <input type="hidden" name="claim_type" value="{{ $claim }}">

                            <table class="table align-middle cashback-table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Date/Time</th>
                                        <th>Order Amount</th>
                                        <th>Cashback Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($clicks->count() <= 0)
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <h5>No Data found.</h5>
                                                <a href="{{ route('account.tickets.create') }}" class="btn btn-primary btn-xs mt-4">Go back</a>
                                            </td>
                                        </tr>
                                    @endif
                                    @foreach ($clicks as $click)
                                        <tr>
                                            <td class="text-center">
                                                <input type="radio" name="click_id" class="form-check-input" value="{{ $click->id }}" id="click_id-{{ $click->id }}"
                                                    required>
                                            </td>
                                            <td>
                                                <label for="click_id-{{ $click->id }}">
                                                    {{ formatDateTimezone($click->created_at, 'Do MMMM YYYY hh:mm:ss') }}
                                                </label>
                                            </td>
                                            <td><small><i>Not Available</i></small></td>
                                            <td><small><i>Not Available</i></small></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary btn-xs mt-4">Next</button>
                        </form>
                    @endif

                    @if ($claim == 'incorrect amount' || $claim == 'declined cashback')
                        <form action="{{ route('account.tickets.step3') }}" method="post">
                            @csrf

                            <input type="hidden" name="claim_type" value="{{ $claim }}">

                            <table class="table align-middle cashback-table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Date</th>
                                        <th>Order Amount</th>
                                        <th>Cashback Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($cashback->count() <= 0)
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <h5>No Data found.</h5>
                                                <a href="{{ route('account.tickets.create') }}" class="btn btn-primary btn-xs mt-4">Go back</a>
                                            </td>
                                        </tr>
                                    @endif
                                    @foreach ($cashback as $cashback)
                                        <tr>
                                            <td class="text-center">
                                                <input type="radio" name="click_id" value="{{ $cashback->exit_click_id }}" id="click_id-{{ $cashback->exit_click_id }}"
                                                    required>
                                            </td>
                                            <td>
                                                <label for="click_id-{{ $cashback->exit_click_id }}">
                                                    {{ Carbon\Carbon::parse($cashback->event_date)->isoFormat('Do MMMM YYYY') }}
                                                </label>
                                            </td>
                                            <td>{{ currency($cashback->order_value) }}</td>
                                            <td>{{ currency($cashback->amount) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary btn-xs mt-4">Next</button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
