//====== USER LOG IN VARIABLES ========
var dealercode;
var userid;
var logname;
var ulevel;
var regdate;
var signin;
var xcustno;
var xcustnoupload;
var xvin;
var xcsno;
var xplateno;
let insuranceno;
var xpayid
var xtpremium;
var newdata;
let table;
var rowindex;
let editingRow;
var editinfo = false;
var btnselect;
var viewpending = false;
var viewexpiring = false;
var editpay = false;
var editnetrem = false;
var editcall = false;
var editstatus = false;
var activeCustTab;
var activeVehTab;
///////////////////////// FIRST LOAD SCRIPT ////////////////////////////////////
$(document).ready( function () {

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': window.LaravelRoutes.csrfToken
    }
});
  //================== GET USER LOG IN INFORMATION =================//
//   $.ajax({
//     url: "fetch_variable.php",
//     dataType: 'json',
//     cache: false,
//     success: function(data) {
//       userid = data.userid;
//       logname = data.logname;
//       ulevel = data.ulevel;
//       regdate = data.regdate;
//       dealercode = data.dealercode;
//       signin = data.signin;

//       if (ulevel == 'ADMINISTRATOR' || ulevel == 'INSURANCE STAFF') {
//         $(".btnactionud").show();
//       } else {
//         $(".btnactionud").hide();
//       }
//     }
//   });
  //=============== END GET USER LOG IN INFORMATION  =================//

  //============= TOOLTIPS ============//
  // Enable tooltips globally
  $("body").tooltip({
    selector: ".popup-data",
    placement: "left",
    trigger: "hover"
  });

  $("body").tooltip({
    selector: ".badge",
    placement: "top",
    title: "Transaction Status",
    trigger: "hover"
  });

  // Initialize tooltips once
  $(".popup-data").tooltip({
    placement: "left",
    trigger: "hover"
  });

  $(".badge").tooltip({
    placement: "top",
    title: "Transaction Status",
    trigger: "hover"
  });

  $(document).on("mouseleave", ".popup-data, .badge", function () {
    $(this).tooltip("hide");
  });
  //============= END TOOLTIPS ============//

  /* MODAL MODIFY */
  // MODAL MODIFY ISE 
  $("#modal-modify-ise").iziModal({
    title: 'Select Insurance Staff',
    subtitle: 'Select insurance staff assigned to new insurance.',
    headerColor: 'linear-gradient(0deg, #505050, #bbb, #505050)',
    icon: 'fa-solid fa-user-shield',
    iconColor: '#000',
    zindex: 9999,
    width: 450,
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
    // openFullscreen: true,
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

  $(document).on('fullscreen', '#modal-modify-ise', function (e, modal) {
    // console.log('Fullscreen: '+modal.isFullscreen);
  });

  $(document).on('opening', '#modal-modify-ise', function (e) {
    //console.dir(e);
  });

  $(document).on('opened', '#modal-modify-ise', function (e) {
    $(".box-body").validator('reset');
    $(".iziModal-wrap").scrollTop(0);
  });

  $(document).on('closing', '#modal-modify-ise', function (e) {
    // Fix accessibility warning: blur focused element before aria-hidden is set
    if (document.activeElement) {
        document.activeElement.blur();
    }
  });

  $(document).on('closed', '#modal-modify-ise', function (e) {
    //console.dir(e);
  });

  // ADD NEW BUSINESS INSURANCE
  $("#modal-add").iziModal({
    title: 'Create New Business Insurance',
    subtitle: 'Fill out all details required here.',
    headerColor: 'linear-gradient(0deg, #505050, #bbb, #505050)',
    icon: 'fa fa-list-alt',
    iconColor: '#000',
    zindex: 9999,
    width: 1000,
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
    // openFullscreen: true,
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

  $(document).on('fullscreen', '#modal-add', function (e, modal) {
    // console.log('Fullscreen: '+modal.isFullscreen);
  });

  $(document).on('opening', '#modal-add', function (e) {
    //console.dir(e);
  });

  $(document).on('opened', '#modal-add', function (e) {
    $(".iziModal-wrap").scrollTop(0); 
    // Triggers the click event
    $('#btnfindcustomer').trigger('click');
  });

  $(document).on('closing', '#modal-add', function (e) {
    // Fix accessibility warning: blur focused element before aria-hidden is set
    if (document.activeElement) {
        document.activeElement.blur();
    }
  });

  $(document).on('closed', '#modal-add', function (e) {
    editinfo = false;
    FormClear();
    FormDisable(true);
    $("#cboise").val("").trigger('change.select2');
    $(".box-body").validator('reset');
  });

  /* MODAL CUSTOMER LIST*/
  $("#modal-customerlist").iziModal({
    title: 'Customer List',
    subtitle: 'List of customer.',
    headerColor: 'linear-gradient(0deg, #505050, #bbb, #505050)',
    icon: 'fa fa-list-alt',
    iconColor: '#000',
    zindex: 9999,
    width: 1400,
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
    // openFullscreen: true,
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

  $(document).on('closing', '#modal-customerlist', function (e) {
    // Fix accessibility warning: blur focused element before aria-hidden is set
    if (document.activeElement) {
        document.activeElement.blur();
    }
  });

  /* MODAL VEHICLE LIST*/
  $("#modal-vehiclelist").iziModal({
    title: 'Customer Vehicle List',
    subtitle: 'List of vehicle owned by customer.',
    headerColor: 'linear-gradient(0deg, #505050, #bbb, #505050)',
    icon: 'fa fa-list-alt',
    iconColor: '#000',
    zindex: 9999,
    width: 1400,
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
    // openFullscreen: true,
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

  $(document).on('closing', '#modal-vehiclelist', function (e) {
    // Fix accessibility warning: blur focused element before aria-hidden is set
    if (document.activeElement) {
        document.activeElement.blur();
    }
  });

  /* MODAL MODIFY PAYMENT */
  $("#modal-modify-pay").iziModal({
    title: 'Payment Information Details',
    subtitle: 'Fill out all details required here.',
    headerColor: 'linear-gradient(0deg, #505050, #bbb, #505050)',
    icon: 'fa-solid fa-peso-sign',
    iconColor: '#000',
    zindex: 9999,
    width: 1400,
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
    // openFullscreen: true,
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

  $(document).on('fullscreen', '#modal-modify-pay', function (e, modal) {
    // console.log('Fullscreen: '+modal.isFullscreen);
  });

  $(document).on('opening', '#modal-modify-pay', function (e) {
    //console.dir(e);
  });

  $(document).on('opened', '#modal-modify-pay', function (e) {
    $(".iziModal-wrap").scrollTop(0); 
  });

  $(document).on('closing', '#modal-modify-pay', function (e) {
    // Fix accessibility warning: blur focused element before aria-hidden is set
    if (document.activeElement) {
        document.activeElement.blur();
    }
  });

  $(document).on('closed', '#modal-modify-pay', function (e) {
    //console.dir(e);
  });

  /* MODAL MODIFY CHANGE STATUS */
  $("#modal-modify-status").iziModal({
    title: 'Modify / Change Transaction Status',
    subtitle: 'Fill out all details required here.',
    headerColor: 'linear-gradient(0deg, #505050, #bbb, #505050)',
    icon: 'fa-solid fa-chart-bar',
    iconColor: '#000',
    zindex: 9999,
    width: 500,
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
    // openFullscreen: true,
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

  $(document).on('fullscreen', '#modal-modify-status', function (e, modal) {
    // console.log('Fullscreen: '+modal.isFullscreen);
  });

  $(document).on('opening', '#modal-modify-status', function (e) {
    //console.dir(e);=
  });

  $(document).on('opened', '#modal-modify-status', function (e) {
    $(".iziModal-wrap").scrollTop(0); 
  });

  $(document).on('closing', '#modal-modify-status', function (e) {
    // Fix accessibility warning: blur focused element before aria-hidden is set
    if (document.activeElement) {
        document.activeElement.blur();
    }
  });

  $(document).on('closed', '#modal-modify-status', function (e) {
    //console.dir(e);
  });

  /* MODAL MODIFY NET REM */
  $("#modal-modify-netrem").iziModal({
    title: 'Modify GP / Net Rem',
    subtitle: 'Fill out all details required here.',
    headerColor: 'linear-gradient(0deg, #505050, #bbb, #505050)',
    icon: 'fa-solid fa-money-bill-transfer',
    iconColor: '#000',
    zindex: 9999,
    width: 350,
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
    // openFullscreen: true,
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

  $(document).on('fullscreen', '#modal-modify-netrem', function (e, modal) {
    // console.log('Fullscreen: '+modal.isFullscreen);
  });

  $(document).on('opening', '#modal-modify-netrem', function (e) {
    //console.dir(e);=
  });

  $(document).on('opened', '#modal-modify-netrem', function (e) {
    $(".iziModal-wrap").scrollTop(0); 
  });

  $(document).on('closing', '#modal-modify-netrem', function (e) {
    // Fix accessibility warning: blur focused element before aria-hidden is set
    if (document.activeElement) {
        document.activeElement.blur();
    }
  });

  $(document).on('closed', '#modal-modify-netrem', function (e) {
    //console.dir(e);
  });

  /* MODAL CALL STATUS */
  $("#modal-call").iziModal({
    title: 'Call Status Modification',
    subtitle: 'Display call status information details.',
    headerColor: 'linear-gradient(0deg, #505050, #bbb, #505050)',
    icon: 'fa fa-list-alt',
    iconColor: '#000',
    zindex: 9999, 
    // width: 900,
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
    // openFullscreen: true,
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

  $(document).on('fullscreen', '#modal-call', function (e, modal) {
    // console.log('Fullscreen: '+modal.isFullscreen);
  });

  $(document).on('opening', '#modal-call', function (e) {
    //console.dir(e);
  });

  $(document).on('opened', '#modal-call', function (e) {
    //console.dir(e);
  });

  $(document).on('closing', '#modal-call', function (e) {
    // Fix accessibility warning: blur focused element before aria-hidden is set
    if (document.activeElement) {
        document.activeElement.blur();
    }
  });

  $(document).on('closed', '#modal-call', function (e) {
    // editcall = false;
    // FormClearCall();
    // FormDisableCall(true);
    // $(".box-body").validator('reset');
  });

  /* MODAL CALL LOGS */
  $("#modal-logs").iziModal({
    title: 'Call Logs History',
    subtitle: 'Display all call logs of the selected vehicle.',
    headerColor: 'linear-gradient(0deg, #505050, #bbb, #505050)',
    icon: 'fa fa-list-alt',
    iconColor: '#000',
    zindex: 9999, 
    width: 1400,
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
    // openFullscreen: true,
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

  $(document).on('fullscreen', '#modal-logs', function (e, modal) {
    // console.log('Fullscreen: '+modal.isFullscreen);
  });

  $(document).on('opening', '#modal-logs', function (e) {
    //console.dir(e);
  });

  $(document).on('opened', '#modal-logs', function (e) {
    //console.dir(e);
  });

  $(document).on('closing', '#modal-logs', function (e) {
    // Fix accessibility warning: blur focused element before aria-hidden is set
    if (document.activeElement) {
        document.activeElement.blur();
    }
  });

  $(document).on('closed', '#modal-logs', function (e) {
    //console.dir(e);
  });

  /* MODAL UPLOAD EXCEL FILE */
  $("#modal-upload").iziModal({
    title: 'Upload Excel File',
    subtitle: 'Locate your excel file you want to upload.',
    headerColor: 'linear-gradient(0deg, #505050, #bbb, #505050)',
    icon: 'fa fa-list-alt',
    iconColor: '#000',
    zindex: 9999,
    width: 1000,
    padding: 20,
    radius: 10,
    focusInput: true,
    loop: true,
    arrowKeys: true,
    navigateCaption: true,
    navigateArrows: true, // Boolean, 'closeToModal', 'closeScreenEdge'
    //history: true,
    //restoreDefaultContent: true,
    // fullscreen: true,
    openFullscreen: true,
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

  $(document).on('fullscreen', '#modal-upload', function (e, modal) {
    // console.log('Fullscreen: '+modal.isFullscreen);
  });

  $(document).on('opening', '#modal-upload', function (e) {
    //============= DRAW TABLE ============//
    if ($.fn.DataTable.isDataTable("#table_upload") == false) {
      $('#table_upload').DataTable({
        "searching": false,
        "info": false,
        "scrollY": "500px",
        "scrollX": true,
        "scrollCollapse": true,
        "paging": false,
        "ordering": false,
        "fixedHeader": true,
        "fixedColumns":   {
          "left": 1
        },
        "columnDefs": [{
          "targets": [ 27 ],
          "visible": false,
        }]
      }).columns.adjust().draw();
    }
  });

  $(document).on('opened', '#modal-upload', function (e) {
    //console.dir(e);
  });

  $(document).on('closing', '#modal-upload', function (e) {
    // Fix accessibility warning: blur focused element before aria-hidden is set
    if (document.activeElement) {
        document.activeElement.blur();
    }
  });

  $(document).on('closed', '#modal-upload', function (e) {
    $("#table_upload").DataTable().clear().draw();
    $("#cntgood").text('GOOD : 0 Record(s)');
    $("#cntupdated").text('UPDATED : 0 Record(s)');
    $("#cntduplicate").text('DUPLICATE : 0 Record(s)');
    $("#cntfailed").text('FAILED : 0 Record(s)');
    $("#cnttotal").text('TOTAL : 0 Record(s)');
    $("#filexls").val(null);
    $(".box-body").validator('reset');
  });

  $("#modaluploading").iziModal({
    title: 'Importing Data',
    subtitle: 'Please wait while importing data...',
    headerColor: 'linear-gradient(0deg, #505050, #bbb, #505050)',
    icon: 'fa fa-spinner fa-spin',
    iconColor: '#000',
    zindex: 10500,   // Higher than your main modal
    width: 400,
    padding: 20,
    radius: 10,
    fullscreen: false,
    overlay: true,
    overlayClose: false,
    overlayColor: 'rgba(0, 0, 0, 0.4)',
    transitionIn: 'fadeIn',
    transitionOut: 'fadeOut',
    // Prevent closing modal by escape key or clicking overlay
    closeOnEscape: false,
    closeButton: false,
    // Open on init for testing, comment in real use
    // onOpening: function() { console.log('Loading modal opened'); }
  });

   $("#modalsaving").iziModal({
    title: 'Saving Data',
    subtitle: 'Please wait while saving data...',
    headerColor: 'linear-gradient(0deg, #505050, #bbb, #505050)',
    icon: 'fa fa-spinner fa-spin',
    iconColor: '#000',
    zindex: 10500,   // Higher than your main modal
    width: 400,
    padding: 20,
    radius: 10,
    fullscreen: false,
    overlay: true,
    overlayClose: false,
    overlayColor: 'rgba(0, 0, 0, 0.4)',
    transitionIn: 'fadeIn',
    transitionOut: 'fadeOut',
    // Prevent closing modal by escape key or clicking overlay
    closeOnEscape: false,
    closeButton: false,
    // Open on init for testing, comment in real use
    // onOpening: function() { console.log('Loading modal opened'); }
  });
  /////////////////////// END IZIMODAL ///////////////////////

  //============== COMBO BOX INITIALIZED ===========//
  //======= Insurance  Staff =====//
  $.ajax({
        type: "POST",
        url: window.LaravelRoutes.insuranceStaffData,
        dataType: "json",
        success: function(response) {
            var options = '<option value="">PLEASE SELECT</option>';
            $.each(response, function(index, item) {
                options += '<option value="' + item.ISE_No + '">' + item.ISE_Name + '</option>';
            });
            $("#cboise").html(options).trigger("change");
        }
  });

  $("#cboise").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });

  /*--------------------- CUSTOMER INFO --------------------*/
  //======= Customer Type =====//
  $.ajax({
    type:"GET",
    url:window.LaravelRoutes.customerTypeData,
    success: function(data) {
      $("#cbogroup").html(data);
    }
  });

  $("#cbogroup").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });

  //======= Region =====//
  $.ajax({
    type:"POST",
    url:"fetch_region.php",
    success: function(data) {
      $("#cboregion").html(data);
    }
  });

  $("#cboregion").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });

  //======= Province =====//
  $("#cboprovince").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });

  //======= City / Municipal =====//
  $("#cbocity").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });

  //======= Barangay =====//
  $("#cbobrgy").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });

  //======= Country =====//
  $("#cbocountry").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });

  /*--------------------- VEHICLE INFO --------------------*/
  //======= Body Type =====//
  $.ajax({
    type:"POST",
    url:"fetch_body_type.php",
    success: function(data) {
      $("#cbobodytype").html(data);
    }
  });

  $("#cbobodytype").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });

  //======= Fuel Type =====//
  $.ajax({
    type:"POST",
    url:"fetch_fuel_type.php",
    success: function(data) {
      $("#cbofueltype").html(data);
    }
  });

  $("#cbofueltype").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });

  //======= Product Classification =====//
  $.ajax({
    type:"POST",
    url:"fetch_product_class.php",
    success: function(data) {
      $("#cboprodclass").html(data);
    }
  });

  $("#cboprodclass").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });

   //======= Owner Type =====//
  $.ajax({
    type:"POST",
    url:"fetch_customer_type.php",
    success: function(data) {
      $("#cboowntype").html(data);
    }
  });

  $("#cboowntype").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });

  /*--------------------- PAYMENT INFO --------------------*/ 
  //======= Payment Type =====//
  $.ajax({
    type:"POST",
    url:"fetch_payment_type.php",
    success: function(data) {
      $("#cbopaytype, #cbopaytype-n").html(data);
    }
  });

  $("#cbopaytype, #cbopaytype-n").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });

  //======= E-Wallet Type =====//
  $.ajax({
    type:"POST",
    url:"fetch_ewallet_type.php",
    success: function(data) {
      $("#cboewallet, #cboewallet-n").html(data);
    }
  });

  $("#cboewallet, #cboewallet-n").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });

 /*--------------------- INSURER INFO --------------------*/ 
  //======= Insurance Type =====//
  $.ajax({
    type:"POST",
    url:"fetch_insurance_type.php",
    success: function(data) {
      $("#cboinstype").html(data);
    }
  });

  $("#cboinstype").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });

  //======= Insurance =====//
  $.ajax({
    type:"POST",
    url:"fetch_insurance_co.php",
    success: function(data) {
      $("#cboinsco").html(data);
    }
  });

  $("#cboinsco").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });

  //======= Bank =====//
  $.ajax({
    type:"POST",
    url:"fetch_banks.php",
    success: function(data) {
      $("#cbomortgage").html(data);
    }
  });

  $("#cbomortgage").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });

  /*--------------------- CHANGE STATUS --------------------*/ 
  //======= Transaction Status =====//
  $.ajax({
    type:"POST",
    data:{ businesstype: "NEW BUSINESS" },
    url:"fetch_transaction_status.php",
    success: function(data) {
      $("#cbotransstatus").html(data);
    }
  });

  $("#cbotransstatus").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });

  /*--------------------- CALL STATUS --------------------*/ 
  //======= Communication Type =====//
  $.ajax({
    type:"POST",
    url:"fetch_communication_type.php",
    success: function(data) {
      $("#cbomodecomm").html(data);
    }
  });

  $("#cbomodecomm").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });

  //======= Call Status Type =====//
  $.ajax({
    type:"POST",
    url:"fetch_call_status.php",
    success: function(data) {
      $("#cbocallstatus").html(data);
    }
  });

  $("#cbocallstatus").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });

  //======= Call Reason =====//
  $("#cbocallreason").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });
  //============== END COMBO BOX INITIALIZED ===========//

  //================== DATE & TIME PICKER ===================//
  /*--------------------- CUSTOMER INFO --------------------*/
  $("#dpbirthdate").datepicker({
    autoclose: true,
    format:'dd-MM-yyyy',
    todayHighlight : true
  });

  /*--------------------- VEHICLE INFO --------------------*/
  $("#dpvsidate").datepicker({
    autoclose: true,
    format:'dd-MM-yyyy',
    todayHighlight : true
  });

  $("#dpreldate").datepicker({
    autoclose: true,
    format:'dd-MM-yyyy',
    todayHighlight : true
  });

  $("#dptechdate").datepicker({
    autoclose: true,
    format:'dd-MM-yyyy',
    todayHighlight : true
  });

  /*--------------------- PAYMENT INFO --------------------*/
  $('#txtccexpirydate, #txtccexpirydate-n').inputmask('99/99');

  $("#dppdccheckdate, #dppdccheckdate-n").datepicker({
    autoclose: true,
    format:'dd-MM-yyyy',
    todayHighlight : true
  });

  /*--------------------- INSURER INFO --------------------*/
  $("#dpstartdate").datepicker({
    autoclose: true,
    format:'dd-MM-yyyy',
    todayHighlight : true
  });

  $("#dpissuedate").datepicker({
    autoclose: true,
    format:'dd-MM-yyyy',
    todayHighlight : true
  });

  $("#dppexpiredate").datepicker({
    autoclose: true,
    format:'dd-MM-yyyy',
    todayHighlight : true
  });

  /*--------------------- CALL STATUS --------------------*/
  $("#dpppdate").datepicker({
    autoclose: true,
    format:'dd-MM-yyyy',
    todayHighlight : true
  });

  //================== Date From & Date To Picker ===================//
  var today = new Date();
  var d = new Date(new Date().setDate(today.getDate() - 30));
  //d.setMonth(d.getMonth() - 3);
  var dd = d.getDate();
  var yy = d.getFullYear();
  var mm = d.getMonth();

  $("#dpdatefrom").datepicker({
    autoclose: true,
    format:'dd-MM-yyyy',
    todayHighlight : true
  }).datepicker("setDate", new Date(yy,mm,dd));

  $("#dpdateto").datepicker({
    autoclose: true,
    format:'dd-MM-yyyy',
    todayHighlight : true
  }).datepicker("setDate", new Date());
  //==================================================//
  //================== END DATE & TIME PICKER ===================//

  //======= Clearable text inputs =======//
  function tog(v){return v ? "addClass" : "removeClass";} 
  $(document).on("input", ".clearable", function(){
      $(this)[tog(this.value)]("x");
  }).on("mousemove", ".x", function( e ){
      $(this)[tog(this.offsetWidth-18 < e.clientX-this.getBoundingClientRect().left)]("onX");
  }).on("touchstart click", ".onX", function( ev ){
      ev.preventDefault();
      $(this).removeClass("x onX").val("").change();
      
      LoadTransactionData();
  });

  $(document).on("input", ".clearable-s", function(){
      $(this)[tog(this.value)]("x");
  }).on("mousemove", ".x", function( e ){
      $(this)[tog(this.offsetWidth-18 < e.clientX-this.getBoundingClientRect().left)]("onX");
  }).on("touchstart click", ".onX", function( ev ){
      ev.preventDefault();
      $(this).removeClass("x onX").val("").change();
      
      if (activeCustTab === '#tmiatab') {
        LoadCustomerData();
      }

      if (activeCustTab === '#uploadtab') {
        LoadCustomerDataEDAFSAP();
      }
  });

  const container = document.getElementById('alphabet-container');

  // Function to create a button
  function createButton(label, isActive = false) {
    const button = document.createElement('button');
    button.textContent = label;
    if (isActive) {
      button.classList.add('active');
    }
    button.addEventListener('click', () => {
      document.querySelectorAll('.alphabet-buttons button').forEach(btn => btn.classList.remove('active'));
      button.classList.add('active');
      // You can add your custom action here (e.g., filter items)
      btnselect = `${label}`;

      // activeCustTab = $('.customertab li.active a').attr('href');

      // console.log(activeCustTab); // #tmiatab or #uploadtab

      if (activeCustTab === '#tmiatab') {
        LoadCustomerData();
      }

      if (activeCustTab === '#uploadtab') {
        LoadCustomerDataEDAFSAP();
      }
    });
    return button;
  }

  // Add "All" button first
  container.appendChild(createButton("ALL"));

  // Add A-Z buttons
  for (let i = 65; i <= 90; i++) {
    const letter = String.fromCharCode(i);
    const isActive = letter === 'A'; // Set "A" as default
    container.appendChild(createButton(letter, isActive));
  }

  // Add Other button first
  container.appendChild(createButton("[0-9]"));
  container.appendChild(createButton("[SPECIAL CHAR]"));

  btnselect = 'A';

  LoadStatusCounts();
});
///////////////////////// END FIRST LOAD SCRIPT ////////////////////////////////////

