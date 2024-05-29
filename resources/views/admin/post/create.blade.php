@extends('admin.layout.app')
<style>
    .post-container {
        max-width: 600px;
        margin: auto;
    }
    .post-box {
        background: #fff;
        padding: 15px;
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
    .posts-list .post-item {
        background: #fff;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }
    .posts-list .post-item img,
    .posts-list .post-item video {
        max-width: 100%;
        border-radius: 10px;
        margin-top: 10px;
    }
    .posts-list .post-item .post-header {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .posts-list .post-item .post-header img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }
    .posts-list .post-item .post-header .post-author {
        font-weight: bold;
    }
</style>
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
                <h2>Create Post</h2>

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
                        <h1>Building Updates</h1>

                        <div class="container">
                            <div class="post-container">
                                <div class="post-box">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <textarea name="content" class="form-control" placeholder="What's on your mind?" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="imageUpload" class="custom-file-upload">
                                                <i class="fas fa-image"></i> Image
                                            </label>
                                            <input id="imageUpload" type="file" name="image" class="form-control-file">
                                        </div>
                                        <div class="form-group">
                                            <label for="videoUpload" class="custom-file-upload">
                                                <i class="fas fa-video"></i> Video
                                            </label>
                                            <input id="videoUpload" type="file" name="video" class="form-control-file">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Post</button>
                                    </form>
                                </div>

                                <div class="posts-list mt-4">
                                    {{-- @foreach ($posts as $post)
                                        @include('posts.partials.post', ['post' => $post])
                                    @endforeach --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
