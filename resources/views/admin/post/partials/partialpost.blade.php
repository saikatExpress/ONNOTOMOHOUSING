<div class="card mb-3 shadow-sm">
    <div class="card-header d-flex align-items-center">
        <img src="{{ asset('logos/avatar-3637425_640.webp') }}" alt="{{ $post->user->name }}" style="border-radius: 50%;" class="rounded-circle" width="40" height="40">
        <div class="ml-2">
            <h5 class="mb-0">{{ $post->user->name }}</h5>
            <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
        </div>
    </div>
    <div class="card-body">
        <p>{{ $post->content }}</p>

        @if ($post->post_link)
            <p><a href="{{ $post->post_link }}" target="_blank">{{ $post->post_link }}</a></p>
        @endif

        @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded mt-2" alt="Post Image">
        @endif

        @if ($post->video)
            <div class="video-container mt-2">
                <video controls class="w-100 rounded">
                    <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        @endif
    </div>
    <div class="card-footer">
        <div class="comments">
            <h6>Comments</h6>
            {{-- @foreach ($post->comments as $comment)
                <div class="comment mb-2">
                    <strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}
                </div>
            @endforeach --}}

            <form action="{{ route('comments.store') }}" method="POST" class="mt-2">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <div class="form-group">
                    <textarea name="comment" class="form-control" placeholder="Add a comment..." required></textarea>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Comment</button>
            </form>
        </div>
    </div>
</div>
