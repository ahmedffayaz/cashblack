<div class="dashboard__panel border mb-4">
    <div class="table-responsive">
        <table class="table align-middle cashback-table">
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
                @if ($cashbacks->count() <= 0)
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <h5>No Cashack found.</h5>
                            <p>Once you start earning cashback your transactions will be listed here.</p>
                        </td>
                    </tr>
                @endif
                @foreach ($cashbacks as $cashback)
                    <tr>
                        <td>
                            @if ($cashback->store_id && $cashback->store)
                                <a href="{{ route('stores.show', $cashback->store->slug) }}" target="_blank">{{ $cashback->store->name }}</a>
                            @else
                                {{ ucfirst(str_replace('_', ' ', $cashback->type)) }}
                            @endif
                        </td>
                        <td>{{ currency($cashback->order_value) }}</td>
                        <td>{{ currency($cashback->amount) }}</td>
                        <td>{{ formatDateTimezone($cashback->event_date, 'Do MMMM YYYY') }}</td>
                        <td>{{ formatDateTimezone($cashback->event_date, 'h:mm A') }}</td>
                        <td>
                            @if ($cashback->type == 'welcome_bonus')
                                <span class="badge badge-primary">Confirmed</span>
                            @elseif ($cashback->statusMap)
                                {!! statusBadges($cashback->statusMap->status) !!}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="page-bottom-actions position-relative mt-5">
    {!! $cashbacks->links() !!}
</div>
