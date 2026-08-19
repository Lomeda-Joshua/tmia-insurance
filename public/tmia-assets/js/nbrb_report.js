//====== USER LOG IN VARIABLES ========
var userid;
var logname;
var ulevel;
var regdate;
var signin;
var table;
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

    //=========== COMBO BOX INITIALIZED =========== //
    $("#cbocategory").select2({
      allowClear: false,
      width: "100%",
      placeholder: "PLEASE SELECT"
    }).on('select2:close', function() {
      $(this).trigger("change");
    });

    $("#cbobustype").select2({
      allowClear: false,
      width: "100%",
      placeholder: "PLEASE SELECT"
    }).on('select2:close', function() {
      $(this).trigger("change");
    });

    //======= Transaction Status =====//
    $.ajax({
      type:"POST",
      url:"fetch_transaction_status.php",
      success: function(data) {
        const options = '<option value="ALL" selected>ALL</option>' + $.trim(data);
        $("#cbotranstatus").html(options);
      }
    });

    $("#cbotranstatus").select2({
      allowClear: true,
      width: "100%",
      placeholder: "PLEASE SELECT"
    }).on('select2:close', function() {
      $(this).trigger("change.select2");
    });

    //======= Month Name =====//
    $.ajax({
      type:"POST",
      url:"fetch_month.php",
      success: function(data) {
        $("#cbomonth").html(data);
      }
    });

    $("#cbomonth").select2({
      allowClear: false,
      width: "100%",
      placeholder: "PLEASE SELECT"
    }).on('select2:close', function() {
      $(this).trigger("change");
    });

    //======= Year =====//
    $.ajax({
      type:"POST",
      url:"fetch_year.php",
      success: function(data) {
        $("#cboyear").html(data);
      }
    });

    $("#cboyear").select2({
      allowClear: false,
      width: "100%",
      placeholder: "PLEASE SELECT"
    }).on('select2:close', function() {
      $(this).trigger("change");
    });
    //========== END COMBO BOX INITIALIZED ======== //

    //================== Date picker ===================//
    $("#dpdatefrom").datepicker({
      autoclose: true,
      format:'dd-MM-yyyy',
      todayHighlight : true
    }).datepicker("setDate", new Date());

    $("#dpdateto").datepicker({
      autoclose: true,
      format:'dd-MM-yyyy',
      todayHighlight : true
    }).datepicker("setDate", new Date());
    //==================================================//
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

////////////////////// COMBO CHANGE ///////////////////
  $(document).on("change","#cbofilter",function(){
    var cbofilter = $("#cbofilter").val();
    if (cbofilter == 'All' || cbofilter == '') {
      $(".viewdaterange").hide();
    } else {
      $(".viewdaterange").show();
    }
  });
//////////////////////////////////////////////////////

////////////////////////////// BUTTONS CLICKED /////////////////////////////////
  $(document).on("click", "#btnprocess", function () {

    // Disable button during processing to prevent double clicks
    $("#btnprocess").prop("disabled", true);

    // Read input values
    var category   = $("#cbocategory").val();
    var bustype    = $("#cbobustype").val();
    var transtatus = $("#cbotranstatus").val();
    var datefrom   = $("#dpdatefrom").val();
    var dateto     = $("#dpdateto").val();

    /* ==========================
       HELPER FUNCTION FOR WARNINGS
    ========================== */
    function showWarning(message, focusEl) {
        swal({
            title: "Warning",
            text: message,
            type: "warning",
            showCancelButton: false,
            confirmButtonColor: "#00a65a",
            confirmButtonText: "OK"
        });
        if (focusEl) focusEl.focus();
        $("#btnprocess").prop("disabled", false); // Re-enable button
        return false;
    }

    /* ==========================
       VALIDATION
    ========================== */
    if (!category) return showWarning("Please fill out category.", $("#cbocategory")[0]);
    if (!bustype) return showWarning("Please fill out Insurance Type.", $("#cbobustype")[0]);
    if (!transtatus) return showWarning("Please fill out Transactions Status.", $("#cbotranstatus")[0]);
    if (!datefrom) return showWarning("Please fill out Date From.", $("#dpdatefrom")[0]);
    if (!dateto) return showWarning("Please fill out Date To.", $("#dpdateto")[0]);

    /* ==========================
       SHOW LOADING MODAL
    ========================== */
    $("#modalloading").modal("show");

    /* ==========================
       LOAD REPORT
    ========================== */
    if (category === "DETAILED REPORT") {
        $("#viewreportDetail").show();
        LoadDetailedReport(); // initial load
    }

    /* ==========================
       ADJUST COLUMNS FOR RESPONSIVE TABLES
    ========================== */
    $($.fn.dataTable.tables(true))
        .DataTable()
        .columns.adjust()
        .responsive.recalc();
  });

  $(document).on("click","#btnexportxls",function(){
    var category   = $("#cbocategory").val();
    var bustype    = $("#cbobustype").val();
    var transtatus = $("#cbotranstatus").val();
    var datefrom   = $("#dpdatefrom").val();
    var dateto     = $("#dpdateto").val();

    if(category === "DETAILED REPORT"){

        var url = "nbrb_report_detailed_exportxls.php"
            + "?category="   + encodeURIComponent(category)
            + "&bustype="    + encodeURIComponent(bustype)
            + "&transtatus=" + encodeURIComponent(transtatus)
            + "&datefrom="   + encodeURIComponent(datefrom)
            + "&dateto="     + encodeURIComponent(dateto);

        window.location.href = url;

        swal({
            title: "Downloaded!",
            text: "Report successfully exported.",
            type: "success",
            confirmButtonColor: "#00a65a",
            confirmButtonText: "OK"
        });

    }else{

        swal({
            title: "Invalid Category",
            text: "Please select DETAILED REPORT.",
            type: "warning"
        });

    }
  });

  $(document).on("click",".btnsignout",function(){
    $.ajax({
      url : "send_signout.php",
      type: "POST",
      success: function(data)
      {
        var isMobile = false; //initiate as false
        // device detection
        if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
            || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))){
            isMobile = true;
            window.location.replace('mobile_login');
        } else {
            window.location.replace('login');
        }
      }
    });
  });
