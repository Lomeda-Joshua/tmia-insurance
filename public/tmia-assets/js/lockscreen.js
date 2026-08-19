//======= GLOBAL VARIABLES =====
var uid2fa;

$(document).ready( function () {

    //================== GET USER LOG IN INFORMATION =================//
    $.ajax({
        url: "fetch_variable.php",
        dataType: 'json',
        cache: false,
        success: function(data) {
          $("#lockscreenname").html(data.logname);
          $("#txtuname").val(data.uname);
          uid2fa = data.userid;
          $.post("endsessions.php");
        }
    });
    //=============== END GET USER LOG IN INFORMATION =================//
  });

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
          $("#txtpword").val("");
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
        }else{
          $("#txtpword").focus();
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

  $.notifyDefaults({
    type: 'success',
    delay: 600
  });
