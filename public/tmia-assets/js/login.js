//======= GLOBAL VARIABLES =====
var xemailadd;
var xuname;
var xpword;
//==============================

  $(document).ready( function () {
    //================== GET USER LOG IN INFORMATION =================//
    $.ajax({
        url: "fetch_variable.php",
        dataType: 'json',
        cache: false,
        success: function(data) {
          if (data.signout == true){

            $.post("endsessions.php");

            $.notify({
            title: '<strong>Success!</strong>',
            message: '<br>Log out successfully.',
            icon: 'glyphicon glyphicon-ok-sign'
            },{
              type: 'success',
              onShow: function() {
                this.css({'width':'auto','height':'auto'});
              }
            });
          }
        }
    });
    //=============== END GET USER LOG IN INFORMATION  =================//
  });

  //================== FUNCTIONS =================//

  //================== END FUNCTIONS =================//  
    $(document).on("click","#btnlogin",function(){
      var uname = $("#txtuname").val();
      var pword = $("#txtpword").val();
      var value = {
        uname:uname,
        pword:pword
      };
      $.ajax(
      {
        url : "authenticate.php",
        type: "POST",
        data : value,
        success: function(data, textStatus, jqXHR)
        {
          var data = jQuery.parseJSON(data);
          
          if(data.result == 1){
            // window.open('home','_self');
            //window.location.replace('home');
            var uid2fa = data.uid;
            $.ajax({
              url : "login_check2FA.php",
              type: "POST",
              success: function(data)
              {
                var data = jQuery.parseJSON(data);
                if(data == 1){
                  $.ajax({
                    url : "2fauthenticator_logincheck.php",
                    type: "POST",
                    success: function(data)
                    {
                      var data = jQuery.parseJSON(data);
                      if(data == 1){
                        window.open('2fauthenticator_code','_self');
                      }else{
                        $.post('send_2FA.php', { uid2fa:uid2fa,Open2FAFROM:'LOGIN' }, function(){
                          window.open('2fauthenticator','_self');
                        });
                      }
                    }
                  });
                }else{
                  window.open('home','_self');
                }
              }
            });
            $("#txtuname").val("");
            $("#txtpword").val("");
          }else if(data.result == 2){
            $("#txtuname").focus();
            $("#txtuname").val("");
            $("#txtpword").val("");
            swal({
              title: "User Deactivated!",
              text: "Sorry, this user account is already deactivated.",
              type: "warning",
              showCancelButton: false,
              confirmButtonColor: "#00a65a",
              confirmButtonText: "Ok!"
            });
          }else if(data.result == 3){
            $("#txtpword").focus();
            swal({
              title: "Incorrect password!",
              text: "You enter invalid password.",
              type: "warning",
              showCancelButton: false,
              confirmButtonColor: "#00a65a",
              confirmButtonText: "Ok!"
            });
          }else if(data.result == 4){
            $("#txtuname").focus();
            swal({
              title: "Incorrect username!",
              text: "You enter invalid username.",
              type: "warning",
              showCancelButton: false,
              confirmButtonColor: "#00a65a",
              confirmButtonText: "Ok!"
            });
          }else{
            $("#txtuname").focus();
            $("#txtuname").val("");
            $("#txtpword").val("");
            swal({
              title: "Error!",
              text: "Invalid Login",
              type: "error",
              showCancelButton: false,
              confirmButtonColor: "#00a65a",
              confirmButtonText: "Ok!"
            });
          }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
           swal({
             title: "Error!",
             text: textStatus,
             type: "error",
             showCancelButton: false,
             confirmButtonColor: "#00a65a",
             confirmButtonText: "Ok!"
           });
        }
      });
    });

    $(document).on("click","#forgotpass",function(){
      $('#modalrecover').modal({
        backdrop: 'static',
        keyboard: false,
        show: true
      }).on("shown.bs.modal", function (e) {
        $("#txtrecempid").focus();
      });
    });

    $(document).on("click","#btnrecsubmit",function(){
      var emailaddress = $("#txtrecemailaddress").val();

      if($.trim(emailaddress.length) == 0) {
        $("#txtrecemailaddress").focus();
        swal({
          title: "Warning!",
          text: "Please fill email address.",
          type: "warning",
          showCancelButton: false,
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        });
        return;
      }

      if(emailaddress.trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
        $("#txtrecemailaddress").focus();
        swal({
          title: "Error!",
          text: "Invalid email address. Here is the valid ex. ex@abc.xyz",
          type: "error",
          showCancelButton: false,
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        });
        return;
      }

      $.ajax({
        url : "login_check_user_exist.php",
        type: "POST",
        data : { emailaddress:emailaddress },
        success: function(data)
        {
          var data = jQuery.parseJSON(data);
          if(data.result == 0) {
            $("#txtrecemailaddress").focus();
            swal({
              title: "Email Not Exist!",
              text: "Couldn't find your email address "+emailaddress+".",
              type: "warning",
              showCancelButton: false,
              confirmButtonColor: "#00a65a",
              confirmButtonText: "OK"
            });
            return;
          } else {
            SendEmail();
          }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
          swal({
            title: "Error!",
            text: textStatus,
            type: "error",
            showCancelButton: false,
            confirmButtonColor: "#00a65a",
            confirmButtonText: "OK"
          });
        }
      });

      function SendEmail() {
        $.ajax({
          url : "login_getuser_recovery.php",
          type: "POST",
          data : {emailaddress:emailaddress},
          success: function(data)
          {
            var data = jQuery.parseJSON(data);
  
            $.each(data, function(i, value) {
    
              if (value.Result == 1) {
                var subject = "Account Recovery!";
                var message = "Good day Sir/Madam,\r\n" +
                              "\r\n" +
                              "You have succesfully recovered your TDAP System Account.\r\n" +
                              "You may now log-in to the Online TDAP System Website.\r\n" +
                              "Please kindly see below for the account details:\r\n" +
                              "\r\n" +
                              "Account Details\r\n" +
                              "----------------------------------\r\n" +
                              "Username : " + value.User_Name + "\r\n" +
                              "Temporary Password  : " + value.Password + "\r\n" +
                              "----------------------------------\r\n" +
                              "\r\n" +
                              "Reminder: Please change Password as soon as you login in the System.\r\n" +
                              "\r\n" +
                              "Should you encounter any problems accessing your account, please inform IT Department for assistance.\r\n" +
                              "\r\n\n" +
                              "Thank you!\r\n" +
                              "\r\n" +
                              "This is an TDAP System Auto Generated E-Mail. Please do not reply.\r\n";
          
                var postdata = {
                emailadd:emailaddress,
                subject:subject,
                message:message
                };
          
                $.post( "sendemail.php", postdata );
          
                saveInfo = "TDAP System will send you a message at your recovery email address. Please check your email inbox now.";
          
                /*$.notify('Successfull save data');*/
                swal({
                  title: "Submitted!",
                  text: saveInfo,
                  type: "success",
                  showCancelButton: false,
                  confirmButtonColor: "#00a65a",
                  confirmButtonText: "Ok!",
                  closeOnConfirm: false
                });
          
                $("#txtrecemailaddress").val("");
                $("#modalreg").validator('reset');
                $("#modalrecover").modal('hide');
              }
            });
          }
        });
      }
    });

    $(document).on("click","#btnrecback",function(){
      $("#txtrecemailaddress").val("");
      $("#modalreg").validator('reset');
      $("#modalrecover").modal('hide');
    });

    $.notifyDefaults({
      type: 'success',
      delay: 600
    });
