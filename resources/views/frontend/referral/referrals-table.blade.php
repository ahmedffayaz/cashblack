<div class="dashboard__panel border mb-4">
    <div class="table-responsive">
        <table class="table align-middle referrel-table">
            <thead>
                <tr class="text-center">
                    <th>User ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Register Date</th>
                    <th>Verified Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if ($referrals->count() <= 0)
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <h5>No Referrals found.</h5>
                            <p>Once you start referring your referrence will be listed here.</p>
                        </td>
                    </tr>
                @endif
                @foreach ($referrals as $referral)
                    <tr class="text-center">
                        <td>{{ $referral->id }}</td>
                        <td>{{ $referral->first_name }}</td>
                        <td>{{ $referral->last_name }}</td>
                        <td>{{ formatDateTimezone($referral->referred_at, 'Do MMMM YYYY') }}</td>
                        <td>{!! isset($referral->is_email_verified) ? '<span class="tb-status badge badge-primary">Yes</span>' : '<span class="tb-status badge badge-danger">No</span>' !!}</td>
                        <td>
                            @if ($referral->status == 'active')
                                <span class="badge badge-success">{{ ucfirst($referral->status) }}</span>
                            @elseif($referral->status == 'pending')
                                <span class="badge badge-info">{{ ucfirst($referral->status) }}</span>
                            @elseif($referral->status == 'in-active')
                                <span class="badge badge-warning">{{ ucfirst(referral->status) }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="page-bottom-actions position-relative mt-5">
    {!! $referrals->links() !!}
</div>
