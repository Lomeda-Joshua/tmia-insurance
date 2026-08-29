<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
    <body class="hold-transition skin-black sidebar-mini {{ request()->routeIs('dashboard') ? '' : 'sidebar-collapse' }}" onload="StartTimers();">
            <!-- Site wrapper -->
            <div class="wrapper">
                @include('components.layouts.headernav')
                @include('components.layouts.sidebar')

                {{ $slot }}


                <footer class="main-footer">
                    <div class="pull-right hidden-xs">
                        <b>Version</b> 0.0.1
                    </div>
                    <strong>Copyright &copy; <script>document.write(new Date().getFullYear());</script> <a href="http://toyotamakati.com.ph/" target="_blank">Toyota Makati, Inc</a>.</strong> All rights reserved.
                    <!-- <strong>Copyright &copy; <script>document.write(new Date().getFullYear());</script> <a href="http://toyotabicutan.com.ph/" target="_blank">Toyota Bicutan Parañaque</a>.</strong> All rights reserved. -->
                </footer>
            </div>
        
            @include('partials.footer')
            @push('scripts')
                <script>
                        (function () {
                            const IDLE_TIMEOUT = 10000; // 10 seconds (testing threshold)
                            let idleTimer = null;

                            function sendLockSignal() {
                                fetch("{{ route('lockscreen.lock') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                    }
                                }).then(() => {
                                    window.location.href = "{{ route('lockscreen') }}";
                                });
                            }

                            function resetTimer() {
                                clearTimeout(idleTimer);
                                idleTimer = setTimeout(sendLockSignal, IDLE_TIMEOUT);
                            }

                            // DOM Events indicating activity
                            const activityEvents = ['mousemove', 'keydown', 'click', 'scroll', 'touchstart'];
                            activityEvents.forEach(event => {
                                window.addEventListener(event, resetTimer, false);
                            });

                            // Initialize timer on layout load
                            resetTimer();
                        })();
                </script>
            @endpush
            @stack('scripts')
    </body>
</html>
