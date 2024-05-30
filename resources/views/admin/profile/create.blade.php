@extends('admin.layout.app')
<style>
    .profile_img img{
        width: 120px;
        height: 120px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .passwordGif img{
        width: 50px;
        height: 50px;
        margin-left: 20px;
        margin-top: 10px;
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
</style>
@section('content')

    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <p class="text-right">
            <a class="btn btn-sm btn-success" href="{{ route('admin.dashboard') }}">
                Back Home
            </a>
        </p>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Admin Profile</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-8">

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

                <div class="card" style="background-color: #fff; padding:5px 8px 5px; border-radius:4px;">
                    <div class="card-body">
                        <h1 style="text-align: center">Profile Updates</h1>

                        <div class="container">
                            <div class="post-container">
                                <p style="text-align: right;">
                                    <button type="button" class="btn btn-sm btn-primary" id="updatePasswordBtn" data-toggle="modal" data-target="#passwordModal">Update Password</button>
                                </p>
                                <div class="post-box">

                                    <div class="profile_img">
                                        @if (auth()->user()->profile_image)
                                            <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="User Image">
                                        @else
                                            <img src="{{ asset('logos/avatar-3637425_640.webp') }}" alt="User Image">
                                        @endif

                                        <h2 style="text-align: center;">{{ auth()->user()->name }}</h2>
                                        <p style="text-align: center;">
                                            <strong style="text-transform: uppercase;">{{ auth()->user()->role }}</strong>
                                        </p>
                                    </div>

                                    <hr>
                                    <form action="{{ route('admin_profile.update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Upload New Image</label>
                                            <input type="file" name="profile_image" class="form-control-file">
                                            @error('content')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="">Name <span class="text-sm text-danger"> * </span></label>
                                            <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="">Email <span class="text-sm text-danger"> * </span></label>
                                            <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Mobile <span class="text-sm text-danger"> * </span></label>
                                            <input type="tel" name="mobile" value="{{ auth()->user()->mobile }}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Whatsapp <span class="text-sm text-danger"> * </span></label>
                                            <input type="tel" name="whatsapp" value="{{ auth()->user()->whatsapp }}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Address</label>
                                            <textarea name="address" class="form-control">{{ auth()->user()->address }}</textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Update Info</button>
                                    </form>
                                </div>

                            </div>
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
                    <h4 class="modal-title" id="passwordModalLabel">Update Password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="passwordGif" id="passwordGif" style="display: none;">
                    <img src="{{ asset('GIF/new-loader.gif') }}" alt="">
                </div>
                <div class="modal-body">
                    <!-- Password update form goes here -->
                    <form id="passwordUpdateForm" action="{{ route('update.password') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Old Password</label>
                            <input type="password" name="old_password" id="oldPasword" class="form-control">
                            <span id="oldPassErr"></span>
                        </div>

                        <div class="form-group">
                            <label for="">New Password</label>
                            <input type="password" name="new_password" id="newPasword" class="form-control">
                            <span id="passErr"></span>
                        </div>

                        <div class="form-group">
                            <label for="">Confirm Password</label>
                            <input type="password" name="con_password" id="conPasword" class="form-control">
                            <span id="conPassErr"></span>
                        </div>

                        <button type="submit" class="btn btn-sm btn-primary">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function () {

            // Handle form submission
            $('#passwordUpdateForm').submit(function (event) {
                event.preventDefault();

                const newPasword = $('#newPasword').val();
                const conPasword = $('#conPasword').val();

                if(newPasword !== conPasword){
                    $('#conPassErr').html('New password and confirm password does not match..!').addClass('text-sm text-danger');
                    return false;
                }

                // Send AJAX request to update password
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    beforeSend: function(){
                        $('#passwordGif').hide();
                    },
                    complete: function(){
                        $('#passwordGif').show();
                    },
                    success: function (response) {
                        // Handle success response
                        alert('Password updated successfully!');

                        // Logout and redirect to login page
                        window.location.href = '/logout';
                    },
                    error: function (xhr) {
                       if (xhr.status === 400) {
                            const response = xhr.responseJSON;

                            if (response.errors) {
                                if (response.errors.old_password) {
                                    $('#oldPasswordError').html(response.errors.old_password[0]);
                                }
                                if (response.errors.new_password) {
                                    $('#newPasswordError').html(response.errors.new_password[0]);
                                }
                                if (response.errors.con_password) {
                                    $('#confirmPasswordError').html(response.errors.con_password[0]);
                                }
                            } else {
                                alert(response.error);
                            }
                        }
                    }
                });
            });

            $('#oldPasword').on('input', function(){
                var inputData = $(this).val();

                $.ajax({
                    url: '/check/password/' + inputData,
                    method: 'GET',
                    success: function(response){
                        if(response && response.success == true){
                            $('#oldPassErr').html('Password Matched').addClass('text-success').removeClass('text-danger');
                        }
                        if(response && response.error == false){
                            $('#oldPassErr').html('Password does not Matched').addClass('text-danger').removeClass('text-success');
                        }
                    },
                    error: function(){

                    }
                });
            });
        });
    </script>

@endsection



