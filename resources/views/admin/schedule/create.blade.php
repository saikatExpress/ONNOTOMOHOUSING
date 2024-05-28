@extends('admin.layout.app')

@section('content')

    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <p class="text-right">
            <a class="btn btn-sm btn-success" href="{{ route('schedule.list') }}">
                Schedule List
            </a>
        </p>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Create Schedule</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <h2>Create Reminder</h2>

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
                        <form action="{{ route('schedule.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">Select</label>
                                <select name="holder_id" id="" class="form-control">
                                    <option value="" disabled selected>Select</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('holder_id')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Task Name</label>
                                <input type="text" name="task_name" class="form-control" placeholder="Task name">
                                @error('task_name')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Schedule Date</label>
                                <input type="date" name="schedule_date" class="form-control">
                                @error('schedule_date')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Remark</label>
                                <textarea name="remark" class="form-control"></textarea>
                                @error('remark')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-sm btn-primary">Create Schedule</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
