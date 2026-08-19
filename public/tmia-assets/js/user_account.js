//====== USER LOG IN VARIABLES ========
var userid;
var logname;
var ulevel;
var regdate;
var signin;
var xuname;
///////////////////////// FIRST LOAD SCRIPT ////////////////////////////////////
  $(document).ready( function () {
    //================== GET USER LOG IN INFORMATION =================//
    $.ajax({
      url: "fetch_variable.php",
      dataType: 'json',
      cache: false,
      success: function(data) {
        userid = data.userid;
        logname = data.logname;
        ulevel = data.ulevel;
        regdate = data.regdate;
        signin = data.signin;
      }
    });
    //=============== END GET USER LOG IN INFORMATION  =================//

    //============== DATE PICKER INITIALIZED ===========//
    $("#dppwdexpdate").datepicker({
      autoclose: true,
      format:'dd/mm/yyyy',
      todayHighlight: true
    });

    $("#dppwdexpdate").click(function(){
      $(this).datepicker({
        autoclose: true,
        format:"dd/mm/yyyy",
        todayHighlight : true
      });
      var pwdexpdate = $(this).val();
      if(pwdexpdate != "" && pwdexpdate != null){
        var d=new Date(pwdexpdate.split("/").reverse().join("-"));
        var dd=d.getDate();
        var mm=d.getMonth();
        var yy=d.getFullYear();
        $(this).datepicker("setDate", new Date(yy, mm, dd));
      }
      $(this).datepicker("update");
      $(this).datepicker("show");
    });

    LoadAccounts();
  });
///////////////////////// FIRST LOAD SCRIPT ////////////////////////////////////

//========= LOAD ACCOUNTS =========
  function LoadAccounts() {
    $.ajax({
      url: "user_account_data.php",
      type: "POST",
      dataType: "json",
      beforeSend: function () {
        // Optional: show loader or disable form
        $("#loader").show();
      },
      success: function (user) {
        if (user.error) {
          swal("Error!", user.error, "error");
          return;
        }

        $("#txtid").val(user.User_ID || "");
        $("#txtlname").val(user.Last_Name || "");
        $("#txtfname").val(user.First_Name || "");
        $("#txtmname").val(user.Middle_Name || "");
        $("#txtsname").val(user.Suffix_Name || "");
        $("#txtdname").val(user.Display_Name || "");
        $("#txtcontactno").val(user.Contact_No || "");
        $("#txtemailadd").val(user.Email_Address || "");
        $("#txtuname").val(user.User_Name || "");
        $("#txtpass").val("");
        $("#txtrpass").val("");
        $("#txtulevel").val(user.User_Level_Description || "");
        $("#txtuseractive").val(user.Active || "");

        // Handle Password Expiration Date
        if (user.ExpireDate && $.fn.datepicker) {
          let expDate = new Date(user.ExpireDate);
          $("#dppwdexpdate").datepicker({ format: "dd/mm/yyyy" })
                            .datepicker("setDate", expDate);
        } else {
          $("#dppwdexpdate").val("");
        }

        // 2FA Checkbox
        $("#chk2fa").prop("checked", user.Enable2FA === 'YES').trigger("change");

        // Show/hide Unbind Button
        if (user.Google2FAKey) {
          $("#btnunbind").show();
        } else {
          $("#btnunbind").hide();
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        swal("Error!", textStatus + ": " + errorThrown, "error");
      },
      complete: function () {
        // Optional: hide loader or re-enable form
        $("#loader").hide();
      }
    });
  }
//////////////////////////////////////////////////////////////

///////////////////////// FETCH VIEW OF DEVICE SCREEN ////////////////////////////////////
  function fetchView(){
    var fetchview = '';
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
            || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))){
      fetchview = 'top';
    } else {
      fetchview = 'left';
    }
    return fetchview;
  }
///////////////////////// END FETCH VIEW OF DEVICE SCREEN ////////////////////////////////////

/////////////// TEXTBOX EVENT ///////////////////
  /*====== LOST FOCUS ======*/
  $(document).on( "blur", "#txtlname", function () {
    var lname = $(this).val().toUpperCase().trim();
    var fname = $("#txtfname").val().toUpperCase().trim();
    var dname;
    if ((fname != '' || fname != null)  && (lname != '' || lname != null)) {
      dname = fname + " " + lname;
    } else {
      dname = lname;
    }
    $("#txtdname").val(dname);
    $("#txtlname").val(lname);
  });

  $(document).on( "blur", "#txtfname", function () {
    var fname = $(this).val().toUpperCase().trim();
    var lname = $("#txtlname").val().toUpperCase().trim();
    var dname;
    if ((fname != '' || fname != null)  && (lname != '' || lname != null)) {
      dname = fname + " " + lname;
    } else {
      dname = fname;
    }
    $("#txtdname").val(dname);
    $("#txtfname").val(fname);
  });

  $(document).on( "blur", "#txtmname", function () {
    var mname = $(this).val().toUpperCase().trim();
    $("#txtmname").val(mname);
  });

  $(document).on( "blur", "#txtsname", function () {
    var sname = $(this).val().toUpperCase().trim();
    $("#txtsname").val(sname);
  });

  $(document).on( "blur", "#txtdname", function () {
    var dname = $(this).val().toUpperCase().trim();
    $("#txtdname").val(dname);
  });
