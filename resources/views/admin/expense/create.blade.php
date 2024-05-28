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

                <div class="card">
                    <div class="card-body" style="background-color: #fff; border-radius:4px; padding:5px 8px 5px;">
                        <form action="{{ route('cost.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">Cost Head <span class="text-sm text-danger"> * </span></label>
                                <select name="cost_head" class="form-control" id="">
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
                                <label for="">Cost Amount <span class="text-sm text-danger"> * </span></label>
                                <input type="number" name="cost_amount" class="form-control" placeholder="Cost Balance">
                                @error('cost_amount')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Cost Date <span class="text-sm text-danger"> * </span></label>
                                <input type="date" name="cost_date" class="form-control">
                                @error('cost_date')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Remark</label>
                                <textarea name="remark" class="form-control" placeholder="Write the cost purpouse"></textarea>
                                @error('remark')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary">Add Expense</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
