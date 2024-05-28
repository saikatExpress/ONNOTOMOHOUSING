@extends('admin.layout.app')
@section('content')
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <p class="text-right">
            <a class="btn btn-sm btn-success" href="{{ route('create.expense') }}">
                Create Expense
            </a>
        </p>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Expense List</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    @if (session('error'))
                        <div class="alert alert-danger text-white">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('message'))
                        <div class="alert alert-success" id="successMessage">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="box">
                            <div class="box-header">
                            <h3 class="box-title">Expense List</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Expense ID</th>
                                        <th>Cost Head</th>
                                        <th>Amount</th>
                                        <th>Cost Date</th>
                                        <th>Added By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expenses as $expense)
                                       <tr>
                                            <td>{{ $expense->id }}</td>
                                            <td>{{ $expense->categories->name }}</td>
                                            <td>{{ number_format($expense->cost_amount) }}</td>
                                            <td>{{ date('d M - Y', strtotime($expense->cost_date)) }}</td>
                                            <td>{{ $expense->admin->name }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary editBtn"
                                                    data-toggle="modal" data-id="{{ $expense->id }}"
                                                    data-costhead="{{ $expense->categories->id }}"
                                                    data-costamount="{{ $expense->cost_amount }}"
                                                    data-costdate="{{ $expense->cost_date }}"
                                                    data-remark="{{ $expense->remark }}" data-target="#editModal">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="{{ $expense->id }}">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Rendering engine</th>
                                        <th>Browser</th>
                                        <th>Platform(s)</th>
                                        <th>Engine version</th>
                                        <th>CSS grade</th>
                                        <th>Actions grade</th>
                                    </tr>
                                </tfoot>
                            </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Expense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Modal content (e.g., form) -->
                    <form id="editForm" action="{{ route('expense.edit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="expenseId" id="expenseId">

                        <div class="form-group">
                            <label for="">Cost Head <span class="text-sm text-danger"> * </span></label>
                            <select name="cost_head" class="form-control" id="costType">
                                <option value="" disabled selected>Select</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('cost_head')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="costDate">Cost Amount</label>
                            <input type="number" class="form-control" id="costAmount" name="cost_amount">
                            @error('cost_amount')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="costDate">Cost Date</label>
                            <input type="date" class="form-control" id="costDate" name="cost_date">
                            @error('cost_date')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="amount">Remark</label>
                            <textarea name="remark" id="remark" class="form-control"></textarea>
                            @error('remark')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary" id="saveChanges">Save changes</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $(document).ready(function(){
            $(document).on('click', '.editBtn', function(){
                var id = $(this).data('id');
                var costHead = $(this).data('costhead');
                var costAmount = $(this).data('costamount');
                var costDate = $(this).data('costdate');
                var remark = $(this).data('remark');

                var formattedDate = new Date(costDate).toISOString().substring(0, 10);

                $('#expenseId').val(id);
                $('#costType').val(costHead);
                $('#costAmount').val(costAmount);
                $('#remark').val(remark);
                $('#costDate').val(formattedDate);
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $(document).on('click', '.deleteBtn', function(){
                var expenseId = $(this).data('id');
                var $row = $(this).closest('tr'); // Save the reference to the row for later

                // Show SweetAlert confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Make the AJAX request to delete the payment
                        $.ajax({
                            url: '/delete/expense/' + expenseId, // Adjust the URL to match your route
                            type: 'GET',
                            data: {
                                _token: '{{ csrf_token() }}' // Laravel CSRF token
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Expense has been deleted.',
                                        'success'
                                    );
                                    // Remove the row from the table
                                    $row.remove();
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'There was an error deleting the expense.',
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'There was an error deleting the category.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