//======= Function Load Master Data ============//
//============== COUNTS PENDING ===============//
function LoadStatusCounts() {
  $.ajax({
    type:"POST",
    url:window.LaravelRoutes.nbpendingcounts,
    dataType: "json",
    success: function(data) {
      $("#pending-counts").text(NumberFormat(data.Pending_Counts,0));
      $("#expiring-counts").text(NumberFormat(data.Expiring_Counts,0));
    }
  });
}

//============== Transaction List ============//
function LoadTransactionData() {
  const searchval = $("#txtsearch").val().trim();
  const datefromRaw = $("#dpdatefrom").val();
  const datetoRaw = $("#dpdateto").val();
  const chkall = $("#chkall").is(":checked") ? 1 : 0;

  const datefrom = formatDate(datefromRaw);
  const dateto = formatDate(datetoRaw);

  const value = {
    viewpending: viewpending,
    viewexpiring: viewexpiring,
    searchval: searchval,
    datefrom: datefrom,
    dateto: dateto,
    chkall: chkall
  };

  console.log(value);

    if ($.fn.DataTable.isDataTable('#table_trans')) {
      // Dynamically reload existing table instance without destroying DOM
      $('#table_trans').DataTable().ajax.reload();
      return;
    }

    const table = $('#table_trans').DataTable({
        language: {
            processing: "Loading Transaction List..."
        },
        processing: true,
        serverSide: true,
        deferLoading: 0,
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        order: [[2, 'desc']], // Orders by Trans_Date descending
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Mandatory for POST
        },
        ajax: {
            url: window.LaravelRoutes.newBusinessData,
            type: "POST",
            data: function (d) {
                // Pass custom request parameters to controller
                d.viewpending = window.viewpending === true;
                d.viewexpiring = window.viewexpiring ?? true;
                d.searchval = $('#txtsearch').val().trim();
                d.datefrom = value.datefrom;
                d.dateto = value.dateto;
                d.chkall = value.chkall;
            },
            error: function (xhr, error, code) {
                console.error('DataTables AJAX Error:', xhr.responseText);
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false },
            { data: 'Insurance_No', name: 'Insurance_No' },
            { data: 'Trans_Date', name: 'Trans_Date' },
            { data: 'Trans_Status', name: 'Trans_Status' },
            { data: 'Customer_No', name: 'Customer_No' },
            { data: 'Full_Name', name: 'Full_Name', defaultContent: '' },
            { data: 'Contact_No', name: 'Contact_No', defaultContent: '' },
            { data: 'VIN', name: 'VIN', defaultContent: '' },
            { data: 'CS_No', name: 'CS_No', defaultContent: '' },
            { data: 'Plate_No', name: 'Plate_No', defaultContent: '' },
            { data: 'Model', name: 'Model', defaultContent: '' },
            { data: 'Variant', name: 'Variant', defaultContent: '' },
            { data: 'Insurance_Company', name: 'Insurance_Company', defaultContent: '' },
            { data: 'ISE_Name', name: 'ISE_Name', defaultContent: '' },
            { data: 'MP_Name', name: 'MP_Name', defaultContent: '' },
            { data: 'button', name: 'button', searchable: false, orderable: false }
        ],
        columnDefs: [
            {
                // Truncate long strings for: Full_Name (5), Variant (11), Insurance_Company (12), ISE_Name (13), MP_Name (14)
                targets: [5, 11, 12, 13, 14],
                render: function(data, type, row, meta) {
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
  
  viewpending = false;
  viewexpiring = false;
}
//======================================//

//============== Customer List ============//
function LoadCustomerData() {
  const searchval = $("#txtcustomersearch").val().trim();
  if (typeof btnselect === 'undefined') { btnselect = '';}

  const value = {
    searchval:searchval,
    btnselect:btnselect
  };

  if ($.fn.dataTable.isDataTable('#table_customerlist')) {
    $('#table_customerlist').DataTable().clear().destroy();               
  }

    const tableCustomerList = $('#table_customerlist').DataTable({
        language: {
            processing: "Loading Customer List..."
        },
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        order: [[1, 'asc']], // Orders by Customer_No ascending
        ajax: {
            url: window.LaravelRoutes.customerData, // Uses named route matching Laravel setup
            type: "GET",
            data: function (d) {
                d.searchval = $('#txtsearch_customer').val() ? $('#txtsearch_customer').val().trim() : '';
            },
            error: function (xhr, error, code) {
                console.error('Customer DataTables AJAX Error:', xhr.responseText);
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false },
            { data: 'Customer_No', name: 'Customer_No', defaultContent: '' },
            { data: 'Group', name: 'Group', defaultContent: '' },
            { data: 'Full_Name', name: 'Full_Name', defaultContent: '' },
            { data: 'Birth_Date', name: 'Birth_Date', defaultContent: '' },
            { data: 'Contact_No', name: 'Contact_No', defaultContent: '' },
            { data: 'Email_Address', name: 'Email_Address', defaultContent: '' },
            { data: 'Full_Address', name: 'Full_Address', defaultContent: '' },
            { data: 'Upload_Cust_No', name: 'Upload_Cust_No', defaultContent: '' },
            { data: 'TIN', name: 'TIN', defaultContent: '' },
            { data: 'Active_Status', name: 'Active_Status', defaultContent: '' }
        ],
        columnDefs: [
            {
                // Truncate long strings for: Full_Name (3), Email_Address (6), Full_Address (7)
                targets: [3, 6, 7],
                render: function(data, type, row, meta) {
                    const maxLength = 30;
                    if (typeof data === 'string' && data.length > maxLength) {
                        const truncated = data.substring(0, maxLength) + '...';
                        return `<span class="popup-data" title="${data}" data-full="${data}">${truncated}</span>`;
                    }
                    return data || '';
                }
            },
            {
                targets: [10], // Format Active_Status
                render: function (data) {
                    return data == "1" || data == "ACTIVE" ? "ACTIVE" : "INACTIVE";
                }
            }
        ]
    });

  // ✅ Bind row click for selection AFTER table initialization
  $('#table_customerlist tbody').off('click', 'tr').on('click', 'tr', function () {
    // Remove selection from any previously selected row
    table.$('tr.selected').removeClass('selected');

    // Highlight clicked row
    $(this).addClass('selected');

    // Optional: get Customer_No
    xcustno = table.cell(this, 1).data();
    console.log('Selected Customer No:', xcustno);

    xcustnoupload = table.cell(this, 8).data();
    xvin = table.cell(this, 9).data();
    xcsno = table.cell(this, 10).data();
    xplateno = table.cell(this, 11).data();
  });

  // ✅ Bind row click for selection AFTER table initialization
  $('#table_customerlist tbody').off('dblclick', 'tr').on('dblclick', 'tr', function () {
     $('#btncustselect').trigger("click");
  });
}

//============== Customer List FROM DAF/SAP ============//
function LoadCustomerDataEDAFSAP() {
  const searchval = $("#txtcustomersearch").val().trim();
  if (typeof btnselect === 'undefined') { btnselect = '';}

  const value = {
    searchval:searchval,
    btnselect:btnselect
  };

  if ($.fn.dataTable.isDataTable('#table_customerlistupload')) {
    $('#table_customerlistupload').DataTable().clear().destroy();               
  }

  table = $('#table_customerlistupload').DataTable({
    language: {
      processing: "Loading Customer List..."
    },
    processing: true,
    serverSide: false,
    pageLength: 10,
    responsive: true,
    autoWidth: false,
    ajax: {
      url: "fetch_upload_customers.php",
      type: "POST",
      data: value
    },
    columns: [
      { data: "urutan" },
      { data: "Customer_No" },
      { data: "Group" },
      { data: "Full_Name" },
      { data: "Birth_Date" },
      { data: "Contact_No" },
      { data: "Email_Address" },
      { data: "Address" },
      { data: "VIN" },
      { data: "CS_No" },
      { data: "Plate_No" },
      { data: "Variant" },
    ],
    columnDefs: [
      {
        targets: [3, 7, 11],
        render: function(data, type, row, meta) {
          const maxLength = 30;
          if (typeof data === 'string' && data.length > maxLength) {
            const truncated = data.substring(0, maxLength) + '...';
            return `<span class="popup-data" title="${data}" data-full="${data}">${truncated}</span>`;
          }
          return data;
        }
      }
    ]
  });

  // ✅ Bind row click for selection AFTER table initialization
  $('#table_customerlistupload tbody').off('click', 'tr').on('click', 'tr', function () {
    // Remove selection from any previously selected row
    table.$('tr.selected').removeClass('selected');

    // Highlight clicked row
    $(this).addClass('selected');

    // Optional: get Customer_No
    xcustno = '';
    xcustnoupload = table.cell(this, 1).data();
    console.log('Selected Customer No:', xcustnoupload);

    xvin = table.cell(this, 8).data();
    xcsno = table.cell(this, 9).data();
    xplateno = table.cell(this, 10).data();
  });

  // ✅ Bind row click for selection AFTER table initialization
  $('#table_customerlistupload tbody').off('dblclick', 'tr').on('dblclick', 'tr', function () {
     $('#btncustselect').trigger("click");
  });
}

//============== Vehicle List ============//
function LoadVehicleData() {
  if ($.fn.dataTable.isDataTable('#table_vehiclelist')) {
    $('#table_vehiclelist').DataTable().clear().destroy();               
  }

  table = $('#table_vehiclelist').DataTable({
    language: {
      processing: "Loading Vehicle List..."
    },
    processing: true,
    serverSide: false,
    pageLength: 10,
    responsive: true,
    autoWidth: false,
    ajax: {
      url: "new_business_vehicles.php",
      type: "POST",
      data: {custno:xcustno}
    },
    columns: [
      { data: "urutan" },
      { data: "VIN" },
      { data: "Model" },
      { data: "Model_Year" },
      { data: "Variant" },
      { data: "Color" },
      { data: "Engine_No" },
      { data: "CS_No" },
      { data: "Plate_No" },
      { data: "VSI_Date" },
      {
        data: "SRP",
        render: function (data) {
          return NumberFormat(data);
        }
      }
    ],
    columnDefs: [
      {
        targets: [4],
        render: function(data, type, row, meta) {
          const maxLength = 30;
          if (typeof data === 'string' && data.length > maxLength) {
            const truncated = data.substring(0, maxLength) + '...';
            return `<span class="popup-data" title="${data}" data-full="${data}">${truncated}</span>`;
          }
          return data;
        }
      }
    ]
  });

  // ✅ Bind row click for selection AFTER table initialization
  $('#table_vehiclelist tbody').off('click', 'tr').on('click', 'tr', function () {
    // Remove selection from any previously selected row
    table.$('tr.selected').removeClass('selected');

    // Highlight clicked row
    $(this).addClass('selected');

    // Optional: get Customer_No
    xvin = table.cell(this, 1).data();
    console.log('Selected VIN:', xvin);
    xcsno = table.cell(this, 7).data();
    xplateno = table.cell(this, 8).data();
  });

  // ✅ Bind row click for selection AFTER table initialization
  $('#table_vehiclelist tbody').off('dblclick', 'tr').on('dblclick', 'tr', function () {
     $('#btnvehselect').trigger("click");
  });
}

function LoadVehicleEDAFSAPData() {
  if ($.fn.dataTable.isDataTable('#table_uploadvehlist')) {
    $('#table_uploadvehlist').DataTable().clear().destroy();               
  }

  table = $('#table_uploadvehlist').DataTable({
    language: {
      processing: "Loading Vehicle List..."
    },
    processing: true,
    serverSide: false,
    pageLength: 10,
    responsive: true,
    autoWidth: false,
    ajax: {
      url: "fetch_vehicle_upload.php",
      type: "POST",
      data: {custno:xcustnoupload}
    },
    columns: [
      { data: "urutan" },
      { data: "VIN" },
      { data: "Model" },
      { data: "Model_Year" },
      { data: "Variant" },
      { data: "Color" },
      { data: "Engine_No" },
      { data: "CS_No" },
      { data: "Plate_No" },
      { data: "VSI_Date" },
      {
        data: "SRP",
        render: function (data) {
          return NumberFormat(data);
        }
      }
    ],
    columnDefs: [
      {
        targets: [4],
        render: function(data, type, row, meta) {
          const maxLength = 30;
          if (typeof data === 'string' && data.length > maxLength) {
            const truncated = data.substring(0, maxLength) + '...';
            return `<span class="popup-data" title="${data}" data-full="${data}">${truncated}</span>`;
          }
          return data;
        }
      }
    ]
  });

  // ✅ Bind row click for selection AFTER table initialization
  $('#table_uploadvehlist tbody').off('click', 'tr').on('click', 'tr', function () {
    // Remove selection from any previously selected row
    table.$('tr.selected').removeClass('selected');

    // Highlight clicked row
    $(this).addClass('selected');

    // Optional: get Customer_No
    xvin = table.cell(this, 1).data();
    console.log('Selected VIN:', xvin);
    xcsno = table.cell(this, 7).data();
    xplateno = table.cell(this, 8).data();
  });

  // ✅ Bind row click for selection AFTER table initialization
  $('#table_uploadvehlist tbody').off('dblclick', 'tr').on('dblclick', 'tr', function () {
     $('#btnvehselect').trigger("click");
  });
}
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

/////////////////////// START LOAD DATA FUNCTION ///////////////////////
//===== LOAD DATA TO MODIFY =====
function LoadCustomerInfo() {
  $.ajax({
    type:"POST",
    url:"fetch_customer_info.php",
    data:{custno:xcustno},
    success: function(data){
      var data = jQuery.parseJSON(data);
      $.each(data, function(i, value) {

        // Helper: set select option safely
        function setSelectOption(selector, text, val) {
          const select = $(selector);
          if (select.find(`option[value="${val}"]`).length) {
            select.val(val).trigger("change.select2");
          } else {
            const newOpt = new Option(text, val, true, true);
            select.append(newOpt).trigger("change.select2");
          }
        }

        $("#txtcustno").val(value.Customer_No);
        xcustnoupload = value.Upload_Cust_No;
        $("#txtcustnoupload").val(value.Upload_Cust_No);
        setSelectOption("#cbogroup", value.Group, value.Group);
        if (value.Group === "INDIVIDUAL") {
          $(".customer-fleet-corp").fadeOut();
          $(".customer-individual").fadeIn();
          $(".birth-date").fadeIn();
        } else {
          $(".customer-fleet-corp").fadeIn();
          $(".customer-individual").fadeOut();
          $(".birth-date").fadeOut();
        }
        $("#txtcustname").val(value.Full_Name);
        $("#txtcustfname").val(value.First_Name);
        $("#txtcustmname").val(value.Middle_Name);
        $("#txtcustlname").val(value.Last_Name);
        $("#txtcustsname").val(value.Suffix_Name);

        // Safe date handling
        if (value.Birth_Date) {
          const safeDate = new Date(value.Birth_Date);
          if (!isNaN(safeDate)) {
            $("#dpbirthdate").datepicker("setDate", safeDate);
          }
        }
        $("#txttin").val(value.TIN);
        $("#txtcontactno").val(value.Contact_No);
        $("#txtemailadd").val(value.Email_Address);
        $("#txtaddress").val(value.Address);
        
        // Location: Region
        if (value.RegCode) {
          setSelectOption("#cboregion", value.Region, value.RegCode);
          FetchProv(value.RegCode, value.ProvCode);
        }

        // Province
        if (value.ProvCode) {
          setSelectOption("#cboprovince", value.Province, value.ProvCode);
          FetchCM(value.ProvCode, value.CMCode);
        }

        // City/Municipality
        if (value.CMCode) {
          setSelectOption("#cbocity", value.CityMunicipal, value.CMCode);
          FetchBrgy(value.CMCode, value.BrgyCode);
        }

        $("#txtzipcode").val(value.Zip_Code);
        setSelectOption("#cbocountry", value.Country, value.Country);
      });
    }
  });
  
  LoadVehicleInfo();

  $(".box-body").validator('reset');
}

function LoadCustomerEDAFSAPInfo() {
  $.ajax({
    type:"POST",
    url:"fetch_upload_customer_info.php",
    data:{custno:xcustnoupload},
    success: function(data){
      var data = jQuery.parseJSON(data);
      $.each(data, function(i, value) {

        // Helper: set select option safely
        function setSelectOption(selector, text, val) {
          const select = $(selector);
          if (select.find(`option[value="${val}"]`).length) {
            select.val(val).trigger("change.select2");
          } else {
            const newOpt = new Option(text, val, true, true);
            select.append(newOpt).trigger("change.select2");
          }
        }

        if(value.Cust_Exist){
          $("#txtcustno").val(value.Customer_No);
          $("#txtcustnoupload").val(value.Upload_Cust_No);
        } else {
          $("#txtcustno").val('');
          $("#txtcustnoupload").val(value.Customer_No);
        }

        setSelectOption("#cbogroup", value.Group, value.Group);
        if (value.Group === "INDIVIDUAL") {
          $(".customer-fleet-corp").fadeOut();
          $(".customer-individual").fadeIn();
          $(".birth-date").fadeIn();
        } else {
          $(".customer-fleet-corp").fadeIn();
          $(".customer-individual").fadeOut();
          $(".birth-date").fadeOut();
        }
        $("#txtcustname").val(value.Full_Name);
        $("#txtcustfname").val(value.First_Name);
        $("#txtcustmname").val(value.Middle_Name);
        $("#txtcustlname").val(value.Last_Name);
        $("#txtcustsname").val(value.Suffix_Name);

        // Safe date handling
        if (value.Birth_Date) {
          const safeDate = new Date(value.Birth_Date);
          if (!isNaN(safeDate)) {
            $("#dpbirthdate").datepicker("setDate", safeDate);
          }
        }
        $("#txttin").val(value.TIN);
        $("#txtcontactno").val(value.Contact_No);
        $("#txtemailadd").val(value.Email_Address);
        $("#txtaddress").val(value.Address);
        
        // Location: Region
        if (value.RegCode) {
          setSelectOption("#cboregion", value.Region, value.RegCode);
          FetchProv(value.RegCode, value.ProvCode);
        }

        // Province
        if (value.ProvCode) {
          setSelectOption("#cboprovince", value.Province, value.ProvCode);
          FetchCM(value.ProvCode, value.CMCode);
        }

        // City/Municipality
        if (value.CMCode) {
          setSelectOption("#cbocity", value.CityMunicipal, value.CMCode);
          FetchBrgy(value.CMCode, value.BrgyCode);
        }

        $("#txtzipcode").val(value.Zip_Code);
        setSelectOption("#cbocountry", value.Country, value.Country);
      });
    }
  });

  LoadVehicleEDAFSAPInfo();

  $(".box-body").validator('reset');
}

function LoadVehicleInfo() {
  $.ajax({
    type:"POST",
    url:"fetch_vehicle_info.php",
    data:{vin:xvin, csno:xcsno, plateno:xplateno},
    success: function(data){
      var data = jQuery.parseJSON(data);
      $.each(data, function(i, value) {

        // Helper: set select option safely
        function setSelectOption(selector, text, val) {
          const select = $(selector);
          if (select.find(`option[value="${val}"]`).length) {
            select.val(val).trigger("change.select2");
          } else {
            const newOpt = new Option(text, val, true, true);
            select.append(newOpt).trigger("change.select2");
          }
        }

        $("#txtvin").val(value.VIN);
        $("#txtmake").val(value.Make);
        $("#txtmodel").val(value.Model);
        $("#txtmodelyear").val(value.Model_Year);
        $("#txtcolor").val(value.Color);
        $("#txtengineno").val(value.Engine_No);
        $("#txtcsno").val(value.CS_No);
        $("#txtplateno").val(value.Plate_No);
        // $("#txtorderno").val(value.Order_No);
        // $("#txtorderstatus").val(value.Order_Status);
        $("#txtsrp").val(NumberFormat(value.SRP));
        
        // Safe date handling
        if (value.VSI_Date) {
          const safeVSIDate = new Date(value.VSI_Date);
          if (!isNaN(safeVSIDate)) {
            $("#dpvsidate").datepicker("setDate", safeVSIDate);
          }
        }

        if (value.Released_Date) {
          const safeRelDate = new Date(value.Released_Date);
          if (!isNaN(safeRelDate)) {
            $("#dpreldate").datepicker("setDate", safeRelDate);
          }
        }

        if (value.Technical_Date) {
          const safeTechDate = new Date(value.Technical_Date);
          if (!isNaN(safeTechDate)) {
            $("#dptechdate").datepicker("setDate", safeTechDate);
          }
        }

        // $("#txtmsalecode").val(value.Model_Sales_Code);
        $("#txtvariant").val(value.Variant);
        setSelectOption("#cbobodytype", value.Body_Type, value.Body_Type);
        $("#txttransmission").val(value.Transmission);
        setSelectOption("#cbofueltype", value.Fuel_Type, value.Fuel_Type);
        $("#txtseats").val(value.Seats);
        // $("#txtunloadweight").val(value.Unloaded_Weight);
        // $("#txtmaxweight").val(value.Max_Weight);
        setSelectOption("#cboprodclass", value.Prod_Classify, value.Prod_Classify);
        setSelectOption("#cboowntype", value.Owner_Type, value.Owner_Type);
        $("#txtvoname").val(value.Owner_Name);
        $("#txtmpname").val(value.MP_Name);
      });
    }
  });
  
  $(".box-body").validator('reset');
}

function LoadVehicleEDAFSAPInfo() {
  $.ajax({
    type:"POST",
    url:"fetch_vehicle_upload_info.php",
    data:{vin:xvin, csno:xcsno, plateno:xplateno},
    success: function(data){
      var data = jQuery.parseJSON(data);
      $.each(data, function(i, value) {

        // Helper: set select option safely
        function setSelectOption(selector, text, val) {
          const select = $(selector);
          if (select.find(`option[value="${val}"]`).length) {
            select.val(val).trigger("change.select2");
          } else {
            const newOpt = new Option(text, val, true, true);
            select.append(newOpt).trigger("change.select2");
          }
        }

        $("#txtvin").val(value.VIN);
        $("#txtmake").val(value.Make);
        $("#txtmodel").val(value.Model);
        $("#txtmodelyear").val(value.Model_Year);
        $("#txtcolor").val(value.Color);
        $("#txtengineno").val(value.Engine_No);
        $("#txtcsno").val(value.CS_No);
        $("#txtplateno").val(value.Plate_No);
        // $("#txtorderno").val(value.Order_No);
        // $("#txtorderstatus").val(value.Order_Status);
        $("#txtsrp").val(NumberFormat(value.SRP));
        
        // Safe date handling
        if (value.VSI_Date) {
          const safeVSIDate = new Date(value.VSI_Date);
          if (!isNaN(safeVSIDate)) {
            $("#dpvsidate").datepicker("setDate", safeVSIDate);
          }
        }

        if (value.Released_Date) {
          const safeRelDate = new Date(value.Released_Date);
          if (!isNaN(safeRelDate)) {
            $("#dpreldate").datepicker("setDate", safeRelDate);
          }
        }

        if (value.Technical_Date) {
          const safeTechDate = new Date(value.Technical_Date);
          if (!isNaN(safeTechDate)) {
            $("#dptechdate").datepicker("setDate", safeTechDate);
          }
        }

        // $("#txtmsalecode").val(value.Model_Sales_Code);
        $("#txtvariant").val(value.Variant);
        setSelectOption("#cbobodytype", value.Body_Type, value.Body_Type);
        $("#txttransmission").val(value.Transmission);
        setSelectOption("#cbofueltype", value.Fuel_Type, value.Fuel_Type);
        $("#txtseats").val(value.Seats);
        // $("#txtunloadweight").val(value.Unloaded_Weight);
        // $("#txtmaxweight").val(value.Max_Weight);
        setSelectOption("#cboprodclass", value.Prod_Classify, value.Prod_Classify);
        setSelectOption("#cboowntype", value.Owner_Type, value.Owner_Type);
        $("#txtvoname").val(value.Owner_Name);
        $("#txtmpname").val(value.MP_Name);
      });
    }
  });
  
  $(".box-body").validator('reset');
}

function LoadPayData() {
  $.ajax({
    type:"POST",
    url:"fetch_transactions_nb.php",
    data:{insuranceno:insuranceno},
    success: function(data){
      var data = jQuery.parseJSON(data);
      $.each(data, function(i, value) {
        // xtpremium = value.Total_Premium;
        xtpremium = value.Gross_Premium;
        $("#txtpayterms").val(value.Month_Terms);
        $("#txtpayamount").val(NumberFormat(value.Month_Pay));
      });

      LoadPaymentInfo();
      $('#modal-modify-pay').iziModal('open');
    }
  });
}

function LoadPaymentInfo() {
  // Destroy existing table if present
  if ($.fn.dataTable.isDataTable('#table_payment')) {
    $('#table_payment').DataTable().clear().destroy();
    $('#table_payment tbody').off(); // remove previous event handlers
  }

  var tablepay = $('#table_payment').DataTable({
      language: {
          processing: "Loading Payment List..."
      },
      processing: true,
      serverSide: false,
      responsive: true,
      autoWidth: false,
      ordering: false,
      searching: false,
      paging: false,
      info: false,
      scrollX: true,
      scrollCollapse: true, 
      fnRowCallback: function (nRow, aData, iDisplayIndex) {
        // Auto-number column
        $("td:first", nRow).html(iDisplayIndex + 1);
        return nRow;
      },
      ajax: {
          url: "new_business_payment.php",
          type: "POST",
          data: { insuranceno: insuranceno }
      },
      drawCallback: function () {
        // 🔥 Calculate totals after data is loaded/refreshed
        updatePaymentTotals();
      },
      columnDefs: [{ targets: [11], visible: false }],
      columns: [
          { data: null },            // Auto numbering
          { data: "Payment_ID" },
          { data: "Payment_Type" },
          { data: "EWallet_Type" },
          { data: "PDC_No" },
          { data: "PDC_Account_Name" },
          { data: "PDC_Bank_Name" },
          { data: "PDC_Date" },
          { data: "Payment_Terms" },
          {
            data: "Payment_Amount",
            render: function (data) {
              return NumberFormat(data);
            }
          },
          {
            data: "Payment_Date",
            render: function (data) {
              return getDisplayDateTimeFormatted(data);
            }
          },
          {
            data: "button",          // 11
            className: "never",     // never show in responsive child rows
            searchable: false,
            orderable: false
          }
      ]
  });

  // ============================
  // FIXED: Row click selection
  // ============================
  // $('#table_payment tbody').off('click', 'tr').on('click', 'tr', function () {
  //   // remove previous selection
  //   tablepay.$('tr.selected').removeClass('selected');

  //   // highlight clicked row
  //   $(this).addClass('selected');

  //   // get Payment_ID instead of undefined variable
  //   let selectedPaymentID = tablepay.row(this).data().Payment_ID;
  //   console.log("Selected Payment ID:", selectedPaymentID);
  // });

  // ============================
  // Row double-click event
  // ============================
  $('#table_payment tbody').off('dblclick', 'tr').on('dblclick', 'tr', function () {
    if (!editpay) return; // 🚫 do nothing if editpay is false

    var balance = $("#tfoot_balance").text();
    balance = RemoveNumFormat(balance);

    // remove previous selection
    tablepay.$('tr.selected').removeClass('selected');

    // highlight clicked row
    $(this).addClass('selected');

    // Get row data
    var rowData = tablepay.row(this).data();
    editingRow = tablepay.row(this); // store reference for later update

    // Populate form fields
    xpayid = rowData.Payment_ID;
    if (balance <= 0) {
      $("#cbopaytype").val(rowData.Payment_Type).trigger("change.select2");
    } else {
      $("#cbopaytype").val(rowData.Payment_Type).trigger("change");
    }
    $("#cboewallet").val(rowData.EWallet_Type).trigger("change.select2");

    $("#txtccno").val(rowData.CC_No || "");
    $("#txtccholder").val(rowData.CC_Holder || "");
    $("#txtccexpirydate").val(rowData.CC_Expiry || "");
    $("#txtccvv").val(rowData.CC_CVV || "");

    $("#txtpdcno").val(rowData.PDC_No || "");
    $("#txtpdcholdername").val(rowData.PDC_Account_Name || "");
    $("#txtpdcbankname").val(rowData.PDC_Bank_Name || "");
    $("#dppdccheckdate").val(rowData.PDC_Date || "");

    $("#txtpayterms").val(rowData.Payment_Terms || "");
    $("#txtpayamount").val(rowData.Payment_Amount || "");
  });
}

function updatePaymentTotals() {
  var tablepay = $("#table_payment").DataTable();
  var data = tablepay.rows().data();

  var total = 0;
  let hasMissingID = false;

  data.each(function(row){
    var amt = parseFloat(String(row.Payment_Amount).replace(/,/g, "")) || 0;
    total += amt;

    if (row.Payment_ID === null || row.Payment_ID === '') {
      hasMissingID = true;
    }
  });

  // Premium from input or hidden field
  // Total Premium
  var premium = xtpremium || 0;
  premium = RemoveNumFormat(premium);
  var balance = premium - total;

  premium = NumberFormat(premium);
  total = NumberFormat(total);
  balance = NumberFormat(balance);

  // Display total payment
  $("#tfoot_tpremium").text(premium);
  $("#tfoot_total").text(total);
  $("#tfoot_balance").text(balance);

  if (editpay == true) {
    if (balance <= 0) {
      $(".pay-section, .term-amount-section, .btnadd-section").fadeOut();
      if (hasMissingID == false){
        $("#btnupdatepay").fadeOut(); 
      } else {
        $("#btnupdatepay").fadeIn();  
      }
    } else {
      $(".pay-section, .term-amount-section, .btnadd-section, #btnupdatepay").fadeIn();
    }
  }
}

function LoadNetRemData() {
  $.ajax({
    type:"POST",
    url:"fetch_transactions_nb.php",
    data:{insuranceno:insuranceno},
    success: function(data){
      var data = jQuery.parseJSON(data);
      $.each(data, function(i, value) {
        $("#txtinsgpremium").val(NumberFormat(value.Gross_Premium,2));
        $("#txtnetrem").val(NumberFormat(value.Net_Rem,2));
        $("#txtinscommission").val(NumberFormat(value.Commission,2));
      });
    }
  });

  if ($('#modal-modify-netrem').is(':visible') == false) {
    $('#modal-modify-netrem').iziModal('open');
  }
  $(".box-body").validator('reset');
}

function LoadStatusData() {
  $.ajax({
    type:"POST",
    url:"fetch_transactions_nb.php",
    data:{insuranceno:insuranceno},
    success: function(data){
      var data = jQuery.parseJSON(data);
      $.each(data, function(i, value) {

        // Helper: set select option safely
        function setSelectOption(selector, text, val) {
          const select = $(selector);
          if (select.find(`option[value="${val}"]`).length) {
            select.val(val).trigger("change.select2");
          } else {
            const newOpt = new Option(text, val, true, true);
            select.append(newOpt).trigger("change.select2");
          }
        }

        setSelectOption("#cbotransstatus", value.Trans_Status, value.Trans_Status); 
        $("#txttranssremarks").val(value.Trans_Status_Remarks);
      });
    }
  });

  if ($('#modal-modify-status').is(':visible') == false) {
    $('#modal-modify-status').iziModal('open');
  }
  $(".box-body").validator('reset');
}

function LoadCallData() {
  $.ajax({
    type:"POST",
    url:"fetch_transaction_nb_call.php",
    data:{insuranceno:insuranceno},
    success: function(data){
      var data = jQuery.parseJSON(data);
      $.each(data, function(i, value) {
        $("#txtinsuranceno").val(value.Insurance_No);
        if(value.Communication_ID !== null){
          if ($("#cbomodecomm").find("option[value='" + value.Communication_ID + "']").length) {
            $("#cbomodecomm").val(value.Communication_ID).trigger('change');
          } else { 
            var newmodecomm = new Option(value.Communication_Type, value.Communication_ID, true, true);
            $("#cbomodecomm").append(newmodecomm).trigger('change');
          }
        }
        if(value.Call_SID !== null){
          if ($("#cbocallstatus").find("option[value='" + value.Call_SID + "']").length) {
            $("#cbocallstatus").val(value.Call_SID).trigger('change');
          } else { 
            var newcallstatus = new Option(value.Call_Status, value.Call_SID, true, true);
            $("#cbocallstatus").append(newcallstatus).trigger('change');
          } 
          FetchCall(value.Call_SID,value.Reason_ID);
        }
        if (value.Promised_Pay_Date !== null && value.Promised_Pay_Date !== ''){
          $("#dpppdate").datepicker("setDate", new Date(value.Promised_Pay_Date));
        } else {
          $("#dpppdate").val('');
        } 
        $("#txtcallremarks").val(value.Call_Remarks);
      });
    }
  });
  
  if ($('#modal-call').is(':visible') == false) {
    $('#modal-call').iziModal('open');
  }
  $(".box-body").validator('reset');
}

function LoadCallLogsData() {
  // If DataTable exists, destroy it and reinitialize
  if ($.fn.dataTable.isDataTable('#table_logs')) {
    $('#table_logs').DataTable().clear().destroy();               
  }

  // Reinitialize the DataTable with updated AJAX configuration
  $('#table_logs').DataTable({
    "language": {
      "processing": "Loading Call Logs History",
    },
    "processing": true,
    "deferRender": true,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "scrollY": "500px",
    "scrollX": true,
    "scrollCollapse": true,
    "fixedHeader": true,
    "fixedColumns":   {
      "left": 1
    },
    "info": true,
    "autoWidth": false,
    "pageLength": 10,
    "ajax": {
      "url": "fetch_call_logs_nb.php",
      "type": "POST",
      "data": {insuranceno:insuranceno}
    },
    "columns": [
      { "data": "urutan" },
      { "data": "Call_LogID" },
      { "data": "Call_Log_Date" },
      { "data": "Insurance_No" },
      { "data": "Customer_Name" },
      { "data": "Contact_No" },
      { "data": "VIN" },
      { "data": "Communication_Type" },
      { "data": "Call_Status" },
      { "data": "Reason_Desc" },
      { "data": "Promised_Pay_Date" },
      { "data": "Call_Remarks" },
      { "data": "User_Name" }
    ],
    "columnDefs": [
      {
        "targets": [4, 9, 11],  // Modify this if you want to target multiple columns
        "render": function(data, type, row, meta) {
          var maxLength = 25; // Set max length for truncation
          if (data.length > maxLength) {
            var truncatedData = data.substring(0, maxLength) + '...';
            return '<span class="popup-data" data-full="' + data + '" title="' + data + '">' + truncatedData + '</span>'; // Set full data in custom data attribute
          }
          return data; // Return original data if no truncation needed
        }
      },
    ]
  });

  if ($('#modal-logs').is(':visible') == false) {
    $('#modal-logs').iziModal('open');
  }
}
/////////////////////// END LOAD DATA FUNCTION ///////////////////////

//============= TAB CUSTOMER ============//
$(document).ready( function () {
  activeCustTab = $('.customertab li.active a').attr('href');

  console.log(activeCustTab); // #tmiatab or #uploadtab

  $('.customertab a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    activeCustTab = $(e.target).attr('href');

    if (activeCustTab === '#tmiatab') {
      console.log('TMIA tab selected');
      LoadCustomerData();
    }

    if (activeCustTab === '#uploadtab') {
      console.log('Upload tab selected');
      LoadCustomerDataEDAFSAP();
    }
  });

  activeVehTab = $('.customervehtab li.active a').attr('href');

  console.log(activeVehTab); // #tmiavehtab or #uploadvehtab

  $('.customervehtab a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    activeVehTab = $(e.target).attr('href');

    if (activeVehTab === '#tmiavehtab') {
      console.log('TMIA Vehicle tab selected');
      LoadVehicleData();
    }

    if (activeVehTab === '#uploadvehtab') {
      console.log('Upload Vehicle tab selected');
      LoadVehicleEDAFSAPData();
    }
  });
  
});
//============= END TAB CUSTOMER ============//

/////////////////////////////// DATATABLE CLICK EVENT ////////////////////////////////////
$('#table_trans tbody').on('click', 'tr', function(event) {
  //csno = table.cell(this,2).data();
  //plateno = table.cell(this,2).data();
  /*
    btnaction = table.cell(this,13).data();
    if(x != undefined) {
      btnaction = btnaction.replace('class="btn btn-success btn-action btnattach"','class="btn btn-success bg-navy btnattach"');
      rowindex = table.row( this ).index();
      //table.cell(this,13).data(x);
      console.log(x);
    }
  */
  rowindex = table.row( this ).index();
});

$('#table_trans tbody').on('click', '.btncall', function () {

  let tr = $(this).closest('tr');

  // If this is a child row, get the parent
  if (tr.hasClass('child')) {
    tr = tr.prev();
  }

  const row = table.row(tr);
  const rowData = row.data();

  if (!rowData) {
    console.error('Row data not found');
    return;
  }

  $("#txtinsuranceno").val(rowData.Insurance_No || '');
  $("#txtsfcustname").val(rowData.Full_Name || '');
  $("#txtsfcontactno").val(rowData.Contact_No || '');
  $("#txtsfvin").val(rowData.VIN || '');
});
///////////////////////////////////////////////////////////////////

/////////////// COMBO BOX EVENT ///////////////////
$(document).on('focus', '.select2.select2-container', function (e) {
  var isOriginalEvent = e.originalEvent // don't re-open on closing focus event
  var isSingleSelect = $(this).find(".select2-selection--single").length > 0 // multi-select will pass focus to input

  if (isOriginalEvent && isSingleSelect) {
    $(this).siblings('select:enabled').select2('open');
  }
});

$(document).on("change", "#cbogroup", function () {
  var group = $(this).val();
  if (group === "INDIVIDUAL") {
    $(".customer-fleet-corp").fadeOut();
    $(".customer-individual").fadeIn();
    $(".birth-date").fadeIn();
  } else {
    $(".customer-fleet-corp").fadeIn();
    $(".customer-individual").fadeOut();
    $(".birth-date").fadeOut();
  }
});

$(document).on("change", "#cboregion", function () {
    var regcode = $(this).val();
    $("#cboprovince").html('<option value="">PLEASE SELECT</option>');
    $("#cbocity").html('<option value="">PLEASE SELECT</option>');
    $("#cbobrgy").html('<option value="">PLEASE SELECT</option>');
    FetchProv(regcode,'');
});

$(document).on("change", "#cboprovince", function () {
    var provcode = $(this).val();
    $("#cbocity").html('<option value="">PLEASE SELECT</option>');
    $("#cbobrgy").html('<option value="">PLEASE SELECT</option>');
    FetchCM(provcode,'');
});

$(document).on("change", "#cbocity", function () {
    var cmcode = $(this).val();
    $("#cbobrgy").html('<option value="">PLEASE SELECT</option>');
    FetchBrgy(cmcode,'');
});

function FetchProv(regcode,provcode) {
  if (regcode !== null) {
    $.ajax({
      type:"POST",
      data: {regcode:regcode},
      url:"fetch_province.php",
      success: function(data) {
        $("#cboprovince").html(data);
        if (provcode !== null && provcode !== '') {
          if ($("#cboprovince").find("option[value='" + provcode + "']").length) {
            $("#cboprovince").val(provcode).trigger('change.select2');
          } 
        }
      }
    });
  }
}

function FetchCM(provcode,cmcode) {
  if (provcode !== null) {
    $.ajax({
      type:"POST",
      data: {provcode:provcode},
      url:"fetch_city_municipal.php",
      success: function(data) {
        $("#cbocity").html(data);
        if (cmcode !== null && cmcode !== '') {
          if ($("#cbocity").find("option[value='" + cmcode + "']").length) {
            $("#cbocity").val(cmcode).trigger('change.select2');
          } 
        }
      }
    });
  }
}

function FetchBrgy(cmcode,brgycode) {
  if (cmcode !== null) {
    $.ajax({
      type:"POST",
      data: {cmcode:cmcode},
      url:"fetch_barangay.php",
      success: function(data) {
        $("#cbobrgy").html(data);
        if (brgycode !== null && brgycode !== '') {
          if ($("#cbobrgy").find("option[value='" + brgycode + "']").length) {
            $("#cbobrgy").val(brgycode).trigger('change.select2');
          } 
        }
      }
    });
  }
}

$(document).on("change", "#cbopaytype", function () {
    var paytype = $(this).val();

    // Hide all sections first
    // $(".cc-section, .pdc-section, .ew-section").fadeOut();
    $(".pdc-section, .ew-section").fadeOut();

    // Map payment types to sections
    var sectionMap = {
        // "CREDIT CARD": ".cc-section",
        "POST-DATED CHECK (PDC)": ".pdc-section",
        "E-WALLET": ".ew-section"
    };

    // Map payment types to focus fields
    var focusMap = {
        // "CREDIT CARD": "#txtccno",
        "POST-DATED CHECK (PDC)": "#txtpdcno",
        "E-WALLET": "#cboewallet"
    };

    if (sectionMap[paytype]) {
        $(sectionMap[paytype]).fadeIn(function() {
            // Set focus on the appropriate field after the fadeIn completes
            if (focusMap[paytype]) {
                // $(focusMap[paytype]).focus();
            }
        });
    }

    $(".box-body").validator('reset');
});

$(document).on("click", "#pgcash", function () {
  $("#cboewallet").val("G-CASH").trigger('change.select2');
});

$(document).on("click", "#pmaya", function () {
  $("#cboewallet").val("PAY MAYA").trigger('change.select2');
});

$(document).on("click", "#ptwallet", function () {
  $("#cboewallet").val("TOYOTA WALLET").trigger('change.select2');
});

$(document).on("click", "#btnaddpay", function () {
  var tablepay = $("#table_payment").DataTable();

  var paytype        = $("#cbopaytype").val();
  var ewallet        = $("#cboewallet").val();
  var ccno           = $("#txtccno").val().trim();
  var ccholder       = $("#txtccholder").val().trim();
  var ccexpirydate   = $("#txtccexpirydate").val().trim();
  var ccvv           = $("#txtccvv").val().trim();
  var pdcno          = $("#txtpdcno").val().trim();
  var pdcholdername  = $("#txtpdcholdername").val().trim();
  var pdcbankname    = $("#txtpdcbankname").val().trim();
  var pdccheckdate   = $("#dppdccheckdate").val();
  var payterms       = $("#txtpayterms").val().trim();
  var payamount      = $("#txtpayamount").val().trim();

  function warn(field, msg) {
      $(field).focus();
      swal({
          title: "Warning",
          text: msg,
          type: "warning",
          showCancelButton: false,
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
      });
  }

  // Validation
  if (!paytype)   return warn("#cbopaytype", "Please select Payment Type.");
  if (!payterms)  return warn("#txtpayterms", "Please fill Payment Terms.");
  if (!payamount) return warn("#txtpayamount", "Please fill Payment Amount.");

  // if (paytype === "CREDIT CARD") {
  //     if (!ccno)          return warn("#txtccno", "Please fill Card No.");
  //     if (!ccholder)      return warn("#txtccholder", "Please fill Card Holder Name.");
  //     if (!ccexpirydate)  return warn("#txtccexpirydate", "Please fill Expiry Date.");
  //     if (!ccvv)          return warn("#txtccvv", "Please fill CVV / CVC.");
  // }

  if (paytype === "POST-DATED CHECK (PDC)") {
      if (!pdcno)          return warn("#txtpdcno", "Please fill Check No.");
      if (!pdcholdername)  return warn("#txtpdcholdername", "Please fill Account Holder Name.");
      if (!pdcbankname)    return warn("#txtpdcbankname", "Please fill Bank Name.");
      if (!pdccheckdate)   return warn("#dppdccheckdate", "Please fill Check Date.");
  }

  if (paytype === "E-WALLET") {
      if (!ewallet) return warn("#cboewallet", "Please select E-Wallet Type.");
  }

  var rowData = {
    Payment_ID: xpayid ?? null,
    Payment_Type: paytype,
    EWallet_Type: ewallet,
    PDC_No: pdcno,
    PDC_Account_Name: pdcholdername,
    PDC_Bank_Name: pdcbankname,
    PDC_Date: pdccheckdate,
    Payment_Terms: payterms,
    Payment_Amount: NumberFormat(payamount),
    Payment_Date: null, 
    button: "<button type='button' data-toggle='tooltip' data-placement='top' title='Remove Payment' class='btn btn-success btn-action btnremovepay'><i class='fa fa-remove'></i></button>"
  };

  if (editingRow) {
    // ✅ Replace the existing row
    editingRow.data(rowData).draw(false);
    editingRow = null; // reset editing
  } else {
    // ✅ Add a new row
    var newRow = tablepay.row.add(rowData).draw(false).node();
  }

  // Deselect any previously selected row
  tablepay.$('tr.selected').removeClass('selected');

  // Clear form
  xpayid = "";
  $("#cbopaytype, #cboewallet").val("").trigger("change");
  $("#txtccno, #txtccholder, #txtccexpirydate, #txtccvv").val("");
  $("#txtpdcno, #txtpdcholdername, #txtpdcbankname, #dppdccheckdate").val("");
});

$(document).on("click", ".btnremovepay", function () {
  // Hide tooltip on the clicked element BEFORE removing the row
  $(this).tooltip('hide');

  var tblpay = $("#table_payment").DataTable();

  // Remove the row
  tblpay.row($(this).closest("tr")).remove().draw();

  // Reinitialize tooltips after redraw
  $('[data-toggle="tooltip"]').tooltip();
});

$(document).on("click", ".btnremovepaysave", function () {
  xpayid = $(this).attr('payid');
  var $btn = $(this); // <-- store reference to clicked button

  swal({
    title: "Are you sure?",
    text: "This payment (ID: " + xpayid + 
          ") will be permanently deleted and cannot be recovered once you click Update Info.",
    type: "info",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    confirmButtonText: "Remove",
    closeOnConfirm: false,
    closeOnCancel: false
  },
  function(isConfirm){
    if (isConfirm) {
      // hide tooltip of clicked button
      $btn.tooltip('hide');

      var tblpay = $("#table_payment").DataTable();

      // remove row of clicked button
      tblpay.row($btn.closest("tr")).remove().draw();

      // reinitialize tooltips
      $('[data-toggle="tooltip"]').tooltip();
      xpayid = '';

      swal.close();
    } else {
      swal({
        title: "Cancelled",
        text: "Nothing Happen!",
        type: "error",
        confirmButtonColor: "#00a65a",
        confirmButtonText: "OK"
      });
  }
  });
});

$(document).on( "click", "#btneditpay", function () {
  editpay = true;
  FormDisablePay(false);
});

$(document).on( "click", "#btnclosepay", function () {
  $('#modal-modify-pay').iziModal('close');
});

$(document).on("click", "#btncancelpay", function() {
  editpay = false;
  FormClearPay();
  FormDisablePay(true);
  LoadPayData();
  $(".iziModal-wrap").scrollTop(0);
});

$(document).on("click", "#btnupdatepay", function() {
  var tablepay = $("#table_payment").DataTable();
  var allData = [];

  tablepay.rows().every(function() {
    var row = this.data();
    // Remove commas from numeric fields
    if (row.Payment_Amount) {
      row.Payment_Amount = row.Payment_Amount.toString().replace(/,/g, '');
    }
    allData.push(row);
  });

  // if(allData.length === 0) {
  //   swal({
  //     title: "Warning",
  //     text: "No payment records to save.",
  //     type: "warning",
  //     confirmButtonColor: "#00a65a",
  //     confirmButtonText: "OK"
  //   });
  //   return;
  // }

  $.ajax({
    url: "new_business_payment_save.php", // Your PHP endpoint
    type: "POST",
    data: {insuranceno:insuranceno, payments:JSON.stringify(allData) },
    success: function(response) {
      // You can parse response and show message
      swal({
        title: "Success",
        text: "Payments updated successfully!",
        type: "success",
        confirmButtonColor: "#00a65a",
        confirmButtonText: "OK"
      }, function () {
        editpay = false;
        FormClearPay();
        FormDisablePay(true);
        LoadPayData();
        $(".iziModal-wrap").scrollTop(0);
        // LoadPaymentInfo();
      });
    },
    error: function(xhr, status, error) {
      console.error(error);
      swal({
        title: "Error",
        text: "Failed to save payments.",
        type: "error",
        confirmButtonColor: "#00a65a",
        confirmButtonText: "OK"
      });
    }
  });
});

$(document).on("change", "#cbopaytype-n", function () {
    var paytype = $(this).val();

    // Hide all sections first
    // $(".cc-section-n, .pdc-section-n, .ew-section-n").fadeOut();
    $(".pdc-section-n, .ew-section-n").fadeOut();

    // Map payment types to sections
    var sectionMap = {
        // "CREDIT CARD": ".cc-section-n",
        "POST-DATED CHECK (PDC)": ".pdc-section-n",
        "E-WALLET": ".ew-section-n"
    };

    // Map payment types to focus fields
    var focusMap = {
        // "CREDIT CARD": "#txtccno-n",
        "POST-DATED CHECK (PDC)": "#txtpdcno-n",
        "E-WALLET": "#cboewallet-n"
    };

    if (sectionMap[paytype]) {
        $(sectionMap[paytype]).fadeIn(function() {
            // Set focus on the appropriate field after the fadeIn completes
            if (focusMap[paytype]) {
                // $(focusMap[paytype]).focus();
            }
        });
    }

    // Clear form
  xpayid = "";
  $("#cboewallet-n").val("").trigger("change");
  $("#txtccno-n, #txtccholder-n, #txtccexpirydate-n, #txtccvv-n").val("");
  $("#txtpdcno-n, #txtpdcholdername-n, #txtpdcbankname-n, #dppdccheckdate-n").val("");
  $(".box-body").validator('reset');
});

$(document).on("click", "#pgcash-n", function () {
  $("#cboewallet-n").val("G-CASH").trigger('change.select2');
});

$(document).on("click", "#pmaya-n", function () {
  $("#cboewallet-n").val("PAY MAYA").trigger('change.select2');
});

$(document).on("click", "#ptwallet-n", function () {
  $("#cboewallet-n").val("TOYOTA WALLET").trigger('change.select2');
});

// INIT TABLE
$(document).ready(function () {

  $('#table_payment-n').DataTable({

    language: {
        processing: "Loading Payment List..."
    },

    processing: true,
    serverSide: false,

    responsive: false,      // remove "+" icon
    scrollX: false,         // no horizontal scroll
    scrollCollapse: false,

    autoWidth: true,        // allow automatic column resizing
    ordering: false,
    searching: false,
    paging: false,
    info: false,

    fnRowCallback: function (nRow, aData, iDisplayIndex) {
        $("td:first", nRow).html(iDisplayIndex + 1);
    },

    drawCallback: function () {
        updatePaymentTotalsNew();
    },

    columnDefs: [ { targets: [1], visible: false } ],
    columns: [
          { data: null },            // Auto numbering
          { data: "Payment_ID" },
          { data: "Payment_Type" },
          { data: "EWallet_Type" },
          { data: "PDC_No" },
          { data: "PDC_Account_Name" },
          { data: "PDC_Bank_Name" },
          { data: "PDC_Date" },
          { data: "Payment_Terms" },
          {
            data: "Payment_Amount",
            render: function (data) {
              return NumberFormat(data);
            }
          },
          {
            data: "Payment_Date",
            render: function (data) {
              return getDisplayDateTimeFormatted(data);
            }
          },
          {
            data: "button",          // 11
            className: "never",     // never show in responsive child rows
            searchable: false,
            orderable: false
          }
      ]
  });

  function updatePaymentTotalsNew() {
    var tablepay = $("#table_payment-n").DataTable();
    var data = tablepay.rows().data();

    var total = 0;
    let hasMissingID = false;

    data.each(function(row){
      var amt = parseFloat(String(row.Payment_Amount).replace(/,/g, "")) || 0;
      total += amt;

      if (row.Payment_ID === null || row.Payment_ID === '') {
        hasMissingID = true;
      }
    });

    // Premium from input or hidden field
    // Total Premium
    var premium = $("#txtgrosspremium").val() || 0;
    premium = RemoveNumFormat(premium);
    var balance = premium - total;

    premium = NumberFormat(premium);
    total = NumberFormat(total);
    balance = NumberFormat(balance);

    // Display total payment
    $("#tfoot_tpremium-n").text(premium);
    $("#tfoot_total-n").text(total);
    $("#tfoot_balance-n").text(balance);

    if (editpay == true) {
      if (balance <= 0) {
        $(".pay-section-n, .term-amount-section-n, .btnadd-section-n").fadeOut();
      } else {
        $(".pay-section-n, .term-amount-section-n, .btnadd-section-n").fadeIn();
      }
    }
  }

  $('#table_payment-n tbody').off('dblclick', 'tr').on('dblclick', 'tr', function () {
    var tablepay = $("#table_payment-n").DataTable();

    // if (!editpay) return; // 🚫 do nothing if editpay is false

    var balance = $("#tfoot_balance-n").text();
    balance = RemoveNumFormat(balance);

    // remove previous selection
    tablepay.$('tr.selected').removeClass('selected');

    // highlight clicked row
    $(this).addClass('selected');

    // Get row data
    var rowData = tablepay.row(this).data();
    editingRow = tablepay.row(this); // store reference for later update

    // Populate form fields
    xpayid = rowData.Payment_ID;
    if (balance <= 0) {
      $("#cbopaytype-n").val(rowData.Payment_Type).trigger("change");
    } else {
      $("#cbopaytype-n").val(rowData.Payment_Type).trigger("change");
    }
    $("#cboewallet-n").val(rowData.EWallet_Type).trigger("change");

    $("#txtccno-n").val(rowData.CC_No || "");
    $("#txtccholder-n").val(rowData.CC_Holder || "");
    $("#txtccexpirydate-n").val(rowData.CC_Expiry || "");
    $("#txtccvv-n").val(rowData.CC_CVV || "");

    $("#txtpdcno-n").val(rowData.PDC_No || "");
    $("#txtpdcholdername-n").val(rowData.PDC_Account_Name || "");
    $("#txtpdcbankname-n").val(rowData.PDC_Bank_Name || "");
    $("#dppdccheckdate-n").val(rowData.PDC_Date || "");

    $("#txtpayterms-n").val(rowData.Payment_Terms || "");
    $("#txtpayamount-n").val(rowData.Payment_Amount || "");
  });

});

$(document).on("click", "#btnaddpay-n", function () {
  var tablepay = $("#table_payment-n").DataTable();

  var paytype        = $("#cbopaytype-n").val();
  var ewallet        = $("#cboewallet-n").val();
  var ccno           = $("#txtccno-n").val().trim();
  var ccholder       = $("#txtccholder-n").val().trim();
  var ccexpirydate   = $("#txtccexpirydate-n").val().trim();
  var ccvv           = $("#txtccvv-n").val().trim();
  var pdcno          = $("#txtpdcno-n").val().trim();
  var pdcholdername  = $("#txtpdcholdername-n").val().trim();
  var pdcbankname    = $("#txtpdcbankname-n").val().trim();
  var pdccheckdate   = $("#dppdccheckdate-n").val();
  var payterms       = $("#txtpayterms-n").val().trim();
  var payamount      = $("#txtpayamount-n").val().trim();

  function warn(field, msg) {
      $(field).focus();
      swal({
          title: "Warning",
          text: msg,
          type: "warning",
          showCancelButton: false,
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
      });
  }

  // Validation
  if (!paytype)   return warn("#cbopaytype-n", "Please select Payment Type.");
  if (!payterms)  return warn("#txtpayterms-n", "Please fill Payment Terms.");
  if (!payamount) return warn("#txtpayamount-n", "Please fill Payment Amount.");

  // if (paytype === "CREDIT CARD") {
  //     if (!ccno)          return warn("#txtccno-n", "Please fill Card No.");
  //     if (!ccholder)      return warn("#txtccholder-n", "Please fill Card Holder Name.");
  //     if (!ccexpirydate)  return warn("#txtccexpirydate-n", "Please fill Expiry Date.");
  //     if (!ccvv)          return warn("#txtccvv-n", "Please fill CVV / CVC.");
  // }

  if (paytype === "POST-DATED CHECK (PDC)") {
      if (!pdcno)          return warn("#txtpdcno-n", "Please fill Check No.");
      if (!pdcholdername)  return warn("#txtpdcholdername-n", "Please fill Account Holder Name.");
      if (!pdcbankname)    return warn("#txtpdcbankname-n", "Please fill Bank Name.");
      if (!pdccheckdate)   return warn("#dppdccheckdate-n", "Please fill Check Date.");
  }

  if (paytype === "E-WALLET") {
      if (!ewallet) return warn("#cboewallet-n", "Please select E-Wallet Type.");
  }

  var rowData = {
    Payment_ID: xpayid ?? null,
    Payment_Type: paytype,
    EWallet_Type: ewallet,
    PDC_No: pdcno,
    PDC_Account_Name: pdcholdername,
    PDC_Bank_Name: pdcbankname,
    PDC_Date: pdccheckdate,
    Payment_Terms: payterms,
    Payment_Amount: NumberFormat(payamount),
    Payment_Date: null, 
    button: "<button type='button' data-toggle='tooltip' data-placement='top' title='Remove Payment' class='btn btn-success btn-action btnremovepay-n'><i class='fa fa-remove'></i></button>"
  };

  if (editingRow) {
    // ✅ Replace the existing row
    editingRow.data(rowData).draw(false);
    editingRow = null; // reset editing
  } else {
    // ✅ Add a new row
    tablepay.row.add(rowData).draw(false).node();
  }

  // Deselect any previously selected row
  tablepay.$('tr.selected').removeClass('selected');

  // Clear form
  xpayid = "";
  $("#cbopaytype-n, #cboewallet-n").val("").trigger("change");
  $("#txtccno-n, #txtccholder-n, #txtccexpirydate-n, #txtccvv-n").val("");
  $("#txtpdcno-n, #txtpdcholdername-n, #txtpdcbankname-n, #dppdccheckdate-n").val("");
  $(".box-body").validator('reset');
});

$(document).on("click", ".btnremovepay-n", function () {
  // Hide tooltip on the clicked element BEFORE removing the row
  $(this).tooltip('hide');

  var tblpay = $("#table_payment-n").DataTable();

  // Remove the row
  tblpay.row($(this).closest("tr")).remove().draw();

  // Reinitialize tooltips after redraw
  $('[data-toggle="tooltip"]').tooltip();
});

$(document).on( "click", "#btneditstatus", function () {
  editstatus = true;
  FormDisableStatus(false);
});

$(document).on( "click", "#btnclosestatus", function () {
  $('#modal-modify-status').iziModal('close');
});

$(document).on("click", "#btncancelstatus", function() {
  editstatus = false;
  FormClearStatus();
  FormDisableStatus(true);
  LoadStatusData();
  $(".iziModal-wrap").scrollTop(0); 
});

$(document).on("click", "#btnupdatestatus", function () {
  // ======================================================
  // Helper Utilities
  // ======================================================
  const getVal = (sel) => $(sel).val()?.toString().trim() || "";
  const getUpper = (sel) => getVal(sel).toUpperCase();
  const getNum = (sel) => RemoveNumFormat(getVal(sel)) || "0";
  const getDate = (sel) => getSaveDateFormatted($(sel).val());
  const isEmpty = (v) => v === "" || v === null || v === undefined;

  const showWarning = (selector, message) => {
    $(selector).focus();
    swal({
      title: "Warning",
      text: message,
      type: "warning",
      confirmButtonColor: "#00a65a",
      confirmButtonText: "OK"
    });
  };

  // ======================================================
  // Master Validation Function
  // ======================================================
  function runValidation(list) {
    for (const v of list) {
      if (isEmpty(v.value)) {
        showWarning(v.selector, v.message);
        return false;
      }
    }
    return true;
  }

  // ======================================================
  // CHANGE TRANSACTION STATUS
  // ======================================================
  const TransStatus = {
    insuranceno,
    transstatus: getVal("#cbotransstatus"),
    transsremarks: getUpper("#txttranssremarks")
  };

  if (!runValidation([
    { value: TransStatus.transstatus, selector: "#cbotransstatus", message: "Please fill out Status." }
  ])) return;

  // ======================================================
  // BUILD FORM DATA
  // ======================================================
  $("#modalsaving").iziModal("open");

  const formdata = new FormData();
  [TransStatus].forEach(statusinfo => {
    Object.entries(statusinfo).forEach(([key, val]) => formdata.append(key, val));
  });

  // ======================================================
  // AJAX SUBMISSION
  // ======================================================
  $.ajax({
    url: "new_business_update_status.php",
    method: "POST",
    data: formdata,
    processData: false,
    contentType: false,
    success: function (response) {
      $("#modalsaving").iziModal('close');

      let result = jQuery.parseJSON(response);

      if (result.result == 1) {
        swal({
          title: "Updated Status!",
          text: "Transaction status has been updated successfully.",
          type: "success",
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        }, function () {
          editstatus = false;
          FormDisableStatus(true);
          LoadStatusData();
          $(".iziModal-wrap").scrollTop(0); 
          LoadTransactionData();
          // $("#modal-modify-status").iziModal("close");
        });
      } else {
        swal({
          title: "Error",
          text: "Failed to save the record.",
          type: "error",
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "OK"
        });
      }
    },
    error: function(xhr, status, error) {
      $("#modalsaving").iziModal('close');
      swal({
        title: "Error",
        text: "Something went wrong: " + error,
        type: "error",
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "OK"
      });
    }
  });
});

$(document).on( "click", "#btneditnetrem", function () {
  editnetrem = true;
  FormDisableNetRem(false);
});

$(document).on( "click", "#btnclosenetrem", function () {
  $('#modal-modify-netrem').iziModal('close');
});

$(document).on("click", "#btncancelnetrem", function() {
  editnetrem = false;
  FormClearNetRem();
  FormDisableNetRem(true);
  LoadNetRemData();
  $(".iziModal-wrap").scrollTop(0); 
});

$(document).on("click", "#btnupdatenetrem", function () {
  // ======================================================
  // Helper Utilities
  // ======================================================
  const getVal = (sel) => $(sel).val()?.toString().trim() || "";
  const getUpper = (sel) => getVal(sel).toUpperCase();
  const getNum = (sel) => RemoveNumFormat(getVal(sel)) || "0";
  const getDate = (sel) => getSaveDateFormatted($(sel).val());
  const isEmpty = (v) => v === "" || v === null || v === undefined;

  const showWarning = (selector, message) => {
    $(selector).focus();
    swal({
      title: "Warning",
      text: message,
      type: "warning",
      confirmButtonColor: "#00a65a",
      confirmButtonText: "OK"
    });
  };

  // ======================================================
  // Master Validation Function
  // ======================================================
  function runValidation(list) {
    for (const v of list) {
      if (isEmpty(v.value)) {
        showWarning(v.selector, v.message);
        return false;
      }
    }
    return true;
  }

  // ======================================================
  // CHANGE TRANSACTION STATUS
  // ======================================================
  const NetRem = {
    insuranceno,
    insgpremium: getNum("#txtinsgpremium"),
    netrem: getNum("#txtnetrem"),
    inscommission: getNum("#txtinscommission")
  };

  if (!runValidation([
    { value: NetRem.insgpremium, selector: "#txtinsgpremium", message: "Please fill out Gross Premium." },
    { value: NetRem.netrem, selector: "#txtnetrem", message: "Please fill out Net Rem." }
  ])) return;

  // ======================================================
  // BUILD FORM DATA
  // ======================================================
  $("#modalsaving").iziModal("open");

  const formdata = new FormData();
  [NetRem].forEach(netreminfo => {
    Object.entries(netreminfo).forEach(([key, val]) => formdata.append(key, val));
  });

  // ======================================================
  // AJAX SUBMISSION
  // ======================================================
  $.ajax({
    url: "new_business_update_netrem.php",
    method: "POST",
    data: formdata,
    processData: false,
    contentType: false,
    success: function (response) {
      $("#modalsaving").iziModal('close');

      let result = jQuery.parseJSON(response);

      if (result.result == 1) {
        swal({
          title: "Updated Gross Premium / Net Rem!",
          text: "Gross Premium / Net Rem has been updated successfully.",
          type: "success",
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        }, function () {
          // $("#modal-modify-netrem").iziModal("close");
          editnetrem = false;
          FormDisableNetRem(true);
          LoadNetRemData();
          $(".iziModal-wrap").scrollTop(0);
        });
      } else {
        swal({
          title: "Error",
          text: "Failed to save the record.",
          type: "error",
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "OK"
        });
      }
    },
    error: function(xhr, status, error) {
      $("#modalsaving").iziModal('close');
      swal({
        title: "Error",
        text: "Something went wrong: " + error,
        type: "error",
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "OK"
      });
    }
  });
});

$(document).on( "change", "#cbocallstatus", function () {
  var callsid = $(this).val();
  if (editcall == true) {
    if (callsid === '1' || callsid === '') {
      $("#cbocallreason").attr("disabled",true);
    } else {
      $("#cbocallreason").attr("disabled",false);
    }
    FetchCall(callsid,'');
  } else {
    $("#cbocallreason").attr("disabled",true);
  }
});

function FetchCall(callsid,reasonid) {
  if (callsid !== null) {
    $.ajax({
      type:"POST",
      data: {callsid:callsid},
      url:"fetch_call_reason.php",
      success: function(data) {
        $("#cbocallreason").html(data);
        if (reasonid != null || reasonid != '') {
          if ($("#cbocallreason").find("option[value='" + reasonid + "']").length) {
            $("#cbocallreason").val(reasonid).trigger('change');
          } 
        }
        
        $(".box-body").validator('reset');
      }
    });
  }
}

$(document).on( "change", "#cbocallreason", function () {
  var callreason = $("#cbocallreason :selected").text();
  if (editcall == true) {
    if (callreason == 'CONFIRM RENEWAL') {
      $("#dpppdate").attr("disabled",false);
    } else {
      $("#dpppdate").attr("disabled",true);
      $("#dpppdate").val("");
    }
  } else {
    $("#dpppdate").attr("disabled",true);
  }
});
/////////////// END COMBO BOX EVENT ///////////////////

/////////////// TEXTBOX EVENT ///////////////////
/*====== TEXT CHANGE ======*/
// $(document).on("change", "#txtcustno", function () {
//   var inputField = $(this);
//   var custno = inputField.val().trim();

//   if (custno === "") return; // do nothing if empty

//   $.ajax({
//     url: "customer_list_custno_exist.php",
//     type: "POST",
//     data: { custno: custno },
//     success: function (response) {
//       var data = jQuery.parseJSON(response);
//       if (data.result == 1) {

//         inputField.focus();
        
//         // Remove last character or digit
//         var newVal = custno.slice(0, -1);
//         inputField.val(newVal);

//         swal({
//           title: "Record Exists!",
//           text: "Customer Number " + custno + " is already assigned to " + data.fullname + ".",
//           type: "warning",
//           confirmButtonColor: "#00a65a",
//           confirmButtonText: "OK"
//         }, function () {
//           $(".box-body").validator('reset');
//         });
//       }
//     },
//     error: function (jqXHR, textStatus) {
//       swal({
//         title: "Error!",
//         text: textStatus,
//         type: "error",
//         confirmButtonColor: "#00a65a",
//         confirmButtonText: "OK"
//       });
//     }
//   });
// });

// $(document).on("change", "#txtvin", function () { 
//   var inputField = $(this);
//   var vin = inputField.val().trim();

//   if (vin === "") return; // do nothing if empty

//   $.ajax({
//     url: "customer_vehicle_vin_exist.php",
//     type: "POST",
//     data: { vin: vin },
//     success: function (response) {
//       var data = jQuery.parseJSON(response);
//       if (data.result == 1) {

//         inputField.focus();
        
//         // Remove last character or digit
//         var newVal = vin.slice(0, -1);
//         inputField.val(newVal);

//         swal({
//           title: "Record Exists!",
//           text: "Vehicle Identification Number " + vin + " is already assigned to a " + data.Model_Type + "  vehicle owned by " + data.fullname + ".",
//           type: "warning",
//           confirmButtonColor: "#00a65a",
//           confirmButtonText: "OK"
//         }, function () {
//           $(".box-body").validator('reset');
//         });
//       }
//     },
//     error: function (jqXHR, textStatus) {
//       swal({
//         title: "Error!",
//         text: textStatus,
//         type: "error",
//         confirmButtonColor: "#00a65a",
//         confirmButtonText: "OK"
//       });
//     }
//   });
// });

//Blur
  // $(document).on("blur", "#txtcustno", function () {
  //   var inputField = $(this);
  //   var custno = inputField.val().trim();

  //   if (custno === "") return; // do nothing if empty

  //   $.ajax({
  //     url: "customer_list_custno_exist.php",
  //     type: "POST",
  //     data: { custno: custno },
  //     dataType: "json",
  //     success: function (data) {

  //       if (data.result == 1) {

  //         swal({
  //           title: "Record Exists!",
  //           text: "Customer Number " + custno +
  //                 " is already assigned to " + data.fullname + ". Click OK to display all info.",
  //           type: "warning",
  //           confirmButtonColor: "#00a65a",
  //           confirmButtonText: "OK"
  //         }, function () {

  //           // Reset validator
  //           $(".box-body").validator('reset');

  //           // Optional: clear customer form
  //           FormClear();

  //           // Load customer info
  //           xcustno = custno;
  //           LoadCustomerInfo();

  //         });
  //       }

  //     },
  //     error: function (jqXHR, textStatus) {
  //       swal({
  //         title: "Error!",
  //         text: textStatus,
  //         type: "error",
  //         confirmButtonColor: "#00a65a",
  //         confirmButtonText: "OK"
  //       });
  //     }
  //   });
  // });

$(document).on("blur", "#txtvin", function () {
  var inputField = $(this);
  var vin = inputField.val().trim();
  var customerno = $("#txtcustno").val();

  if (vin === "") return; // do nothing if empty

  $.ajax({
    url: "customer_vehicle_vin_exist.php",
    type: "POST",
    data: { vin: vin },
    dataType: "json",
    success: function (data) {

      if (data.result == 1) {

        if (customerno == data.customerno ) {
          swal({
            title: "Record Exists!",
            text: "Vehicle Identification Number " + vin +
                  " is already assigned to a " + data.model +
                  " vehicle owned by " + data.fullname + ". Click OK to display all info.",
            type: "warning",
            confirmButtonColor: "#00a65a",
            confirmButtonText: "OK"
          }, function () {

            // Reset validator
            $(".box-body").validator('reset');

            // Optional: clear vehicle form
            FormClearVeh();

            // Load vehicle info
            xvin = vin;
            LoadVehicleInfo();

          });
        } else {
          swal({
            title: "Record Exists!",
            text: "Vehicle Identification Number " + vin +
                  " is already assigned to a " + data.model +
                  " vehicle owned by " + data.fullname + ".",
            type: "warning",
            confirmButtonColor: "#00a65a",
            confirmButtonText: "OK"
          }, function () {

            // Reset validator
            $(".box-body").validator('reset');

            // Optional: clear vehicle form
            FormClearVeh();
          });
        }
      }

    },
    error: function (jqXHR, textStatus) {
      swal({
        title: "Error!",
        text: textStatus,
        type: "error",
        confirmButtonColor: "#00a65a",
        confirmButtonText: "OK"
      });
    }
  });
});

//Button View 
$(document).on( "click", "#viewpending", function () {
  viewpending = true;
  LoadTransactionData();
});

$(document).on( "click", "#viewexpiring", function () {
  viewexpiring = true;
  LoadTransactionData();
});

//Button View 
$(document).on( "click", "#btnrefresh", function () {
  viewpending = false;
  viewexpiring = false;
  $("#txtsearch").val("");
  LoadTransactionData();
});

/*====== KEY UP ======*/
$(document).on( "keyup", "#txtsearch", function () {
  var searchval = $(this).val().trim();
  if($.trim(searchval) == "" ) {
    LoadTransactionData();
  }
});

$(document).on( "keyup", "#txtcustomersearch", function () {
  var searchval = $(this).val().trim();
  if($.trim(searchval) == "" ) {
    if (activeCustTab === '#tmiatab') {
      LoadCustomerData();
    }

    if (activeCustTab === '#uploadtab') {
      LoadCustomerDataEDAFSAP();
    }
  }
});

/*====== KEY DOWN ======*/
$(document).on( "keydown", "#txtsearch", function (e) {
  if (e.which == 13) {
    e.preventDefault();
    var search = $(this).val();
    if ($.trim(search) != 0) {
      LoadTransactionData();
    }
    $(this).select();
  }
});

$(document).on( "keydown", "#txtcustomersearch", function (e) {
  if (e.which == 13) {
    e.preventDefault();
    var search = $(this).val();
    if ($.trim(search) != 0) {
      if (activeCustTab === '#tmiatab') {
        LoadCustomerData();
      }

      if (activeCustTab === '#uploadtab') {
        LoadCustomerDataEDAFSAP();
      }
    }
    $(this).select();
  }
});

//Button Search 
$(document).on( "click", "#btnfind", function () {
  LoadTransactionData();
});

$(document).on( "click", "#btnfindcust", function () {
  if (activeCustTab === '#tmiatab') {
    LoadCustomerData();
  }

  if (activeCustTab === '#uploadtab') {
    LoadCustomerDataEDAFSAP();
  }
});

/*====== KEY PRESS ======*/
/*----------- CUSTOMER INFO ------------*/
$(document).on( "keypress", "#txtzipcode", function () {
  return isNumberKey(this, event);
});

/*---------- VEHICLE INFO ---------------*/
$(document).on( "keypress", "#txtmodelyear", function () {
  return isNumberKey(this, event);
});

$(document).on( "keypress", "#txtsrp", function () {
  return isNumberKey(this, event);
});

$(document).on( "keypress", "#txtseats", function () {
  return isNumberKey(this, event);
});

// $(document).on( "keypress", "#txtunloadweight", function () {
//   return isNumberKey(this, event);
// });

// $(document).on( "keypress", "#txtmaxweight", function () {
//   return isNumberKey(this, event);
// });

/*----------- INSURANCE CALC ------------*/
$(document).on( "keypress", "#txtgrosspremium", function () {
  return isNumberKey(this, event);
});

$(document).on( "keypress", "#txtnetremittance", function () {
  return isNumberKey(this, event);
});

$(document).on( "keypress", "#txtcommission", function () {
  return isNumberKey(this, event);
});

$(document).on( "keypress", "#txtterms", function () {
  return isNumberKey(this, event);
});

$(document).on( "keypress", "#txtmonthpay", function () {
  return isNumberKey(this, event);
});

/*---------- PAYMENT INFO ---------------*/
$(document).on( "keypress", "#txtpayamount, #txtpayamount-n", function () {
  return isNumberKey(this, event);
});

/*---------- GP / NET REM ---------------*/
$(document).on( "keypress", "#txtinsgpremium", function () {
  return isNumberKey(this, event);
});

$(document).on( "keypress", "#txtnetrem", function () {
  return isNumberKey(this, event);
});

$(document).on( "keypress", "#txtinscommission", function () {
  return isNumberKey(this, event);
});

/*====== FOCUS ======*/
$("#txtsearch").focus(function(){
  $(this).select();
});

$("#txtcustomersearch").focus(function(){
  $(this).select();
});

/*---------- VEHICLE INFO ---------------*/
$(document).on("focus", "#txtsrp", function () {
    const raw = $(this).val();
    $(this).val(RemoveNumFormat(raw)).select();
});

/*----------- INSURANCE CALC ------------*/
$(document).on("focus", "#txtgrosspremium", function () {
    const raw = $(this).val();
    $(this).val(RemoveNumFormat(raw)).select();
});

$(document).on("focus", "#txtnetremittance", function () {
    const raw = $(this).val();
    $(this).val(RemoveNumFormat(raw)).select();
});

$(document).on("focus", "#txtcommission", function () {
    const raw = $(this).val();
    $(this).val(RemoveNumFormat(raw)).select();
});

$(document).on("focus", "#txtterms", function () {
    const raw = $(this).val();
    $(this).val(RemoveNumFormat(raw)).select();
});

$(document).on("focus", "#txtmonthpay", function () {
    const raw = $(this).val();
    $(this).val(RemoveNumFormat(raw)).select();
});

/*---------- PAYMENT INFO ---------------*/
$(document).on("focus", "#txtpayamount, #txtpayamount-n", function () {
    const raw = $(this).val();
    $(this).val(RemoveNumFormat(raw)).select();
});

/*---------- GP / NET REM ---------------*/
$(document).on("focus", "#txtinsgpremium", function () {
    const raw = $(this).val();
    $(this).val(RemoveNumFormat(raw)).select();
});

$(document).on("focus", "#txtnetrem", function () {
    const raw = $(this).val();
    $(this).val(RemoveNumFormat(raw)).select();
});

$(document).on("focus", "#txtinscommission", function () {
    const raw = $(this).val();
    $(this).val(RemoveNumFormat(raw)).select();
});

/*====== LOST FOCUS ======*/
/*---------- CUSTOMER INFO ---------------*/
// $(document).on( "blur", "#txtcustno", function () {
//   var txtcustno = $(this).val().toUpperCase().trim();
//   $(this).val(txtcustno);
// });

$(document).on( "blur", "#txtcustname", function () {
  var txtcustname = $(this).val().toUpperCase().trim();
  $(this).val(txtcustname);
});

$(document).on( "blur", "#txtcustfname", function () {
  var txtcustfname = $(this).val().toUpperCase().trim();
  $(this).val(txtcustfname);
});

$(document).on( "blur", "#txtcustmname", function () {
  var txtcustfname = $(this).val().toUpperCase().trim();
  $(this).val(txtcustfname);
});

$(document).on( "blur", "#txtcustlname", function () {
  var txtcustlname = $(this).val().toUpperCase().trim();
  $(this).val(txtcustlname);
});

$(document).on( "blur", "#txtcustsname", function () {
  var txtcustsname = $(this).val().toUpperCase().trim();
  $(this).val(txtcustsname);
});

$(document).on( "blur", "#txtaddress", function () {
  var txtaddress = $(this).val().toUpperCase().trim();
  $(this).val(txtaddress);
});

/*---------- VEHICLE INFO ---------------*/
$(document).on( "blur", "#txtvin", function () {
  var txtvin = $(this).val().toUpperCase().trim();
  $(this).val(txtvin);
});

$(document).on( "blur", "#txtmake", function () {
  var txtmake = $(this).val().toUpperCase().trim();
  $(this).val(txtmake);
});

$(document).on( "blur", "#txtmodel", function () {
  var txtmodel = $(this).val().toUpperCase().trim();
  $(this).val(txtmodel);
});

$(document).on( "blur", "#txtcolor", function () {
  var txtcolor = $(this).val().toUpperCase().trim();
  $(this).val(txtcolor);
});

$(document).on( "blur", "#txtengineno", function () {
  var txtengineno = $(this).val().toUpperCase().trim();
  $(this).val(txtengineno);
});

$(document).on( "blur", "#txtcsno", function () {
  var txtcsno = $(this).val().toUpperCase().trim();
  $(this).val(txtcsno);
});

$(document).on( "blur", "#txtplateno", function () {
  var txtplateno = $(this).val().toUpperCase().trim();
  $(this).val(txtplateno);
});

// $(document).on( "blur", "#txtorderno", function () {
//   var txtorderno = $(this).val().toUpperCase().trim();
//   $(this).val(txtorderno);
// });

// $(document).on( "blur", "#txtorderstatus", function () {
//   var txtorderstatus = $(this).val().toUpperCase().trim();
//   $(this).val(txtorderstatus);
// });

$(document).on("blur", "#txtsrp", function () {
    let val = $(this).val().replace(/[^0-9.]/g, "").trim();

    if (val !== "") {
        $(this).val(NumberFormat(val));
    }
});

// $(document).on( "blur", "#txtmsalecode", function () {
//   var txtmsalecode = $(this).val().toUpperCase().trim();
//   $(this).val(txtmsalecode);
// });

$(document).on( "blur", "#txtvariant", function () {
  var txtvariant = $(this).val().toUpperCase().trim();
  $(this).val(txtvariant);
});

$(document).on( "blur", "#txttransmission", function () {
  var txttransmission = $(this).val().toUpperCase().trim();
  $(this).val(txttransmission);
});

$(document).on( "blur", "#txtvoname", function () {
  var txtvoname = $(this).val().toUpperCase().trim();
  $(this).val(txtvoname);
});

$(document).on( "blur", "#txtmpname", function () {
  var txtmpname = $(this).val().toUpperCase().trim();
  $(this).val(txtmpname);
});

/*---------- INSURANCE CALC ---------------*/
$(document).on("blur", "#txtgrosspremium", function () {
    let val = $(this).val().replace(/[^0-9.]/g, "").trim();

    if (val !== "") {
        $(this).val(NumberFormat(val));
    }
});

$(document).on("blur", "#txtnetremittance", function () {
    let val = $(this).val().replace(/[^0-9.]/g, "").trim();

    if (val !== "") {
        $(this).val(NumberFormat(val));
    }
});

$(document).on("blur", "#txtcommission", function () {
    let val = $(this).val().replace(/[^0-9.]/g, "").trim();

    if (val !== "") {
        $(this).val(NumberFormat(val));
    }
});

$(document).on("blur", "#txtmonthpay", function () {
    let val = $(this).val().replace(/[^0-9.]/g, "").trim();

    if (val !== "") {
        $(this).val(NumberFormat(val));
    }
});

/*---------- INSURER INFO ---------------*/
$(document).on( "blur", "#txtpolicyno", function () {
  var txtpolicyno = $(this).val().toUpperCase().trim();
  $(this).val(txtpolicyno);
});

// $(document).on( "blur", "#txtmortaddress", function () {
//   var txtmortaddress = $(this).val().toUpperCase().trim();
//   $(this).val(txtmortaddress);
// });

/*---------- PAYMENT INFO ---------------*/
$(document).on("blur", "#txtpayamount, #txtpayamount-n", function () {
    let val = $(this).val().replace(/[^0-9.]/g, "").trim();

    if (val !== "") {
        $(this).val(NumberFormat(val));
    }
});

/*---------- GP / NET REM ---------------*/
$(document).on("blur", "#txtinsgpremium", function () {
    let val = $(this).val().replace(/[^0-9.]/g, "").trim();

    if (val !== "") {
        $(this).val(NumberFormat(val));
    }
});

$(document).on("blur", "#txtnetrem", function () {
    let val = $(this).val().replace(/[^0-9.]/g, "").trim();

    if (val !== "") {
        $(this).val(NumberFormat(val));
    }
});

$(document).on("blur", "#txtinscommission", function () {
    let val = $(this).val().replace(/[^0-9.]/g, "").trim();

    if (val !== "") {
        $(this).val(NumberFormat(val));
    }
});

/*---------- Transaction Status ---------------*/
$(document).on( "blur", "#txttranssremarks", function () {
  var txttranssremarks = $(this).val().toUpperCase().trim();
  $(this).val(txttranssremarks);
});

/*---------- Call Status ---------------*/
$(document).on( "blur", "#txtcallremarks", function () {
  var txtcallremarks = $(this).val().toUpperCase().trim();
  $(this).val(txtcallremarks);
});
/////////////// END TEXTBOX EVENT ///////////////////

//////////// Date Picker Event ///////
$(document).on("changeDate", "#dpdatefrom, #dpdateto", function () {
  const dateFrom = $("#dpdatefrom").val();
  const dateTo   = $("#dpdateto").val();

  if (dateFrom && dateTo) {
    LoadTransactionData();
  }
});

// Start Date & Expire Date
const parseSafeDate = (value) => {
  const date = new Date(getSaveDateFormatted(value));
  return isNaN(date.getTime()) ? null : date;
};

$(document).on("changeDate", "#dpreldate", function () {
  const reldate = parseSafeDate($(this).val());

  if (reldate) {
    $("#dpstartdate").datepicker("setDate", reldate);
  }
});

$(document).on("changeDate", "#dpstartdate", function () {
  const startdate = parseSafeDate($(this).val());

  if (startdate) {
    const expireDate = new Date(startdate);
    expireDate.setFullYear(expireDate.getFullYear() + 1);

    $("#dppexpiredate").datepicker("setDate", expireDate);
  }
});

/////////// CHECKED BOX EVENT //////////////
$(document).on( "change", "#chkall", function () {
  if ($(this).is(":checked")) {
    $("#dpdatefrom").attr("disabled",true);
    $("#dpdateto").attr("disabled",true);
  } else {
    $("#dpdatefrom").attr("disabled",false);
    $("#dpdateto").attr("disabled",false);
  }
  LoadTransactionData();
});

////////////////////////////// INSUIRANCE CALCULATION /////////////////////////////////
$(document).ready( function () {
  // ------------------------------
  // Commission Calculation
  // ------------------------------
  function calculateTotalCommission() {
    const grosspremium = RemoveNumFormat($('#txtgrosspremium').val());
    const netremittance = RemoveNumFormat($('#txtnetremittance').val());
    const commission = grosspremium - netremittance;
    $('#txtcommission').val(NumberFormat(commission));
  }
  // ------------------------------
  // Monthly Payment Calculation
  // ------------------------------
  // function calculateMonthlyPayment() {
  //     const tpremium = RemoveNumFormat($('#txttpremium').val());
  //     const term = Number(RemoveNumFormat($('#txtterms').val())) || 1; // prevent div by zero
  //     const monthly = tpremium / term;
  //     $('#txtmonthpay').val(NumberFormat(monthly));
  // }

  function calculateMonthlyPayment() {
      const grosspremium = RemoveNumFormat($('#txtgrosspremium').val());
      const term = Number(RemoveNumFormat($('#txtterms').val())) || 1; // prevent div by zero
      const monthly = grosspremium / term;
      $('#txtmonthpay').val(NumberFormat(monthly));

      $('#txtpayterms-n').val(term);
      $('#txtpayamount-n').val(NumberFormat(monthly));
      $(".box-body").validator('reset');
  }

  // ------------------------------
  // Manual override for DS/LGT
  // ------------------------------
  // $('#txtdspremium').on("input", function() {
  //   $(this).data("manual", true);
  //   calculateTotals();
  // });

  // $('#txtlgtpremium').on("input", function() {
  //   $(this).data("manual", true);
  //   calculateTotals();
  // });

  // ------------------------------
  // Recalculate Total Premium when AF changes
  // ------------------------------
  // $('#txtafpremium').on("input change keyup paste", function() {
  //   calculateTotals(); // recalculates TP including new AF
  // });

  // ------------------------------
  // Gross Premium & Net Remittance input trigger for Commission
  // ------------------------------
  $('#txtgrosspremium, #txtnetremittance').on('input', () => {
    calculateTotalCommission();
    calculateMonthlyPayment();
  });

  // ------------------------------
  // Term input trigger for Monthly Payment
  // ------------------------------
  $('#txtterms').on('input', calculateMonthlyPayment);

  $(document).on( "change", "#chkpayment", function () {
    if ($(this).is(':checked')) {
      $("#installpay-terms").fadeIn();
      $("#installpay-mpay").fadeIn();

      calculateMonthlyPayment();
    } else {
      $("#installpay-terms").fadeOut();
      $("#installpay-mpay").fadeOut();

      $("#txtterms").val("1");
      $("#txtmonthpay").val("0.00");
    }
  });

  $('input[name="rdoptiontype"]').on('change', function() {
    const val = $(this).val();
    if (val === 'FREE') {
      $(".installment-section").fadeOut();
      $(".payment-new").fadeOut();
    } else {
      $(".installment-section").fadeIn();
      $(".payment-new").fadeIn();
    }
    $("#chkpayment").prop("checked", false).trigger('change');
    // $("#chknonvat").prop("checked", false).trigger('change');
  });

  // Also trigger on page load for default state:
  $('input[name="optionType"]:checked').trigger('change');

  // $(document).on( "change", "#chknonvat", function () {
  //   calculateTotals(); // recalc totals whenever checkbox changes
  // });

  // ------------------------------
  // Row triggers
  // ------------------------------
  // rows.forEach(row => {
  //   let triggers = [row.cover];
  //   if (row.rate) triggers.push(row.rate);
  //   triggers.push(row.premium); // include premium changes

  //   $(triggers.join(",")).on("input change keyup paste", function(e) {
  //     const isPremiumInput = e.target === $(row.premium)[0];

  //     if (!isPremiumInput) {
  //         // Cover/Rate changed → auto row premium
  //         $(row.premium).data("manual", false);
  //     } else {
  //         // Premium typed manually → set manual
  //         $(row.premium).data("manual", true);
  //     }

  //     calculateRow(row);

  //     // Reset DS/LGT to auto mode whenever any NPBT row changes
  //     $('#txtdspremium').data("manual", false);
  //     $('#txtlgtpremium').data("manual", false);

  //     calculateTotals();
  //   });
  // });

  // ------------------------------
  // Initial calculation
  // ------------------------------
  // rows.forEach(row => calculateRow(row));
  // calculateTotals();

  // ------------------------------
  // Commission Calculation
  // ------------------------------
  function calculateTotalINSCommission() {
    const insgpremium = RemoveNumFormat($('#txtinsgpremium').val());
    const netrem = RemoveNumFormat($('#txtnetrem').val());
    const inscommission = insgpremium - netrem;
    $('#txtinscommission').val(NumberFormat(inscommission));
  }

  // ------------------------------
  // Gross Premium & Net Remittance input trigger for Commission
  // ------------------------------
  $('#txtinsgpremium, #txtnetrem').on('input', () => {
    calculateTotalINSCommission();
  });
});

///////////////////////// END INSUIRANCE CALCULATION/////////////////////////////////

////////////////////////////// BUTTONS CLICKED /////////////////////////////////
//============= BUTTONS OUTSIDE TABLE ============//
$(document).on( "click", "#btnfindcustomer", function () {
  if (activeCustTab === '#tmiatab') {
    LoadCustomerData();
  }

  if (activeCustTab === '#uploadtab') {
    LoadCustomerDataEDAFSAP();
  }
  $('#modal-customerlist').iziModal('open');
});

$(document).on( "click", "#btncustselect", function () {
  if (activeCustTab === '#tmiatab') {
    LoadCustomerInfo();
  }

  if (activeCustTab === '#uploadtab') {
    LoadCustomerEDAFSAPInfo();
  }
  $('#modal-customerlist').iziModal('close');
});

$(document).on( "click", "#btnfindvehicle", function () {
  if (activeVehTab === '#tmiavehtab') {
    LoadVehicleData();
  }

  if (activeVehTab === '#uploadvehtab') {
    LoadVehicleEDAFSAPData();
  }
  $('#modal-vehiclelist').iziModal('open');
});

$(document).on( "click", "#btnvehselect", function () {
  if (activeVehTab === '#tmiavehtab') {
    LoadVehicleInfo();
  }

  if (activeVehTab === '#uploadvehtab') {
    LoadVehicleEDAFSAPInfo();
  }
  $('#modal-vehiclelist').iziModal('close');
});

$(document).on( "click", "#btnadd", function () {
  newdata = true;
  transid = '';
  editinfo = true;
  FormClear();
  FormDisable(false);
  if ( ulevel == 'INSURANCE STAFF') { 
    $("#cboise").val(userid).trigger("change.select2");
    
    $('#modal-add').iziModal('open');
  } else {
    $('#modal-modify-ise').iziModal('open');
  }
});

$(document).on( "click", "#btnselectise", function () {
  var selectise = $("#cboise").val();
  if ($.trim(selectise) == '' || $.trim(selectise) == null || $.trim(selectise) == 'PLEASE SELECT') {
    $("#cboise").focus();
    swal({
      title: "Warning",
      text: "Please select Insurance Staff.",
      type: "warning",
      showCancelButton: false,
      confirmButtonColor: "#00a65a",
      confirmButtonText: "OK"
    });
    return;
  }

  $('#modal-add').iziModal('open');
  $('#modal-modify-ise').iziModal('close');
});

$(document).on( "click", "#btncancelise", function () {
  $('#modal-modify-ise').iziModal('close');
});

$(document).on( "click", "#btnaddveh", function () {
  newdata = true;
  xvin = '';
  xcsno = '';
  xplateno = '';
  editinfo = true;
  FormClearVeh();
  FormDisableVeh(false);
  $('#modal-modifyveh').iziModal('open');
});

$(document).on( "click", "#btnupload", function () {
  $('#modal-upload').iziModal('open');
});
//============= END BUTTONS OUTSIDE TABLE ============//

//============= BUTTONS ON MODAL UPLOAD FILE EXCEL ============//
$(document).on("click", "#btnimport", function () {
  // Reset UI and table
  $("#table_upload").DataTable().clear().draw();
  $("#cntgood").text('GOOD : 0 Record(s)');
  $("#cntupdated").text('UPDATED : 0 Record(s)');
  $("#cntduplicate").text('DUPLICATE : 0 Record(s)');
  $("#cntfailed").text('FAILED : 0 Record(s)');
  $("#cnttotal").text('TOTAL : 0 Record(s)');

  const fileInput = $('#filexls');
  const fileData = fileInput.prop('files')[0];

  if (!fileData) {
    fileInput.focus();
    showError("Warning!", "Please choose a file.");
    return;
  }

  const ext = fileData.name.split('.').pop().toLowerCase();
  if (!['xls', 'xlsx'].includes(ext)) {
    fileInput.focus();
    showError("Invalid File!", "Please choose a valid Excel (.xls/.xlsx) file.");
    return;
  }

  const formData = new FormData();
  formData.append('file', fileData);

  $("#btnimport").prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Importing...');

  // Step 1: Validate file structure before importing
  $.ajax({
    url: "customer_list_import_xls_check.php",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {
      const result = typeof data === "string" ? JSON.parse(data) : data;

      switch (result.result) {
        case 0:
          showError("Invalid File Importing!", "Column is not match. Please import the correct file.");
          break;
        case 2:
          showError("No Record!", "No records found to import.");
          break;
        case 1:
          startImport(formData);
          break;
        default:
          showError("Unexpected Response!", "Server returned an unknown result.");
          break;
      }
    },
    error: function () {
      showError("Check Failed!", "Unable to validate the file.");
    }
  });
});

function startImport(formData) {
  $("#modaluploading").iziModal('open');
  setUploadProgressText("0%");
  window.importData = null;

  startProgressPolling(); // Start checking progress immediately

  // Step 2: Perform the actual import
  $.ajax({
    url: "customer_list_import_xls.php",
    method: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      window.importData = typeof response === "string" ? JSON.parse(response) : response;
      // Progress polling will handle finish
    },
    error: function () {
      stopProgressPolling();
      $("#modaluploading").iziModal('close');
      showError("Import Error!", "An error occurred during file import. Please try again.");
    }
  });
}

function setUploadProgressText(text) {
  $("#uploadPercentage").text(text);
}

function showError(title, message) {
  $("#btnimport").prop('disabled', false).html('<i class="fa fa-upload"></i> Import File');
  swal({
    title,
    text: message,
    type: "error",
    confirmButtonColor: "#00a65a",
    confirmButtonText: "OK"
  });
}

// 🔁 Progress Polling Logic
let progressInterval = null;

function startProgressPolling() {
  if (progressInterval) return;

  let pollAttempts = 0;
  const maxAttempts = 1200; // 20 minutes

  progressInterval = setInterval(() => {
    pollAttempts++;

    if (pollAttempts > maxAttempts) {
      stopProgressPolling();
      $("#modaluploading").iziModal('close');
      showError("Timeout!", "Import process took too long.");
      return;
    }

    $.ajax({
      url: 'import_progress.php',
      dataType: 'json',
      success: function (res) {
        if (res.processing_percent !== null) {
          setUploadProgressText(res.processing_percent + '%');

          if (res.processing_percent >= 100) {
            stopProgressPolling();
            waitForImportDataAndDisplay(); // Wait for backend response
          }
        }
      },
      error: function () {
        stopProgressPolling();
        showError("Progress Error!", "Unable to fetch progress.");
      }
    });
  }, 1000);
}

function stopProgressPolling() {
  if (progressInterval) {
    clearInterval(progressInterval);
    progressInterval = null;
  }
}

// Wait for the backend importData to be ready before closing modal
function waitForImportDataAndDisplay(attempts = 0) {
  if (window.importData?.counts) {
    setTimeout(() => {
      finishImportDisplay(); // ✅ Delay modal close here
    }, 500); // ⏱️ Wait 2 seconds after 100%
  } else if (attempts < 50) {
    setTimeout(() => waitForImportDataAndDisplay(attempts + 1), 100);
  } else {
    $("#modaluploading").iziModal('close');
    showError("Import Failed!", "Import finished but no result data was returned.");
  }
}

function finishImportDisplay() {
  if (!window.importData?.counts) return;

  buildTable(window.importData.data || []);
  updateCounters(window.importData.counts);

  $("#modaluploading").iziModal('close');
  $("#btnimport").prop('disabled', false).html('<i class="fa fa-upload"></i> Import File');
  $("#filexls").val(null);
  $(".box-body").validator('reset');

  swal({
    title: "Saved!",
    text: "Record has been imported successfully.",
    type: "success",
    confirmButtonColor: "#00a65a",
    confirmButtonText: "OK"
  });

  LoadCustData();
}

// 👇 UI Helpers
function updateCounters(counts) {
  $("#cntgood").text(`GOOD : ${counts.good || 0} Record(s)`);
  $("#cntupdated").text(`UPDATED : ${counts.updated || 0} Record(s)`);
  $("#cntduplicate").text(`DUPLICATE : ${counts.duplicate || 0} Record(s)`);
  $("#cntfailed").text(`FAILED : ${counts.failed || 0} Record(s)`);
  $("#cnttotal").text(`TOTAL : ${counts.total || 0} Record(s)`);
}

function buildTable(data) {
  $("#table_upload").DataTable().clear().destroy();
  $('#table_upload').DataTable({
    searching: false,
    info: false,
    scrollY: "500px",
    scrollX: true,
    scrollCollapse: true,
    paging: false,
    ordering: false,
    fixedHeader: true,
    fixedColumns: { left: 1 },
    columnDefs: [{ targets: [27], visible: false }],
    data: data,
    columns: [
      { data: "urutan" },
      { data: "VSI_No" },
      { data: "VSI_Date" },
      { data: "VSP_No" },
      { data: "VSP_Date" },
      { data: "Veh_Rel_Date" },
      { data: "Rel_Date" },
      { data: "Reserve_Type" },
      { data: "Cust_Grp_Code" },
      { data: "Cust_Grp_Descr" },
      { data: "Cust_No" },
      { data: "Cust_Name" },
      { data: "Contact_No" },
      { data: "Cust_Address" },
      { data: "MP_No" },
      { data: "MP_Name" },
      { data: "CS_No" },
      { data: "Colour" },
      { data: "Model_Descr" },
      { data: "VIN" },
      { data: "Frame_No" },
      { data: "Engine_No" },
      { data: "Model_Year" },
      { data: "Selling_Price" },
      { data: "Plant" },
      { data: "Dealer_Name" },
      { data: "Import_Status" },
      { data: "Status" }
    ]
  });
}
//============= BUTTONS ON MODAL UPLOAD FILE EXCEL ============//

//============= BUTTONS INSIDE TABLE ============//
var currentPopover = null;

// Preloaded popover HTML with placeholders
var popoverTemplate = `
<div style="background:#fff;border-radius:5px;padding:10px 10px 0;box-shadow:0 2px 12px rgba(0,0,0,.12)">
    <div class="text-center" style="margin-bottom:10px">
        <span class="badge-lg" id="popover-status">Loading...</span>
    </div>
    <table class="table table-hover" style="font-size:11px;margin:0">
        <tbody>
            <tr><td colspan="2"><strong>Approved By</strong></td></tr>
            <tr><td>ID:</td><td id="popover-user-id">-</td></tr>
            <tr><td>Name:</td><td id="popover-display-name">-</td></tr>
            <tr><td>Status Date:</td><td id="popover-status-date">-</td></tr>
            <tr><td colspan="2" class="text-center"><strong>REMARKS</strong></td></tr>
            <tr><td colspan="2" class="text-center" id="popover-remarks">-</td></tr>
        </tbody>
    </table>
</div>`;

// Click handler
$(document).on("click", ".badge", function (e) {
    e.preventDefault();
    e.stopPropagation();

    var $badge = $(this);
    var insuranceno = $badge.attr("insuranceno");

    // Toggle same badge
    if (currentPopover && currentPopover.is($badge)) {
        $badge.popover("hide");
        currentPopover = null;
        return;
    }

    // Hide previous
    if (currentPopover) {
        currentPopover.popover("hide");
        currentPopover = null;
    }

    // Initialize only once
    if (!$badge.data('bs.popover')) {
        $badge.popover({
            html: true,
            trigger: "manual",
            placement: fetchView,
            container: "body",
            title: 'TRANSACTION STATUS INFO. &emsp;&emsp;&emsp;<button type="button" class="close popover-close-btn">&times;</button>',
            content: popoverTemplate
        });
    }

    // Show popover
    $badge.popover("show");
    currentPopover = $badge;

    // Wait until popover is fully shown
    $badge.one('shown.bs.popover', function () {
        var popoverInstance = $badge.data('bs.popover');
        if (!popoverInstance || !popoverInstance.tip) return;

        var tip = popoverInstance.tip;

        // If cached, fill placeholders
        if ($badge.data('loadedContent')) {
            updatePopover(tip, $badge.data('loadedContent'));
            return;
        }

        // AJAX JSON fetch
        $.ajax({
            url: "new_business_status.php",
            type: "POST",
            data: { insuranceno: insuranceno },
            dataType: "json",
            success: function (data) {
                if (!tip || !data) return;
                $badge.data('loadedContent', data); // cache
                updatePopover(tip, data);
            },
            error: function () {
                if (!tip) return;
                $(tip).find('#popover-status').text('Error').addClass('label label-danger');
                $(tip).find('#popover-user-id').text('-');
                $(tip).find('#popover-display-name').text('-');
                $(tip).find('#popover-status-date').text('-');
                $(tip).find('#popover-remarks').text('Failed to load data');
            }
        });
    });
});

// Function to update placeholders
function updatePopover(tip, data) {
    $(tip).find('#popover-status')
        .text(data.status)
        .attr('class', 'badge-lg ' + data.labelClass);

    $(tip).find('#popover-user-id').text(data.userId);
    $(tip).find('#popover-display-name').text(data.displayName);
    $(tip).find('#popover-status-date').text(data.statusDate);
    $(tip).find('#popover-remarks').html(data.remarks.replace(/\n/g,'<br>'));
}

// Close popover
$(document).on("click", ".popover-close-btn", function (e) {
    e.preventDefault();
    e.stopPropagation();
    if (currentPopover) {
        currentPopover.popover("hide");
        currentPopover = null;
    }
});

// Close when clicking outside
$(document).on("click", function (e) {
    if (currentPopover && !$(e.target).closest(".popover, .badge").length) {
        currentPopover.popover("hide");
        currentPopover = null;
    }
});

$(document).on( "click", ".btnpay", function () {
  insuranceno = $(this).attr('insuranceno');
  FormClearPay();
  LoadPayData();
  FormDisablePay(true);
});

$(document).on( "click", ".btnnetrem", function () {
  insuranceno = $(this).attr('insuranceno');
  FormClearNetRem();
  LoadNetRemData();
  FormDisableNetRem(true);
});

$(document).on("click",".btnsoa",function(){
  insuranceno = $(this).attr('insuranceno');

  window.location = 'new_business_soa_xls.php?insuranceno='+insuranceno;

  swal({
    title: "Downloaded!",
    text: "SOA report succesfully exported.",
    type: "success",
    showCancelButton: false,
    confirmButtonColor: "#00a65a",
    confirmButtonText: "OK"
  });
});

$(document).on( "click", ".btnstatus", function () {
  insuranceno = $(this).attr('insuranceno');
  FormClearStatus();
  LoadStatusData();
  FormDisableStatus(true);
});

$(document).on( "click", ".btncall", function () {
  insuranceno = $(this).attr('insuranceno');
  FormClearCall();
  LoadCallData();
  FormDisableCall(true);
});

$(document).on( "click", ".btncalllog", function () {
  insuranceno = $(this).attr('insuranceno');
  LoadCallLogsData();
});

$(document).on( "click", ".btnedit", function () {
  insuranceno = $(this).attr('insuranceno');
  $.post("send_variable.php", { insuranceno:insuranceno }) .done(function(data) {
    window.open('new_business_modify.php', '_self');
  });
});

$(document).on( "click", ".btndelete", function () {
  insuranceno = $(this).attr('insuranceno');
  swal({
    title: "Are you sure?",
    text: "Data record with Insurance No " + insuranceno + " will be permanently delete.",
    type: "info",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    confirmButtonText: "Delete Record",
    closeOnConfirm: false,
    closeOnCancel: false
  },
  function(isConfirm){
    if (isConfirm) {
      $.ajax({
        type:"POST",
        url:"new_business_delete.php",
        data:{ insuranceno:insuranceno },
        dataType: "json",   // keep this
        success: function(data){
          if(data.result == 1){
            swal({
              title: "Deleted!",
              text: "Selected record has been deleted succesfully.",
              type: "success",
              showCancelButton: false,
              confirmButtonColor: "#00a65a",
              confirmButtonText: "OK"
            });
            LoadTransactionData();
          }else{
            swal({
              title: "Error!",
              text: "Can't delete data.",
              type: "error",
              showCancelButton: false,
              confirmButtonColor: "#00a65a",
              confirmButtonText: "OK"
            });
          }
        }
      });
    } else {
      swal({
        title: "Cancelled",
        text: "Nothing Happen!",
        type: "error",
        showCancelButton: false,
        confirmButtonColor: "#00a65a",
        confirmButtonText: "OK"
      });
    }
  });
});
//============= END BUTTONS INSIDE TABLE ============//

//============= BUTTONS ON MODAL MODIFY ============//
$(document).on( "click", "#btneditcall", function () {
  editcall = true;
  FormDisableCall(false);
});

$(document).on( "click", "#btnclosecall", function () {
  $('#modal-call').iziModal('close');
});

$(document).on( "click", "#btncancelcall", function () {
  editcall = false;
  FormClearCall();
  FormDisableCall(true);
  LoadCallData();
  $(".iziModal-wrap").scrollTop(0); 
});

$(document).on("click", "#btnupdatecall", function () {
  var insuranceno = $("#txtinsuranceno").val();
  var commid = $("#cbomodecomm").val();
  var commtype = $("#cbomodecomm :selected").text();
  var callsid = $("#cbocallstatus").val();
  var callstatus = $("#cbocallstatus :selected").text();
  var callreasonid = $("#cbocallreason").val();
  var callreason = $("#cbocallreason :selected").text();
  var promisedpaydate = getSaveDateFormatted($("#dpppdate").val());
  var callremarks = $("#txtcallremarks").val().trim();

  // Validation
  if (!commid || commid === 'PLEASE SELECT') {
    $("#cbomodecomm").focus();
    swal({
      title: "Warning",
      text: "Please fill out Mode of Communication.",
      type: "warning",
      confirmButtonColor: "#00a65a",
      confirmButtonText: "OK"
    });
    return;
  }

  if (!callsid || callsid === 'PLEASE SELECT') {
    $("#cbocallstatus").focus();
    swal({
      title: "Warning",
      text: "Please fill out Call Status.",
      type: "warning",
      confirmButtonColor: "#00a65a",
      confirmButtonText: "OK"
    });
    return;
  }

  if (callsid !== '1' && callsid !== '') {
    if (!callreasonid || callreasonid === 'PLEASE SELECT') {
      $("#cbocallreason").focus();
      swal({
        title: "Warning",
        text: "Please fill out Call Reason.",
        type: "warning",
        confirmButtonColor: "#00a65a",
        confirmButtonText: "OK"
      });
      return;
    }
  }

  if (callreason === 'CONFIRM RENEWAL') {
    if (!promisedpaydate) {
      $("#dpppdate").focus();
      swal({
        title: "Warning",
        text: "Please fill out Book Appointment Date.",
        type: "warning",
        confirmButtonColor: "#00a65a",
        confirmButtonText: "OK"
      });
      return;
    }
  }

  // Show loading modal
  $("#modalsaving").modal({
    backdrop: "static",
    keyboard: false,
    show: true
  });

  // Prepare form data
  var formdata = new FormData();
  formdata.append('insuranceno', insuranceno);
  formdata.append('commid', commid);
  formdata.append('commtype', commtype);
  formdata.append('callsid', callsid);
  formdata.append('callstatus', callstatus);
  formdata.append('callreasonid', callreasonid);
  formdata.append('callreason', callreason);
  formdata.append('promisedpaydate', promisedpaydate);
  formdata.append('callremarks', callremarks);

  // AJAX request
  $.ajax({
    url: "new_business_call_status_save.php",
    method: "POST",
    data: formdata,
    processData: false,
    contentType: false,
    dataType: 'json', // Let jQuery handle JSON parsing
    success: function (data) {
      $("#modalsaving").modal("hide");

      if (data.result == 1) {
        swal({
          title: "Save Call Status",
          text: "Record has been saved successfully.",
          type: "success",
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        }, function () {
          editcall = false;
          FormDisableCall(true);
          LoadCallData();
          $(".iziModal-wrap").scrollTop(0);

          if ($.fn.dataTable.isDataTable('#table_trans')) {
            table = $('#table_trans').DataTable();
            table.ajax.reload(null, false);
          }
        });
      } else {
        swal({
          title: "Error",
          text: "Failed to save the record. Please try again.",
          type: "error",
          confirmButtonColor: "#dd4b39",
          confirmButtonText: "OK"
        });
      }
    },
    error: function () {
      $("#modalsaving").modal("hide");
      swal({
        title: "Error",
        text: "An unexpected error occurred.",
        type: "error",
        confirmButtonColor: "#dd4b39",
        confirmButtonText: "OK"
      });
    }
  });
});

$(document).on("click", "#btnsubmit", function () {
  // ======================================================
  // Helper Utilities
  // ======================================================
  const getVal = (sel) => $(sel).val()?.toString().trim() || "";
  const getUpper = (sel) => getVal(sel).toUpperCase();
  const getNum = (sel) => RemoveNumFormat(getVal(sel)) || "0";
  const getDate = (sel) => getSaveDateFormatted($(sel).val());
  const isEmpty = (v) => v === "" || v === null || v === undefined;

  const showWarning = (selector, message) => {
    $(selector).focus();
    swal({
      title: "Warning",
      text: message,
      type: "warning",
      confirmButtonColor: "#00a65a",
      confirmButtonText: "OK"
    });
  };

  // ======================================================
  // Master Validation Function
  // ======================================================
  function runValidation(list) {
    for (const v of list) {
      if (isEmpty(v.value)) {
        showWarning(v.selector, v.message);
        return false;
      }
    }
    return true;
  }
  
  // ======================================================
  // CUSTOMER INFO
  // ======================================================
  const group = getVal("#cbogroup");

  let custfname = getUpper("#txtcustfname");
  let custmname = getUpper("#txtcustmname");
  let custlname = getUpper("#txtcustlname");
  let custsname = getUpper("#txtcustsname");
  let custname = getUpper("#txtcustname");

  // Build full name for INDIVIDUAL
  if (group === "INDIVIDUAL") {
    custname = [custfname, custmname, custlname, custsname]
      .filter((x) => x && x !== "")
      .join(" ");
  }

  // Customer fields
  const customerFields = {
    custno: getVal("#txtcustno"),
    custnoupload: getVal("#txtcustnoupload"),
    group,
    custname,
    custfname,
    custmname,
    custlname,
    custsname,
    birthdate: getDate("#dpbirthdate"),
    tin: getVal("#txttin"),
    contactno: getVal("#txtcontactno"),
    emailadd: getVal("#txtemailadd"),
    address: getVal("#txtaddress"),
    region: getVal("#cboregion"),
    province: getVal("#cboprovince"),
    city: getVal("#cbocity"),
    brgy: getVal("#cbobrgy"),
    zipcode: getVal("#txtzipcode"),
    country: getVal("#cbocountry"),
  };

  // Customer validation rules
  const customerValidation = [
    // { key: "custno", selector: "#txtcustno", message: "Please fill out Customer No." },
    { key: "group", selector: "#cbogroup", message: "Please fill out Group." },
    { key: "tin", selector: "#txttin", message: "Please fill out TIN." },
    { key: "contactno", selector: "#txtcontactno", message: "Please fill out Contact No." },
    { key: "emailadd", selector: "#txtemailadd", message: "Please fill out Email Address." },
    { key: "address", selector: "#txtaddress", message: "Please fill out Address." },
    { key: "region", selector: "#cboregion", message: "Please fill out Region." },
    { key: "province", selector: "#cboprovince", message: "Please fill out Province." },
    { key: "city", selector: "#cbocity", message: "Please fill out City." },
    { key: "brgy", selector: "#cbobrgy", message: "Please fill out Barangay." },
    { key: "zipcode", selector: "#txtzipcode", message: "Please fill out Zip Code." },
    { key: "country", selector: "#cbocountry", message: "Please fill out Country." },
  ];

  if (group === "INDIVIDUAL") {
    customerValidation.push(
      { key: "custfname", selector: "#txtcustfname", message: "Please fill out First Name." },
      { key: "custlname", selector: "#txtcustlname", message: "Please fill out Last Name." },
      { key: "birthdate", selector: "#dpbirthdate", message: "Please fill out Birth Date." }
    );
  } else {
    customerValidation.push(
      { key: "custname", selector: "#txtcustname", message: "Please fill out Customer Name." }
    );
  }

  if (!runValidation(customerValidation.map(v => ({
    value: customerFields[v.key],
    selector: v.selector,
    message: v.message
  })))) return;

  // Email format check
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(customerFields.emailadd)) {
    return showWarning("#txtemailadd", "Invalid email address. Example: ex@abc.xyz");
  }

  // ======================================================
  // VEHICLE INFO
  // ======================================================
  const vehicleFields = {
    vin: getVal("#txtvin"),
    make: getVal("#txtmake"),
    model: getVal("#txtmodel"),
    modelyear: getVal("#txtmodelyear"),
    color: getVal("#txtcolor"),
    engineno: getVal("#txtengineno"),
    csno: getVal("#txtcsno"),
    plateno: getVal("#txtplateno"),
    // orderno: getVal("#txtorderno"),
    // orderstatus: getVal("#txtorderstatus"),
    paidprice: getNum("#txtsrp"),
    vsidate: getDate("#dpvsidate"),
    reldate: getDate("#dpreldate"),
    techdate: getDate("#dptechdate"),
    // msalecode: getVal("#txtmsalecode"),
    variant: getVal("#txtvariant"),
    bodytype: getVal("#cbobodytype"),
    transmission: getVal("#txttransmission"),
    fueltype: getVal("#cbofueltype"),
    seats: getVal("#txtseats"),
    // unloadweight: getNum("#txtunloadweight"),
    // maxweight: getNum("#txtmaxweight"),
    prodclass: getVal("#cboprodclass"),
    owntype: getVal("#cboowntype"),
    voname: getVal("#txtvoname"),
    mpname: getVal("#txtmpname"),
  };

  // ======================================================
  // Custom Validation: CS No / Plate No (either one required)
  // ======================================================
  if (isEmpty(vehicleFields.csno) && isEmpty(vehicleFields.plateno)) {
    $("#txtcsno, #txtplateno").focus();
    showWarning("#txtcsno", "Please fill out either CS No or Plate No.");
    return;
  }

  const vehicleValidation = [
    { key: "vin", selector: "#txtvin", message: "Please fill out VIN." },
    { key: "make", selector: "#txtmake", message: "Please fill out Make." },
    { key: "model", selector: "#txtmodel", message: "Please fill out Model." },
    { key: "modelyear", selector: "#txtmodelyear", message: "Please fill out Model Year." },
    { key: "color", selector: "#txtcolor", message: "Please fill out Color." },
    { key: "engineno", selector: "#txtengineno", message: "Please fill out Engine No." },
    // { key: "orderno", selector: "#txtorderno", message: "Please fill out Order No." },
    // { key: "orderstatus", selector: "#txtorderstatus", message: "Please fill out Order Status." },
    { key: "paidprice", selector: "#txtsrp", message: "Please fill out Paid Price." },
    { key: "vsidate", selector: "#dpvsidate", message: "Please fill out VSI Date." },
    { key: "reldate", selector: "#dpreldate", message: "Please fill out Released Date." },
    // { key: "techdate", selector: "#dptechdate", message: "Please fill out Technical Date." },
    // { key: "msalecode", selector: "#txtmsalecode", message: "Please fill out Model Sales Code." },
    { key: "variant", selector: "#txtvariant", message: "Please fill out Variant." },
    { key: "bodytype", selector: "#cbobodytype", message: "Please fill out Body Type." },
    { key: "transmission", selector: "#txttransmission", message: "Please fill out Power Transmission." },
    { key: "fueltype", selector: "#cbofueltype", message: "Please fill out Fuel Type." },
    { key: "seats", selector: "#txtseats", message: "Please fill out Seats." },
    // { key: "unloadweight", selector: "#txtunloadweight", message: "Please fill out Unloaded Weight." },
    // { key: "maxweight", selector: "#txtmaxweight", message: "Please fill out Maximum Weight." },
    { key: "prodclass", selector: "#cboprodclass", message: "Please fill out Product Classification." },
    { key: "owntype", selector: "#cboowntype", message: "Please fill out Owner Type." },
    { key: "voname", selector: "#txtvoname", message: "Please fill out Vehicle Owner Name." },
    { key: "mpname", selector: "#txtmpname", message: "Please fill out Marketing Professional." }
  ];

  if (!runValidation(vehicleValidation.map(v => ({
    value: vehicleFields[v.key],
    selector: v.selector,
    message: v.message
  })))) return;

  // ======================================================
  // INSURANCE CALC
  // ======================================================
  var tablepay = $("#table_payment-n").DataTable();
  var allData = [];

  tablepay.rows().every(function() {
    var row = this.data();
    // Remove commas from numeric fields
    if (row.Payment_Amount) {
      row.Payment_Amount = row.Payment_Amount.toString().replace(/,/g, '');
    }
    allData.push(row);
  });

  const insuranceFields = {
    grosspremium: getNum("#txtgrosspremium"),
    netremittance: getNum("#txtnetremittance"),
    commission: getNum("#txtcommission"),
    optiontype: $('input[name="rdoptiontype"]:checked').val(),
    chkpayment: $("#chkpayment").is(":checked") ? 1 : 0,
    terms: getVal("#txtterms"),
    monthpay: getNum("#txtmonthpay"),
    payments:JSON.stringify(allData)
  }

  if (!runValidation([
    { value: insuranceFields.grosspremium, selector: "#txtgrosspremium", message: "Please fill out Gross Premium." },
    { value: insuranceFields.netremittance, selector: "#txtnetremittance", message: "Please fill out Net Remittance." },
    // { value: insuranceFields.commission, selector: "#txtcommission", message: "Please fill out Commission." }
  ])) return;

  if (insuranceFields.chkpayment) {
    if (!runValidation([
      { value: insuranceFields.terms, selector: "#txtterms", message: "Please fill out Terms." },
      { value: insuranceFields.monthpay, selector: "#txtmonthpay", message: "Please fill out Monthly Payment." },
    ])) return;
  }

  // ======================================================
  // INSURER INFO
  // ======================================================
  const insurerFields = {
    instype: getVal("#cboinstype"),
    insco: getVal("#cboinsco"),
    startdate: getDate("#dpstartdate"),
    policyno: getUpper("#txtpolicyno"),
    issuedate: getDate("#dpissuedate"),
    pexpiredate: getDate("#dppexpiredate"),
    mortgage: getVal("#cbomortgage")
    // mortaddress: getUpper("#txtmortaddress"),
    // selectedPromo: $('input[name="promo"]:checked').val() === "YES" ? 1 : 0
  };

  if (!runValidation([
    { value: insurerFields.instype, selector: "#cboinstype", message: "Please fill out Insurance Type." },
    { value: insurerFields.insco, selector: "#cboinsco", message: "Please fill out Insurance Company." },
    { value: insurerFields.startdate, selector: "#dpstartdate", message: "Please fill out Start / Inception Date." },
    { value: insurerFields.policyno, selector: "#txtpolicyno", message: "Please fill out Policy No." },
    { value: insurerFields.issuedate, selector: "#dpissuedate", message: "Please fill out Issue Date." },
    { value: insurerFields.pexpiredate, selector: "#dppexpiredate", message: "Please fill out Policy Expiration Date." },
    { value: insurerFields.mortgage, selector: "#cbomortgage", message: "Please fill out Mortgage." },
    // { value: insurerFields.mortaddress, selector: "#txtmortaddress", message: "Please fill out Mortgage Address." },
  ])) return;

  const iseno = getVal("#cboise");
  insuranceFields.iseno = iseno;

  // ======================================================
  // BUILD FORM DATA
  // ======================================================
  $("#modalsaving").iziModal("open");

  const formdata = new FormData();
  [customerFields, vehicleFields, insuranceFields, insurerFields].forEach(group => {
    Object.entries(group).forEach(([key, val]) => formdata.append(key, val));
  });

  // ======================================================
  // AJAX SUBMISSION
  // ======================================================
  $.ajax({
    url: "new_business_save.php",
    method: "POST",
    data: formdata,
    processData: false,
    contentType: false,
    success: function (response) {
      $("#modalsaving").iziModal('close');

      let result = jQuery.parseJSON(response);

      if (result.result == 1) {
        swal({
          title: "Saved!",
          text: "New record with Insurance No "+ result.Insurance_No +" has been created successfully.",
          type: "success",
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        }, function () {
          $("#modal-add").iziModal("close");
          if ($.fn.dataTable.isDataTable("#table_trans")) {
            $('#table_trans').DataTable().ajax.reload(null, false);
          }
        });
      } else {
        swal({
          title: "Error",
          text: "Failed to save the record.",
          type: "error",
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "OK"
        });
      }
    },
    error: function(xhr, status, error) {
      $("#modalsaving").iziModal('close');
      swal({
        title: "Error",
        text: "Something went wrong: " + error,
        type: "error",
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "OK"
      });
    }
  });
});

