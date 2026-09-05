//====== USER LOG IN VARIABLES ========
var userid;
var logname;
var ulevel;
var regdate;
var signin;
var table;
var xuname;
///////////////////////// FIRST LOAD SCRIPT ////////////////////////////////////
  $(document).ready( function () {    

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': window.LaravelRoutes.csrfToken
        }
    });

    //============= DRAW TABLE ============//
    //===== USER =====//
    $('#table_user').DataTable({
        language: {
            processing: "Loading User List..."
        },
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        order: [[3, 'asc']], // Orders by User_ID ascending
        ajax: {
            url: window.tableRoute.userData, // Resolves to route('users.data')
            type: "POST",
            data: function (d) {
                // Pass custom filter values safely
                d.searchval = $('#txtsearch').length ? $('#txtsearch').val().trim() : '';
            },
            error: function (xhr, error, code) {
                console.error('DataTables AJAX Error:', xhr.responseText);
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'User_ID', searchable: false, orderable: false },
            { data: 'Full_Name', name: 'Full_Name', defaultContent: '' },
            { data: 'User_Name', name: 'User_Name', defaultContent: '' },
            { data: 'User_Level_Description', name: 'User_Level_Description', defaultContent: '' },
            { data: 'Active', name: 'Active', defaultContent: '' },
            { data: 'Enable2FA', name: 'Enable2FA', defaultContent: '' },
            { data: 'ExpireDate', name: 'ExpireDate' },
            { data: 'button', name: 'button', searchable: false, orderable: false }
        ],
        columnDefs: [
            {
                // Truncate long strings for: Full_Name (Index 2) and User_Name (Index 3)
                targets: [2, 3],
                render: function (data, type, row, meta) {
                    const maxLength = 30;
                    if (typeof data === 'string' && data.length > maxLength) {
                        const truncated = data.substring(0, maxLength) + '...';
                        return `<span class="popup-data" title="${data}" data-full="${data}">${truncated}</span>`;
                    }
                    return data || '';
                }
            }
        ]
    });
    //============= END DRAW TABLE ============//

    /////////////////////// START IZIMODAL ///////////////////////
    /* MODAL MODIFY */
    $("#modal-modify").iziModal({
      title: 'User Account Information Maintenancen',
      subtitle: 'Fill Out All Details Required of User Account.',
      headerColor: 'linear-gradient(0deg, #505050, #bbb, #505050)',
      icon: 'fa fa-list-alt',
      iconColor: '#000',
      zindex: 9999,
      width: 900,
      padding: 20,
      radius: 10,
      focusInput: true,
      loop: true,
      arrowKeys: true,
      navigateCaption: true,
      navigateArrows: true, // Boolean, 'closeToModal', 'closeScreenEdge'
      //history: true,
      //restoreDefaultContent: true,
      fullscreen: true,
      overlay: true,
      overlayClose: false,
      overlayColor: 'rgba(0, 0, 0, 0.4)',
      transitionIn: 'bounceInDown',
      transitionOut: 'bounceOutDown',
      transitionInOverlay: 'fadeIn',
      transitionOutOverlay: 'fadeOut',
      onResize: function(modal){
      // console.log(modal.modalHeight);
      },
      afterRender: function(modal){
      // modal.open();
      }
    });

    $(document).on('fullscreen', '#modal-modify', function (e, modal) {
        console.log('Fullscreen: '+modal.isFullscreen);
    });

    $(document).on('opening', '#modal-modify', function (e) {
        //console.dir(e);
    });

    $(document).on('opened', '#modal-modify', function (e) {
        //console.dir(e);
    });

    $(document).on('closing', '#modal-modify', function (e) {
        //console.dir(e);
        ClearForm();
        $('#modal-modify').iziModal('close');
    });

    $(document).on('closed', '#modal-modify', function (e) {
        //console.dir(e);
        ClearForm();
        $('#modal-modify').iziModal('close');
    });
    /////////////////////// END IZIMODAL ///////////////////////
    //======= User Level =====//
    $.ajax({
      type:"POST",
      url: window.formRoute.userLevelData,
      success: function(data){
        let options = '<option value="">PLEASE SELECT</option>';
    
        // Loop through the JSON array and build <option> tags
        $.each(data.data, function(index, item) {
          options += `<option value="${item.User_Level_ID}">${item.User_Level_Description}</option>`;
      });

      // Inject options into the element and tell Select2 to refresh its UI
      $("#cboulevel").html(options).trigger('change.select2');
      }
    });

    $("#cboulevel").select2({
      allowClear: true,
      width: "100%",
      placeholder: "PLEASE SELECT"
    }).on('select2:close', function() {
      $(this).trigger("change");
    });

    $("#cbouseractive").select2({
      allowClear: false,
      width: "100%"
    }).on('select2:close', function() {
      $(this).trigger("change");
    });

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
  });
