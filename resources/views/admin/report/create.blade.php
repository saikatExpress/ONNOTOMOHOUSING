@extends('admin.layout.app')

@section('content')

    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <p class="text-right">
            <a class="btn btn-sm btn-success" href="{{ route('expense.list') }}">
                Expense List
            </a>
        </p>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Create Expense</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <form id="searchForm">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Share Holder</label>
                        <select name="holder_id" id="holderId" class="form-control">
                            <option value="" disabled selected>Select</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="">Amounty Type</label>
                    <select name="holder_id" id="holderId" class="form-control">
                        <option value="" disabled selected>Select</option>
                        <option value="credit">Credit</option>
                        <option value="debit">Debit</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">From</label>
                        <input type="date" name="from_date" id="fromDate" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">To</label>
                        <input type="date" name="to_date" id="toDate" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-sm btn-primary">Search</button>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="resultsTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Share Holder</th>
                            <th>Amount Type</th>
                            <th>Date</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Results will be appended here -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#resultsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('search') }}',
                    data: function(d) {
                        d.holder_id = $('#holderId').val();
                        d.amount_type = $('#amountType').val();
                        d.from_date = $('#fromDate').val();
                        d.to_date = $('#toDate').val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'holder_name', name: 'holder_name' },
                    { data: 'amount_type', name: 'amount_type' },
                    { data: 'date', name: 'date' },
                    { data: 'amount', name: 'amount' }
                ]
            });

            // Search form submit
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                table.draw();
            });
        });
    </script>

@endsection
