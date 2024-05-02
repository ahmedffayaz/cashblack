<div class="dashboard__panel border mb-4">
    <div class="table-responsive">
        <table class="table align-middle cashout-table">
            <thead>
                <tr class="text-center">
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Payment Method</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if ($cashouts->count() <= 0)
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <h5>No Cashout found.</h5>
                            <p>Once you start withdraw amount your record will be listed here.</p>
                        </td>
                    </tr>
                @endif
                @foreach ($cashouts as $cashout)
                    <tr class="text-center">
                        <td>{{ currency($cashout->amount) }}</td>
                        @if($cashout->payment_method == 'paypal')
                            <td>PayPal</td>
                            <td>PayPal</td>
                        @else
                            <td>{{ ucfirst(str_replace('charity', 'Giveback', $cashout->payment_method)) }}</td>
                            <td>{{ ucfirst(str_replace('charity', 'Giveback', $cashout->payment_method)) }}</td>
                        @endif
                        <td>{{ formatDateTimezone($cashout->created_at, 'Do MMMM YYYY, h:mm A') }}</td>
                        <td>
                            @if ($cashout->status)
                                @if ($cashout->status == 'confirmed')
                                    <span class="badge badge-primary">{{ ucfirst($cashout->status) }}</span>
                                @elseif($cashout->status == 'paid')
                                    <span class="badge badge-success">{{ ucfirst($cashout->status) }}</span>
                                @elseif($cashout->status == 'failed')
                                    <span class="badge badge-danger">{{ ucfirst($cashout->status) }}</span>
                                @elseif($cashout->status == 'pending')
                                    <span class="badge badge-info">{{ ucfirst($cashout->status) }}</span>
                                @elseif($cashout->status == 'donated')
                                    <span class="badge badge-secondary">{{ ucfirst($cashout->status) }}</span>
                                @elseif($cashout->status == 'processing donation')
                                    <span class="badge badge-light">{{ ucfirst($cashout->status) }}</span>
                                @elseif($cashout->status == 'processing')
                                    <span class="badge badge-warning">{{ ucfirst($cashout->status) }}</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="page-bottom-actions position-relative mt-5">
    {!! $cashouts->links() !!}
</div>