$(document).on( "click", "#btndelete", function () {
  swal({
    title: "Are you sure?",
    text: "Data record with Transaction ID " + transid + " will be permanently deleted.",
    type: "info",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    confirmButtonText: "Delete Record",
    closeOnConfirm: false,
    closeOnCancel: false
  },
  function(isConfirm){
    if (isConfirm) {
      $.ajax({
        type:"POST",
        url:"customer_list_delete.php",
        data:{ transid:transid },
        success: function(data){
          var data = jQuery.parseJSON(data);
          if(data.result == 1){
            swal({
              title: "Deleted!",
              text: "Selected record has been deleted succesfully.",
              type: "success",
              showCancelButton: false,
              confirmButtonColor: "#00a65a",
              confirmButtonText: "OK",
              closeOnConfirm: true
            }, function(){
                LoadCustData();
                FormClear();
                FormDisable(true);
                $('#modal-add').iziModal('close');
            });
          }else{
            swal({
              title: "Error!",
              text: "Can't delete data.",
              type: "error",
              showCancelButton: false,
              confirmButtonColor: "#00a65a",
              confirmButtonText: "OK"
            });
          }
        }
      });
    } else {
      swal({
        title: "Cancelled",
        text: "Nothing Happen!",
        type: "error",
        showCancelButton: false,
        confirmButtonColor: "#00a65a",
        confirmButtonText: "OK"
      });
    }
  });
});

