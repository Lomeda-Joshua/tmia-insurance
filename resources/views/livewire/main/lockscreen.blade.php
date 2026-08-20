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
                background: url("{{ asset('tmia-assets/images/background.jpg') }}") no-repeat center center fixed;
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
        <!-- Automatic element centering -->
        <div class="lockscreen-wrapper">
        <div class="lockscreen-container">
            <div class="lockscreen-logo">
            <IMG SRC="{{ asset('tmia-assets/images/logo.png') }}" style="width:340px;height:190px;">
            </div>
            <!-- User name -->
            <div class="lockscreen-name" id="lockscreenname">User Login Name</div>
            <br>
            <!-- START LOCK SCREEN ITEM -->
            <div class="lockscreen-item">
            <!-- lockscreen image -->
            <div class="lockscreen-image">
                <img src="{{ asset('tmia-assets/images/user.png') }}" alt="User Image">
            </div>
            <!-- /.lockscreen-image -->

            <!-- lockscreen credentials (contains the form) -->
            <form class="lockscreen-credentials" action="javascript:void(0);" method="POST">
                <div class="input-group">
                <input type="password" id="txtpword" class="form-control" placeholder="password">
                <input type="hidden" id="txtuname">
                <div class="input-group-btn">
                    <button type="submit" id="btnlogin" class="btn"><i class="fa-regular fa-circle-right text-muted"></i></button>
                </div>
                </div>
            </form>
            <!-- /.lockscreen credentials -->

            </div>
            <!-- /.lockscreen-item -->
            <div class="help-block text-center">
            Enter your password to retrieve your session
            </div>
            <div class="text-center">
            <a class="lnksite" onclick="javascript:checkSite();">Or sign in as a different user</a>
            <script type="text/javascript">
                function checkSite(){
                    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
                    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))){
                        window.location.replace('mobile_login');
                    } else {
                        window.location.replace('login');
                    }
                }
            </script>
            </div>
            <div class="lockscreen-footer text-center">
            <strong>Copyright &copy; <script>document.write(new Date().getFullYear());</script> <a href="http://toyotamakati.com.ph/" target="_blank">Toyota Makati, Inc</a>.</strong> All rights reserved.
            <!-- <strong>Copyright &copy; <script>document.write(new Date().getFullYear());</script> <a href="http://toyotabicutan.com.ph/" target="_blank">Toyota Bicutan Parañaque</a>.</strong> All rights reserved. -->
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
