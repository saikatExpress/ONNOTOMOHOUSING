<!-- search_results.blade.php -->

@if (isset($expenses) && $expenses->count() > 0)
    <h3>Expense Results:</h3>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>HOLDER ID</th>
                <th>Cost Type</th>
                <th>Amount</th>
                <th>Expense Date</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenses as $expense)
                <tr>
                    <td>{{ $expense->user_id }}</td>
                    <td>{{ $expense->cost_amount }}</td>
                    <td>{{ $expense->cost_amount }}</td>
                    <td>{{ date('d M - Y', strtotime($expense->expense_date)) }}</td>
                    <td>{{ $expense->remark }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No payment results found.</p>
@endif
