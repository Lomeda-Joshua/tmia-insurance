    // Set timeout variables.
    var timoutWarning = 900000; // Display warning in 15 minutes (15 * 60 * 1000)
    var timoutNow = 30000;      // Log out 30 seconds after the warning
    var logoutUrl = 'lockscreen'; // URL to logout page.

    var warningTimer;
    var timeoutTimer;

    // Start timers.
    function StartTimers() {
        warningTimer = setTimeout("IdleWarning()", timoutWarning);
    }

    // Reset timers.
    function ResetTimers() {
        clearTimeout(warningTimer);
        clearTimeout(timeoutTimer);
        if($('.modal').hasClass('in') || $('.popover').hasClass('in')){
        }else{
            StartTimers();
        }
        $("#timeout").modal('hide');
    }

    // Show idle timeout warning dialog.
    function IdleWarning() {
        if($('.modal').hasClass('in') || $('.popover').hasClass('in')){
            ResetTimers();
        }else{
            clearTimeout(warningTimer);
            timeoutTimer = setTimeout("IdleTimeout()", timoutNow);

            document.getElementById("countdown").innerHTML = "Time Remaining: 30 s";
            $("#timeout").modal('show');

            // Set the date we're counting down to
            var countDownDate = new Date().getTime();
            countDownDate = countDownDate + 30000;
            // Update the count down every 1 second
            var x = setInterval(function() {
                // Get todays date and time
                var now = new Date().getTime();
                // Find the distance between now an the count down date
                var distance = countDownDate - now;
                // Time calculations for days, hours, minutes and seconds
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                // Output the result in an element with id="countdown"
                document.getElementById("countdown").innerHTML = "Time Remaining: " + seconds + " s";
                // If the count down is over, write some text
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("countdown").innerHTML = "Logging Off!";
                }
            }, 1000);
        }
    }

    // Logout the user.
    function IdleTimeout() {
        /*
        $.ajax({
            url : "timeout.php",
            type: "POST",
            success: function(data)
            { */
                window.location.replace(logoutUrl);
            /*}
        });*/
    }

    $(document).on('keyup keydown keypress blur change mousemove mousedown click scroll', function(){
        ResetTimers();
    });