/*========== STEPPER =========*/
let currentStep = 1;

function showStep(step){
  currentStep = step;
  document.querySelectorAll('.step').forEach(el => {
      el.classList.toggle('active', el.dataset.step == step);
  });
  document.querySelectorAll('.page').forEach(el => el.classList.remove('active'));
  document.getElementById('page'+step).classList.add('active');

  const totalSteps = document.querySelectorAll('.step').length;
  const percent = ((step-1)/(totalSteps-1))*100;
  document.getElementById('progressBar').style.width = percent + '%';
}

// Step click
$(document).on("click", ".step", function () {
  const stepNum = parseInt(this.dataset.step);
  showStep(stepNum);
});

// Next button
$(document).on("click", "#nextBtn", function () {
  if(currentStep < 5) showStep(currentStep + 1);
});

// Previous button
$(document).on("click", "#prevBtn", function () {
  if(currentStep > 1) showStep(currentStep - 1);
});
//============= END BUTTONS ON MODAL MODIFY ============//


////////////////////////////// END BUTTONS CLICKED /////////////////////////////////

/////////////////// ENABLED OR DISABLED /////////////////////
function FormDisable(val) { 
  $("#cboise").attr("disabled",val);

  /*============== CUSTOMER INFO ===========*/
  // $("#txtcustno").attr("disabled",val);
  $("#cbogroup").attr("disabled",val);
  $("#txtcustname").attr("disabled",val);
  $("#txtcustfname").attr("disabled",val);
  $("#txtcustmname").attr("disabled",val);
  $("#txtcustlname").attr("disabled",val);
  $("#txtcustsname").attr("disabled",val);
  $("#dpbirthdate").attr("disabled",val);
  $("#txttin").attr("disabled",val);
  $("#txtcontactno").attr("disabled",val);
  $("#txtemailadd").attr("disabled",val);
  $("#txtaddress").attr("disabled",val);
  $("#cboregion").attr("disabled",val);
  $("#cboprovince").attr("disabled",val);
  $("#cbocity").attr("disabled",val);
  $("#cbobrgy").attr("disabled",val);
  $("#txtzipcode").attr("disabled",val);
  $("#cbocountry").attr("disabled",val);

  /*============= VEHICLE INFO ============*/
  $("#txtvin").attr("disabled",val);
  $("#txtmake").attr("disabled",val);
  $("#txtmodel").attr("disabled",val);
  $("#txtmodelyear").attr("disabled",val);
  $("#txtcolor").attr("disabled",val);
  $("#txtengineno").attr("disabled",val);
  $("#txtcsno").attr("disabled",val);
  $("#txtplateno").attr("disabled",val);
  // $("#txtorderno").attr("disabled",val);
  // $("#txtorderstatus").attr("disabled",val);
  $("#txtsrp").attr("disabled",val);
  $("#dpvsidate").attr("disabled",val);
  $("#dpreldate").attr("disabled",val);
  $("#dptechdate").attr("disabled",val);
  // $("#txtmsalecode").attr("disabled",val);
  $("#txtvariant").attr("disabled",val);
  $("#cbobodytype").attr("disabled",val);
  $("#txttransmission").attr("disabled",val);
  $("#cbofueltype").attr("disabled",val);
  $("#txtseats").attr("disabled",val);
  // $("#txtunloadweight").attr("disabled",val);
  // $("#txtmaxweight").attr("disabled",val);
  $("#cboprodclass").attr("disabled",val);
  $("#cboowntype").attr("disabled",val);
  $("#txtvoname").attr("disabled",val);
  $("#txtmpname").attr("disabled",val);

  /*============= INSURANCE CALC ============*/
  $("#txtgrosspremium").attr("disabled",val);
  $("#txtnetremittance").attr("disabled",val);
  $("#chkpayment").prop("disabled", val);
  $("#txtterms").attr("disabled",val);
  $("#txtmonthpay").attr("disabled",true);
  // $("#chknonvat").prop("disabled", val);
  $("#cbopaytype-n").attr("disabled",val);
  $("#cboewallet-n").attr("disabled",val);
  $("#txtccno-n").attr("disabled",val);
  $("#txtccholder-n").attr("disabled",val);
  $("#txtccexpirydate-n").attr("disabled",val);
  $("#txtccvv-n").attr("disabled",val);
  $("#txtpdcno-n").attr("disabled",val);
  $("#txtpdcholdername-n").attr("disabled",val);
  $("#txtpdcbankname-n").attr("disabled",val);
  $("#dppdccheckdate-n").attr("disabled",val);
  $("#txtpayamount-n").attr("disabled",val);
  $("#btnaddpay-n").attr("disabled",val);

  /*============= INSURER INFO ============*/
  $("#cboinstype").attr("disabled",val);
  $("#cboinsco").attr("disabled",val);
  $("#dpstartdate").attr("disabled",val);
  $("#txtpolicyno").attr("disabled",val);
  $("#dpissuedate").attr("disabled",val);
  $("#dppexpiredate").attr("disabled",val);
  $("#cbomortgage").attr("disabled",val);
  // $("#txtmortaddress").attr("disabled",val);
  // $("#promoNo").prop("disabled", val);
  // $("#promoYes").prop("disabled", val);

  $(".box-body").validator('reset');
}

