<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string')]
    public string $password = '';

    public function unlock(): void
    {
        $this->validate();
        $this->ensureIsNotRateLimited();

        $user = Auth::user();

        // If no user is logged in, redirect straight to login
        if (! $user) {
            $this->signInAsAnotherUser();
            return;
        }


        // Map credentials using your schema's custom username column and active status
        if (! Hash::check($this->password, $user->Encrypt_Password)) {

            RateLimiter::hit($this->throttleKey());

            $this->password = '';

            throw ValidationException::withMessages([
                'password' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        $this->password = '';
        
        // Remove lockscreen flag if set by your middleware
        Session::forget('lockscreen');

        $this->redirect(
            route('dashboard', navigate: true),
        );
    }


    public function signInAsAnotherUser(): void
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();

        $this->redirect(route('login', navigate: false));
    }

    /**
     * Ensure the unlock request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'password' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    protected function throttleKey(): string
    {
        $username = Auth::user()?->User_Name ?? 'guest';
        return Str::transliterate(Str::lower($username).'|'.request()->ip());
    }
};
?>

<!DOCTYPE html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
        <meta http-equiv="Pragma" content="no-cache"/>
        <meta http-equiv="Expires" content="0"/>
        <title>TMI INSURANCE AGENCY SYSTEM | Lockscreen</title>

        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"/>

        <!--============<******* PAGES FAVICON LOGO *******>============-->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('tmia-assets/images/favicon/apple-touch-icon.png') }}"/>
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('tmia-assets/images/favicon/favicon-32x32.png') }}"/>
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('tmia-assets/images/favicon/favicon-16x16.png') }}"/>
        <link rel="manifest" href="{{ asset('tmia-assets/images/favicon/site.webmanifest') }}"/>
        <link rel="mask-icon" href="{{ asset('tmia-assets/images/favicon/safari-pinned-tab.svg') }}" color="#5bbad5"/>
        <meta name="msapplication-TileColor" content="#da532c"/>
        <meta name="msapplication-TileImage" content="/mstile-144x144.png">
        <meta name="theme-color" content="#ffffff"/>

        <!--============<******* CASCADING STYLE SHEETS (CSS) *******>============-->
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" type="text/css" href="{{ asset('tmia-assets/plugins/bootstrap/css/bootstrap.min.css') }}"/>
        <!-- Font Awesome -->
        <link rel="stylesheet" type="text/css" href="{{ asset('tmia-assets/plugins/fontawesome/css/all.min.css') }}"/>
        <!-- Theme style -->
        <link rel="stylesheet" type="text/css" href="{{ asset('tmia-assets/css/AdminLTE.min.css') }}"/>
        <!-- SweetAlert style -->
        <link rel="stylesheet" type="text/css" href="{{ asset('tmia-assets/plugins/sweetalert/sweetalert.css') }}"/>
        <style type="text/css">
            body {
                color: #000000;
            }

            /* Fullscreen flexbox to center content */
            body.lockscreen {
                display: flex;
                justify-content: center;   /* center horizontally */
                align-items: center;        /* center vertically */
                height: 100vh;              /* full page height */
                margin: 0;
                background: url("{{ asset('tmia-assets/images/background.webp') }}") no-repeat center center fixed;
                background-size: cover;
            }

            /* Center box container */
            .lockscreen-container {
                background-color: rgba(255, 255, 255, 0.5); /* semi-transparent white */
                padding: 40px 30px;
                width: 100%;
                max-width: 420px;
                border-radius: 15px;
                box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.25);
                text-align: center;
            }

            /* Optional: adjust wrapper spacing */
            .lockscreen-wrapper {
                margin-top: 5% !important;
                display: flex;
                justify-content: center;
            }

            .lockscreen-wrapper {
                margin-top: 5% !important;
            }

            .lockscreen-logo img {
                width: 100% !important;
                height: auto !important;
            }

            /* Shadow only on the right and bottom of input box */
            .lockscreen-credentials .input-group {
                box-shadow: 4px 4px 6px rgba(0, 0, 0, 0.25); /* Right + bottom shadow */
                border-radius: 6px;
            }

            .lockscreen-credentials .form-control {
                border-radius: 6px 0 0 6px; /* Rounded left side */
            }

            .lockscreen-credentials .input-group-btn .btn {
                border-radius: 0 6px 6px 0; /* Rounded right side */
            }
            
            .help-block {
                color: #1e1b1b;
            }

            a {
                color: #00178d;
            }

            a:hover {
                color: #000;
            }

            /* Add background here */
            body.lockscreen {
                background: url("{{ asset('tmia-assets/images/background.webp') }}") no-repeat center center fixed;
                background-size: cover;
            }
        </style>
    </head>
            <div class="lockscreen-wrapper">
                <div class="lockscreen-container">
                    <div class="lockscreen-logo">
                        <img src="{{ asset('tmia-assets/images/logo.png') }}" style="width:340px;height:190px;" alt="Logo">
                    </div>

                    <div class="lockscreen-name" id="lockscreenname">
                        {{ Auth::user()->Display_Name ?? Auth::user()->User_Name ?? 'User Login Name' }}
                    </div>
                    <br>

                    <div class="lockscreen-item">
                        <div class="lockscreen-image">
                            <img src="{{ asset('tmia-assets/images/user.png') }}" alt="User Image">
                        </div>

                        <form class="lockscreen-credentials" wire:submit="unlock">
                            <div class="input-group">
                                <input 
                                    type="password" 
                                    id="txtpword" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    placeholder="password"
                                    wire:model="password"
                                    autofocus
                                >
                                <div class="input-group-btn">
                                    <button type="submit" id="btnlogin" class="btn">
                                        <i class="fa-regular fa-circle-right text-muted"></i>
                                    </button>
                                </div>
                            </div>

                            @error('password')
                                <div class="text-danger mt-1 text-left" style="font-size: 12px;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </form>
                    </div>

                    <div class="help-block text-center">
                        Enter your password to retrieve your session
                    </div>

                    <div class="text-center">
                        <a class="lnksite" wire:click="signInAsAnotherUser" style="cursor: pointer;">
                            Or sign in as a different user
                        </a>
                    </div>

                    <div class="lockscreen-footer text-center">
                        <strong>Copyright &copy; {{ date('Y') }} <a href="http://toyotamakati.com.ph/" target="_blank">Toyota Makati, Inc</a>.</strong> All rights reserved.
                        <div class="hidden-xs">
                            <b>Version</b> 0.0.1
                        </div>
                    </div>
                </div>
            </div>
        <!-- ======================================================== -->

        <!--============<******* JAVA SCRIPT (JS) *******>============-->
        <!-- jQuery v3.7.1  -->
        <script type="text/javascript" src="{{ asset('tmia-assets/plugins/jquery/dist/jquery.min.js') }}"></script>
        <!-- Bootstrap 3.3.6 -->
        <script type="text/javascript" src="{{ asset('tmia-assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- SweetAlert -->
        <script type="text/javascript" src="{{ asset('tmia-assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
        <!-- Bootstrap-notify -->
        <script type="text/javascript" src="{{ asset('tmia-assets/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

        <script type="text/javascript" src="{{ asset('tmia-assets/js/lockscreen.js') }}"></script>
        
        <script>
            $('.lnksite').css({
                "cursor": "pointer",
                "box-shadow": "none"
            });
        </script>
  </body>
</html>
