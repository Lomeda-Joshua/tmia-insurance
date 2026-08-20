<header class="main-header">
    <!-- Logo -->
    <a class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="{{ asset('tmia-assets/images/logo-mini.png') }}" style="width:50px;height:20px;"></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="{{ asset('tmia-assets/images/logo.png') }}" style="width:100px;height:100px;"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- Notification Dropdown -->
            <!-- ================== NOTIFICATION DROPDOWN ================== -->
            <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="notification-toggle">
                <i class="fa-regular fa-bell fa-lg" id="notification-bell"></i>
                <span class="label label-danger" id="notification-count">0</span>
            </a>
            
            <ul class="dropdown-menu">
                <li class="header" id="notification-header">You have 0 notifications</li>
                <li>
                <ul class="menu" id="notification-menu">
                    <!-- Notifications will be dynamically inserted here -->
                </ul>
                </li>
                <!-- <li class="footer"><a href="#">View all</a></li> -->
            </ul>

            <!-- Notification sound -->
            <audio id="notification-sound" preload="auto">
                <source src="{{ asset('tmia-assets/sounds/bell-notification.wav') }}" type="audio/mpeg">
            </audio>
            </li>
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('tmia-assets/images/user.png') }}" class="user-image" alt="User Image">
                <span class="hidden-xs"><b><font size="2px" face="arial black">{{ Auth::user()->name }}</font></b></span>
            </a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                <img src="{{ asset('tmia-assets/images/user.png') }}" class="img-circle" alt="User Image">
                <p>
                    {{ Auth::user()->name }}
                </p>
                <p>
                    <b></b>
                    <br>

                    <small>Member since {{ Auth::user()->created_at }}</small>
                </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                <div class="pull-right">
                    <a class="btn btn-default btn-flat btnsignout"><i class="fa fa-sign-out"></i>Sign out</a>
                </div>
                </li>
            </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
            <!--
            <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
            </li>
            -->
        </ul>
        </div>
    </nav>
</header>
<!-- =============================================== -->