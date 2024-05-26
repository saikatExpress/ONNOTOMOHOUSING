@extends('admin.layout.app')
@section('content')
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <p class="text-right">
            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#createCategoryModal">
                Create Category
            </button>
        </p>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User List</li>
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
                                <h3 class="box-title">Share Holder List</h3>
                            </div>
                            <div style="display: none;" id="paymentLoader">
                                <img style="width: 50px;height:50px;border-radius:50%;" src="{{ asset('GIF/new-loader.gif') }}" alt="Loading...">
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                       <tr>
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>
                                                @if ($category->status == 1)
                                                    <label for="" class="btn btn-sm btn-success">
                                                        Active
                                                    </label>
                                                @else
                                                    <label for="" class="btn btn-sm btn-warning">
                                                        Deactive
                                                    </label>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary editBtn"
                                                data-toggle="modal" data-target="#editCategoryModal" data-name="{{ $category->name }}"
                                                data-id="{{ $category->id }}">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="{{ $category->id }}">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <div class="image-preview" id="imagePreview"></div>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Rendering engine</th>
                                        <th>Browser</th>
                                        <th>Platform(s)</th>
                                        <th>Engine version</th>
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

    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCategoryModalLabel">Create Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('category.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="amount" class="form-label">Expense Head <span class="text-danger text-sm"> * </span></label>
                        <input type="text" name="category_head" class="form-control" id="category_head" required>
                        <span id="headErr" class="text-danger text-sm"></span>
                    </div>
                    <button style="margin-top: 10px;" type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPaymentModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('category.update') }}" method="POST">
                        @csrf
                        <input type="hidden" id="categoryId" name="cat_id">

                        <div class="mb-3">
                            <label for="amount" class="form-label">Expense Head <span class="text-danger text-sm"> * </span></label>
                            <input type="text" name="cat_head" class="form-control" id="catHead" required>
                            <span id="headErr" class="text-danger text-sm"></span>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button style="margin-top: 10px;" type="submit" class="btn btn-primary">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $(document).ready(function(){
            $(document).on('click', '.editBtn', function(){
                var id   = $(this).data('id');
                var name = $(this).data('name');

                $('#categoryId').val(id);
                $('#catHead').val(name);
            });

            $(document).on('click', '.deleteBtn', function(){
                var categoryId = $(this).data('id');
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
                            url: '/delete/category/' + categoryId, // Adjust the URL to match your route
                            type: 'GET',
                            data: {
                                _token: '{{ csrf_token() }}' // Laravel CSRF token
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Category has been deleted.',
                                        'success'
                                    );
                                    // Remove the row from the table
                                    $row.remove();
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'There was an error deleting the category.',
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