function FormDisablePay(val) {
  if (ulevel == 'ADMINISTRATOR' || ulevel == 'INSURANCE STAFF') {
    if (val == true) {
      $("#btneditpay").show();
      $("#btnclosepay").show();
      $("#btncancelpay").hide();
      $("#btnupdatepay").hide();
    } else {
      $("#btneditpay").hide();
      $("#btnclosepay").hide();
      $("#btncancelpay").show();
      $("#btnupdatepay").show();
    }
  } else {
    $("#btneditpay").hide();
    $("#btnclosepay").show();
    $("#btncancelpay").hide();
    $("#btnupdatepay").hide();
  }

  
  var balance = $("#tfoot_balance").text();
  balance = RemoveNumFormat(balance);

  // if (editpay == true) {
    if (val === true) {
      $(".pay-section, .term-amount-section, .btnadd-section, #btnupdatepay").fadeOut();
    } else {
      if (balance <= 0) {
        $(".pay-section, .term-amount-section, .btnadd-section, #btnupdatepay").fadeOut();
      } else {
        $(".pay-section, .term-amount-section, .btnadd-section, #btnupdatepay").fadeIn();
      }
    }
  // }

  var tablepay = $("#table_payment").DataTable();
  if (val === true) {
    tablepay.column('.col-action').visible(false);
  } else {
    tablepay.column('.col-action').visible(true);
  }
  tablepay.columns.adjust().draw(false);
    
  $("#cbopaytype").attr("disabled",val);
  $("#cboewallet").attr("disabled",val);
  $("#txtccno").attr("disabled",val);
  $("#txtccholder").attr("disabled",val);
  $("#txtccexpirydate").attr("disabled",val);
  $("#txtccvv").attr("disabled",val);
  $("#txtpdcno").attr("disabled",val);
  $("#txtpdcholdername").attr("disabled",val);
  $("#txtpdcbankname").attr("disabled",val);
  $("#dppdccheckdate").attr("disabled",val);
  $("#txtpayamount").attr("disabled",val);
  $("#btnaddpay").attr("disabled",val);

  $(".box-body").validator('reset');
}

