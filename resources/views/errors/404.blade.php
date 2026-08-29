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
        background-color: rgba(255, 255, 255); /* semi-transparent white */
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



        <div class="lockscreen-item">

         

            <h1>404 PAGE NOT FOUND</h1>



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

<script>
    (function () {
        // 1. Force a full page reload if loaded from the browser's back-forward cache (bfcache)
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                // Forces browser to hit Laravel server, triggering your EnsureScreenUnlocked middleware
                window.location.reload();
            }
        });

        // 2. Intercept browser back/forward navigation actions
        window.addEventListener('popstate', function () {
            // Check session/lock status via endpoint or force direct redirect
            window.location.href = "{{ route('lockscreen') }}";
        });
    })();
</script>

</body>

</html>

