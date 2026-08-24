<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|max:30')]
    
    // public string $email = '';
    public string $username = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        // Map input properties to custom database columns
        $credentials = [
            'User_Name' => $this->username,
            'Active' => 'YES',
            'password' => $this->password,
        ];

        if (! Auth::attempt($credentials, $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'username' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirect(
            route('dashboard', absolute: false),
        );
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'username' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(
            Str::lower($this->username).'|'.request()->ip()
        );
    }

    
}; ?>

<x-layouts.auth.simple>
    <div class="main"> 
        <div class="container center-box">

            <!-- Header -->
            <div class="row text-center">
                <div class="wave-container">
                    <h3 class="animate-charcter">TMIA</h3>

                    <div id="flip">
                        <div class="flip-inner">
                            <div>T O Y O T A</div>
                            <div>M A K A T I</div>
                            <div>A N D</div>
                            <div>B I C U T A N</div>
                            <div>I N S U R A N C E</div>
                            <div>A G E N C Y</div>
                        </div>
                    </div>

                    <h1 class="wave-text">
                        <span>S</span>
                        <span>y</span>
                        <span>s</span>
                        <span>t</span>
                        <span>e</span>
                        <span>m</span>
                    </h1>
                </div>
            </div>

            <!-- Profile Image -->
            <div class="row">
                <div class="center-block">
                    <img
                        class="profile-img"
                        src="{{ asset('tmia-assets/images/user.png') }}"
                        alt="User"
                    >
                </div>
            </div>

            <!-- Form + Logo -->
            <div class="row cellcenter">

                <!-- Login Form -->
                <div class="col-md-6 login-form">

                    <!-- Session Status -->
                    <x-auth-session-status
                        class="text-center"
                        :status="session('status')"
                    />

                    <form wire:submit="login">
                        <fieldset>

                            <!-- Email / Username -->
                            <p>
                                <span class="fa fa-user"></span>

                                <input
                                    wire:model="username"
                                    type="text"
                                    id="txtuname"
                                    name="username"
                                    placeholder="Username"
                                    required
                                    autofocus
                                    autocomplete="username"
                                >
                            </p>

                            @error('username')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror

                            <!-- Password -->
                            <p>
                                <span class="fa fa-lock"></span>

                                <input
                                    wire:model="password"
                                    type="password"
                                    id="txtpword"
                                    name="password"
                                    placeholder="Password"
                                    required
                                    autocomplete="current-password"
                                >
                            </p>

                            @error('password')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror

                        

                            <!-- Login Button -->
                            <center>
                                <div>
                                    <span>
                                        <input
                                            type="submit"
                                            value="Log In"
                                            id="btnlogin"
                                        >
                                    </span>
                                </div>
                            </center>

                        </fieldset>
                    </form>

                </div>

                <!-- Logo -->
                <div class="col-md-6 login-logo">
                    <img
                        class="login-img"
                        src="{{ asset('tmia-assets/images/logo.png') }}"
                        alt="TMIA Logo"
                    >
                </div>

            </div>

            <!-- Modal Recover Account -->
            <div id="modalrecover" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" style="color:white;"><p><strong>×</strong></p></button>
                    <h3 class="modal-title"><strong>ACCOUNT RECOVERY</strong></h3>
                </div>
                <!--/modal-header-->
                <div class="modal-body">
                    <div class="pad" id="infopanel">
                    <div class="form-horizontal">
                        <div class="controls">
                        <div class="row">
                            <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="form-group">
                                <label for="txtrecemailaddress" style="color:gray;">Recovery E-Mail Address *</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                    <i class="fa fa-envelope"></i>
                                    </span>
                                    <input type="text" id="txtrecemailaddress" class="form-control input-sm" placeholder="Enter Email Address." required="required" data-error="Email Address is required.">
                                </div>
                                <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    <!--/pad-->
                </div>
                <!--/modal-body-->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btnrecback"><i class="fa fa-arrow-circle-left"></i> Back to Login</button>
                    <button type="submit" class="btn btn-success" id="btnrecsubmit"><i class="fa fa-send"></i> Submit</button>
                </div>
                </div>
                <!--/modal-content-->
            </div>
            <!-- /modal-dialog -->
            </div>
            <!-- END Modal Recover Account -->
        </div>

    </div>
</x-layouts.auth.simple>