function FormDisableNetRem(val) {
  if (ulevel == 'ADMINISTRATOR' || ulevel == 'INSURANCE STAFF') {
    if (val == true) {
      $("#btneditnetrem").show();
      $("#btnclosenetrem").show();
      $("#btncancelnetrem").hide();
      $("#btnupdatenetrem").hide();
    } else {
      $("#btneditnetrem").hide();
      $("#btnclosenetrem").hide();
      $("#btncancelnetrem").show();
      $("#btnupdatenetrem").show();
    }
  } else {
    $("#btneditnetrem").hide();
    $("#btnclosenetrem").show();
    $("#btncancelnetrem").hide();
    $("#btnupdatenetrem").hide();
  }
  
  $("#txtinsgpremium").attr("disabled",val);
  $("#txtnetrem").attr("disabled",val);

  $(".box-body").validator('reset');
}

function FormDisableStatus(val) {
  if (ulevel == 'ADMINISTRATOR' || ulevel == 'INSURANCE STAFF') {
    if (val == true) {
      $("#btneditstatus").show();
      $("#btnclosestatus").show();
      $("#btncancelstatus").hide();
      $("#btnupdatestatus").hide();
    } else {
      $("#btneditstatus").hide();
      $("#btnclosestatus").hide();
      $("#btncancelstatus").show();
      $("#btnupdatestatus").show();
    }
  } else {
    $("#btneditstatus").hide();
    $("#btnclosestatus").show();
    $("#btncancelstatus").hide();
    $("#btnupdatestatus").hide();
  }
  
  $("#cbotransstatus").attr("disabled",val);
  $("#txttranssremarks").attr("disabled",val);

  $(".box-body").validator('reset');
}

