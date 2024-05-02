<section>
    <div class="container pb-5">
        <div class="row">
            <div class="content-area">
                <div class="filter-sort">
                    <div class="listing-actions">
                        <div class="result-preview-option">
                            <a href="javascript:;" id="gridview" class="grid-view view-btn active"></a>
                            <a href="javascript:;" id="listview" class="list-view view-btn"></a>
                        </div>
                        <form action="{{ route('stores.view') }}" class="is-alter search_form {{ isset($letter) ? 'd-none' : '' }}" method="POST">
                            @csrf
                            <input type="hidden" name="perPage" id="perPage" value="12">
                            <input type="hidden" name="viewType" id="viewType" value="grid-view">
                            <input type="hidden" name="letter" id="letter" value="{{ $letter }}">
                            <input type="hidden" name="storesType" id="storesType" value="{{ isset($storesType) ? $storesType : '' }}">
                            <div class="sort-option dropdown">
                                <select class="form-control filter-by btn sort-btn select_search" name="orderBy" id="">
                                    <option value="">Default</option>
                                    <option value="name-asc" id="name-asc">Name (A-Z)</option>
                                    <option value="name-desc" id="name-desc">Name (Z-A)</option>
                                    <option value="id-desc" id="new-desc">Newest to Oldest</option>
                                    <option value="popularity" id="popularity">Popularity</option>
                                    <option value="cashback-amount-desc" id="cashback-amount-desc">Cashback Amount</option>
                                    <option value="cashback-percentage-desc" id="cashback-percentage-desc">Cashback Percentage</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    @if (!isset($storesType))
                        <ul class="alphabet-filter">
                            <li class="{{ empty(request()->input('letter')) ? 'active' : '' }}">
                                <a href="{{ route('stores.index', ['page' => request()->input('page')]) }}">All</a>
                            </li>
                            <li class="letter">
                                <a href="{{ route('stores.index', ['letter' => '0-9']) }}">0-9</a>
                            </li>
                            @foreach (range('A', 'Z') as $letter)
                                <li class="{{ request()->input('letter') == $letter ? 'active' : '' }}">
                                    <a href="{{ route('stores.index', ['letter' => $letter]) }}">{{ $letter }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div id="stores-view"></div>
                <div class="position-relative d-flex justify-content-between flex-wrap flex-sm-nowrap pagination-wrap">
                    <nav aria-label="Page navigation example"></nav>
                    <div class="per-page-select">
                        <label>Stores per page</label>
                        <select id="stores_per_page">
                            <option value="12" selected="">12</option>
                            <option value="24">24</option>
                            <option value="48">48</option>
                        </select>
                    </div>
                </div>
            </div>
        </div> <!-- row [end] -->
    </div>
</section>
@push('scripts')
    <script>
        function storesView(page) {
            var formData = $('.search_form').serialize();
            var requestUrl = '{{ route('stores.view') }}';

            if (page != 0) {
                requestUrl += '?page=' + page;
            }
            $('#stores-view').html(
                `<div class="text-center">
                    <img src="{{ asset('storage/__asset/img/loading_light_mode.gif') }}" alt="Loading..." style="margin: 100px; width: 60px; height: 60px;">
                </div>`
            );

            $.ajax({
                type: 'post',
                url: requestUrl,
                data: formData,
                dataType: 'html',
                success: function(data) {
                    $('#stores-view').html(data);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

        $(document).ready(function() {
            storesView(0)
            $(document).on('change', '.select_search', function() {
                storesView(0);
            });

            $(document).on('click', '.page-link', function(event) {
                event.preventDefault();
                var pageurl = new URL($(this).attr('href'));
                const page = pageurl.searchParams.get("page");
                storesView(page);
            });
            $(document).on('change', "#stores_per_page", function(e) {
                $('#perPage').val($("#stores_per_page").val());
                storesView();
            });
        });
    </script>
@endpush
