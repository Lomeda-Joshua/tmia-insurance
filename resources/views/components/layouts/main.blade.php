<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Dark semi-transparent full-screen overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99999 !important;
            /* Keeps spinner on top of all elements */
        }

        .loader-image{
            width:120px;
            margin:auto;
        }

        /* Card container */
        .loader-card {
            background: #ffffff;
            padding: 25px 35px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Circular Spinner */
        .spinner {
            width: 40px;
            height: 40px;
            margin: 0 auto 12px auto;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #28a745;
            /* Spinner color */
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

</head>

<body class="hold-transition skin-black sidebar-mini {{ request()->routeIs('dashboard') ? '' : 'sidebar-collapse' }}"
    onload="StartTimers();">
    <!-- Site wrapper -->
    <div class="wrapper">
        @include('components.layouts.headernav')
        @include('components.layouts.sidebar')
        {{-- <livewire:layouts.header-nav /> --}}

        {{ $slot }}

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.8.14
            </div>
            <strong>Copyright &copy; <script>
                    document.write(new Date().getFullYear());
                </script> <a href="http://toyotamakati.com.ph/" target="_blank">Toyota Makati, Inc</a>.</strong> All
            rights reserved.
            <!-- <strong>Copyright &copy; <script>document.write(new Date().getFullYear());</script> <a href="http://toyotabicutan.com.ph/" target="_blank">Toyota Bicutan Parañaque</a>.</strong> All rights reserved. -->
        </footer>

        <!-- MODAL PASSWORD EXPIRED -->
        <div id="modalpwdexpired" class="modal">
            <div class="modal-content pwd-content animate">
                <span class="close" title="Close Modal">&times;</span>
                <div class="logo">
                    <img src="{{ asset('tmia-assets/images/user.png') }}" alt="">
                </div>
                <div id="user-name" class="text-center mt-4 name">
                    System Administrator
                </div>
                <div class="text-center mt-4">
                    Your password is already expired, please change your password now!
                </div>
                <form class="p-3 mt-3">
                    <div class="form-field d-flex align-items-center">
                        <span class="fas fa-key"></span>
                        <input type="password" name="password" id="pwd" placeholder="Password" autocomplete="off">
                        <span toggle="#pwd" class="toggle-password fas fa-eye"></span>
                    </div>
                    <div class="form-field d-flex align-items-center">
                        <span class="fas fa-key"></span>
                        <input type="password" name="Verify" id="verify" placeholder="Verify" autocomplete="off">
                        <span toggle="#verify" class="toggle-verify fas fa-eye"></span>
                    </div>
                    <button type="button" class="btn btn-success mt-3" id="btnupdatepwd">Update</button>
                </form>
            </div>
        </div>
        <!-- END PASSWORD EXPIRED -->

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
    </div>

    <!-- Full-Screen Loading Overlay -->
    <div id="loading-overlay" class="loading-overlay" style="display: none;">
        <div class="loader-card">
            <div class="spinner">
            </div>
            <img class="loader-image" src="{{ asset('tmia-assets/images/logo-mini.png') }}" />
            <p id="loading-text">Saving data, please wait...</p>
        </div>
    </div>


    @include('partials.footer')
    @push('scripts')

    <script>
        //================== lOADING SPINNER =================//
        function showLoading(message = "Saving data, please wait...") {
            document.getElementById("loading-text").innerText = message;
            document.getElementById("loading-overlay").style.display = "flex";
        }

        function hideLoading() {
            document.getElementById("loading-overlay").style.display = "none";
        }

        //================== FUNTION LOGIN NOTIFICATION =================//
        @if(session('signin'))
            document.addEventListener('DOMContentLoaded', function () {
                // Define or set the global signin flag
                window.signin = true;

                // Call notification function
                if (typeof LogNotify === 'function') {
                    LogNotify();
                }
            });
        @endif

        function LogNotify() {
            if (signin == true){
            $.notify({
                title: "<strong>Success!</strong>",
                message: "<br>Login successfully.",
                icon: 'glyphicon glyphicon-ok-sign'
            },{
                type: "success",
                onShow: function() {
                this.css({'width':'auto','height':'auto'});
                }
            });
            }
        }
        
        //================== LOGIN IDLE SCRIPT =================//
        (function () {
                const IDLE_TIMEOUT = 36 * 10000; // 10 seconds (testing threshold)
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
    <script>
        window.nofiticationdata = {
            notifications_data : @json(route('notifications.data')),
        }
    
        window.dataRoutes = {
            sessionVariable : @json(route('getSession.dataVariable')),
        }
    </script>
    {{-- <script src="{{ asset('tmia-assets/js/laravel/main_laravel.js') }}"></script> --}}

</body>

</html>