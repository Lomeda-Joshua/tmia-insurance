//====== USER LOG IN VARIABLES ========
var dealercode;
var userid;
var logname;
var ulevel;
var regdate;
var signin;
var xcustno;
var xvin;
var xcustnosel;
var xvinsel;
var xcsno;
var xplateno;
var xpayid;
var newdata;
let table;
var rowindex;
let editingRow;
var editinfo = false;
var btnselect;
var modifyinfo;
///////////////////////// FIRST LOAD SCRIPT ////////////////////////////////////
$(document).ready( function () {
  //================== GET USER LOG IN INFORMATION =================//
  $.ajax({
    url: window.fetchData.variableData,
    dataType: 'json',
    cache: false,
    success: function(data) {
      userid = data.userid;
      logname = data.logname;
      ulevel = data.ulevel;
      regdate = data.regdate;
      dealercode = data.dealercode;
      signin = data.signin;
    }
  });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': window.LaravelRoutes.csrfToken
        }
    });
  //=============== END GET USER LOG IN INFORMATION  =================//

  
  //============= TOOLTIPS ============//
  // Enable tooltips globally
  $('body').tooltip({
    selector: '.popup-data',
    placement: 'left',
    trigger: 'hover'
  });
  
  // Initialize tooltips once
  $(".popup-data").tooltip({
    placement: "left",
    trigger: "hover"
  });

  $(document).on("mouseleave", ".popup-data", function () {
    $(this).tooltip("hide");
  });
  //============= END TOOLTIPS ============//

  /* MODAL MODIFY CUSTOMER */
  $("#modal-modify-cust").iziModal({
    title: 'Customer Information Details',
    subtitle: 'Fill out all details required here.',
    headerColor: 'linear-gradient(0deg, #505050, #bbb, #505050)',
    icon: 'fa-regular fa-circle-user',
    iconColor: '#000',
    zindex: 9999,
    width: 800,
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

  $(document).on('fullscreen', '#modal-modify-cust', function (e, modal) {
    // console.log('Fullscreen: '+modal.isFullscreen);
  });

  $(document).on('opening', '#modal-modify-cust', function (e) {
    //console.dir(e);
  });

  $(document).on('opened', '#modal-modify-cust', function (e) {
    $(".iziModal-wrap").scrollTop(0); 
  });

  $(document).on('closing', '#modal-modify-cust', function (e) {
    // Fix accessibility warning: blur focused element before aria-hidden is set
    if (document.activeElement) {
        document.activeElement.blur();
    }
  });

  $(document).on('closed', '#modal-modify-cust', function (e) {
    //console.dir(e);
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

  /* MODAL MODIFY VEHICLE */
  $("#modal-modify-veh").iziModal({
    title: 'Vehicle Information Details',
    subtitle: 'Fill out all details required here.',
    headerColor: 'linear-gradient(0deg, #505050, #bbb, #505050)',
    icon: 'fa-solid fa-car',
    iconColor: '#000',
    zindex: 9999,
    width: 800,
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

  $(document).on('fullscreen', '#modal-modify-veh', function (e, modal) {
    // console.log('Fullscreen: '+modal.isFullscreen);
  });

  $(document).on('opening', '#modal-modify-veh', function (e) {
    //console.dir(e);
  });

  $(document).on('opened', '#modal-modify-veh', function (e) {
    $(".iziModal-wrap").scrollTop(0); 
  });

  $(document).on('closing', '#modal-modify-veh', function (e) {
    // Fix accessibility warning: blur focused element before aria-hidden is set
    if (document.activeElement) {
        document.activeElement.blur();
    }
  });

  $(document).on('closed', '#modal-modify-veh', function (e) {
    //console.dir(e);
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

  $(document).on('closing', '#modal-vehlist', function (e) {
    // Fix accessibility warning: blur focused element before aria-hidden is set
    if (document.activeElement) {
        document.activeElement.blur();
    }
  });

  /* MODAL MODIFY INSURANCE CALC */
  $("#modal-modify-calc").iziModal({
    title: 'Insurance Calculations Details',
    subtitle: 'Fill out all details here to auto compute.',
    headerColor: 'linear-gradient(0deg, #505050, #bbb, #505050)',
    icon: 'fa fa-calculator',
    iconColor: '#000',
    zindex: 9999,
    width: 800,
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

  $(document).on('fullscreen', '#modal-modify-calc', function (e, modal) {
    // console.log('Fullscreen: '+modal.isFullscreen);
  });

  $(document).on('opening', '#modal-modify-calc', function (e) {
    //console.dir(e);
  });

  $(document).on('opened', '#modal-modify-calc', function (e) {
    $(".iziModal-wrap").scrollTop(0); 
  });

  $(document).on('closing', '#modal-modify-calc', function (e) {
    // Fix accessibility warning: blur focused element before aria-hidden is set
    if (document.activeElement) {
        document.activeElement.blur();
    }
  });

  $(document).on('closed', '#modal-modify-calc', function (e) {
    //console.dir(e);
  });

  /* MODAL MODIFY INSURER */
  $("#modal-modify-ins").iziModal({
    title: 'Insurer Information Details',
    subtitle: 'Fill out all details required here.',
    headerColor: 'linear-gradient(0deg, #505050, #bbb, #505050)',
    icon: 'fa fa-building-shield',
    iconColor: '#000',
    zindex: 9999,
    width: 800,
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

  $(document).on('fullscreen', '#modal-modify-ins', function (e, modal) {
    // console.log('Fullscreen: '+modal.isFullscreen);
  });

  $(document).on('opening', '#modal-modify-ins', function (e) {
    //console.dir(e);
  });

  $(document).on('opened', '#modal-modify-ins', function (e) {
    $(".iziModal-wrap").scrollTop(0); 
  });

  $(document).on('closing', '#modal-modify-ins', function (e) {
    // Fix accessibility warning: blur focused element before aria-hidden is set
    if (document.activeElement) {
        document.activeElement.blur();
    }
  });

  $(document).on('closed', '#modal-modify-ins', function (e) {
    //console.dir(e);
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
  /*--------------------- CUSTOMER INFO --------------------*/
  //======= Customer Type =====//
  $.ajax({
    type:"POST",
    url:window.formRoutes.customerTypeData,
    success: function(data) {
        let options = '<option value="">PLEASE SELECT</option>';
        // Iterate over JSON objects and build <option> elements
        $.each(data, function(index, item) {
          options += `<option value="${item.Customer_TID}">${item.Customer_Type}</option>`;
        });

        // Inject populated options into dropdown
        $("#cbogroup").html(options);

        // Force Select2 to refresh its display
        $("#cbogroup").trigger('change.select2');
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
    url:window.formRoutes.regionData,
    success: function(data) {
        let options = '<option value="">PLEASE SELECT</option>';
        // Iterate over JSON objects and build <option> elements
        $.each(data, function(index, item) {
          options += `<option value="${item.RegCode}">${item.Region}</option>`;
        });

        // Inject populated options into dropdown
        $("#cboregion").html(options);

        // Force Select2 to refresh its display
        $("#cboregion").trigger('change.select2');
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
    url:window.formRoutes.bodyTypeData,
    success: function(data) {
            let options = '<option value="">PLEASE SELECT</option>';
            // Iterate over JSON objects and build <option> elements
            $.each(data, function(index, item) {
            options += `<option value="${item.Body_TID}">${item.Body_Type}</option>`;
            });

            // Inject populated options into dropdown
            $("#cbobodytype").html(options);

            // Force Select2 to refresh its display
            $("#cbobodytype").trigger('change.select2');
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
    url:window.formRoutes.fuelTypeData,
    success: function(data) {
            let options = '<option value="">PLEASE SELECT</option>';
            // Iterate over JSON objects and build <option> elements
            $.each(data, function(index, item) {
            options += `<option value="${item.Fuel_TID}">${item.Fuel_Type}</option>`;
            });

            // Inject populated options into dropdown
            $("#cbofueltype").html(options);

            // Force Select2 to refresh its display
            $("#cbofueltype").trigger('change.select2');
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
    url:window.formRoutes.productClassData,
    success: function(data) {
        let options = '<option value="">PLEASE SELECT</option>';
        // Iterate over JSON objects and build <option> elements
        $.each(data, function(index, item) {
        options += `<option value="${item.Prod_Class_ID}">${item.Prod_Class}</option>`;
        });

        // Inject populated options into dropdown
        $("#cboprodclass").html(options);

        // Force Select2 to refresh its display
        $("#cboprodclass").trigger('change.select2');
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
    url:window.formRoutes.customerTypeData,
    success: function(data) {
        let options = '<option value="">PLEASE SELECT</option>';
        // Iterate over JSON objects and build <option> elements
        $.each(data, function(index, item) {
          options += `<option value="${item.Customer_TID}">${item.Customer_Type}</option>`;
        });

        // Inject populated options into dropdown
        $("#cboowntype").html(options);

        // Force Select2 to refresh its display
        $("#cboowntype").trigger('change.select2');
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
    url:window.formRoutes.paymentTypeData,
    success: function(data) {
        let options = '<option value="">PLEASE SELECT</option>';

        // Iterate over JSON objects and build <option> elements
        $.each(data, function(index, item) {
          options += `<option value="${item.PayTID}">${item.PayType}</option>`;
        });

        // Inject populated options into dropdown
        $("#cbopaytype").html(options);

        // Force Select2 to refresh its display
        $("#cbopaytype").trigger('change.select2');
    }
  });

  $("#cbopaytype").select2({
    allowClear: true,
    width: "100%",
    placeholder: "PLEASE SELECT"
  }).on('select2:close', function() {
    $(this).trigger("change.select2");
  });

  //======= E-Wallet Type =====//
  $.ajax({
    type:"POST",
    url:window.formRoutes.ewalletTypeData,
    success: function(data) {
        let options = '<option value="">PLEASE SELECT</option>';

        // Iterate over JSON objects and build <option> elements
        $.each(data, function(index, item) {
          options += `<option value="${item.PayTID}">${item.PayType}</option>`;
        });

        // Inject populated options into dropdown
        $("#cboewallet").html(options);

        // Force Select2 to refresh its display
        $("#cboewallet").trigger('change.select2');
    }
  });

  $("#cboewallet").select2({
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
    url:window.formRoutes.insuranceTypeData,
    success: function(data) {
        let options = '<option value="">PLEASE SELECT</option>';

        // Iterate over JSON objects and build <option> elements
        $.each(data, function(index, item) {
          options += `<option value="${item.Insurance_TID}">${item.Insurance_Type}</option>`;
        });

        // Inject populated options into dropdown
        $("#cboinstype").html(options);

        // Force Select2 to refresh its display
        $("#cboinstype").trigger('change.select2');
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
    url:window.formRoutes.insuranceCoData,
    success: function(data) {
        let options = '<option value="">PLEASE SELECT</option>';

        // Iterate over JSON objects and build <option> elements
        $.each(data, function(index, item) {
          options += `<option value="${item.Insurance_ID}">${item.Insurance_Desc}</option>`;
        });

        // Inject populated options into dropdown
        $("#cboinsco").html(options);

        // Force Select2 to refresh its display
        $("#cboinsco").trigger('change.select2');
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
    url:window.formRoutes.bankData,
    success: function(data) {
        let options = '<option value="">PLEASE SELECT</option>';

        // Iterate over JSON objects and build <option> elements
        $.each(data, function(index, item) {
          options += `<option value="${item.BankID}">${item.BankDesc}</option>`;
        });

        // Inject populated options into dropdown
        $("#cbomortgage").html(options);

        // Force Select2 to refresh its display
        $("#cbomortgage").trigger('change.select2');
    }
  });

  $("#cbomortgage").select2({
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
  $('#txtccexpirydate').inputmask('99/99');

  $("#dppdccheckdate").datepicker({
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
      
      LoadCustomerData();
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
        LoadCustomerData();
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

    LoadInsuranceInfoDisplay(insuranceno);
});
///////////////////////// END FIRST LOAD SCRIPT ////////////////////////////////////

//======= Function Load Master Data ============//

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

  table = $('#table_customerlist').DataTable({
    language: {
      processing: "Loading Customer List..."
    },
    processing: true,
    serverSide: false,
    pageLength: 10,
    responsive: true,
    autoWidth: false,
    ajax: {
      url: "new_business_customers.php",
      type: "POST",
      data: value
    },
    columns: [
      { data: "urutan" },
      { data: "Customer_No" },
      { data: "Group" },
      { data: "Full_Name" },
      {
        data: "Birth_Date",
        render: function (data) {
          return getDateFormatted(data).toUpperCase();
        }
      },
      { data: "Contact_No" },
      { data: "Email_Address" },
      { data: "Address" },
      {
        data: "Active_Status",
        render: function (data) {
          return data == "1" ? "ACTIVE" : "INACTIVE";
        }
      },
      { data: "Inactive_Date" }
    ],
    columnDefs: [
      {
        targets: [3, 7],
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
  $('#table_customerlist tbody').off('click', 'tr').on('click', 'tr', function () {
    // Remove selection from any previously selected row
    table.$('tr.selected').removeClass('selected');

    // Highlight clicked row
    $(this).addClass('selected');

    // Optional: get Customer_No
    xcustnosel = table.cell(this, 1).data();
    console.log('Selected Customer No:', xcustno);
  });

  // ✅ Bind row click for selection AFTER table initialization
  $('#table_customerlist tbody').off('dblclick', 'tr').on('dblclick', 'tr', function () {
     $('#btncustselect').trigger("click");
  });
}

//============== Vehicle List ============//
function LoadVehicleData(custno) {
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
      data: {custno:custno}
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
    xvinsel = table.cell(this, 1).data();
    console.log('Selected VIN:', xvin);
  });

  // ✅ Bind row click for selection AFTER table initialization
  $('#table_vehiclelist tbody').off('dblclick', 'tr').on('dblclick', 'tr', function () {
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
//===== LOAD DATA TO DISPLAY =====
function LoadInsuranceInfoDisplay(insuranceno) {
  $.ajax({
    type:"POST",
    url:window.fetchData.getInsuranceNo,
    data:{insuranceno:insuranceno},
    success: function(data){
      $.each(data, function(i, value) {
        $("#insurance-no").html("TRANSACTION NO.: &emsp;" + value.Insurance_No);
        LoadCustomerInfoDisplay(value.Customer_No);
        LoadVehicleInfoDisplay(value.VIN);
        
        $("#rowgrosspremium").val(NumberFormat(value.Gross_Premium));
        $("#rownetremittance").val(NumberFormat(value.Net_Rem));
        $("#rowcommission").val(NumberFormat(value.Commission));
        $("input[name='rowoptiontype'][value='" + value.Option_Type + "']").prop("checked", true);
        $("#rowpayment").prop("checked", value.Install_Pay);
        $("#rowterms").val(value.Month_Terms);
        $("#rowmonthpay").val(NumberFormat(value.Month_Pay));
        // $("#rownonvat").prop("checked", value.Non_VAT);

        if (value.Option_Type === 'FREE') {
          $(".calc-paid-section").fadeOut()
          $(".payment-info").fadeOut()
        } else {
          $(".calc-paid-section").fadeIn()
          $(".payment-info").fadeIn()
        }

        if (value.Install_Pay == 1) {
          $(".calc-terms").fadeIn();
          $(".calc-monthpay").fadeIn();
        } else {
          $(".calc-terms").fadeOut()
          $(".calc-monthpay").fadeOut()
        }

        LoadPaymentInfoDisplay(insuranceno);

        /*------------ Insurer Info --------- */
        $("#insurertype").text(value.Insurance_Type);
        $("#insurercompany").text(value.Insurance_Company);
        $("#insurersdate").text(getDateFormatted(value.Start_Date).toUpperCase());
        $("#insurerpolicyno").text(value.Policy_No);
        $("#insurerissuedate").text(getDateFormatted(value.Issue_Date).toUpperCase());
        $("#insurerpexpiredate").text(getDateFormatted(value.Policy_Expiration).toUpperCase());
        $("#insurermortgage").text(value.Mortgage);
        // $("#insurermortgageaddress").text(value.Mortgage_Address);
        // $("input[name='insurerpromo'][value='" + (value.Promo_Avail == 1 ? "YES" : "NO") + "']").prop("checked", true);
        
        getAttachment(insuranceno);
      });
    }
  });
}

function LoadCustomerInfoDisplay(custno) {
  $.ajax({
    type:"POST",
    url:window.fetchData.customerData,
    data:{custno:custno},
    success: function(data){
      $.each(data, function(i, value) {
        xcustno = value.Customer_No;
        $("#custfullname").text(value.Full_Name);
        $("#custbirthdate").text(getDateFormatted(value.Birth_Date).toUpperCase());
        $("#custtin").text(value.TIN);
        $("#custcontactno").text(value.Contact_No);
        $("#custemailadd").text(value.Email_Address);
        $("#custno").text(value.Customer_No);
        $("#custaddress").text(value.Full_Address);
      });
    }
  });
}

function LoadVehicleInfoDisplay(vin) {
  $.ajax({
    type:"POST",
    url:window.fetchData.vehicleInfo,
    data:{vin:vin},
    success: function(data){
      $.each(data, function(i, value) {
        xvin = value.VIN;
        $("#vehvin").text(value.VIN);
        $("#vehmake").text(value.Make);
        $("#vehmodel").text(value.Model);
        $("#vehmodelyear").text(value.Model_Year);
        $("#vehcolor").text(value.Color);
        $("#vehengineno").text(value.Engine_No);
        $("#vehcsno").text(value.CS_No);
        $("#vehplateno").text(value.Plate_No);
        // $("#vehorderno").text(value.Order_No);
        // $("#vehorderstatus").text(value.Order_Status);
        $("#vehsrp").text(NumberFormat(value.SRP));
        $("#vehvsidate").text(getDateFormatted(value.VSI_Date).toUpperCase());
        $("#vehreldate").text(getDateFormatted(value.Released_Date).toUpperCase());
        $("#vehtechdate").text(getDateFormatted(value.Technical_Date).toUpperCase());
        // $("#vehmsalescode").text(value.Model_Sales_Code);
        $("#vehvariant").text(value.Variant);
        $("#vehbodytype").text(value.Body_Type);
        $("#vehtransmission").text(value.Transmission);
        $("#vehfueltype").text(value.Fuel_Type);
        $("#vehseats").text(value.Seats);
        // $("#vehunloadweight").text(value.Unloaded_Weight);
        // $("#vehmaxweight").text(value.Max_Weight);
        $("#vehprodclass").text(value.Prod_Classify);
        $("#vehownertype").text(value.Owner_Type);
        $("#vehownername").text(value.Owner_Name);
        $("#vehmpname").text(value.MP_Name);
      });
    }
  });
}

function LoadPaymentInfoDisplay(insuranceno) {
  // Destroy previous instance
  if ($.fn.dataTable.isDataTable('#table_paymentdisplay')) {
    $('#table_paymentdisplay').DataTable().clear().destroy();
  }

  $('#table_paymentdisplay').DataTable({
    language: { processing: "Loading Payment List..." },
    processing: true,
    serverSide: false,
    responsive: true,
    autoWidth: false,
    ordering: false,
    searching: false,
    paging: false,
    info: false,

    // Right-align the Amount column
    columnDefs: [
      {
        targets: 5,          // Payment_Amount column
        className: "text-right"
      }
    ],

    ajax: {
      url: window.fetchData.getPaymentData,
      type: "POST",
      data: { insuranceno: insuranceno }
    },

    drawCallback: function () {
      var api = this.api();              // ✅ FIX
      var data = api.rows().data();      // now valid

      var total = 0;

      // Compute total amount
      data.each(function(row){
        var amt = parseFloat(String(row.Payment_Amount).replace(/,/g, "")) || 0;
        total += amt;
      });

      // Total Premium
      // var premium = $("#rowtpremium").text() || 0;
      var premium = $("#rowgrosspremium").val() || 0;
      premium = RemoveNumFormat(premium);

      // Balance
      var balance = premium - total;

      // Update TFOOT fields
      $("#tfoot_tpremiumd").text(NumberFormat(premium));
      $("#tfoot_totald").text(NumberFormat(total));
      $("#tfoot_balanced").text(NumberFormat(balance));
    },

    columns: [
      { data: "urutan" },
      { data: "Payment_ID" },
      { data: "Payment_Type" },
      { data: "EWallet_Type" },
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
      }
    ]
  });
}

//===== LOAD DATA TO MODIFY =====
function LoadCustomerInfo(custno) {
  $.ajax({
    type:"POST",
    url:"fetch_customer_info.php",
    data:{custno:custno},
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

  $(".box-body").validator('reset');
}

function LoadVehicleInfo(vin) {
  $.ajax({
    type:"POST",
    url:"fetch_vehicle_info.php",
    data:{vin:vin},
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

function LoadInsuranceInfo(insuranceno) {
  $.ajax({
    type:"POST",
    url:"fetch_transactions_nb.php",
    data:{insuranceno:insuranceno},
    success: function(data){
      var data = jQuery.parseJSON(data);
      $.each(data, function(i, value) {
        $("#txtgrosspremium").val(NumberFormat(value.Gross_Premium));
        $("#txtnetremittance").val(NumberFormat(value.Net_Rem));
        $("#txtcommission").val(NumberFormat(value.Commission));
        $("input[name='rdoptiontype'][value='" + value.Option_Type + "']").prop("checked", true).trigger('change');
        $("#chkpayment").prop("checked", value.Install_Pay).trigger('change');
        $("#txtterms").val(value.Month_Terms);
        $("#txtmonthpay").val(NumberFormat(value.Month_Pay));
      });
    }
  });
}

function LoadPaymentInfo(insuranceno) {
  // Destroy existing table if present
  if ($.fn.dataTable.isDataTable('#table_payment')) {
      $('#table_payment').DataTable().clear().destroy();
  }

  var tablepay = $('#table_payment').DataTable({
      language: {
          processing: "Loading Payment List..."
      },
      processing: true,
      serverSide: false,
      responsive: false,
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
          { data: "button" }
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
    // remove previous selection
    tablepay.$('tr.selected').removeClass('selected');

    // highlight clicked row
    $(this).addClass('selected');

    // get Payment_ID instead of undefined variable
    let selectedPaymentID = tablepay.row(this).data().Payment_ID;
    console.log("Selected Payment ID:", selectedPaymentID);


    var rowData = tablepay.row(this).data();
    editingRow = tablepay.row(this); // store reference for later update

    // Populate form fields
    xpayid = rowData.Payment_ID;
    $("#cbopaytype").val(rowData.Payment_Type).trigger("change.select2");
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
  var premium = $("#tfoot_tpremiumd").text() || 0;
  premium = RemoveNumFormat(premium);
  var balance = premium - total;

  premium = NumberFormat(premium);
  total = NumberFormat(total);
  balance = NumberFormat(balance);

  // Display total payment
  $("#tfoot_tpremium").text(premium);
  $("#tfoot_total").text(total);
  $("#tfoot_balance").text(balance);
  
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

function LoadInsurerInfo(insuranceno) {
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

        
        setSelectOption("#cboinstype", value.Insurance_Type, value.Insurance_Type);
        setSelectOption("#cboinsco", value.Insurance_Company, value.Insurance_Company);

        // Safe date handling
        if (value.Start_Date) {
          const safeSDate = new Date(value.Start_Date);
          if (!isNaN(safeSDate)) {
            $("#dpstartdate").datepicker("setDate", safeSDate);
          }
        }

        $("#txtpolicyno").val(value.Policy_No);

        // Safe date handling
        if (value.Issue_Date) {
          const safeIDate = new Date(value.Issue_Date);
          if (!isNaN(safeIDate)) {
            $("#dpissuedate").datepicker("setDate", safeIDate);
          }
        }

        // Safe date handling
        if (value.Policy_Expiration) {
          const safePEDate = new Date(value.Policy_Expiration);
          if (!isNaN(safePEDate)) {
            $("#dppexpiredate").datepicker("setDate", safePEDate);
          }
        }
        
        setSelectOption("#cbomortgage", value.Mortgage, value.Mortgage);
        // $("#txtmortaddress").val(value.Mortgage_Address);
        // $("input[name='rdinspromo'][value='" + (value.Promo_Avail == 1 ? "YES" : "NO") + "']").prop("checked", true);
      });
    }
  });
}

function getAttachment(insuranceno) {
  $.ajax({
    url:"file_nb_attach.php",
    method:"POST",
    data:{insuranceno:insuranceno},
    success:function(data){
      //Hide Button Download All and Delete All if files exists.
      $(".btnall").hide();

      var image2=[];
      var image1=[];
      var idata='';
      var data = jQuery.parseJSON(data);
      $.each(data, function(i, value) {
        image1.push('data:'+value.Type+';base64, '+value.File);
        idata = value.Name;

        if (idata.match(/(jpg|jpeg)$/i)) {
            image2.push({caption: value.Name, filename: value.Name, size: (value.Size * 1024), key: value.ID});
        } else if (idata.match(/(gif)$/i)) {
            image2.push({caption: value.Name, filename: value.Name, size: (value.Size * 1024), key:  value.ID});
        } else if (idata.match(/(png)$/i)) {
            image2.push({caption: value.Name, filename: value.Name, size: (value.Size * 1024), key:  value.ID});
        } else if (idata.match(/(webp)$/i)) {
            image2.push({caption: value.Name, filename: value.Name, size: (value.Size * 1024), key:  value.ID});
        } else if (idata.match(/(pdf)$/i)) {
            image2.push({type: 'pdf', caption: value.Name, filename: value.Name, size: (value.Size * 1024), key: value.ID});
        } else if (idata.match(/(doc|docx)$/i)) {
            image2.push({type: 'object', caption: value.Name, filename: value.Name, size: (value.Size * 1024), key: value.ID});
        } else if (idata.match(/(xls|xlsx)$/i)) {
            image2.push({type: 'object', caption: value.Name, filename: value.Name, size: (value.Size * 1024), key: value.ID});
        } else if (idata.match(/(ppt|pptx)$/i)) {
            image2.push({type: 'object', caption: value.Name, filename: value.Name, size: (value.Size * 1024), key: value.ID});
        }

        //Show Button Download All and Delete All if files exists.
        $(".btnall").show();
      });

      var isadmin;
      if (ulevel == "INSURANCE STAFF" || ulevel == "ADMINISTRATOR") {
        isadmin = true;
        $("#btndeleteall").show();
      } else {
        isadmin = false;
        $("#btndeleteall").hide();
      }

      var krajeeGetCount = function(id) {
        var cnt = $('#' + id).fileinput('getFilesCount');
        var msg = '';

        if (cnt === 0) {
          msg = 'You have no files remaining.';
          $(".btnall").hide();
        } else {
          msg = 'You have ' + cnt + ' file' + (cnt > 1 ? 's' : '') + ' remaining.';
          $(".btnall").show();
        }

        return msg;
      };

      $("#file").fileinput({
        uploadUrl: "./file_nb_upload.php",
        deleteUrl: './file_nb_delete.php',
        //initialPreviewDownloadUrl: './file_nb_download.php',
        uploadAsync: false,
        uploadExtraData: function() {
          return {
            insuranceno:insuranceno
          };
        },
        maxFileCount: 5,
        //maxTotalFileCount: 3,
        maxFileSize: 5120, //KB = 5MB
        validateInitialCount: true,
        overwriteInitial: false,
        allowedFileExtensions: ["jpg|jpeg", "png", "webp", "pdf", "doc|docx", "xls|xlsx", "ppt|pptx"],
        initialPreviewAsData: true, // defaults markup
        initialPreviewFileType: 'image', // image is the default and can be overridden in config below
        showUpload: isadmin, // hide upload button
        showRemove: isadmin, // hide remove button
        showBrowse: isadmin,
        dropZoneEnabled: isadmin,
        initialPreviewShowDelete: isadmin,
        initialPreview: image1,
        initialPreviewConfig: image2,
        otherActionButtons:'<button type="button" ' +
                            'class="btndownload btn btn-xs btn-default" ' +
                            'title="Download" {dataKey}>\n' + // the {dataKey} tag will be auto replaced
                            '<i class="bi-download"></i>\n' +
                            '</button>\n',
        preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
        previewFileIconSettings: { // configure your icon file extensions
          'jpg|jpeg': '<i class="fa-regular fa-file-image text-danger"></i>',
          'png': '<i class="fa-regular fa-file-image text-primary"></i>',
          'webp': '<i class="fa-regular fa-file-image text-warning"></i>',
          'pdf': '<i class="fa-regular fa-file-pdf text-danger"></i>',
          'doc|docx': '<i class="fa-regular fa-file-word text-primary"></i>',
          'xls|xlsx': '<i class="fa-regular fa-file-excel text-success"></i>',
          'ppt|pptx': '<i class="fa-regular fa-file-powerpoint text-danger"></i>'
        },
        previewFileExtSettings: { // configure the logic for determining icon file extensions
          'jpg|jpeg': function(ext) {
              return ext.match(/(jpg|jpeg)$/i);
          },
          'png': function(ext) {
              return ext.match(/(png)$/i);
          },
          'webp': function(ext) {
              return ext.match(/(webp)$/i);
          },
          'pdf': function(ext) {
              return ext.match(/(pdf)$/i);
          },
          'doc|docx': function(ext) {
              return ext.match(/(doc|docx)$/i);
          },
          'xls|xlsx': function(ext) {
              return ext.match(/(xls|xlsx)$/i);
          },
          'ppt|pptx': function(ext) {
              return ext.match(/(ppt|pptx)$/i);
          }
        }
      }).on('filebeforedelete', function() {
        return new Promise(function(resolve) {
          swal({
            title: "Are you sure?",
            text: "You will not be able to recover this file anymore!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel",
            closeOnConfirm: true,
            closeOnCancel: false
          },
          function(isConfirm){
            if (isConfirm) {
              resolve();
            } else {
              swal("Cancelled", "Your file is safe :)", "error");
            }
          });
        });
    }).on('filedeleted', function() {
      setTimeout(function() {
        swal({
          title: "Deleted!",
          text: "Selected file has been deleted succesfully. " + krajeeGetCount('file'),
          type: "success",
          showCancelButton: false,
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        });
      }, 10);
    }).on('fileuploaded', function(event) {
        swal({
          title: "Uploaded!",
          text: "File has been uploaded succesfully.",
          type: "success",
          showCancelButton: false,
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        }, function() {
          // This runs AFTER OK is clicked
          $('.kv-upload-progress').hide();     // Hide progress bar
          $('.kv-upload-progress .progress').hide();
          //Show Button Download All and Delete All if files exists.
          $(".btnall").show();
        });
      }).on('filebatchuploadcomplete', function(event) {
        swal({
          title: "Uploaded!",
          text: "All files have been uploaded successfully.",
          type: "success",
          showCancelButton: false,
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        }, function() {
          // This runs AFTER OK is clicked
          $('.kv-upload-progress').hide();     // Hide progress bar
          $('.kv-upload-progress .progress').hide();
          //Show Button Download All and Delete All if files exists.
          $(".btnall").show();
        });
      }).on('fileuploaderror', function(event, data, msg) {
        var size = data.files[0].size,
        maxFileSize = $(this).data().fileinput.maxFileSize,
        formatSize = (s) => {
          i = Math.floor(Math.log(s) / Math.log(1024));
          sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
          out = (s / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + sizes[i];
          return out;
        };
    
        msg = msg.replace('{customSize}', formatSize(size));
        msg = msg.replace('{customMaxSize}', formatSize(maxFileSize * 1024 /* Convert KB to Bytes */));
        $('li[data-file-id="'+data.id+'"]').html(msg);
      });

      $('.btndownload').on('click', function() {
        var key = $(this).data('key'); // get the file key)
        swal({
          title: "Are you sure?",
          text: "Your downloading selected file!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes, download it!",
          cancelButtonText: "No, cancel plx!",
          closeOnConfirm: false,
          closeOnCancel: false
        },function(isConfirm) {
          if (isConfirm) {
            window.location = 'file_nb_download.php?key='+key;
            swal("Downloaded!", "Selected file has been downloaded succesfully.", "success");
          } else {
            swal("Cancelled", "Downloading file abort.", "error");
          }
        });
      });
    }
  });
}
/////////////////////// END LOAD DATA FUNCTION ///////////////////////

//============= BUTTONS ON ATTACHEMENT ============//
$(document).on( "click", "#btndownloadall", function () {
  swal({
    title: "Are you sure?",
    text: "All attachment files in Insurance No. " + insuranceno + " will be downloaded.",
    type: "info",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    confirmButtonText: "Download All",
    closeOnConfirm: false,
    closeOnCancel: false
  },
  function(isConfirm) {
    if (isConfirm) {
      $.post("send_variable.php", { insuranceno:insuranceno,csno:csno,plateno:plateno }) .done(function(data) {
        window.location = 'file_nb_download_all.php';
        swal({
          title: "Downloaded!",
          text: "All attachement files has been downloaded succesfully.",
          type: "success",
          showCancelButton: false,
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        });
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

$(document).on( "click", "#btndeleteall", function () {
  swal({
    title: "Are you sure?",
    text: "All attachment files in Insurance No. " + insuranceno + " will be permanently deleted.",
    type: "info",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    confirmButtonText: "Delete All",
    closeOnConfirm: false,
    closeOnCancel: false
  },
  function(isConfirm){
    if (isConfirm) {
      $.ajax({
        type:"POST",
        url:"file_nb_delete_all.php",
        data:{ insuranceno:insuranceno },
        success: function(data){
          var data = jQuery.parseJSON(data);
          if(data.result == 1){
            $('#file').fileinput('destroy');
            getAttachment(insuranceno);
            swal({
              title: "Deleted!",
              text: "All attachment files has been permanently deleted succesfully.",
              type: "success",
              showCancelButton: false,
              confirmButtonColor: "#00a65a",
              confirmButtonText: "OK"
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
//============= END BUTTONS ON ATTACHEMENT ============//

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
      url:window.formRoutes.provinceData,
      success: function(data) {

            let options = '<option value="">PLEASE SELECT</option>';

            // Iterate over JSON objects and build <option> elements
            $.each(data, function(index, item) {
            options += `<option value="${item.ProvCode}">${item.Province}</option>`;
            });

            // Inject populated options into dropdown
            $("#cboprovince").html(options);

            // Pre-select province code if available
            if (provcode !== null && provcode !== '') {
            $("#cboprovince").val(provcode);
            }

            // Force Select2 to refresh its display
            $("#cboprovince").trigger('change.select2');

      }
    });
  }
}

function FetchCM(provcode,cmcode) {
  if (provcode !== null) {
    $.ajax({
      type:"POST",
      data: {provcode:provcode},
      url:window.formRoutes.cityMunicipalData,
      success: function(data) {
            let options = '<option value="">PLEASE SELECT</option>';

            // Iterate over JSON objects and build <option> elements
            $.each(data, function(index, item) {
                options += `<option value="${item.CMCode}">${item.CityMunicipal}</option>`;
            });

            // Inject populated options into dropdown
            $("#cbocity").html(options);

            // Pre-select province code if available
            if (provcode !== null && provcode !== '') {
                $("#cbocity").val(provcode);
            }

            // Force Select2 to refresh its display
            $("#cbocity").trigger('change.select2');
      }
    });
  }
}

function FetchBrgy(cmcode,brgycode) {
  if (cmcode !== null) {
    $.ajax({
      type:"POST",
      data: {cmcode:cmcode},
      url:window.formRoutes.barangayData,
      success: function(data) {
            let options = '<option value="">PLEASE SELECT</option>';

            // Iterate over JSON objects and build <option> elements
            $.each(data, function(index, item) {
            options += `<option value="${item.BrgyCode}">${item.Barangay}</option>`;
            });

            // Inject populated options into dropdown
            $("#cbobrgy").html(options);

            // Pre-select province code if available
            if (brgycode !== null && brgycode !== '') {
            $("#cbobrgy").val(brgycode);
            }

            // Force Select2 to refresh its display
            $("#cbobrgy").trigger('change.select2');
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
                $(focusMap[paytype]).focus();
            }
        });
    }
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
    data: { insuranceno:insuranceno, payments:JSON.stringify(allData) },
    success: function(response) {
      // You can parse response and show message
      swal({
        title: "Success",
        text: "Payments updated successfully!",
        type: "success",
        confirmButtonColor: "#00a65a",
        confirmButtonText: "OK"
      }, function () {
        LoadPaymentInfo(insuranceno);
        LoadPaymentInfoDisplay(insuranceno);
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

$(document).on("click", "#btncancelpay", function() {
  $('#modal-modify-pay').iziModal('close');
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

/*====== KEY UP ======*/
$(document).on( "keyup", "#txtcustomersearch", function () {
  var searchval = $(this).val().trim();
  if($.trim(searchval) == "" ) {
    LoadCustomerData();
  }
});

/*====== KEY DOWN ======*/
$(document).on( "keydown", "#txtcustomersearch", function (e) {
  if (e.which == 13) {
    e.preventDefault();
    var search = $(this).val();
    if ($.trim(search) != 0) {
      LoadCustomerData();
    }
    $(this).select();
  }
});

$(document).on( "click", "#btnfindcust", function () {
  LoadCustomerData();
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
$(document).on( "keypress", "#txtpayamount", function () {
  return isNumberKey(this, event);
});

/*====== FOCUS ======*/
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
$(document).on("focus", "#txtpayamount", function () {
    const raw = $(this).val();
    $(this).val(RemoveNumFormat(raw)).select();
});

/*====== LOST FOCUS ======*/
/*---------- CUSTOMER INFO ---------------*/
$(document).on( "blur", "#txtcustno", function () {
  var txtcustno = $(this).val().toUpperCase().trim();
  $(this).val(txtcustno);
});

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
$(document).on("blur", "#txtpayamount", function () {
    let val = $(this).val().replace(/[^0-9.]/g, "").trim();

    if (val !== "") {
        $(this).val(NumberFormat(val));
    }
});
/////////////// END TEXTBOX EVENT ///////////////////

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

      $("#txtterms").val("0");
      $("#txtmonthpay").val("0.00");
    }
  });

  $('input[name="rdoptiontype"]').on('change', function() {
    const val = $(this).val();
    if (val === 'FREE') {
      $(".installment-section").fadeOut();
    } else {
      $(".installment-section").fadeIn();
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
});
///////////////////////// END INSUIRANCE CALCULATION/////////////////////////////////

////////////////////////////// BUTTONS CLICKED /////////////////////////////////
//============= BUTTONS OUTSIDE TABLE ============//
$(document).on( "click", "#btneditcust", function () {
  modifyinfo = 'CUSTOMER INFO';
  LoadCustomerInfo(xcustno);
  $('#modal-modify-cust').iziModal('open');
});

$(document).on( "click", "#btnfindcustomer", function () {
  LoadCustomerData();
  $('#modal-customerlist').iziModal('open');
});

$(document).on( "click", "#btncustselect", function () {
  LoadCustomerInfo(xcustnosel);
  $('#modal-customerlist').iziModal('close');
});

$(document).on( "click", "#btneditveh", function () {
  modifyinfo = 'VEHICLE INFO';
  LoadVehicleInfo(xvin);
  $('#modal-modify-veh').iziModal('open');
});

$(document).on( "click", "#btnfindvehicle", function () {
 LoadVehicleData(xcustno);
  $('#modal-vehiclelist').iziModal('open');
});

$(document).on( "click", "#btnvehselect", function () {
  LoadVehicleInfo(xcustno);
  $('#modal-vehiclelist').iziModal('close');
});

$(document).on( "click", "#btneditinscalc", function () {
  modifyinfo = 'INSURANCE CALC';
  LoadInsuranceInfo(insuranceno);
  $('#modal-modify-calc').iziModal('open');
});

$(document).on( "click", "#btneditpayment", function () {
  modifyinfo = 'PAYMENT INFO';
  const rowterms = $('#rowterms').val();
  const rowmonthpay = $('#rowmonthpay').val();
  $('#txtpayterms').val(rowterms);
  $('#txtpayamount').val(rowmonthpay);
  LoadPaymentInfo(insuranceno);
  $('#modal-modify-pay').iziModal('open');
});

$(document).on( "click", "#btneditinsurer", function () {
  modifyinfo = 'INSURER INFO';
  LoadInsurerInfo(insuranceno);
  $('#modal-modify-ins').iziModal('open');
});

$(document).on( "click", "#btnupload", function () {
  $('#modal-upload').iziModal('open');
});
//============= END BUTTONS OUTSIDE TABLE ============//

//============= BUTTONS ON MODAL MODIFY ============//
$(document).on("click", "#btnupdatecust", function () {
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
  const custno = getVal("#txtcustno");

  // Build full name for INDIVIDUAL
  if (group === "INDIVIDUAL") {
    custname = [custfname, custmname, custlname, custsname]
      .filter((x) => x && x !== "")
      .join(" ");
  }

  // Customer fields
  const customerFields = {
    modifyinfo,
    xcustno,
    custno,
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
    { key: "custno", selector: "#txtcustno", message: "Please fill out Customer No." },
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
  // BUILD FORM DATA
  // ======================================================
  $("#modalsaving").iziModal("open");

  const formdata = new FormData();
  [customerFields].forEach(customerinfo => {
    Object.entries(customerinfo).forEach(([key, val]) => formdata.append(key, val));
  });

  // ======================================================
  // AJAX SUBMISSION
  // ======================================================
  $.ajax({
    url: "new_business_update.php",
    method: "POST",
    data: formdata,
    processData: false,
    contentType: false,
    success: function (response) {
      $("#modalsaving").iziModal('close');

      let result = jQuery.parseJSON(response);

      if (result.result == 1) {
        swal({
          title: "Updated Information!",
          text: "Customer information detatils has been updated successfully.",
          type: "success",
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        }, function () {
          LoadCustomerInfoDisplay(custno);
          $("#modal-modify-cust").iziModal("close");
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

$(document).on("click", "#btncancelcust", function () {
  $('#modal-modify-cust').iziModal('close');
});

$(document).on("click", "#btnupdateveh", function () {
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
  // VEHICLE INFO
  // ======================================================
  const vin = getVal("#txtvin");

  const vehicleFields = {
    modifyinfo,
    xvin,
    vin,
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
  // BUILD FORM DATA
  // ======================================================
  $("#modalsaving").iziModal("open");

  const formdata = new FormData();
  [vehicleFields].forEach(vehicleinfo => {
    Object.entries(vehicleinfo).forEach(([key, val]) => formdata.append(key, val));
  });

  // ======================================================
  // AJAX SUBMISSION
  // ======================================================
  $.ajax({
    url: "new_business_update.php",
    method: "POST",
    data: formdata,
    processData: false,
    contentType: false,
    success: function (response) {
      $("#modalsaving").iziModal('close');

      let result = jQuery.parseJSON(response);

      if (result.result == 1) {
        swal({
          title: "Updated Information!",
          text: "Vehicle information details has been updated successfully.",
          type: "success",
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        }, function () {
          LoadVehicleInfoDisplay(vin);
          $("#modal-modify-veh").iziModal("close");
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

$(document).on("click", "#btncancelveh", function () {
  $('#modal-modify-veh').iziModal('close');
});

$(document).on("click", "#btnupdatecalc", function () {
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
  // INSURANCE CALC
  // ======================================================
  const insuranceFields = {
    modifyinfo: modifyinfo,
    grosspremium: getNum("#txtgrosspremium"),
    netremittance: getNum("#txtnetremittance"),
    commission: getNum("#txtcommission"),
    optiontype: $('input[name="rdoptiontype"]:checked').val(),
    chkpayment: $("#chkpayment").is(":checked") ? 1 : 0,
    terms: getVal("#txtterms"),
    monthpay: getNum("#txtmonthpay")
  }

  if (!runValidation([
    { value: insuranceFields.grosspremium, selector: "#txtgrosspremium", message: "Please fill out Gross Premium." },
    { value: insuranceFields.netremittance, selector: "#txtnetremittance", message: "Please fill out Net Remittance." },
    { value: insuranceFields.commission, selector: "#txtcommission", message: "Please fill out Commission." }
  ])) return;

  if (insuranceFields.chkpayment) {
    if (!runValidation([
      { value: insuranceFields.terms, selector: "#txtterms", message: "Please fill out Terms." },
      { value: insuranceFields.monthpay, selector: "#txtmonthpay", message: "Please fill out Monthly Payment." },
    ])) return;
  }

  // ======================================================
  // BUILD FORM DATA
  // ======================================================
  $("#modalsaving").iziModal("open");

  const formdata = new FormData();
  [insuranceFields].forEach(inscalc => {
    Object.entries(inscalc).forEach(([key, val]) => formdata.append(key, val));
  });

  // ======================================================
  // AJAX SUBMISSION
  // ======================================================
  $.ajax({
    url: "new_business_update.php",
    method: "POST",
    data: formdata,
    processData: false,
    contentType: false,
    success: function (response) {
      $("#modalsaving").iziModal('close');

      let result = jQuery.parseJSON(response);

      if (result.result == 1) {
        swal({
          title: "Updated Information!",
          text: "Insurance calculations has been updated successfully.",
          type: "success",
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        }, function () {
          LoadInsuranceInfoDisplay(insuranceno);
          $("#modal-modify-calc").iziModal("close");
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

$(document).on("click", "#btncancelcalc", function () {
  $('#modal-modify-calc').iziModal('close');
});

$(document).on("click", "#btnupdateins", function () {
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
  // INSURER INFO
  // ======================================================
  const insurerFields = {
    modifyinfo,
    instype: getVal("#cboinstype"),
    insco: getVal("#cboinsco"),
    startdate: getDate("#dpstartdate"),
    policyno: getUpper("#txtpolicyno"),
    issuedate: getDate("#dpissuedate"),
    pexpiredate: getDate("#dppexpiredate"),
    mortgage: getVal("#cbomortgage"),
    // mortaddress: getUpper("#txtmortaddress"),
    // selectedPromo: $('input[name="rdinspromo"]:checked').val() === "YES" ? 1 : 0
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

  // ======================================================
  // BUILD FORM DATA
  // ======================================================
  $("#modalsaving").iziModal("open");

  const formdata = new FormData();
  [insurerFields].forEach(insurerinfo => {
    Object.entries(insurerinfo).forEach(([key, val]) => formdata.append(key, val));
  });

  // ======================================================
  // AJAX SUBMISSION
  // ======================================================
  $.ajax({
    url: "new_business_update.php",
    method: "POST",
    data: formdata,
    processData: false,
    contentType: false,
    success: function (response) {
      $("#modalsaving").iziModal('close');

      let result = jQuery.parseJSON(response);

      if (result.result == 1) {
        swal({
          title: "Updated Information!",
          text: "Insurer information details has been updated successfully.",
          type: "success",
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        }, function () {
          LoadInsuranceInfoDisplay(insuranceno);
          $("#modal-modify-ins").iziModal("close");
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

$(document).on("click", "#btncancelins", function () {
  $('#modal-modify-ins').iziModal('close');
});
//============= END BUTTONS ON MODAL MODIFY ============//
////////////////////////////// END BUTTONS CLICKED /////////////////////////////////

/////////////////// ENABLED OR DISABLED /////////////////////
function FormDisable(val) {
  /*============== CUSTOMER INFO ===========*/
  $("#txtcustno").attr("disabled",val);
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

  /*============= INSURER INFO ============*/
  $("#cboinstype").attr("disabled",val);
  $("#cboinsco").attr("disabled",val);
  $("#dpstartdate").attr("disabled",val);
  $("#txtpolicyno").attr("disabled",val);
  $("#dpissuedate").attr("disabled",val);
  $("#dppexpiredate").attr("disabled",val);
  $("#cbomortgage").attr("disabled",val);
  // $("#txtmortaddress").attr("disabled",val);

  $(".box-body").validator('reset');
}
///////////////////////////////////////////////////////

/////////////////// ENABLED OR DISABLED /////////////////////
function FormClear() {
  /*============== CUSTOMER INFO ===========*/
  $("#txtcustno").val("");
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
  $("#txtterms").val("0");
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
///////////////////////////////////////////////////////

///////////// FORMATTING SETTINGS ////////////
function formatDate(input) {
  if (!input) return "";

  // Handle format like "09-August-2025"
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

  return `${year}-${month}-${day}`; // Output: YYYY-MM-DD
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