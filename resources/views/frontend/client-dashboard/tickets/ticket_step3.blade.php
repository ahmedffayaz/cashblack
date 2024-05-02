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
                        <p class="mb-3">Please enter your order amount and describe your claim:</p>
                    </div>
                    @include('flash::message') 
                    <form action="{{ route('account.tickets.update', $claim) }}" method="post">
                        @csrf
                        @method('put')
                        <input type="hidden" name="click_id" value="{{ $click_id }}">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <label for="amount">Order Amount</label>
                                <input type="number" class="form-control icon mail-icon valid" name="amount" id="amount" placeholder="Order Amount" min="1"
                                    step="0.01" data-msg-required="Order amount is required." required aria-invalid="false" aria-label="Order Amount">
                            </div>
                            <div class="col-12 mb-2">
                                <label for="amount">Description</label>
                                <textarea class="form-control icon mail-icon valid" name="product" id="product" placeholder="Describe your claim" rows="6" aria-label="Description"
                                    data-msg-required="Description is required." required aria-invalid="false"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-xs mt-4">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
