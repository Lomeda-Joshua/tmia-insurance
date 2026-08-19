<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="msapplication-TileColor" content="#da532c"/>
<meta name="msapplication-TileImage" content="/mstile-144x144.png">
<meta name="theme-color" content="#ffffff"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
<meta http-equiv="Pragma" content="no-cache"/>
<meta http-equiv="Expires" content="0"/>

<title>{{ env("APP_NAME") ?? 'tmia project' }}</title>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<title>TMI INSURANCE AGENCY SYSTEM</title>

<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"/>

<!--============<******* PAGES FAVICON LOGO *******>============-->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('tmia-assets/images/favicon/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('tmia-assets/images/favicon/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('tmia-assets/images/favicon/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('tmia-assets/images/favicon/site.webmanifest') }}">
<link rel="mask-icon" href="{{ asset('tmia-assets/images/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">


<!--============<******* CASCADING STYLE SHEETS (CSS) *******>============-->
<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" type="text/css" href="{{ asset('tmia-assets/plugins/bootstrap/css/bootstrap.min.css') }}"/>

<!-- Font Awesome -->
<link rel="stylesheet" type="text/css" href="{{ asset('tmia-assets/plugins/fontawesome/css/all.min.css') }}"/>

<!-- Theme style -->
<link rel="stylesheet" type="text/css" href="{{ asset('tmia-assets/css/AdminLTE.min.css') }}"/>

<!-- iCheck -->
<link rel="stylesheet" type="text/css" href="{{ asset('tmia-assets/plugins/iCheck/skins/flat/blue.css') }}"/>

<!-- SweetAlert style -->
<link rel="stylesheet" type="text/css" href="{{ asset('tmia-assets/plugins/sweetalert/sweetalert.css') }}"/>

<!-- Customized Style -->
<link rel="stylesheet" type="text/css" href="{{ asset('tmia-assets/css/login.css') }}"/>

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
