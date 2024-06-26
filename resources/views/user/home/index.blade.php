
    @extends('user.layout.app')
    <style>
        .ticker-wrapper {
            background-color: #007bff;
            color: white;
            overflow: hidden;
            position: relative;
            height: 50px;
            display: flex;
            align-items: center;
        }

        .ticker {
            display: flex;
            animation: ticker 30s linear infinite;
        }

        .ticker-item {
            padding: 0 50px;
            white-space: nowrap;
            font-size: 1.2em;
            display: flex;
            align-items: center;
            height: 100%;
        }

        @keyframes ticker {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
    </style>

    @section('content')
        <div class="container-fluid py-4">

            <div class="row" style="border-radius: 4px; box-shadow:0 0 10px rgba(0,0,0,0.1)">
                <div class="col-md-12">
                    <div class="ticker-wrapper">
                        <div class="ticker">
                            @if (count($announces) > 0)
                                @foreach ($announces as $announce)
                                    <div class="ticker-item">
                                        <a class="text-white" href="">
                                            {{ $announce->title }}
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                <div class="ticker-item">Update: The office will be closed on Monday for a public holiday.</div>
                                <div class="ticker-item">Reminder: Team meeting at 10 AM tomorrow.</div>
                                <div class="ticker-item">Reminder: Team meeting at 10 AM tomorrow.</div>
                                <div class="ticker-item">Reminder: Team meeting at 10 AM tomorrow.</div>
                                <div class="ticker-item">Reminder: Team meeting at 10 AM tomorrow.</div>
                                <div class="ticker-item">Reminder: Team meeting at 10 AM tomorrow.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">weekend</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Total Cash Deposite</p>
                                <h4 class="mb-0">{{ number_format($totalCashDeposite) }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>than last week</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">weekend</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Current Balance</p>
                            @if ($currentBalance > 0)
                                <h4 class="mb-0">{{ number_format($currentBalance) }}</h4>
                            @else
                                <h4 class="mb-0 text-danger">{{ number_format($currentBalance) }}</h4>
                            @endif
                        </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                        <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+5% </span>than yesterday</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Today's Users</p>
                            <h4 class="mb-0">2,300</h4>
                        </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                        <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than last month</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">New Clients</p>
                            <h4 class="mb-0">3,462</h4>
                        </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                        <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">-2%</span> than yesterday</p>
                        </div>
                    </div>
                </div>

            </div>
            <hr>
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">{{ $post->user->name }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $post->created_at->diffForHumans() }}</h6>
                                <p class="card-text">{{ $post->content }}</p>
                                @if ($post->post_link)
                                    <a href="{{ $post->post_link }}" target="_blank" class="card-link">Read More</a>
                                @endif
                                <div class="d-flex">
                                    @if ($post->image)
                                        <div>
                                            <img src="{{ asset('storage/'.$post->image) }}" class="img-fluid" alt="Post Image">
                                        </div>
                                    @endif
                                    @if ($post->video)
                                        <div>
                                            <video controls class="img-fluid mt-2">
                                                <source src="{{ asset('storage/'.$post->video) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            {{-- <div class="card-footer">
                                <form action="{{ route('comments.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <div class="input-group">
                                        <input type="text" name="comment" class="form-control" placeholder="Add a comment..." required>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">Comment</button>
                                        </div>
                                    </div>
                                </form>
                                <ul class="list-group list-group-flush mt-2">
                                    @foreach ($post->comments as $comment)
                                        <li class="list-group-item">
                                            <strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}
                                            <br>
                                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                        </li>
                                    @endforeach
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                @endforeach
            </div>

            <footer class="footer py-4  ">
                <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                    <div class="copyright text-center text-sm text-muted text-lg-start">
                        © <script>
                            document.write(new Date().getFullYear())
                        </script>,
                        made with <i class="fa fa-heart"></i> by
                        <a href="https://github.com/saikatExpress" class="font-weight-bold" target="_blank">TS WEB</a>
                        for a better web.
                    </div>
                    </div>
                    <div class="col-lg-6">
                    <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                        <li class="nav-item">
                        <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
                        </li>
                        <li class="nav-item">
                        <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
                        </li>
                        <li class="nav-item">
                        <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
                        </li>
                        <li class="nav-item">
                        <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
                        </li>
                    </ul>
                    </div>
                </div>
                </div>
            </footer>
        </div>

    @endsection

