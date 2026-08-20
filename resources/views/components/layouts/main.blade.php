<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="hold-transition skin-black sidebar-mini" onload="StartTimers();">
    <!-- Site wrapper -->
    <div class="wrapper">
        @include('components.layouts.headernav')
        @include('components.layouts.sidebar')
        @yield('content')
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 0.0.1
            </div>
            <strong>Copyright &copy; <script>document.write(new Date().getFullYear());</script> <a href="http://toyotamakati.com.ph/" target="_blank">Toyota Makati, Inc</a>.</strong> All rights reserved.
            <!-- <strong>Copyright &copy; <script>document.write(new Date().getFullYear());</script> <a href="http://toyotabicutan.com.ph/" target="_blank">Toyota Bicutan Parañaque</a>.</strong> All rights reserved. -->
        </footer>
    </div>
</body>
    @include('partials.footer')
</html>
