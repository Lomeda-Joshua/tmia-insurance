<html>
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
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset("tmia-assets/images/favicon/apple-touch-icon.png") }}"/>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset("tmia-assets/images/favicon/favicon-32x32.png") }}"/>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset("tmia-assets/images/favicon/favicon-16x16.png") }}"/>
    <link rel="manifest" href="{{ asset("tmia-assets/images/favicon/site.webmanifest") }}"/>
    <link rel="mask-icon" href="{{ asset("tmia-assets/images/favicon/safari-pinned-tab.svg") }}" color="#5bbad5"/>
    <meta name="msapplication-TileColor" content="#da532c"/>
    <meta name="msapplication-TileImage" content="/mstile-144x144.png">
    <meta name="theme-color" content="#ffffff"/>

    <!--============<******* CASCADING STYLE SHEETS (CSS) *******>============-->
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" type="text/css" href="{{ asset("tmia-assets/plugins/bootstrap/css/bootstrap.min.css") }}"/>
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset("tmia-assets/plugins/fontawesome/css/all.min.css") }}"/>
    <!-- Theme style -->
    <link rel="stylesheet" type="text/css" href="{{ asset("tmia-assets/css/AdminLTE.min.css") }}"/>
    <!-- SweetAlert style -->
    <link rel="stylesheet" type="text/css" href="{{ asset("tmia-assets/plugins/sweetalert/sweetalert.css") }}"/>
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
        background: url(" {{ asset('tmia-assets/images/background.webp') }} ") no-repeat center center fixed;
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

<body class="hold-transition lockscreen">
    
<div class="lockscreen-wrapper">

    <div class="lockscreen-container">

        <div class="lockscreen-logo">
            <img
                src="{{ asset('tmia-assets/images/logo.png') }}"
                style="width:340px;height:190px;"
                alt="Logo"
            >
        </div>

        <div class="lockscreen-name" id="lockscreenname">
            {{ Auth::user()->Display_Name ?? Auth::user()->User_Name ?? 'User Login Name' }}
        </div>

        <br>

        <div class="lockscreen-item">

            <div class="lockscreen-image">
                <img
                    src="{{ asset('tmia-assets/images/user.png') }}"
                    alt="User Image"
                >
            </div>

            <form class="lockscreen-credentials" method="POST" action="{{ route('lockscreen.unlock') }}" >
                @csrf
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
                        <button type="submit" id="btnlogin" class="btn"><i class="fa-regular fa-circle-right text-muted"></i></button>
                    </div>

                </div>

                @error('password')
                    <div
                        class="text-danger mt-1 text-left"
                        style="font-size:12px;color:#ff4d4d;"
                    >
                        {{ $message }}
                    </div>
                @enderror

            </form>



        </div>

        <div class="help-block text-center">
            Enter your password to retrieve your session
        </div>

        <div class="text-center">
            <a class="lnksite" wire:click="signInAsAnotherUser" style="cursor:pointer;">Or sign in as a different user</a>
        </div>

        <div
            class="lockscreen-footer text-center"
            style="margin-top:15px;"
        >
            <strong>
                Copyright &copy; {{ date('Y') }}

                <a
                    href="http://toyotamakati.com.ph/"
                    target="_blank"
                >
                    Toyota Makati, Inc
                </a>.
            </strong>

            All rights reserved.

            <div class="hidden-xs">
                <b>Version</b> 1.8.14
            </div>
        </div>

    </div>

</div>
</body>
</html>

