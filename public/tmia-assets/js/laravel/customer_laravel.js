//====== USER LOG IN VARIABLES ========
var dealercode;
var userid;
var logname;
var ulevel;
var regdate;
var signin;
var xcustno;
var xvin;
var xcsno;
var xplateno;
var newdata;
let table;
var rowindex;
var editinfo = false;
var btnselect;
///////////////////////// FIRST LOAD SCRIPT ////////////////////////////////////
$(document).ready( function () {

  console.log(window.LaravelRoutes.customerTypeData);

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

  /* MODAL MODIFY */
  $("#modal-modify").iziModal({
    title: 'Customer Information Details',
    subtitle: 'Fill out all details required here.',
    headerColor: 'linear-gradient(0deg, #505050, #bbb, #505050)',
    icon: 'fa-regular fa-circle-user',
    iconColor: '#000',
    zindex: 9999,
    width: 600,
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

  $(document).on('fullscreen', '#modal-modify', function (e, modal) {
    // console.log('Fullscreen: '+modal.isFullscreen);
  });

  $(document).on('opening', '#modal-modify', function (e) {
    //console.dir(e);
  });

  $(document).on('opened', '#modal-modify', function (e) {
    $(".iziModal-wrap").scrollTop(0); 
  });

  $(document).on('closing', '#modal-modify', function (e) {
    // Fix accessibility warning: blur focused element before aria-hidden is set
    if (document.activeElement) {
        document.activeElement.blur();
    }
  });

  $(document).on('closed', '#modal-modify', function (e) {
    editinfo = false;
    FormClear();
    FormDisable(true);
    $(".box-body").validator('reset');
  });

   /* MODAL VEHICLE LIST*/
  $("#modal-vehlist").iziModal({
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

  $(document).on('fullscreen', '#modal-vehlist', function (e, modal) {
    // console.log('Fullscreen: '+modal.isFullscreen);
  });

  $(document).on('opening', '#modal-vehlist', function (e) {
    //console.dir(e);
  });

  $(document).on('opened', '#modal-vehlist', function (e) {
    //console.dir(e);
  });

  $(document).on('closing', '#modal-vehlist', function (e) {
    // Fix accessibility warning: blur focused element before aria-hidden is set
    if (document.activeElement) {
        document.activeElement.blur();
    }
  });

  $(document).on('closed', '#modal-vehlist', function (e) {
    //console.dir(e);
  });

  /* MODAL MODIFY */
  $("#modal-modifyveh").iziModal({
    title: 'Vehicle Information Details',
    subtitle: 'Fill out all details required here.',
    headerColor: 'linear-gradient(0deg, #505050, #bbb, #505050)',
    icon: 'fa-solid fa-car',
    iconColor: '#000',
    zindex: 9999,
    width: 600,
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

  $(document).on('fullscreen', '#modal-modifyveh', function (e, modal) {
    // console.log('Fullscreen: '+modal.isFullscreen);
  });

  $(document).on('opening', '#modal-modifyveh', function (e) {
    //console.dir(e);
  });

  $(document).on('opened', '#modal-modifyveh', function (e) {
    $(".iziModal-wrap").scrollTop(0); 
  });

  $(document).on('closing', '#modal-modifyveh', function (e) {
    // Fix accessibility warning: blur focused element before aria-hidden is set
    if (document.activeElement) {
        document.activeElement.blur();
    }
  });

  $(document).on('closed', '#modal-modifyveh', function (e) {
    editinfo = false;
    FormClear();
    FormDisable(true);
    $(".box-body").validator('reset');
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
          "left": 2
        },
        "columnDefs": [{
          "targets": [ 40 ],
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

  /* MODAL GENERATE Vehicle List */
  $("#modal-history").iziModal({
    title: 'Vehicle List Information',
    subtitle: 'Display all Vehicle List of the selected vehicle.',
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

  $(document).on('fullscreen', '#modal-history', function (e, modal) {
    // console.log('Fullscreen: '+modal.isFullscreen);
  });

  $(document).on('opening', '#modal-history', function (e) {
    //console.dir(e);
  });

  $(document).on('opened', '#modal-history', function (e) {
    //console.dir(e);
  });

  $(document).on('closing', '#modal-history', function (e) {
    // Fix accessibility warning: blur focused element before aria-hidden is set
    if (document.activeElement) {
        document.activeElement.blur();
    }
  });

  $(document).on('closed', '#modal-history', function (e) {
    //console.dir(e);
  });
  /////////////////////// END IZIMODAL ///////////////////////

  //============== COMBO BOX INITIALIZED ===========//
  //======= Customer Type =====//
  $.ajax({
    type:"POST",
    url: window.LaravelRoutes.customerTypeData,
    headers: {
        'X-CSRF-TOKEN': window.LaravelRoutes.csrfToken
    },
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
    LoadCustomerData();
});
///////////////////////// END FIRST LOAD SCRIPT ////////////////////////////////////

//======= Function Load Master Data ============//
//============== Customer List ============//
function LoadCustomerData() {
  const searchval = $("#txtsearch").val().trim();

  // Ensure btnselect is extracted as a string/primitive, not a DOM/jQuery object
  let cleanBtnSelect = '';
  if (typeof btnselect !== 'undefined' && btnselect !== null) {
    cleanBtnSelect = typeof btnselect === 'object' ? ($(btnselect).val() || '') : btnselect;
  }

  const value = {
    searchval:searchval,
    btnselect:btnselect
  };

  if ($.fn.DataTable.isDataTable('#table_trans')) {
    // Dynamically reload existing table instance without destroying DOM
    $('#table_trans').DataTable().ajax.reload();
    return;
  }

 const customerTable = $('#table_trans').DataTable({
    language: {
        processing: "Loading Customer List..."
    },
    processing: true,
    serverSide: true,
    deferLoading: 0,
    responsive: true,
    autoWidth: false,
    pageLength: 10,
    order: [[1, 'asc']], // Orders by Customer_No ascending
    ajax: {
        url: window.LaravelRoutes.customerData,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: function (d) {
            // Extracted values ensure no jQuery/DOM objects are passed
            d.searchval = $('#txtsearch').val() ? $('#txtsearch').val().trim() : (typeof searchval === 'string' ? searchval : '');
            d.btnselect = typeof cleanBtnSelect === 'string' ? cleanBtnSelect : '';
        },
        error: function (xhr, error, code) {
            console.error('DataTables AJAX Error:', xhr.responseText);
        }
    },
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false, defaultContent: '' },
        { data: 'Customer_No', name: 'Customer_No', defaultContent: '' },
        { data: 'Group', name: 'Group', defaultContent: '' },
        { data: 'Full_Name', name: 'Full_Name', defaultContent: '' },
        { 
            data: 'Birth_Date', 
            name: 'Birth_Date', 
            defaultContent: '',
            render: function (data) {
                return data ? getDateFormatted(data).toUpperCase() : '';
            }
        },
        { data: 'Contact_No', name: 'Contact_No', defaultContent: '' },
        { data: 'Email_Address', name: 'Email_Address', defaultContent: '' },
        { data: 'Full_Address', name: 'Full_Address', defaultContent: '' },
        { data: 'Remarks', name: 'Remarks', defaultContent: '' },
        { 
            data: 'Active_Status', 
            name: 'Active_Status', 
            defaultContent: '',
            render: function (data) {
                return data == "1" ? "ACTIVE" : "INACTIVE";
            }
        },
        { data: 'Inactive_Date', name: 'Inactive_Date', defaultContent: '' },
        { data: 'button', name: 'button', searchable: false, orderable: false, defaultContent: '' }
    ],
    columnDefs: [
        {
            // Truncate long strings for: Full_Name (2), Address (5)
            targets: [2, 5],
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
}
//======================================//

//============== Vehicle List ============//
function LoadVehicleData(custno) {
  if (ulevel == 'ADMINISTRATOR' || ulevel == 'INSURANCE STAFF') {
    $("#btnaddveh").show();
  } else {
    $("#btnaddveh").hide();
  }

  if ($.fn.dataTable.isDataTable('#table_vehlist')) {
    $('#table_vehlist').DataTable().clear().destroy();               
  }

  table = $('#table_vehlist').DataTable({
    language: {
      processing: "Loading Vehicle List..."
    },
    processing: true,
    serverSide: false,
    pageLength: 10,
    responsive: true,
    autoWidth: false,
    ajax: {
      url: "customer_vehicle_data.php",
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
      {
        data: "VSI_Date",
        render: function (data) {
          return getDateFormatted(data).toUpperCase();
        }
      },
      {
        data: "SRP",
        render: function (data) {
          return NumberFormat(data);
        }
      },
      { data: "button" }
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
}

//======= Function History Data ============//
function LoadHistoryData(custno) {
  // If DataTable exists, destroy it and reinitialize
  if ($.fn.dataTable.isDataTable('#table_history')) {
    $('#table_history').DataTable().clear().destroy();               
  }

  // Reinitialize the DataTable with updated AJAX configuration
  $('#table_history').DataTable({
    "language": {
      "processing": "Loading Vehicle List",
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
      "url": "fetch_vehicle_info.php",
      "type": "POST",
      "data": {custno:custno}
    },
    "columns": [
      { "data": "urutan" },
      { "data": "Order_No" },
      { "data": "Doc_Date" },
      { "data": "Job_Type" },
      { "data": "Job_Description" },
      { "data": "Plate_No" },
      { "data": "KM_Reading" },
      { "data": "SA_Name" },
      { "data": "VIN" },
      { "data": "Vehicle_Model_Descr" }
    ],
    "columnDefs": [
      {
        "targets": [9],  // Modify this if you want to target multiple columns
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

  if ($('#modal-history').is(':visible') == false) {
    $('#modal-history').iziModal('open');
  }
}
//======================================//

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

        xcustno = value.Customer_No;
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
        $("#txtremarks").val(value.Remarks);
      });
    }
  });
  
  $(".box-body").validator('reset');
  if ($('#modal-modify').is(':visible') == false) {
    $('#modal-modify').iziModal('open');
  }
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

        xcustno = value.Customer_No;
        xvin = value.VIN;
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
  if ($('#modal-modifyveh').is(':visible') == false) {
    $('#modal-modifyveh').iziModal('open');
  }
}
/////////////////////// END LOAD DATA FUNCTION ///////////////////////

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

$(document).on( "change", "#cbogroup", function () {
  var group = $(this).val();
  if (group === "INDIVIDUAL") {
    $(".customer-fleet-corp").fadeOut();
    $(".customer-individual").fadeIn();
  } else {
    $(".customer-fleet-corp").fadeIn();
    $(".customer-individual").fadeOut();
  }
});

$(document).on( "change", "#cboregion", function () {
  if (editinfo == true) {
    var regcode = $(this).val();
    $("#cboprovince").html('<option value="">PLEASE SELECT</option>');
    $("#cbocity").html('<option value="">PLEASE SELECT</option>');
    $("#cbobrgy").html('<option value="">PLEASE SELECT</option>');
    FetchProv(regcode,'');
  }
});

$(document).on( "change", "#cboprovince", function () {
  if (editinfo == true) {
    var provcode = $(this).val();
    $("#cbocity").html('<option value="">PLEASE SELECT</option>');
    $("#cbobrgy").html('<option value="">PLEASE SELECT</option>');
    FetchCM(provcode,'');
  }
});

$(document).on( "change", "#cbocity", function () {
  if (editinfo == true) {
    var cmcode = $(this).val();
    $("#cbobrgy").html('<option value="">PLEASE SELECT</option>');
    FetchBrgy(cmcode,'');
  }
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
/////////////// END COMBO BOX EVENT ///////////////////

/////////////// TEXTBOX EVENT ///////////////////
/*====== TEXT CHANGE ======*/
$(document).on("change", "#txtcustno", function () {
  var inputField = $(this);
  var custno = inputField.val().trim();

  if (custno === "") return; // do nothing if empty

  $.ajax({
    url: "customer_list_custno_exist.php",
    type: "POST",
    data: { custno: custno },
    success: function (response) {
      var data = jQuery.parseJSON(response);
      if (data.result == 1) {

        inputField.focus();
        
        // Remove last character or digit
        var newVal = custno.slice(0, -1);
        inputField.val(newVal);

        swal({
          title: "Record Exists!",
          text: "Customer Number " + custno + " is already assigned to " + data.fullname + ".",
          type: "warning",
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        }, function () {
          $(".box-body").validator('reset');
        });
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

$(document).on("change", "#txtvin", function () { 
  var inputField = $(this);
  var vin = inputField.val().trim();

  if (vin === "") return; // do nothing if empty

  $.ajax({
    url: "customer_vehicle_vin_exist.php",
    type: "POST",
    data: { vin: vin },
    success: function (response) {
      var data = jQuery.parseJSON(response);
      if (data.result == 1) {

        inputField.focus();
        
        // Remove last character or digit
        var newVal = vin.slice(0, -1);
        inputField.val(newVal);

        swal({
          title: "Record Exists!",
          text: "Vehicle Identification Number " + vin + " is already assigned to a " + data.Model + "  vehicle owned by " + data.fullname + ".",
          type: "warning",
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        }, function () {
          $(".box-body").validator('reset');
        });
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

/*====== KEY UP ======*/
$(document).on( "keyup", "#txtsearch", function () {
  var searchval = $(this).val().trim();
  if($.trim(searchval) == "" ) {
    LoadCustomerData();
  }
});

/*====== KEY DOWN ======*/
$(document).on( "keydown", "#txtsearch", function (e) {
  if (e.which == 13) {
    e.preventDefault();
    var search = $(this).val();
    if ($.trim(search) != 0) {
      LoadCustomerData();
    }
    $(this).select();
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

/*====== FOCUS ======*/
$("#txtsearch").focus(function(){
  $(this).select();
});

/*---------- VEHICLE INFO ---------------*/
$(document).on("focus", "#txtsrp", function () {
    const raw = $(this).val();
    $(this).val(RemoveNumFormat(raw)).select();
});

//Button Search 
$(document).on( "click", "#btnfind", function () {
  LoadCustomerData();
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

$(document).on( "blur", "#txtremarks", function () {
  var txtremarks = $(this).val().toUpperCase().trim();
  $(this).val(txtremarks);
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
/////////////// END TEXTBOX EVENT ///////////////////

////////////////////////////// BUTTONS CLICKED /////////////////////////////////
//============= BUTTONS OUTSIDE TABLE ============//
$(document).on( "click", "#btnadd", function () {
  newdata = true;
  transid = '';
  editinfo = true;
  FormClear();
  FormDisable(false);
  $('#modal-modify').iziModal('open');
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

$(document).on("click","#btndownload",function(){
  window.location = 'repair_order_template.php';

  swal({
    title: "Downloaded!",
    text: "RO Templates succesfully downloaded.",
    type: "success",
    showCancelButton: false,
    confirmButtonColor: "#00a65a",
    confirmButtonText: "OK"
  });
});
//============= END BUTTONS OUTSIDE TABLE ============//

//============= BUTTONS ON MODAL UPLOAD FILE EXCEL ============//
// =====================
// IMPORT BUTTON CLICK
// =====================
$(document).on("click", "#btnimport", function () {
    resetUI();

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

    // Step 1: Validate file structure
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
            }
        },
        error: function () {
            showError("Check Failed!", "Unable to validate the file.");
        }
    });
});

// =====================
// RESET UI
// =====================
function resetUI() {
    const dt = $("#table_upload").DataTable();
    if (dt) dt.clear().draw();

    $("#cntgood").text('GOOD : 0 Record(s)');
    $("#cntupdated").text('UPDATED : 0 Record(s)');
    $("#cntfailed").text('FAILED : 0 Record(s)');
    $("#cnttotal").text('TOTAL : 0 Record(s)');
}

// =====================
// START IMPORT
// =====================
function startImport(formData) {
    $("#modaluploading").iziModal('open');
    setUploadProgressText("0%");
    window.importData = null;

    startProgressPolling(); // Start progress polling

    // Step 2: Perform actual import
    $.ajax({
        url: "customer_list_import_xls.php",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            window.importData = typeof response === "string" ? JSON.parse(response) : response;
            // Polling will handle finish display
        },
        error: function () {
            stopProgressPolling();
            $("#modaluploading").iziModal('close');
            showError("Import Error!", "An error occurred during file import. Please try again.");
        }
    });
}

// =====================
// PROGRESS UI
// =====================
function setUploadProgressText(text) {
    $("#uploadPercentage").text(text);
}

// =====================
// ERROR HANDLER
// =====================
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

// =====================
// PROGRESS POLLING
// =====================
let progressInterval = null;

function startProgressPolling() {
    if (progressInterval) return;

    let attempts = 0;
    const maxAttempts = 1200; // ~20 minutes max

    progressInterval = setInterval(() => {
        attempts++;
        if (attempts > maxAttempts) {
            stopProgressPolling();
            showError("Timeout!", "Import took too long.");
            return;
        }

        $.getJSON('import_progress.php')
            .done(function (res) {
                if (res.processing_percent != null) {
                    setUploadProgressText(res.processing_percent + '%');

                    if (res.processing_percent >= 100) {
                        stopProgressPolling();
                        waitForImportDataAndDisplay();
                    }
                }
            })
            .fail(function () {
                stopProgressPolling();
                showError("Progress Error!", "Unable to fetch progress.");
            });
    }, 1000);
}

function stopProgressPolling() {
    if (progressInterval) {
        clearInterval(progressInterval);
        progressInterval = null;
    }
}

// =====================
// WAIT FOR BACKEND DATA
// =====================
function waitForImportDataAndDisplay(attempts = 0) {
    if (window.importData?.counts) {
        setTimeout(() => finishImportDisplay(), 500); // Wait 500ms for smooth UX
    } else if (attempts < 50) {
        setTimeout(() => waitForImportDataAndDisplay(attempts + 1), 100);
    } else {
        $("#modaluploading").iziModal('close');
        showError("Import Failed!", "Import finished but no result data was returned.");
    }
}

// =====================
// DISPLAY RESULTS
// =====================
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

    LoadCustomerData();
}

// =====================
// UI HELPERS
// =====================
function updateCounters(counts) {
    $("#cntgood").text(`GOOD : ${counts.good || 0} Record(s)`);
    $("#cntupdated").text(`UPDATED : ${counts.updated || 0} Record(s)`);
    $("#cntfailed").text(`FAILED : ${counts.failed || 0} Record(s)`);
    $("#cnttotal").text(`TOTAL : ${counts.total || 0} Record(s)`);
}

function buildTable(data) {
    const dt = $("#table_upload").DataTable();
    if (dt) dt.clear().destroy();

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
        // columnDefs: [{ targets: [27], visible: false }],
        data: data,
        columns: [
            { data: "urutan" },
            { data: "Customer_No" },
            { data: "Group" },
            { data: "Full_Name" },
            { data: "First_Name" },
            { data: "Middle_Name" },
            { data: "Last_Name" },
            { data: "Suffix_Name" },
            { data: "Birth_Date" },
            { data: "TIN" },
            { data: "Contact_No" },
            { data: "Email_Address" },
            { data: "Address" },
            { data: "RegCode" },
            { data: "ProvCode" },
            { data: "CMCode" },
            { data: "BrgyCode" },
            { data: "Zip_Code" },
            { data: "Country" },
            { data: "VIN" },
            { data: "Make" },
            { data: "Model" },
            { data: "Model_Year" },
            { data: "Color" },
            { data: "Engine_No" },
            { data: "CS_No" },
            { data: "Plate_No" },
            { data: "SRP" },
            { data: "VSI_Date" },
            { data: "Released_Date" },
            { data: "Variant" },
            { data: "Body_Type" },
            { data: "Transmission" },
            { data: "Fuel_Type" },
            { data: "Seats" },
            { data: "Prod_Classify" },
            { data: "Owner_Type" },
            { data: "Owner_Name" },
            { data: "MP_Name" },
            { data: "Import_Status" },
            { data: "Status" }
        ]
    });
}
//============= BUTTONS ON MODAL UPLOAD FILE EXCEL ============//

//============= BUTTONS INSIDE TABLE ============//
$(document).on( "click", ".btnhistory", function () {
  var vin = $(this).attr('vin');
  LoadHistoryData(vin);
});

$(document).on( "click", ".btnvehicle", function () {
  var custno = $(this).attr('custno');
  xcustno = custno;
  LoadVehicleData(custno);
  $('#modal-vehlist').iziModal('open');
});

$(document).on( "click", ".btnprint", function () {
  transid = $(this).attr('transid');
  $.post("send_variable.php", { transid:transid }) .done(function(data) {
    window.open('preview.php');
  });
});

$(document).on( "click", ".btnedit", function () {
  newdata = false;
  var custno = $(this).attr('custno');
  FormClear();
  FormDisable(true);
  LoadCustomerInfo(custno);
});

$(document).on( "click", ".btndelete", function () {
  var custno = $(this).attr('custno');
  swal({
    title: "Are you sure?",
    text: "Data record with Customer No. " + custno + " will be permanently delete.",
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
        data:{ custno:custno },
        success: function(data){
          var data = jQuery.parseJSON(data);
          if(data.result == 1){
            swal({
              title: "Deleted!",
              text: "Selected record has been deleted succesfully.",
              type: "success",
              showCancelButton: false,
              confirmButtonColor: "#00a65a",
              confirmButtonText: "OK"
            });
            LoadCustomerData();
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

$(document).on( "click", ".btnlock", function () {
  const custno = $(this).attr('custno');
  swal({
    title: "Set customer as active.",
    text: "Data record will be active.",
    type: "info",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    confirmButtonText: "OK",
    closeOnConfirm: false,
    closeOnCancel: false
  },
  function(isConfirm){
    if (isConfirm) {
      $.ajax({
        type:"POST",
        url:"customer_list_lock_unlock.php",
        data:{ custno:custno },
        success: function(data){
          var data = jQuery.parseJSON(data);
          if(data.result == 1){
            swal({
              title: "Active Records!",
              text: "Selected record has been active successfully.",
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
          if ($.fn.dataTable.isDataTable('#table_trans')) {
            table = $('#table_trans').DataTable();
            table.ajax.reload( null, false );
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

$(document).on( "click", ".btnunlock", function () {
  const custno = $(this).attr('custno');
  swal({
    title: "Set customer as inactive.",
    text: "Data record will be inactive.",
    type: "info",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    confirmButtonText: "OK",
    closeOnConfirm: false,
    closeOnCancel: false
  },
  function(isConfirm){
    if (isConfirm) {
      $.ajax({
        type:"POST",
        url:"customer_list_lock_unlock.php",
        data:{ custno:custno },
        success: function(data){
          var data = jQuery.parseJSON(data);
          if(data.result == 1){
            swal({
              title: "Inactive Records!",
              text: "Selected record has been inactive successfully.",
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
          if ($.fn.dataTable.isDataTable('#table_trans')) {
            table = $('#table_trans').DataTable();
            table.ajax.reload( null, false );
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

$(document).on( "click", ".btneditveh", function () {
  newdata = false;
  var vin = $(this).attr('vin');
  FormClearVeh();
  FormDisableVeh(true);
  LoadVehicleInfo(vin);
});

$(document).on("click", ".btndeleteveh", function () {
  var vin    = $(this).attr('vin');
  swal({
    title: "Are you sure?",
    text: "Selected record with VIN "+ vin + " will be permanently deleted.",
    type: "info",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    confirmButtonText: "Delete Record",
    closeOnConfirm: false
  }, function(isConfirm) {
    if (isConfirm) {
      $.ajax({
        type: "POST",
        url: "customer_vehicle_delete.php",
        data: { vin:vin },
        dataType: "json", // <-- IMPORTANT
        success: function(response){
          if (response.result == 1) {
            swal({
              title: "Deleted!",
              text: "Selected record has been deleted successfully.",
              type: "success",
              confirmButtonColor: "#00a65a",
              confirmButtonText: "OK"
            });

            // Refresh DataTable
            if ($.fn.dataTable.isDataTable('#table_vehlist')) {
              $('#table_vehlist').DataTable().ajax.reload(null, false);
            }
          } else {
            swal({
              title: "Error!",
              text: "Record could not be deleted.",
              type: "error",
              confirmButtonColor: "#00a65a",
              confirmButtonText: "OK"
            });
          }
        },
        error: function(xhr, status, error){
          swal({
            title: "Server Error!",
            text: "An unexpected error occurred: " + error,
            type: "error"
          });
        }
      });
    } else {
      swal({
        title: "Cancelled",
        text: "Nothing happened.",
        type: "error",
        confirmButtonColor: "#00a65a",
        confirmButtonText: "OK"
      });
    }
  });
});
//============= END BUTTONS INSIDE TABLE ============//

//============= BUTTONS ON MODAL MODIFY ============//
$(document).on( "click", "#btnedit", function () {
  editinfo = true;
  FormDisable(false);
  //$('#dprodate').focus();
});

$(document).on("click", "#btnsave", function () {
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
    newdata,
    xcustno,
    custno: getVal("#txtcustno"),
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
    remarks: getVal("#txtremarks")
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

  const txttitle = newdata === true ? "Saved!" : "Updated!";

  $.ajax({
    url: "customer_list_save.php",
    method: "POST",
    data: formdata,
    processData: false,
    contentType: false,
    success: function (response) {

      let result = jQuery.parseJSON(response);

      if (result.result == 1) {

        swal({
          title: txttitle,
          text: "Record has been saved successfully.",
          type: "success",
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        }, function () {
          if (newdata === true) {
            $("#modal-modify").iziModal("close");
          } else {
            editinfo = false;
            FormDisable(true);
            $(".iziModal-wrap").scrollTop(0);
          }

          if ($.fn.dataTable.isDataTable("#table_trans")) {
            $('#table_trans').DataTable().ajax.reload(null, false);
          }
        });
      }

      $("#modalsaving").iziModal('close');
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
                LoadCustomerData();
                FormClear();
                FormDisable(true);
                $('#modal-modify').iziModal('close');
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

$(document).on( "click", "#btnprint", function () {
  $.post("send_variable.php", { transid:transid }) .done(function(data) {
    window.open('preview.php');
  });
});

$(document).on( "click", "#btncancel", function () {
  editinfo = false;
  FormClear();
  FormDisable(true);
  LoadCustomerInfo(xcustno);
  $(".iziModal-wrap").scrollTop(0); 
});

$(document).on( "click", "#btnclose", function () {
  $('#modal-modify').iziModal('close');
});

$(document).on( "click", "#btneditveh", function () {
  editinfo = true;
  FormDisableVeh(false);
});

$(document).on("click", "#btnsaveveh", function () {
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
    newdata,
    xcustno,
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
    remarks: getVal("#txtremarksveh")
  };


  const vehicleValidation = [
    { key: "vin", selector: "#txtvin", message: "Please fill out VIN." },
    { key: "make", selector: "#txtmake", message: "Please fill out Make." },
    { key: "model", selector: "#txtmodel", message: "Please fill out Model." },
    { key: "modelyear", selector: "#txtmodelyear", message: "Please fill out Model Year." },
    { key: "color", selector: "#txtcolor", message: "Please fill out Color." },
    { key: "engineno", selector: "#txtengineno", message: "Please fill out Engine No." },
    { key: "csno", selector: "#txtcsno", message: "Please fill out CS No." },
    { key: "plateno", selector: "#txtplateno", message: "Please fill out Plate No." },
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

  const txttitle = newdata === true ? "Saved!" : "Updated!";

  $.ajax({
    url: "customer_vehicle_save.php",
    method: "POST",
    data: formdata,
    processData: false,
    contentType: false,
    success: function (response) {
      $("#modalsaving").iziModal('close');

      let result = jQuery.parseJSON(response);

      if (result.result == 1) {
        swal({
          title: txttitle,
          text: "Record has been saved successfully.",
          type: "success",
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        }, function () {
          if (newdata === true) {
            $("#modal-modifyveh").iziModal("close");
          } else {
            editinfo = false;
            FormDisableVeh(true);
            $(".iziModal-wrap").scrollTop(0);
          }

          if ($.fn.dataTable.isDataTable("#table_vehlist")) {
            $('#table_vehlist').DataTable().ajax.reload(null, false);
          }
        });
      }
    }
  });
});

$(document).on( "click", "#btncancelveh", function () {
  editinfo = false;
  FormClearVeh();
  FormDisableVeh(true);
  LoadVehicleInfo(xvin);
  $(".iziModal-wrap").scrollTop(0); 
});

$(document).on( "click", "#btncloseveh", function () {
  $('#modal-modifyveh').iziModal('close');
});

//============= END BUTTONS ON MODAL MODIFY ============//
////////////////////////////// END BUTTONS CLICKED /////////////////////////////////

/////////////////// ENABLED OR DISABLED /////////////////////
function FormDisable(val) {
  if (ulevel == 'ADMINISTRATOR' || ulevel == 'INSURANCE STAFF') {
    if (val == true){
      $("#viewaction").show();
      $("#viewaction1").hide();
    } else {
      $("#viewaction").hide();
      $("#viewaction1").show();
    }
  }

  if (newdata == true){
    $("#btncancel").hide();
    $("#btnclose").show();
  } else {
    $("#btncancel").show();
    $("#btnclose").hide();
  }
  

  // $("#txtvsino").attr("disabled",val);
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
  $("#txtremarks").attr("disabled",val);

  $(".box-body").validator('reset');
}

function FormDisableVeh(val) {
  if (ulevel == 'ADMINISTRATOR' || ulevel == 'INSURANCE STAFF') {
    if (val == true){
      $("#viewactionveh").show();
      $("#viewactionveh1").hide();
    } else {
      $("#viewactionveh").hide();
      $("#viewactionveh1").show();
    }
  }

  if (newdata == true){
    $("#btncancelveh").hide();
    $("#btncloseveh").show();
  } else {
    $("#btncancelveh").show();
    $("#btncloseveh").hide();
  }
  
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
  $("#txtremarksveh").attr("disabled",val);

  $(".box-body").validator('reset');
}
///////////////////////////////////////////////////////

/////////////////// ENABLED OR DISABLED /////////////////////
function FormClear() {
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
  $("#txtremarks").val("");
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
  $("#txtremarksveh").val("");
  // $("#dpreldate").datepicker("setDate", new Date());
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