/////////////// END TEXTBOX EVENT ///////////////////

////////////////////////////// BUTTONS CLICKED /////////////////////////////////
  $(document).on("click","#btnedit",function(){
    FormDisable(false);
  });

  $(document).on("click","#btnsave",function(){
    if($("#txtlname").val() == '' || $("#txtlname").val() == null ){
      $("#txtlname").focus();
      swal({
        title: "Warning!",
        text: "Please fill last name.",
        type: "warning",
        showCancelButton: false,
        confirmButtonColor: "#00a65a",
        confirmButtonText: "OK"
      });
      return;
    } else if($("#txtfname").val() == '' || $("#txtfname").val() == null){
      $("#txtfname").focus();
      swal({
        title: "Warning!",
        text: "Please fill first name.",
        type: "warning",
        showCancelButton: false,
        confirmButtonColor: "#00a65a",
        confirmButtonText: "OK"
      });
      return;
    } else if($("#txtdname").val() == '' || $("#txtdname").val() == null){
      $("#txtdname").focus();
      swal({
        title: "Warning!",
        text: "Please fill display name.",
        type: "warning",
        showCancelButton: false,
        confirmButtonColor: "#00a65a",
        confirmButtonText: "OK"
      });
      return;
    } else if($("#txtemailadd").val() == '' || $("#txtemailadd").val() == null){
      $("#txtemailadd").focus();
      swal({
        title: "Warning!",
        text: "Please fill email address.",
        type: "warning",
        showCancelButton: false,
        confirmButtonColor: "#00a65a",
        confirmButtonText: "OK"
      });
      return;
    } else if($("#txtuname").val() == '' || $("#txtuname").val() == null){
      $("#txtuname").focus();
      swal({
        title: "Warning!",
        text: "Please fill username.",
        type: "warning",
        showCancelButton: false,
        confirmButtonColor: "#00a65a",
        confirmButtonText: "OK"
      });
      return;
    } 
    
    if ($("#txtpass").val() != '' || $("#txtrpass").val() != '') {
      if($("#txtpass").val() == '' || $("#txtpass").val() == null){
        $("#txtpass").focus();
        swal({
          title: "Warning!",
          text: "Please fill password.",
          type: "warning",
          showCancelButton: false,
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        });
        return;
      } else if($("#txtrpass").val() == '' || $("#txtrpass").val() == null){
        $("#txtrpass").focus();
        swal({
          title: "Warning!",
          text: "Please fill repeat password.",
          type: "warning",
          showCancelButton: false,
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        });
        return;
      }
    }

    if($("#txtemailadd").val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
      $("#txtemailadd").focus();
      swal({
        title: "Warning!",
        text: "Invalid email address. Here is the valid ex. ex@abc.xyz",
        type: "warning",
        showCancelButton: false,
        confirmButtonColor: "#00a65a",
        confirmButtonText: "OK"
      });
      return;
    }

    if($("#txtpass").val() != $("#txtrpass").val()) {
      $("#txtrpass").focus();
      swal({
        title: "Warning!",
        text: "Password not match. Please check password.",
        type: "warning",
        showCancelButton: false,
        confirmButtonColor: "#00a65a",
        confirmButtonText: "OK"
      });
      return;
    }

    var uid = $("#txtid").val();
    var lname = $("#txtlname").val();
    var fname = $("#txtfname").val();
    var mname = $("#txtmname").val();
    var sname = $("#txtsname").val();
    var dname = $("#txtdname").val();
    var contactno = $("#txtcontactno").val();
    var email = $("#txtemailadd").val();
    var uname = $("#txtuname").val();
    var pword = $("#txtpass").val();
    var pwdexpdate = $("#dppwdexpdate").val();
    var d = new Date(pwdexpdate.split("/").reverse().join("-"));
    pwdexpdate = [d.getFullYear(),('0' + (d.getMonth() + 1)).slice(-2),('0' + d.getDate()).slice(-2)].join('-');
    pwdexpdate = pwdexpdate.replace("NaN-aN-aN","");
    var chk2fa = $("#chk2fa").is(":checked");
    if(chk2fa == true){chk2fa = 'YES';}else{chk2fa = 'NO';}

    if (pword != '') {
      if (isValidPassword(pword) === false) {
        $("#txtpass").focus();
        const result = validatePassword(pword);
        swal({
          title: "Warning!",
          text: '<label style="color: #000;">Password must meet all of the following requirements: be at least 12 minimum characters long and include a combination of uppercase and lowercase letters, numbers, and special characters.</label>' 
                + '<br><br><span style="font-size: 12px; text-align: left; color: #000;">' + result.message + '<span>',
          html: true,
          type: "warning",
          showCancelButton: false,
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        });
        return;
      } 
    }

    var value = {
      uid:uid,
      lname:lname,
      fname:fname,
      mname:mname,
      sname:sname,
      dname:dname,
      contactno:contactno,
      email:email,
      uname:uname,
      pword:pword,
      pwdexpdate:pwdexpdate,
      chk2fa:chk2fa
    };

    if (xuname != uname)  {
      CheckUserName();
    } else {
      SaveData();
    }

    function CheckUserName() {
      $.ajax(
        {
          url : "user_check_uname_exist.php",
          type: "POST",
          data : { uname:uname,uid:uid  },
          success: function(data)
          {
            var data = jQuery.parseJSON(data);
            if(data.result == 1) {
              $("#txtuname").focus();
              $(".box-body").validator('reset');
              swal({
                title: "Record Exist!",
                text: "Username "+uname+" is already in used or taken.",
                type: "warning",
                showCancelButton: false,
                confirmButtonColor: "#00a65a",
                confirmButtonText: "OK"
              });
              return;
            } else {
              SaveData();
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
    }

    function SaveData() {
      $.ajax({
        url : "user_account_save.php",
        type: "POST",
        data : value,
        success: function(data)
        {
          var data = jQuery.parseJSON(data);
          saveInfo = "Modified record has been updated succesfully.";
          if(data.result == 1){
            /*$.notify('Successfull save data');*/
            swal({
              title: "Saved!",
              text: saveInfo,
              type: "success",
              showCancelButton: false,
              confirmButtonColor: "#00a65a",
              confirmButtonText: "OK"
            });

            var subject = "Account Information Updated!";
            var message = "Good day Sir/Madam,\r\n" +
                          "\r\n" +
                          "You have succesfully updated your Online MRSCMF System Account.\r\n" +
                          "Please kindly see below for some details: \r\n" +
                          "\r\n" +
                          "Account Details\r\n" +
                          "-------------------------------------------------------------\r\n" +
                          "Last Name. : " + lname + "\r\n" +
                          "First Name : " + fname + "\r\n" +
                          "Middle Name : " + mname + "\r\n" +
                          "Suffix Name : " + sname + "\r\n" +
                          "Display Name : " + dname + "\r\n" +
                          "Username : " + uname + "\r\n" +
                          "Password : " + pword + "\r\n" +
                          "Contact No. : " + contactno + "\r\n" +
                          "Email Address : " + email + "\r\n" +
                          "-------------------------------------------------------------\r\n" +
                          "\r\n" +
                          "Should you encounter any problems accessing your account, please inform IT Department for assistance.\r\n" +
                          "\r\n" +
                          "Thank you!\r\n" +
                          "\r\n" +
                          "This is an MRSCMF System Auto Generated E-Mail. Please do not reply.\r\n";

            var postdata = {
            emailadd:email,
            subject:subject,
            message:message
            };

            $.post( "sendemail.php", postdata );

            FormDisable(true);
            LoadAccounts();

          }else{
            swal({
              title: "Error!",
              text: "Can't save user.",
              type: "error",
              showCancelButton: false,
              confirmButtonColor: "#00a65a",
              confirmButtonText: "OK"
            });
          }
        }
      });
    }

    function isValidPassword(password) {
      const minLength = 12;
      const hasUpperCase = /[A-Z]/.test(password);
      const hasLowerCase = /[a-z]/.test(password);
      const hasNumber = /\d/.test(password);
      const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);
    
      return (
        password.length >= minLength &&
        hasUpperCase &&
        hasLowerCase &&
        hasNumber &&
        hasSpecialChar
      );
    }

    function validatePassword(password) {
      const warnings = [''];
    
      if (password.length < 12) {
        warnings.push("<br>❌ Password must have a minimum of 12 characters.");
      } else {
        warnings.push("<br>✅ Password must have a minimum of 12 characters.");
      }
    
      if (!/[A-Z]/.test(password)) {
        warnings.push("<br>❌ Password must include at least one uppercase letter(A–Z).");
      } else {
        warnings.push("<br>✅ Password must include at least one uppercase letter(A–Z).");
      }

      if (!/[a-z]/.test(password)) {
        warnings.push("<br>❌ Password must include at least one lowercase letter(a–z).");
      } else {
        warnings.push("<br>✅ Password must include at least one lowercase letter(a–z).");
      }
    
      if (!/\d/.test(password)) {
        warnings.push("<br>❌ Password must include at least one number (0–9).");
      } else {
        warnings.push("<br>✅ Password must include at least one number (0–9).");
      }
    
      if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
        warnings.push("<br>❌ Password must include at least one special character (e.g., !@#$%).");
      } else {
        warnings.push("<br>✅ Password must include at least one special character (e.g., !@#$%).");
      }
    
      if (warnings.length === 0) {
        return { valid: true, message: "Password is valid." };
      } else {
        return { valid: false, message: warnings.join("") };
      }
    }
  });

  $(document).on("click","#btncancel",function(){
    FormDisable(true);
    LoadAccounts();
  });

  $(document).on("click", "#btnpass, #btnrpass", function () {
    const $btn = $(this);
    const $group = $btn.closest(".input-group");
    const $input = $group.find("input");
    const $icon = $btn.find("i");

    const isText = $input.prop("type") === "text";
    $input.prop("type", isText ? "password" : "text");

    // Toggle the icon
    $icon.toggleClass("fa-eye fa-eye-slash");
  });

  ///////////// TWO FACTOR AUTHENTICATOR ////////////////////
  $(document).on("change","#chk2fa",function(){
    if ($(this).is(":checked")) {
      $(".view2fa").show();
    } else {
      $(".view2fa").hide();
    }
  });

  $(document).on("click","#btntotp", function(){
    var uid2fa = $("#txtid").val();
    $.post('send_2FA.php', { uid2fa:uid2fa,Open2FAFROM:'ACCOUNT' }, function(){
      window.open('2fauthenticator','_self');
    });
  });

  $(document).on("click","#btnunbind", function(){
    var uid2fa = $("#txtid").val();
    $.post('send_2FA.php', { uid2fa:uid2fa,Open2FAFROM:'ACCOUNT' }, function(){
      swal({
        title: "Unbind TOTP Code?",
        text: "This action will disable the Time-based One-Time Password!\nAre your sure?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#00a65a",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm) {
        if (isConfirm) {
          $.ajax({
            url: "2fauthenticator_unbind.php",
            dataType: 'json',
            cache: false,
            success: function(data)
            {
              var data = jQuery.parseJSON(data);
              if(data == 1){
                $("#btnunbind").hide();
                swal({
                  title: "Unbinded TOTP!",
                  text: "Two-Factor Authentication (2FA) has been successfully disable.",
                  type: "success",
                  showCancelButton: false,
                  confirmButtonColor: "#00a65a",
                  confirmButtonText: "OK"
                });
              }
            }
          });
        } else {
          $("#chk2fa").prop("checked",true);
          swal({
            title: "Cancelled",
            text: "Your TOTP is safe. 😃",
            type: "error",
            showCancelButton: false,
            confirmButtonColor: "#00a65a",
            confirmButtonText: "OK"
          });
        }
      });
    });
  });
////////////////////////////// END BUTTONS CLICKED /////////////////////////////////
  function getTwentyFourHourTime(amPmString) {
      var d = new Date("1/1/2013 " + amPmString);
      return d.getHours() + ':' + d.getMinutes();
  }

  /////////////////// ENABLED OR DISABLED /////////////////////
  function FormDisable(val) {
    $("#txtlname").focus();
    $("#txtlname").attr("disabled",val);
    $("#txtfname").attr("disabled",val);
    $("#txtmname").attr("disabled",val);
    $("#txtsname").attr("disabled",val);
    $("#txtdname").attr("disabled",val);
    $("#txtcontactno").attr("disabled",val);
    $("#txtemailadd").attr("disabled",val);
    $("#txtuname").attr("disabled",val);
    $("#txtpass").attr("disabled",val);
    $("#txtrpass").attr("disabled",val);
    $(".form-horizontal").validator('reset');

    
    if (ulevel === "ADMINISTRATOR") {
      $("#dppwdexpdate").attr("disabled",val);
      $("#chk2fa").attr("disabled",val);
    }

    if(val == true) {
      $("#btnedit").show();
      $(".actionbtn").hide();
    } else {
      $("#btnedit").hide();
      $(".actionbtn").show();
    }
  }
///////////////////////////////////////////////////////

  $.notifyDefaults({
    type: 'success',
    delay: 600
  });
