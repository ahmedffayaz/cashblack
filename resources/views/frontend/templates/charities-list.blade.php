@if (isset($charities) && !empty($charities))
    <section class="more_charities_  pb-5">
        <div class="container">
            <div class="d-sm-flex justify-content-between flex-wrap flex-md-nowrap">
                <div class="mb-4">
                    <h4 class="heading mb-0"></h4>
                    <p class="mb-0"></p>
                </div>
                <form action="{{ route('charities.search') }}" class="is-alter search_form" method="POST">
                    @csrf
                    <div class="mb-4">
                        <div class="d-sm-flex">
                            <div class="sort-option dropdown">
                                <select name="country" class="form-control filter-by  w_20_" id="country">
                                    <option value="">Filter By Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" {{ !isset($countryId) ? '' : ($countryId == $country->id ? 'selected' : '') }}>{{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sort-option dropdown">
                                <select name="charity_types_id" class="form-control filter-by w_20_" id="charity_types_id">
                                    <option value="">Filter By Type</option>
                                    @foreach ($charityTypes as $charityType)
                                        <option value="{{ $charityType->id }}" {{ !isset($charity) ? '' : ($charity == $charityType->id ? 'selected' : '') }}>
                                            {{ $charityType->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="charity-search-results" class="">
            </div>

        </div>
    </section>

    <div class="modal fade" id="charity-details-modal" tabindex="-1" role="dialog" aria-labelledby="charity-details-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

@endif
@push('scripts')
    <script>
        let charityModal = $('#charity-details-modal');

        // Function to open the modal and load charity details
        function openCharityModal(charitySlug) {
            $.ajax({
                url: `{{ url('charities') }}` + '/' + charitySlug,
                method: "POST",
                data: {
                    _token: $('input[name=_token]').val()
                },
                success: function(data) {
                    charityModal.find('.modal-content').html(data);
                    charityModal.modal('show');
                }
            });
        }

        // Check if the URL contains #charitySlug on page load
        $(document).ready(function() {
            if (window.location.hash) {
                let charitySlug = window.location.hash.substring(1); // Remove the leading #
                openCharityModal(charitySlug);
            }
        });

        // Handle charity card click event
        $(document).on('click', '.charity-card', function(e) {
            e.preventDefault();
            let charitySlug = $(this).attr('data-slug');

            // Update the URL with #charitySlug
            window.location.hash = charitySlug;

            // Open the modal and load charity details
            openCharityModal(charitySlug);
        });

        // Handle modal close event
        charityModal.on('hidden.bs.modal', function () {
            // Remove #charitySlug from the URL
            history.pushState("", document.title, window.location.pathname + window.location.search);
        });
    </script>

    <script>
        function searchCharity() {
            var formData = $('.search_form').serialize();
            $.ajax({
                type: 'POST',
                url: 'charity/search',
                data: formData,
                dataType: 'html',
                success: function(data) {
                    $('#charity-search-results').html(data);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
        $(document).ready(function() {
            searchCharity()
            $(document).on('change', '.search_form', function() {
                searchCharity();
            });
        });

        $(document).on('click', '.page-link', function(event) {
            event.preventDefault();
            var pageurl = $(this).attr('href');
            var _token = $("input[name=_token]").val();
            $.ajax({
                type: 'POST',
                url: pageurl,
                data: {
                    _token: _token
                },
                dataType: 'html',
                success: function(data) {
                    $('#charity-search-results').html(data);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    </script>
@endpush
