@extends('admin.layout.app')
<style>
    .user_box img{
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .passBox{
        margin: 5px 8px 5px;
        padding: 5px 8px 5px;
    }
</style>
@section('content')
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <p class="text-right">
            <a class="btn btn-sm btn-success" href="{{ route('create.user') }}">
                Create User
            </a>
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
                            <!-- /.box-header -->
                            <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>USER ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Cash Deposite</th>
                                        <th>Current Balance</th>
                                        <th>Whatsapp</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                       <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ number_format($user->total_deposite_balance) }}</td>
                                            @if ($user->current_balance < 0)
                                                <td class="text-danger">
                                                    {{ number_format($user->current_balance) }}
                                                </td>
                                            @else
                                                <td class="text-success">
                                                    {{ number_format($user->current_balance) }}
                                                </td>
                                            @endif
                                            <td>
                                                <a href="https://wa.me/880{{ $user->whatsapp }}" target="_blank">
                                                    {{ $user->whatsapp }}
                                                </a>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary editBtn"
                                                data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                                data-email="{{ $user->email }}" data-status="{{ $user->status }}"
                                                data-mobile="{{ $user->mobile }}" data-whatsapp="{{ $user->whatsapp }}"
                                                data-toggle="modal" data-target="#passwordModal">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger">Delete</button>
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

    <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="passwordModalLabel">Update User Info</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="user_box">
                    <img src="{{ asset('logos/avatar-3637425_640.webp') }}" alt="">
                    <h2 style="text-align: center;" id="userName"></h2>
                    <p style="text-align: center;">
                        <button type="button" class="btn btn-sm btn-primary" id="updatePass">
                            Update Password
                        </button>
                    </p>

                    <div id="passBox" class="passBox" style="display: none;">
                        <form id="userUpdatePassForm" action="{{ route('password.user') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="">Set Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                                <span class="text-sm text-danger" id="errMsg"></span>
                            </div>

                            <button type="submit" class="btn btn-sm btn-primary">Update Password</button>
                        </form>

                        <span class="text-sm text-success" id="passSuccess"></span>
                    </div>
                </div>
                <hr>
                <div class="modal-body">
                    <form action="{{ route('user.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="userId" id="userId">
                        <div class="form-group">
                            <label for="old_password">Name <span class="text-sm text-danger"> * </span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <span id="nameErr"></span>
                        </div>

                        <div class="form-group">
                            <label for="new_password">Email <span class="text-sm text-danger"> * </span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <span id="newPasswordError"></span>
                        </div>

                        <div class="form-group">
                            <label for="con_password">Mobile <span class="text-sm text-danger"> * </span></label>
                            <input type="tel" class="form-control" id="mobile" name="mobile" required>
                            <span id="mobileError"></span>
                        </div>

                        <div class="form-group">
                            <label for="con_password">Whatsapp <span class="text-sm text-danger"> * </span></label>
                            <input type="tel" class="form-control" id="whatsapp" name="whatsapp" required>
                            <span id="whatsappError"></span>
                        </div>

                        <div class="form-group">
                            <label for="con_password">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="" selected disabled>Select</option>
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>
                            <span id="status"></span>
                        </div>

                        <button type="submit" class="btn btn-primary">Update User</button>
                        <span id="successMessage" class="success-message"></span>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $(document).on('click', '.editBtn', function(){
                const id = $(this).data('id');
                const name = $(this).data('name');
                const email = $(this).data('email');
                const mobile = $(this).data('mobile');
                const whatsapp = $(this).data('whatsapp');
                const status = $(this).data('status');

                $('#userId').val(id);
                $('#name').val(name);
                $('#userName').html(name);
                $('#email').val(email);
                $('#mobile').val(mobile);
                $('#whatsapp').val(whatsapp);
                $('#status').val(status);
            });
            $(document).on('click', '#updatePass', function(){
                $('#passBox').toggle();
                var userId = $('#userId').val();
            });

            $('#userUpdatePassForm').on('submit', function(e){
                e.preventDefault();
                var password = $('#password').val();
                var userId = $('#userId').val();

                if(password == ''){
                    $('#errMsg').html('Please enter password');
                    return false;
                }

                var token = $('input[name="_token"]').val();

                var data = {
                    userId: userId,
                    password: password,
                    _token: token
                };

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: data,
                    success: function(response){
                        if(response && response.success == true){
                            $('#passSuccess').html('Password update successfully');
                        }
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endsection
