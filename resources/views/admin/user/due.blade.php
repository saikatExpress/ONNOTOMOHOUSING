@extends('admin.layout.app')
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
                                        <th>Current Balance</th>
                                        <th>Mobile</th>
                                        <th>Whatsapp</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                       <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td class="text-danger text-bold">{{ $user->current_balance }}</td>
                                            <td>{{ $user->mobile }}</td>
                                            <td>{{ $user->whatsapp }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary">Edit</button>
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
@endsection