///////////////////////// FIRST LOAD SCRIPT ////////////////////////////////////

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

/////////////// COMBO BOX EVENT ///////////////////
  $(document).on('focus', '.select2.select2-container', function (e) {
    var isOriginalEvent = e.originalEvent // don't re-open on closing focus event
    var isSingleSelect = $(this).find(".select2-selection--single").length > 0 // multi-select will pass focus to input

    if (isOriginalEvent && isSingleSelect) {
      $(this).siblings('select:enabled').select2('open');
    }
  });
/////////////// END COMBO BOX EVENT ///////////////////

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
  $(document).on("click","#btnadd",function(){
    ClearForm();
    $('#modal-modify').iziModal('open');
  });

  $(document).on( "click",".btndelete", function() {
    var uid = $(this).data("uid");
    var fullname = $(this).data("fullname");

    swal({
      title: "Delete user?",
      text: "Delete user : "+fullname+" ?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#00a65a",
      confirmButtonText: "Delete",
      closeOnConfirm: false
    },
      function(){
        $.ajax({
          url : "user_delete.php",
          type: "POST",
          data : { uid:uid },
          success: function(data)
          {
            var data = jQuery.parseJSON(data);
            if(data.result ==1){
              /*$.notify('Successfull delete customer');*/
              swal({
                title: "Deleted!",
                text: "Selected record has been deleted succesfully.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#00a65a",
                confirmButtonText: "OK"
              });

              table.ajax.reload( null, false );
              table.search('').columns().search('').draw();
            }else{
              swal({
                title: "Error!",
                text: "Can't delete user data.",
                type: "error",
                showCancelButton: false,
                confirmButtonColor: "#00a65a",
                confirmButtonText: "OK"
              });
            }
          }
        });
    });
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
    } else if($("#cboulevel").val() == '' || $("#cboulevel").val() == null){
      $("#cboulevel").focus();
      swal({
        title: "Warning!",
        text: "Please fill user type.",
        type: "warning",
        showCancelButton: false,
        confirmButtonColor: "#00a65a",
        confirmButtonText: "OK"
      });
      return;
    }
    
    if ($("#appmethod").val() == 'N' || $("#txtpass").val() != '' || $("#txtrpass").val() != '') {
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

    var appmethod = $("#appmethod").val();
    var uid = $("#txtid").val();
    var lname = $("#txtlname").val().trim();
    var fname = $("#txtfname").val().trim();
    var mname = $("#txtmname").val().trim();
    var sname = $("#txtsname").val().trim();
    var dname = $("#txtdname").val().trim();
    var contactno = $("#txtcontactno").val().trim();
    var email = $("#txtemailadd").val().trim();
    var uname = $("#txtuname").val().trim();
    var pword = $("#txtpass").val().trim();
    var ulevel = $("#cboulevel").val();
    var useractive = $("#cbouseractive").val();
    var d = new Date();
    var regdate = [d.getFullYear(),('0' + (d.getMonth() + 1)).slice(-2),('0' + d.getDate()).slice(-2)].join('-');
    var apprdate = [d.getFullYear(),('0' + (d.getMonth() + 1)).slice(-2),('0' + d.getDate()).slice(-2)].join('-');
    var pwdexpdate = $("#dppwdexpdate").val();
    d = new Date(pwdexpdate.split("/").reverse().join("-"));
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
      appmethod:appmethod,
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
      ulevel:ulevel,
      useractive:useractive,
      regdate:regdate,
      apprdate:apprdate,
      pwdexpdate:pwdexpdate,
      chk2fa:chk2fa
    };

    if (appmethod == "N")  {
      CheckUserName();
    } else if (appmethod == "E" && xuname != uname)  {
      CheckUserName();
    } else {
      SaveData();
    }

    function CheckUserName() {
      $.ajax(
        {
          url : window.LaravelRoutes.checkUserAccount,
          type: "POST",
          data : { uname:uname,uid:uid },
          success: function(data)
          {
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
      showLoading("Saving user record..."); // Show spinner before sending request
      $.ajax({
        url : window.SaveRoute.saveNewUserData,
        type: "POST",
        data : value,
        success: function(data)
        {
          if(appmethod == 'N'){
            saveInfo = "New record has been added succesfully.";
          }else {
            saveInfo = "Modified record has been updated succesfully.";
          }

          if(data.result == 1){
            /*$.notify('Successfull save data');*/
            hideLoading();
            swal({
                title: "Saved!",
                text: "Updated successfully.",
                type: "success",
                confirmButtonColor: "#00a65a",
                confirmButtonText: "OK"
            }, function(isConfirm) {
                if (isConfirm) {
                      $('#modal-modify').iziModal('close');
                      
                      ClearForm();
                }
            });

            table.ajax.reload( null, false );
            table.search('').columns().search('').draw();
            
            
           
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
        },
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

  $(document).on("click", ".btnedit", function () {
    var uid = $(this).data("uid");

    if (!uid) {
        swal("Error", "User ID not found.", "error");
        return;
    }

    $.ajax({
        url: "user_get_data.php",
        type: "POST",
        dataType: "json", // Let jQuery parse the JSON
        data: { uid: uid },
        success: function (response) {
          if (response.error) {
            swal("Error", response.error, "error");
            return;
          }

          // Adjusted to match PHP output: a single user object in an array
          var user = response[0]; 

          if (!user) {
            swal("Error", "No user data returned.", "error");
            return;
          }

          // Fill form fields
          $("#appmethod").val("E");
          $("#txtid").val(user.User_ID);
          $("#txtlname").val(user.Last_Name);
          $("#txtfname").val(user.First_Name);
          $("#txtmname").val(user.Middle_Name);
          $("#txtsname").val(user.Suffix_Name);
          $("#txtdname").val(user.Display_Name);
          $("#txtcontactno").val(user.Contact_No);
          $("#txtemailadd").val(user.Email_Address);
          $("#txtuname").val(user.User_Name);
          $("#cboulevel").val(user.User_Level_ID).trigger("change");
          $("#cbouseractive").val(user.Active).trigger("change");

          // Password Expiry Date
          if (user.ExpireDate) {
            let expDate = new Date(user.ExpireDate);
            if (!isNaN(expDate.getTime())) {
              $("#dppwdexpdate").datepicker("setDate", expDate);
            } else {
              $("#dppwdexpdate").val(""); // fallback
            }
          } else {
            $("#dppwdexpdate").val("");
          }

          // 2FA Checkbox
          $("#chk2fa").prop("checked", user.Enable2FA === "YES").trigger("change");

          // Google 2FA Key
          if (user.Google2FAKey) {
            $("#btnunbind").show();
          } else {
            $("#btnunbind").hide();
          }

          // Open the modal and reset validation
          $('#modal-modify').iziModal('open');
          $(".box-body").validator('reset');
      },
      error: function (jqXHR, textStatus, errorThrown) {
        swal("Error", "AJAX error: " + textStatus, "error");
        console.error("AJAX error:", errorThrown);
      }
    });
  });


  $(document).on("click","#btncancel",function(){
    ClearForm();
    $('#modal-modify').iziModal('close');
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
  
  ////////// TWO FACTOR AUTHENTICATOR ///////////////
  $(document).on("change","#chk2fa",function(){
    if ($(this).is(":checked")) {
      if ($("#appmethod").val() == 'E') {
        $(".view2fa").show();
      }
    } else {
      $(".view2fa").hide();
    }
  });

  $(document).on("click","#btntotp", function(){
    var uid2fa = $("#txtid").val();
    $.post('send_2FA.php', { uid2fa:uid2fa,Open2FAFROM:'USERS' }, function(){
      window.open('2fauthenticator','_self');
    });
  });

  $(document).on("click","#btnunbind", function(){
    var uid2fa = $("#txtid").val();
    $.post('send_2FA.php', { uid2fa:uid2fa,Open2FAFROM:'USERS' }, function(){
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

  function ClearForm() {
    $("#appmethod").val("N");
    $("#txtid").val(0);
    $("#txtlname").val("");
    $("#txtfname").val("");
    $("#txtmname").val("");
    $("#txtsname").val("");
    $("#txtdname").val("");
    $("#txtcontactno").val("");
    $("#txtemailadd").val("");
    xuname = "";
    $("#txtuname").val("");
    $("#txtpass").val("");
    $("#txtrpass").val("");
    $("#cboulevel").val("").trigger("change");
    $("#cbouseractive").val("YES").trigger("change");
    $("#dppwdexpdate").val("");
    $("#chk2fa").prop("checked", false).trigger('change')
    $(".box-body").validator('reset');

    // Reset input type to password
    $('#txtpass').prop('type', 'password');
    // Reset icon to eye
    $('#btnpass .ipass')
      .removeClass('fa-eye-slash')
      .addClass('fa-eye');
    // Do the same for repeat password if needed
    $('#txtrpass').prop('type', 'password');
    $('#btnrpass .irpass')
      .removeClass('fa-eye-slash')
      .addClass('fa-eye');
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
    $("#cboutype").attr("disabled",val);
    $("#cbouseractive").attr("disabled",val);
    $(".form-horizontal").validator('reset');
  }
///////////////////////////////////////////////////////

  function getTwentyFourHourTime(amPmString) {
    var d = new Date("1/1/2013 " + amPmString);
    return d.getHours() + ':' + d.getMinutes();
  }

  $.notifyDefaults({
    type: 'success',
    delay: 600
  });
