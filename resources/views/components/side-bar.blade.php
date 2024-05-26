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

    <li class="treeview">
        <a href="#">
        <i class="fa fa-pie-chart"></i>
        <span>Expense</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="../charts/chartjs.html"><i class="fa fa-circle-o"></i> Create Expense</a></li>
            <li><a href="../charts/morris.html"><i class="fa fa-circle-o"></i> Expense List</a></li>
        </ul>
    </li>

    <li>
        <a href="{{ route('category.list') }}">
            <i class="fa-solid fa-list"></i> <span>Category</span>
                <span class="pull-right-container">
                <small class="label pull-right bg-yellow">{{ $totalCatgeories }}</small>
            </span>
        </a>
    </li>
</ul>
