<div class="dashboard__panel border mb-4">
    <div class="table-responsive">
        <table class="table align-middle click-table">
            <thead>
                <tr>
                    <th>Store</th>
                    <th>Conversion</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @if ($clicks->count() <= 0)
                    <tr>
                        <td colspan="2" class="text-center py-5">
                            <h5>No visits activity found.</h5>
                            <p>Your stores visits activity will be listed here.</p>
                        </td>
                    </tr>
                @endif
                @foreach ($clicks as $click)
                    <tr>
                        <td><a href="{{ route('stores.show', $click->store->slug) }}" target="_blank">{{ $click->store->name }}</a></td>
                        <td> {!! isset($click->cashback) ? '<span class="tb-status badge badge-success">Purchase</span>' : '<span class="tb-status badge badge-danger">No Purchase</span>' !!}</td>
                        <td>{{ formatDateTimezone($click->created_at, 'Do MMMM YYYY, hh:mm A') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="page-bottom-actions position-relative mt-5">
    {!! $clicks->links() !!}
</div>
