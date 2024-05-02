@extends('frontend.layouts.app')

@section('title', 'Tickets')

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
                        <div class="row mb-4">
                            <div class="col-lg-6 col-md-6">
                                <h4 class="section-title">Support Tickets</h4>
                                <p class="section-para mb-3">On this page, you can manage your support tickets.</p>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <a href="{{ route('account.tickets.create') }}" class="btn btn-primary float-button text-uppercase">Open a Ticket</a>
                            </div>
                        </div>
                    </div>

                    @include('flash::message')

                    <div class="dashboard__panel border mb-4">
                        <div class="table-responsive">
                            <table class="table align-middle cashback-table">
                                <thead>
                                    <tr>
                                        <th>Ticket ID</th>
                                        <th>Store</th>
                                        <th>Order Amount</th>
                                        <th>Ticket Type</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (auth()->user()->claims->count() <= 0)
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <h5>No Ticket found.</h5>
                                                <a href="{{ route('account.tickets.create') }}" class="btn btn-primary btn-xs mt-4">Open a Ticket</a>
                                            </td>
                                        </tr>
                                    @endif
                                    @foreach (auth()->user()->claims as $claim)
                                        <tr>
                                            <td><a href="{{ route('account.tickets.show', $claim->ticket_id) }}">{{ $claim->ticket_id }}</a></td>
                                            <td>{{ optional($claim->store)->name }}</td>
                                            <td>{{ currency($claim->claim_amount) }}</td>
                                            <td class="text-capitalize">{{ $claim->claim_type }}</td>
                                            <td>{{ Carbon\Carbon::parse($claim->created_at)->isoFormat('Do MMMM YYYY') }}</td>
                                            <td>
                                                @if ($claim->status == 'open')
                                                <span class="badge badge-success">open</span>
                                                @elseif($claim->status == 'pending')
                                                    @if ($claim->lastReply->user_id == auth()->user()->id)
                                                    <span class="badge badge-primary">Replied</span>
                                                    @else
                                                    <span class="badge badge-warning">Awaiting your reply</span>

                                                    @endif
                                                @elseif($claim->status == 'closed')
                                                <span class="badge badge-info"> Closed</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
