@extends('admin.layout.app')
@section('content')
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <p class="text-right">
            <a class="btn btn-sm btn-success" href="{{ route('create.announce') }}">
                Create Announce
            </a>
        </p>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Announce List</li>
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
                            <h3 class="box-title">Announce List</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Announce ID</th>
                                        <th>Title</th>
                                        <th>Announce Date</th>
                                        <th>Added By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($announces as $announce)
                                       <tr>
                                            <td>{{ $announce->id }}</td>
                                            <td>{{ $announce->title }}</td>
                                            <td>{{ date('d M - Y', strtotime($announce->announce_date)) }}</td>
                                            <td>{{ $announce->creator->name }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary announceEditBtn"
                                                    data-toggle="modal" data-id="{{ $announce->id }}"
                                                    data-announcedate="{{ $announce->announce_date }}" data-title="{{ $announce->title }}"
                                                    data-description="{{ $announce->description }}" data-target="#editModal">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger announceDeleteBtn" data-id="{{ $announce->id }}">Delete</button>
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
                    <h5 class="modal-title" id="editModalLabel">Edit Announce</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Modal content (e.g., form) -->
                    <form id="editForm" action="{{ route('announce.edit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="announceId" id="announceId">

                        <div class="form-group">
                            <label for="costDate">Title</label>
                            <input type="text" class="form-control" id="annoucetitle" name="title">
                            @error('title')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="amount">Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                            @error('description')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="costDate">Announce Date</label>
                            <input type="date" class="form-control" id="aDate" name="announce_date">
                            @error('announce_date')
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
            $(document).on('click', '.announceEditBtn', function(){
                var id = $(this).data('id');
                var title = $(this).data('title');
                var description = $(this).data('description');
                var announcedate = $(this).data('announcedate');

                var formattedDate = new Date(announcedate).toISOString().substring(0, 10);

                $('#announceId').val(id);
                $('#annoucetitle').val(title);
                $('#description').val(description);
                $('#aDate').val(formattedDate);
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $(document).on('click', '.announceDeleteBtn', function(){
                var announceId = $(this).data('id');
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
                            url: '/delete/announce/' + announceId, // Adjust the URL to match your route
                            type: 'GET',
                            data: {
                                _token: '{{ csrf_token() }}' // Laravel CSRF token
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Announce has been deleted.',
                                        'success'
                                    );
                                    // Remove the row from the table
                                    $row.remove();
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'There was an error deleting the Announce.',
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'There was an error deleting the Announce.',
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