function FormDisableCall(val) {
  if (ulevel == 'ADMINISTRATOR' || ulevel == 'INSURANCE STAFF') {
    if (val == true) {
      $("#btneditcall").show();
      $("#btnclosecall").show();
      $("#btncancelcall").hide();
      $("#btnupdatecall").hide();
    } else {
      $("#btneditcall").hide();
      $("#btnclosecall").hide();
      $("#btncancelcall").show();
      $("#btnupdatecall").show();
    }
  } else {
    $("#btneditcall").hide();
    $("#btnclosecall").show();
    $("#btncancelcall").hide();
    $("#btnupdatecall").hide();
  }

  $("#cbomodecomm").attr("disabled",val);
  
  $("#cbocallstatus").attr("disabled",val);

  if (editcall == true) {
      var callsid = $("#cbocallstatus").val();
      if (callsid === '1' || callsid === '') {
        $("#cbocallreason").attr("disabled",true);
      } else {
        $("#cbocallreason").attr("disabled",false);
      }

      var callreason = $("#cbocallreason :selected").text();
      if (callreason === 'BOOKED APPOINTMENT'){
        $("#dpppdate").attr("disabled",false);
      } else {
        $("#dpppdate").attr("disabled",true);
      }
  } else {
    $("#cbocallreason").attr("disabled",true);
    $("#dpppdate").attr("disabled",true);
  }
  
  $("#txtcallremarks").attr("disabled",val);

  $(".box-body").validator('reset');
}
///////////////////////////////////////////////////////

