<li class="dropdown tasks-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-flag-o"></i>
    <span class="label label-danger">{{ count($allTask) }}</span>
    </a>
    <ul class="dropdown-menu">
    <li class="header">You have {{ count($allTask) }} tasks</li>
    <li>
        <!-- inner menu: contains the actual data -->
        <ul class="menu">
            @if (count($allTask) > 0)
                @foreach ($allTask as $task)
                    <li>
                        <a href="#">
                            <h3 style="font-weight: 600; color:#000;">
                                {{ $task->holders->name }} <br>
                                <p style="padding: 3px;font-weight:600;color:teal;">
                                    {{ $task->remark }}
                                </p>
                                <small class="pull-right">20%</small>
                            </h3>
                            <div class="progress xs">
                                <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                                    aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                <span class="sr-only">20% Complete</span>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            @else
                <p>
                    There are no task today..!
                </p>
            @endif
        </ul>
    </li>
    <li class="footer">
        <a href="#">View all tasks</a>
    </li>
    </ul>
</li>
