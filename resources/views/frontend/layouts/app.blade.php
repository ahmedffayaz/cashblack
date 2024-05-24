@php $settings = SiteSetting(); @endphp

<!DOCTYPE html>
<html>
@include('frontend.layouts.includes.head')

<body class="h-100 before-login" data-user-id="{{ !empty(auth()->user()) ? auth()->user()->id : 0 }}">
    @include('frontend.layouts.includes.session_messages')
    <main class="flex-shrink-0">
        @include('frontend.layouts.includes.header')

        @yield('content')

        @include('frontend.layouts.includes.footer')

        <div class="responsive-menu-overlay"></div>
    </main>

    @include('frontend.layouts.includes.scripts')
    @include('frontend.layouts.includes.welcome-message')
    @auth
        <div class="d-lg-none d-xl-none">
            @include('frontend.client-dashboard.side-menu')
        </div>
    @endauth
    @include('frontend.layouts.includes.web-platform-modal')

    <script>
        function __debounce(func, wait, immediate) {
            var timeout;
            return function() {
                var context = this,
                    args = arguments;
                var later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        };

        $(document).on('keyup', '[name="search"]', __debounce(function(e) {
            e.preventDefault();

            let _self = $(this);
            let searchResultPlaceholder = _self.siblings('#search-results');

            if (e.keyCode == 27) {
                searchResultPlaceholder.html('');
                return;
            }

            if (e.keyCode == 8 || /[a-zA-Z0-9-_ ]/.test(String.fromCharCode(e.keyCode))) {
                searchResultPlaceholder.height('29px').html(`
            <ul class="search-suggestions ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all_new" role="listbox"
                style="left: 609px; width: 409px; top: 204px; z-index: 1001; height: 29px; overflow: auto;">
                <a class="ui-corner-all_new">
                    <li class="ui-menu-item" role="menuitem">Searching...</li>
                </a>
            </ul>
        `);

                $.ajax({
                    url: `{{ route('quick-search') }}`,
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        search: $(this).val(),
                    },
                    success: function(data) {
                        if (data.trim() !== '') {
                            searchResultPlaceholder.html(data);
                        } else {
                            searchResultPlaceholder.html(
                                '<ul class="search-suggestions ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all_new" role="listbox" style="left: 609px; width: 409px; top: 204px; z-index: 1001; height: 29px; overflow: auto;"><li class="ui-menu-item" role="menuitem">No result found</li></ul>'
                            );
                        }

                    }
                });
            }
        }, 200));


        $(document).mouseup(function(e) {
            let container = $('.header-search');

            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.find('#search-results').html('');
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            function clearAllNotification(action) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'GET',
                    url: '{{ route('clearNotifications') }}',
                    success: function(response) {
                        showUserNotification('');
                    },
                    error: function(response) {
                        console.log('fail');
                    }
                });
            }
            $('#clearAllNotification').click(function(e) {
                clearAllNotification();
            });
            $('#notificationDropdown').click(function(e) {
                showUserNotification('');
            });
            $('#viewAllNotification').click(function(e) {
                showUserNotification('view-all');
            });

            function showUserNotification(action) {
                var offset = 0;
                if (action === 'view-all') {
                    offset = parseInt(offset) + 10;
                    var attributeOffsetValue = parseInt($("#notification-offset").val()) + 10;
                    $("#notification-offset").val(attributeOffsetValue);
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '{{ route('userNotifications') }}',
                    data: {
                        offset: offset,
                    },
                    success: function(response) {
                        $(".notification-dropdown-div").html(response);
                        if (parseInt($("#notification-offset").val()) >= (parseInt($("#totalNotificationCount").val()) - 1)) {
                            $("#footer-notification").addClass("d-none");
                        } else {
                            $("#footer-notification").removeClass("d-none");
                        }
                    },
                    error: function(response) {
                        console.log('fail');
                    }
                });
            }
        });
        $(document).ready(function() {
            var dropdown = $('#dropdownMenuLink');
            var bellIcon = $('#notificationDropdown');
            var seeAllLink = $('#viewAllNotification');
            var notificationsContainer = $('.notification-dropdown-div');
            var clearAllNotification = $('#clearAllNotification');
            bellIcon.on('click', function(e) {
                e.stopPropagation();
                if (dropdown.attr('aria-expanded') === 'false') {
                    dropdown.dropdown('toggle');
                }
            });

            $(document).on('click', function(e) {
                if (
                    !bellIcon.is(e.target) &&
                    !seeAllLink.is(e.target) &&
                    !clearAllNotification.is(e.target) &&
                    !notificationsContainer.is(e.target) &&
                    notificationsContainer.has(e.target).length === 0
                ) {
                    dropdown.dropdown('hide');
                }
            });

            dropdown.on('click', function(e) {
                e.stopPropagation();
            });

            seeAllLink.on('click', function(e) {
                e.stopPropagation();
                e.preventDefault();
            });
            clearAllNotification.on('click', function(e) {
                e.stopPropagation();
                e.preventDefault();
            });
            notificationsContainer.on('click', '.activity-item', function(e) {
                e.stopPropagation();
            });
        });
    </script>

</body>

</html>
