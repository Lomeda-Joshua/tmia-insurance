<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('tmia-assets/images/user.png') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->Display_Name }}</p>
                <a href="#" id="user-status"><i class="fa fa-circle text-warning"></i> Online</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" id="mymenu">
            <li class="header"><b><font size="2px" face="arial black" color="white">MAIN NAVIGATION</font></b></li>
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
            <li class="treeview {{ request()->routeIs(['customer_list', 'vehicle_list', 'new_business*', 'renewal_business*']) ? 'active menu-open' : '' }}">
                <a href="#">
                    <i class="fa fa-tasks"></i>
                    <span>Transactions</span>
                    <span class="pull-right-container">
                        <i class="fa-solid fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" id="mymenuchild0">
                    <li class="{{ request()->routeIs('new_business.index*') ? 'active' : '' }}" >
                        <a href="{{ route('new_business.index') }}"><i class="fa-solid fa-car"></i> New Business Insurance</a>
                    </li>
                    <li class="{{ request()->routeIs('renewal_business*') ? 'active' : '' }}" >
                        <a href="{{ route('renewal_business') }}"><i class="fa-solid fa-car-side"></i> Renewal Business Insurance</a>
                    </li>
                     <li class="{{ request()->routeIs('customer.list') ? 'active' : '' }}" >
                        <a href="{{ route('customer.list') }}"><i class="fa fa-list-alt"></i> Customer List</a>
                    </li>
                    {{-- <li class="{{ request()->routeIs('vehicle_list') ? 'active' : '' }}" >
                        <a href="{{ route('vehicle_list') }}"><i class="fa fa-list-alt"></i> Vehicle List</a>
                    </li>  --}}
                </ul>
            </li>
            <li class="treeview {{ request()->routeIs('settings.*') ? 'active menu-open' : '' }}">
                <a href="#">
                    <i class="fa fa-gears"></i>
                    <span>Settings</span>
                    <span class="pull-right-container">
                        <i class="fa-solid fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" id="mymenuchild1">
                    <li class="{{ request()->routeIs('user') ? 'active' : '' }}">
                        <a href="{{ route('user') }}"><i class="fa fa-user"></i> <span>Users</span></a>
                    </li>
                    <li class="{{ request()->routeIs('user_account') ? 'active' : '' }}">
                        <a href="{{ route('user_account') }}"><i class="fa fa-user"></i> <span>Account</span></a>
                    </li>
                </ul>
            </li>
            {{-- <li class="treeview {{ request()->routeIs('nbrb_report') ? 'active menu-open' : '' }}">
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span>Reports</span>
                    <span class="pull-right-container">
                        <i class="fa-solid fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" id="mymenuchild2">
                    <li class="{{ request()->routeIs('nbrb_report') ? 'active' : '' }}">
                        <a href="{{ route('nbrb_report') }}">
                            <i class="fa fa-file-text"></i> 
                            <span>New Business / Renewal Business Report</span>
                        </a>
                    </li>
                </ul>
            </li> --}}
        </ul>


    </section>
    <!-- /.sidebar -->
</aside>
<!-- =============================================== -->