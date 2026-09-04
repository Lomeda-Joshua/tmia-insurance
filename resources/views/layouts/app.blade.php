<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])z
    @livewireStyles
</head>
    <body class="hold-transition skin-black sidebar-mini {{ request()->routeIs('dashboard') ? '' : 'sidebar-collapse' }}" onload="StartTimers();">
            <!-- Site wrapper -->
            <div class="wrapper">
                @include('components.layouts.headernav')
                @include('components.layouts.sidebar')

                {{ $slot }}


                <!-- MODAL TIME OUT -->
                <div id="timeout" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-warning modal-sm">
                        <div class="modal-content">
                        <div class="modal-header">
                            <!--<button type="button" class="btn btn-outline close" data-dismiss="modal">×</button>-->
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Session About To Timeout</h4>
                        </div>
                        <!--/modal-header-->
                        <div class="modal-body">
                            <p id="countdown"></p>
                            <p>
                                    You will be automatically logged out in 30 seconds.<br>
                                To remain logged in move your mouse over this window.
                            </p>
                        </div>
                        <!--/modal-body-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
                        </div>
                        </div>
                        <!--/modal-content-->
                    </div>
                    <!-- /modal-dialog -->
                </div>
                <!-- END MODAL TIME OUT -->


                <footer class="main-footer">
                    <div class="pull-right hidden-xs">
                        <b>Version</b> 0.0.1
                    </div>
                    <strong>Copyright &copy; <script>document.write(new Date().getFullYear());</script> <a href="http://toyotamakati.com.ph/" target="_blank">Toyota Makati, Inc</a>.</strong> All rights reserved.
                    <!-- <strong>Copyright &copy; <script>document.write(new Date().getFullYear());</script> <a href="http://toyotabicutan.com.ph/" target="_blank">Toyota Bicutan Parañaque</a>.</strong> All rights reserved. -->
                </footer>
            </div>
        
            @include('partials.footer')
            {{-- @push('scripts')
                <script>
                    let idleTimer;

                    function resetIdleTimer() {
                        clearTimeout(idleTimer);
                        // Lock screen after 15 minutes (900,000 ms) of inactivity
                        idleTimer = setTimeout(() => {
                            window.location.href = "{{ route('lock') }}";
                            console.log("hello");
                        }, 3600); 
                    }

                    // Listen for user activity
                    ['mousemove', 'keydown', 'click', 'scroll'].forEach(event => {
                        window.addEventListener(event, resetIdleTimer, false);
                    });

                    resetIdleTimer();
                </script>
            @endpush --}}
            <!-- Stack target for view-specific scripts -->
            @livewireScripts
            @stack('scripts')
    </body>
</html>
