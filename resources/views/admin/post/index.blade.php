@extends('admin.layout.app')
@section('content')
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <p class="text-right">
            <a class="btn btn-sm btn-success" href="{{ route('create.post') }}">
                Create Post
            </a>
        </p>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Post List</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    @if (session('error'))
                        <div class="alert alert-danger text-white" id="errorAlert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('message'))
                        <div class="alert alert-success" id="successAlert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="box">
                            <div class="box-header">
                            <h3 class="box-title">Post List</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>POST ID</th>
                                        <th>Post</th>
                                        <th>Post Date</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                       <tr>
                                            <td>{{ $post->id }}</td>
                                            <td>{{ $post->content }}</td>
                                            <td>{{ date('d M - Y', strtotime($post->created_at)) }}</td>
                                            <td>{{ $post->created_by }}</td>
                                            <td>
                                                <a href="{{ route('post.edit', ['id' => $post->id]) }}" class="btn btn-sm btn-primary">
                                                    Edit
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="{{ $post->id }}">Delete</button>
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
                    <h5 class="modal-title" id="editModalLabel">Edit Schedule</h5>
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
                            <label for="">Task Name</label>
                            <input type="text" class="form-control" name="taskName" id="tname">
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
                var taskName = $(this).data('taskName');
                var costAmount = $(this).data('costamount');
                var costDate = $(this).data('costdate');
                var remark = $(this).data('remark');

                // var formattedDate = new Date(costDate).toISOString().substring(0, 10);

                $('#expenseId').val(id);
                $('#tname').val(taskName);
                $('#costAmount').val(costAmount);
                $('#remark').val(remark);
                // $('#costDate').val(formattedDate);
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $(document).on('click', '.deleteBtn', function(){
                var postId = $(this).data('id');
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
                            url: '/delete/post/' + postId, // Adjust the URL to match your route
                            type: 'GET',
                            data: {
                                _token: '{{ csrf_token() }}' // Laravel CSRF token
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Post has been deleted.',
                                        'success'
                                    );
                                    // Remove the row from the table
                                    $row.remove();
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'There was an error deleting the post.',
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'There was an error deleting the post.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Automatically hide success message after 2 seconds
            setTimeout(function() {
                $('#successAlert').fadeOut('slow');
            }, 2000);

            // Automatically hide error message after 2 seconds
            setTimeout(function() {
                $('#errorAlert').fadeOut('slow');
            }, 2000);
        });
    </script>
@endsection