/////////////////// ENABLED OR DISABLED /////////////////////
function FormClear() {
  // $("#cboise").val("").trigger('change.select2');

  /*============== CUSTOMER INFO ===========*/
  $("#txtcustno").val("");
  $("#txtcustnoupload").val("");
  $("#cbogroup").val("").trigger('change.select2');
  $("#txtcustname").val("");
  $("#txtcustfname").val("");
  $("#txtcustmname").val("");
  $("#txtcustlname").val("");
  $("#txtcustsname").val("");
  $("#dpbirthdate").val("");
  $("#txttin").val("");
  $("#txtcontactno").val("");
  $("#txtemailadd").val("");
  $("#txtaddress").val("");
  $("#cboregion").val("").trigger('change.select2');
  $("#cboprovince").val("").trigger('change.select2');
  $("#cbocity").val("").trigger('change.select2');
  $("#cbobrgy").val("").trigger('change.select2');
  $("#txtzipcode").val("");
  $("#cbocountry").val("PHILIPPINES").trigger('change.select2');

  /*============= VEHICLE INFO ============*/
  $("#txtvin").val("");
  $("#txtmake").val("");
  $("#txtmodel").val("");
  $("#txtmodelyear").val("");
  $("#txtcolor").val("");
  $("#txtengineno").val("");
  $("#txtcsno").val("");
  $("#txtplateno").val("");
  // $("#txtorderno").val("");
  // $("#txtorderstatus").val("");
  $("#txtsrp").val("");
  $("#dpvsidate").val("");
  $("#dpreldate").val("");
  $("#dptechdate").val("");
  // $("#txtmsalecode").val("");
  $("#txtvariant").val("");
  $("#cbobodytype").val("").trigger('change.select2');
  $("#txttransmission").val("");
  $("#cbofueltype").val("").trigger('change.select2');
  $("#txtseats").val("");
  // $("#txtunloadweight").val("");
  // $("#txtmaxweight").val("");
  $("#cboprodclass").val("").trigger('change.select2');
  $("#cboowntype").val("").trigger('change.select2');
  $("#txtvoname").val("");
  $("#txtmpname").val("");

  /*============= INSURANCE CALC ============*/
  $("#txtgrosspremium").val("0.00");
  $("#txtnetremittance").val("0.00");
  $("#txtcommission").val("0.00");
  $("input[name='rdoptiontype'][value='FREE']").prop("checked", true).trigger('change');
  $("#chkpayment").prop("checked", false).trigger('change');
  $("#txtterms").val("1");
  $("#txtmonthpay").val("0.00");
  // $("#chknonvat").prop("checked", false);

  /*============= INSURER INFO ============*/
  $("#cboinstype").val("").trigger('change.select2');
  $("#cboinsco").val("").trigger('change.select2');
  $("#dpstartdate").val("");
  $("#txtpolicyno").val("");
  $("#dpissuedate").val("");
  $("#dppexpiredate").val("");
  $("#cbomortgage").val("").trigger('change.select2');
  // $("#txtmortaddress").val("");
  // $("input[name='rdinspromo'][value='NO']").prop("checked", true);

  $(".box-body").validator('reset');
}

function FormClearVeh() {
  $("#txtvin").val("");
  $("#txtmake").val("");
  $("#txtmodel").val("");
  $("#txtmodelyear").val("");
  $("#txtcolor").val("");
  $("#txtengineno").val("");
  $("#txtcsno").val("");
  $("#txtplateno").val("");
  // $("#txtorderno").val("");
  // $("#txtorderstatus").val("");
  $("#txtsrp").val("");
  $("#dpvsidate").val("");
  $("#dpreldate").val("");
  $("#dptechdate").val("");
  // $("#txtmsalecode").val("");
  $("#txtvariant").val("");
  $("#cbobodytype").val("").trigger('change.select2');
  $("#txttransmission").val("");
  $("#cbofueltype").val("").trigger('change.select2');
  $("#txtseats").val("");
  // $("#txtunloadweight").val("");
  // $("#txtmaxweight").val("");
  $("#cboprodclass").val("").trigger('change.select2');
  $("#cboowntype").val("").trigger('change.select2');
  $("#txtvoname").val("");
  $("#txtmpname").val("");
}

function FormClearPay() {
  $("#cbopaytype, #cboewallet").val("").trigger("change");
  $("#txtccno, #txtccholder, #txtccexpirydate, #txtccvv").val("");
  $("#txtpdcno, #txtpdcholdername, #txtpdcbankname, #dppdccheckdate").val("");

  $(".box-body").validator('reset');
}

function FormClearNetRem() {
  $("#txtinsgpremium").val("");
  $("#txtnetrem").val("");

  $(".box-body").validator('reset');
}

function FormClearStatus() {
  $("#cbotransstatus").val("").trigger('change.select2');
  $("#txttranssremarks").val("");

  $(".box-body").validator('reset');
}

function FormClearCall() {
  $("#cbomodecomm").val("").trigger('change.select2');
  $("#cbocallstatus").val("").trigger('change.select2');
  $("#cbocallreason").val("").trigger('change.select2');
  $("#dpppdate").val("");
  $("#txtcallremarks").val("");

  $(".box-body").validator('reset');
}
///////////////////////////////////////////////////////

///////////// FORMATTING SETTINGS ////////////
function formatDate(input) {
  if (!input) return "";

  // Handle input format like "09-August-2025"
  const months = {
    January: "01", February: "02", March: "03",
    April: "04", May: "05", June: "06",
    July: "07", August: "08", September: "09",
    October: "10", November: "11", December: "12"
  };

  const parts = input.split("-");
  if (parts.length !== 3) return "";

  const day = parts[0].padStart(2, '0');
  const monthName = parts[1];
  const year = parts[2];

  const month = months[monthName];
  if (!month) return "";

  // Aligned Output: DD-MM-YYYY (e.g., "09-08-2025")
  return `${day}-${month}-${year}`; 
}

function getAmPmTime(twentyFourHourString) {
  // Match hours, minutes, optional seconds
  const match = twentyFourHourString.match(/^(\d{2}):(\d{2})(?::(\d{2}))?$/);
  if (!match) return ""; // invalid input

  let [_, hours, minutes, seconds] = match;
  hours = parseInt(hours, 10);
  const hasSeconds = !!seconds;
  seconds = seconds || "00";

  const period = hours >= 12 ? "PM" : "AM";
  let hh = hours % 12;
  if (hh === 0) hh = 12;

  const hourStr = ('0' + hh).slice(-2);
  const minuteStr = minutes;
  const secondStr = ('0' + seconds).slice(-2);

  return hasSeconds ? `${hourStr}:${minuteStr}:${secondStr} ${period}` 
                    : `${hourStr}:${minuteStr} ${period}`;
  // → 12 Hour "HH:MM:SS AMPM"
}

function getTwentyFourHourTime(amPmString) {
  // Match hours, minutes, optional seconds, and AM/PM
  const match = amPmString.match(/^(\d{1,2}):(\d{2})(?::(\d{2}))?\s*([APap][Mm])$/);
  if (!match) return ""; // invalid input

  let [_, hours, minutes, seconds, period] = match;
  hours = parseInt(hours, 10);
  const hasSeconds = !!seconds;
  seconds = seconds || "00";

  if (period.toUpperCase() === "PM" && hours !== 12) {
    hours += 12;
  } else if (period.toUpperCase() === "AM" && hours === 12) {
    hours = 0;
  }

  const hh = ('0' + hours).slice(-2);
  const mm = minutes;
  const ss = ('0' + seconds).slice(-2);

  return hasSeconds ? `${hh}:${mm}:${ss}` : `${hh}:${mm}`;
  // → 24 Hour "HH:MM:SS"
}

function getSaveDateFormatted(DateString) {
  const d = new Date(DateString);
  if (isNaN(d.getTime())) return ""; // invalid date
  
  const year = d.getFullYear();
  const month = ('0' + (d.getMonth() + 1)).slice(-2);
  const day = ('0' + d.getDate()).slice(-2);
  
  return `${year}-${month}-${day}`;
  // → "YYYY-MM-DD"
}

function getDateFormatted(dateString) {
    if (!dateString) return "";        // handles null, undefined, ""
    
    const d = new Date(dateString);
    if (isNaN(d)) return "";

    const day = String(d.getDate()).padStart(2, '0');
    const month = d.toLocaleString('en-GB', { month: 'short' });
    const year = d.getFullYear();

    return `${day}-${month}-${year}`;
    // → "DD-MMM-YYYY"
}

function getSaveDateTimeFormatted(DateTimeString) {
    const d = new Date(DateTimeString);

    // Check if date is valid
    if (isNaN(d.getTime())) {
        return ""; // Return empty string for invalid input
    }

    // Format date parts
    const year = d.getFullYear();
    const month = ('0' + (d.getMonth() + 1)).slice(-2);
    const day = ('0' + d.getDate()).slice(-2);

    // Format time parts
    const hours = ('0' + d.getHours()).slice(-2);
    const minutes = ('0' + d.getMinutes()).slice(-2);
    const seconds = ('0' + d.getSeconds()).slice(-2);

    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    // → "YYYY-MM-DD HH:mm:ss"
}

function getDisplayDateTimeFormatted(DateTimeString) {
  // Check for null, undefined, empty, or whitespace-only
  if (!DateTimeString || String(DateTimeString).trim() === "") {
      return "";
  }
  
  const d = new Date(DateTimeString);

  // Check for invalid date
  if (isNaN(d)) return "";

  const pad = (n) => String(n).padStart(2, "0");

  // Months in short text format
  const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

  const day = pad(d.getDate());
  const month = months[d.getMonth()];
  const year = d.getFullYear();

  const hours = pad(d.getHours());
  const minutes = pad(d.getMinutes());
  const seconds = pad(d.getSeconds());

  return `${day} ${month} ${year} ${hours}:${minutes}:${seconds}`;
  // → "DD MMM YYYY HH:MM:SS"
}

function isNumberKey(txt, evt) {
    const char = evt.key;

    // Allow control keys (delete, arrows, tab, esc, enter)
    if (
        evt.ctrlKey || evt.metaKey ||
        ["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab", "Escape", "Enter"].includes(char)
    ) {
        return true;
    }

    // Allow digits 0–9
    if (/[0-9]/.test(char)) return true;

    // Allow ONE decimal point, but not as the first character
    if (char === ".") {
        if (txt.value.includes(".")) return false;
        if (txt.value === "" || txt.value === "-" || txt.value === "+") return false; // don't allow "."
        return true;
    }

    // Allow negative or positive sign only at the start
    if (char === "-" || char === "+") {
        // Only allow at beginning & only one "-"
        if (txt.value.length === 0) return true;
        return false;
    }

    // Block all other characters
    return false;
}

function NumberFormat(value, decimals = 2) {
    if (value === null || value === undefined) return "";

    // Remove formatting before parsing
    value = value.toString().replace(/,/g, "");

    let num = parseFloat(value);

    if (isNaN(num)) return "";

    let fixed = num.toFixed(decimals);

    return fixed.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function RemoveNumFormat(text) {
    // If null, undefined, or empty → return 0
    if (text === null || text === undefined || text === "") return 0;

    // Remove commas and trim spaces
    let raw = text.toString().replace(/,/g, "").trim();

    // If still empty → return 0
    if (raw === "") return 0;

    // Convert to number
    let num = Number(raw);

    // If cannot convert → return 0
    if (isNaN(num)) return 0;

    // If integer → return integer
    if (Number.isInteger(num)) {
        return num;
    }

    // Strip unnecessary decimals (like 100.0 → 100)
    if (Number(num.toFixed(0)) === num) {
        return Number(num.toFixed(0));
    }

    // Otherwise, return numeric value as-is
    return num;
}

// Replace If Negative Number To ()
function replaceNegNum(textBox) {
  // Convert input to string and trim whitespace
  let str = String(textBox).trim();

  // If already wrapped in parentheses, return as-is
  if (/^\(.*\)$/.test(str)) {
    return str;
  }

  // If negative number, convert to parentheses format
  if (parseFloat(str) < 0) {
    str = "(" + str.replace(/^-/, '') + ")";
  }

  return str;
}

// Replace If () to Negative Number
function replaceParNum(textBox) {
  // Convert input to string and trim whitespace
  let str = String(textBox).trim();

  // Check if the number is wrapped in parentheses
  if (/^\(.*\)$/.test(str)) {
    // Remove parentheses and prepend negative sign
    str = '-' + str.replace(/[\(\)]/g, '');
  }

  return str;
}

// If parentheses → convert to negative or If negative → convert to parentheses
function convertFinancialNumber(value, decimals = 2) {
  // Convert input to number (remove parentheses if any)
  let num = parseFloat(String(value).replace(/[()]/g, '').trim());

  if (isNaN(num)) return value; // Return as-is if not a number

  // If originally in parentheses → convert to negative number
  if (/^\(.*\)$/.test(String(value).trim())) {
    return (-Math.abs(num)).toFixed(decimals);
  }

  // If negative → convert to parentheses
  if (num < 0) {
    return "(" + Math.abs(num).toFixed(decimals) + ")";
  }

  // Positive numbers → format to specified decimals
  return num.toFixed(decimals);
}
/////////// END FORMATTING SETTING ///////////