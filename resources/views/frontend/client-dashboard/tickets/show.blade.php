@extends('frontend.layouts.app')

@section('title', 'Ticket Details')

@push('styles')
    <style>
        hr {
            background-color: #666;
            border: 0 none;
            color: #666;
            height: 2px;
        }

        .category-listing .list-item {
            display: block;
        }

        .odd-row {
            background-color: #f7f6fb;
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

                    <div class="section-title-wrap">
                        <h4 class="section-title">Ticket # {{ $ticket->ticket_id }}</h4>
                        <p class="section-para">We've received your ticket. Please allow up to six months to get a decision from the retailer.</p>
                    </div>

                    @include('flash::message')

                    <div class="dashboard__panel border mb-4">
                        <div class="table-responsive">
                            <table class="table align-middle cashback-table">
                                <thead>
                                    <tr>
                                        <th>Store</th>
                                        <th>Order Amount</th>
                                        <th>Ticket Type</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ optional($ticket->store)->name }}</td>
                                        <td>{{ currency($ticket->claim_amount) }}</td>
                                        <td class="text-capitalize">{{ $ticket->claim_type }}</td>
                                        <td>{{ Carbon\Carbon::parse($ticket->created_at)->isoFormat('Do MMMM YYYY') }}</td>
                                        <td>
                                            @if ($ticket->status == 'open')
                                                <span class="badge badge-success">open</span>
                                            @elseif($ticket->status == 'pending')
                                                @if ($ticket->lastReply->user_id == auth()->user()->id)
                                                    <span class="badge badge-primary">Replied</span>
                                                @else
                                                    <span class="badge badge-warning">Awaiting your reply</span>
                                                @endif
                                            @elseif($ticket->status == 'closed')
                                                <span class="badge badge-info"> Closed</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if (!empty($ticket->message))
                        <div class="panel rounded-border mb-3">
                            <h3 class="heading mb-2">Ticket Description</h3>
                            <p>{{ $ticket->message }}</p>
                        </div>
                    @endif
                    <ul class="category-listing store-listing list-view">
                        <li class="list-item li-items">

                            @foreach ($ticket->replies as $reply)
                                <div class="row">
                                    <div class="col-12 mb-2 py-2 px-3" style="background-color: #f7f6fb; border-radius: 5px;">
                                        <p>
                                            @if ($reply->reply_by == 'admin')
                                                <b class="{{ $reply->reply_by == 'admin' ? 'text-primary' : '' }}">
                                                    Cashblack Customer Support
                                                </b>
                                            @else
                                                <b>
                                                    {{ $reply->user->first_name }} {{ $reply->user->last_name }}
                                                </b>
                                            @endif

                                            <small style="float: right;">
                                                <i>
                                                    {{ Carbon\Carbon::createFromTimeStamp(strtotime($reply->created_at))->diffForHumans() }}
                                                </i>
                                            </small>
                                        </p>
                                        <p>{{ $reply->reply }}</p>
                                    </div>
                                </div>
                            @endforeach

                            @if ($ticket->replies->count() > 0)
                                <hr>
                            @endif

                            @if ($ticket->status != 'closed')
                                <form method="post" action="{{ route('account.replies.store') }}" novalidate="novalidate">
                                    @csrf

                                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                                    <h5 class="mb-3">Reply</h5>

                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <textarea type="text" class="form-control icon mail-icon valid" name="reply" id="reply" placeholder="Leave your reply" required
                                                data-msg-required="Reply field is required." aria-invalid="false" aria-label="Leave your reply" rows="5"></textarea>
                                        </div>
                                    </div>

                                    <div class="cta text-center d-grid">
                                        <button class="btn btn-primary btn-lg rounded-pill text-uppercase">Submit</button>
                                    </div>
                                </form>
                            @endif
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
@endsection
