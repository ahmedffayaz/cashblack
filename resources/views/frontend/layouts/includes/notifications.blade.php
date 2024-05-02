<div class="notifications-container">
    <div id="notification-list" class="list-group list-group-alt">
        @if (!count($Notifications))
            <div class="p-1"> No Notification Found </div>
        @else
            @foreach ($Notifications as $notify)
                <div class="activity-item">
                    @if (isset($notify->data['url']))
                        <a href="{{ $notify->data['url'] }}">
                    @endif
                    <span class="text-center"><i class="fa fa-user text-success" aria-hidden="true"></i></span>
                    <div class="activity">
                        <p class="tx-12 text-muted">{{ $notify->data['title'] }}</p>
                        <strong>{{ $notify->data['body'] }}</strong>
                        <span> {{ Carbon\Carbon::createFromTimeStamp(strtotime($notify->created_at))->diffForHumans() }}</span>
                    </div>
                    </a>
                </div>
            @endforeach
        @endif
    </div>
</div>
