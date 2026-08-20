<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
        <div class="pull-left image">
            <img src="{{ asset('../tmia-assets/images/user.png') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p>{{ Auth::user()->name }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" id="mymenu">
            <li class="header"><b><font size="2px" face="arial black" color="white">MAIN NAVIGATION</font></b></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
<!-- =============================================== -->