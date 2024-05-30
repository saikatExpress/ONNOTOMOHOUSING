@extends('admin.layout.app')
@section('content')

    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <p class="text-right">
            <a class="btn btn-sm btn-success" href="{{ route('schedule.list') }}">
                Post List
            </a>
        </p>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Create Post</li>
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
                        <h1 style="text-align: center">Building Updates</h1>

                        <div class="container">
                            <div class="post-container">
                                <div class="post-box">
                                    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <textarea name="content" class="form-control" placeholder="What's on your mind?" required></textarea>
                                            @error('content')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">
                                                <i class="fa-solid fa-link"></i> Link
                                            </label>
                                            <input type="text" class="form-control" name="post_link">
                                            <label for="">You can insert an link</label>
                                        </div>
                                        <div class="form-group">
                                            <label for="imageUpload" class="custom-file-upload">
                                                <i class="fas fa-image"></i> Image
                                            </label>
                                            <input id="imageUpload" type="file" name="image" class="form-control-file">
                                            @error('image')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="videoUpload" class="custom-file-upload">
                                                <i class="fas fa-video"></i> Video
                                            </label>
                                            <input id="videoUpload" type="file" name="video" class="form-control-file">
                                            @error('video')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add Post</button>
                                    </form>
                                </div>

                                <div class="posts-list mt-4">
                                    @foreach ($posts as $post)
                                        @include('admin.post.partials.partialpost', ['post' => $post])
                                        <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
