<!-- search_results.blade.php -->

@if (isset($payments) && $payments->count() > 0)
    <h3>Payment Results:</h3>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>HOLDER ID</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Status</th>
                <th>Approved By</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ date('d M - Y', strtotime($payment->created_at)) }}</td>
                    @if ($payment->is_approve == 1)
                        <td>
                            <label for="" class="btn btn-sm btn-success">Approved</label>
                        </td>
                    @else
                        <td>
                            <label for="" class="btn btn-sm btn-danger">Pending</label>
                        </td>
                    @endif

                    @if ($payment->approve_by != NULL)
                        <td>
                            <label for="" class="btn btn-sm btn-primary">
                                {{ App\Models\User::where('id', $payment->approve_by)->value('name') }}
                            </label>
                        </td>
                    @else
                        <td>
                            <label for="" class="btn btn-sm btn-warning">
                                Not Approved yet..!
                            </label>
                        </td>
                    @endif
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No payment results found.</p>
@endif