////////////////////////////// END BUTTONS CLICKED /////////////////////////////////

//////////////////////// FUNCTION LOAD DATA /////////////////////////
function LoadDetailedReport(){
  if ($.fn.DataTable.isDataTable('#table_detail')) {
      $('#table_detail').DataTable().clear().destroy();
  }

  $.ajax({
      url: "nbrb_report_detailed.php",
      type: "POST",
      data: {
          category: $("#cbocategory").val(),
          bustype: $("#cbobustype").val(),
          transtatus: $("#cbotranstatus").val(),
          datefrom: $("#dpdatefrom").val(),
          dateto: $("#dpdateto").val()
      },
      dataType: "json",
      success: function(response){
          $('#table_detail').DataTable({
              data: response,
              deferRender: true,
              pageLength: 10,
              scrollY: "500px",
              scrollX: true,
              scrollCollapse: true,
              fixedHeader: true,
              fixedColumns: { left: 1 },
              // responsive: true,
              columns:[
                  {data:"urutan", title:"#"},
                  {data:"Insurance_No", title:"Insurance No"},
                  {data:"Trans_Date", title:"Transaction Date"},
                  {data:"Trans_Status", title:"Status"},
                  {data:"Customer_No", title:"Customer No"},
                  {data:"Full_Name", title:"Full Name"},
                  {data:"Contact_No", title:"Contact No"},
                  {data:"VIN", title:"VIN"},
                  {data:"CS_No", title:"CS No"},
                  {data:"Plate_No", title:"Plate No"},
                  {data:"Model", title:"Model"},
                  {data:"Variant", title:"Variant"},
                  {data:"Insurance_Company", title:"Insurance Company"},
                  {data:"ISE_Name", title:"ISE Name"},
                  {data:"User_Full_Name", title:"User"}
              ],
              order:[[2,"asc"]]
          });

          $("#modalloading").modal("hide");

          swal({
              title: "Done!",
              text: "Report loaded successfully.",
              icon: "success",
              button: "OK"
          });
          
          $("#btnprocess").prop("disabled", false); // Re-enable button
          $("#btnexportxls").prop("disabled", false);
      },
      error: function(xhr, error, thrown){
          $("#modalloading").modal("hide");
          swal("Error", "Failed loading data: " + thrown, "error");
      }
  });
}
/////////////////////////////////////////////////////////////////////

function getSaveDateFormatted(DateString) {
  const d = new Date(DateString);
  var formattedDate = [d.getFullYear(),('0' + (d.getMonth() + 1)).slice(-2),('0' + d.getDate()).slice(-2)].join('-');
  formattedDate = formattedDate.replace("NaN-aN-aN","");
  return formattedDate;
}

function getDateFormatted(DateString) {
  const d = new Date(DateString);
  var formattedDate = d.toLocaleDateString('en-GB', {
    day: 'numeric', month: 'short', year: 'numeric'
  }).replace(/ /g, '-');
  formattedDate = formattedDate.replace("NaN-aN-aN","");
  return formattedDate;
}

function NumberFormat(value, decimals) {
  var x;
  if (decimals == undefined) {
    //x = Number(Math.round(value+'e2')+'e-2');
    x = parseFloat(value).toFixed(2);
  } else {
    //x = Number(Math.round(value+'e'+decimals)+'e-'+decimals);
    x = parseFloat(value).toFixed(decimals);
  }
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}