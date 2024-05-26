<ul class="sidebar-menu" data-widget="tree">
    <li class="header">MAIN NAVIGATION</li>
    <li class="active treeview">
        <a href="#">
            <i class="fa fa-dashboard"></i>
            <span>Dashboard</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="active">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-circle-o"></i>
                    Home
                </a>
            </li>
        </ul>
    </li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-files-o"></i>
            <span>User Options</span>
            <span class="pull-right-container">
                <span class="label label-primary pull-right">4</span>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="{{ route('create.user') }}"><i class="fa fa-circle-o"></i> Create User</a></li>
            <li><a href="{{ route('user.list') }}"><i class="fa fa-circle-o"></i> User List</a></li>
            <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Role</a></li>
            <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Permission</a></li>
        </ul>
    </li>

    <li>
        <a href="{{ route('user.payment') }}">
            <i class="fa fa-th"></i> <span>Payments</span>
            <span class="pull-right-container">
                <small class="label pull-right bg-green">{{ $totalPayments }}</small>
            </span>
        </a>
    </li>

    <li>
        <a href="pages/mailbox/mailbox.html">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
            <span class="pull-right-container">
            <small class="label pull-right bg-yellow">12</small>
            <small class="label pull-right bg-green">16</small>
            <small class="label pull-right bg-red">5</small>
            </span>
        </a>
    </li>
</ul>
