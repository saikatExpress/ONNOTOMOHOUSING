@extends('admin.layout.app')
<style>
    .post-container {
        max-width: 700px;
        margin: auto;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 10px;
    }

    .post-box {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .post-box .form-group {
        margin-bottom: 15px;
    }

    .post-box textarea {
        resize: none;
        width: 100%;
        height: 100px;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
    }

    .custom-file-upload {
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
        color: #007bff;
    }

    .custom-file-upload i {
        margin-right: 5px;
    }

    .video-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 */
        height: 0;
        overflow: hidden;
        max-width: 100%;
        background: #000;
        margin-top: 10px;
    }

    .video-container video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .img-fluid {
        max-width: 100%;
        height: auto;
    }

    .rounded {
        border-radius: .25rem;
    }

    .rounded.mb-2 {
        margin-bottom: .5rem;
    }

    .invalid-feedback {
        display: block;
    }
</style>

@section('content')

    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <p class="text-right">
            <a class="btn btn-sm btn-success" href="{{ route('post.list') }}">
                Post List
            </a>
        </p>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Edit Post</li>
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
                            <div class="card" style="background-color: #fff; padding:5px 8px 5px; border-radius:4px;">
                                <div class="card-body">
                                    <h1 style="text-align: center">Edit Building Update</h1>
                                    <div class="post-container">
                                        <div class="post-box">
                                            <form action="{{ route('post.update') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                <div class="form-group">
                                                    <textarea name="content" class="form-control" placeholder="What's on your mind?" required>{{ $post->content }}</textarea>
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
                                                    <input type="text" class="form-control" name="post_link" value="{{ $post->post_link }}">
                                                    <label for="">You can insert a link</label>
                                                </div>
                                                <div class="form-group">
                                                    <label for="currentImage">Current Image</label>
                                                    @if($post->image)
                                                        <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded mb-2" alt="Post Image">
                                                    @else
                                                        <p>No image uploaded</p>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="imageUpload" class="custom-file-upload">
                                                        <i class="fas fa-image"></i> Update Image
                                                    </label>
                                                    <input id="imageUpload" type="file" name="image" class="form-control-file">
                                                    @error('image')
                                                        <span class="invalid-feedback text-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="currentVideo">Current Video</label>
                                                    @if($post->video)
                                                        <div class="video-container mb-2">
                                                            <video controls class="w-100 rounded">
                                                                <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </div>
                                                    @else
                                                        <p>No video uploaded</p>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="videoUpload" class="custom-file-upload">
                                                        <i class="fas fa-video"></i> Update Video
                                                    </label>
                                                    <input id="videoUpload" type="file" name="video" class="form-control-file">
                                                    @error('video')
                                                        <span class="invalid-feedback text-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update Post</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
