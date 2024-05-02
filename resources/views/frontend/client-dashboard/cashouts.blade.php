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

                @include('frontend.client-dashboard.side-menu', ['page' => 'cashouts'])

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
                        <h4 class="section-title">Cashouts</h4>
                        <p class="section-para">On this page, you'll find your cashouts details.</p>
                    </div>

                    <form id="cashout-search-form" class="my-exitclick" novalidate="novalidate">
                        @csrf
                        <input type="hidden" name="cashout-page" id="cashout-page" value="0">
                        <div class="adv-filters row mt-3 mt-md-0 mb-4">
                            <div class="col-3 pe-md-1">
                                <select class="form-control payment_method" name="payment_method">
                                    <option value="">All Payment Method</option>
                                    <option value="paypal">Paypal</option>
                                    <option value="bank">Bank</option>
                                    @if (getImporterYMLSettings(config('app.charity_yaml_path')))
                                        <option value="charity">Chairty</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col px-md-1">
                                <select class="form-control" name="status" id="status">
                                    <option value="">Select Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                    <option value="donated">Donated</option>
                                </select>
                            </div>

                            <div class="col px-md-1">
                                <input type="text" autofill="off" autocomplete="off" class="form-control date_from datepicker55286 hasDatepicker" id="date_from1"
                                    name="date_from" placeholder="Start Date">
                                <input type="hidden" id="date_from" name="date_from">
                            </div>
                            <div class="col px-md-1">
                                <input type="text" autofill="off" autocomplete="off" class="form-control date_to datepicker55286 hasDatepicker" id="date_to1" name="date_to"
                                    placeholder="End Date">
                                <input type="hidden" id="date_to" name="date_to">
                            </div>

                            <div class="col mt-2 mt-md-0 text-md-end">
                                <button type="submit" class="btn btn-primary btn-xs">Search</button>
                            </div>
                        </div>
                    </form>

                    <div id="cashout-table"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

        <script type="text/javascript">
            setTimeout(function() {
                $("#date_from1").datepicker({
                    autoclose: true,
                    dateFormat: 'd MM yy',
                    startDate: '-300d'
                })

                $("#date_from1").change(function() {
                    var dateObject = $("#date_from1").datepicker('getDate');
                    var date = $.datepicker.formatDate('yy-mm-dd', dateObject);
                    $("#date_from").val(date);
                })
                $("#date_to1").datepicker({
                    autoclose: true,
                    dateFormat: 'd MM yy',
                    startDate: '-300d'
                })

                $("#date_to1").change(function() {
                    var dateObject = $("#date_to1").datepicker('getDate');
                    var date = $.datepicker.formatDate('yy-mm-dd', dateObject);
                    $("#date_to").val(date);
                })
            }, 1000);

            $(document).on('submit', '#cashout-search-form', function(e) {
                e.preventDefault();
                dateToLess();
                searchCashout();
            });

            function dateToLess() {
                date_from = new Date($("#date_from1").datepicker('getDate'));
                date_to = new Date($("#date_to1").datepicker('getDate'));
                if (date_from > date_to) {
                    $("#date_to1").datepicker('setDate', date_from);
                }
            }

            $(document).ready(function() {
                searchCashout();
            });


            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                var pageurl = new URL($(this).attr('href'));
                const page = pageurl.searchParams.get("page");
                $("#cashout-page").val(page);
                searchCashout();
            });

            function searchCashout() {
                var formData = $('#cashout-search-form').serialize();
                var page = $("#cashout-page").val();
                var requestUrl = '{{ route('account.search_cashout') }}';
                if (page != 0) {
                    requestUrl += '?page=' + page;
                }
                $.ajax({
                    type: 'post',
                    url: requestUrl,
                    data: formData,
                    dataType: 'html',
                    success: function(data) {
                        $('#cashout-table').html(data);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        </script>
    @endpush

@endsection
