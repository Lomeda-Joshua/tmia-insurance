///////////////////// PUBLIC VARIABLES ///////////////////
//====== USER LOG IN VARIABLES ========
var userid;
var logname;
var ulevel;
var regdate;
var signin;
//////////////////// END PUBLIC VARIABLES //////////////////

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
        LogNotify();
      }
  });

  //================== FUNTION LOGIN NOTIFICATION =================//
  function LogNotify() {
    if (signin == true){
      $.notify({
        title: "<strong>Success!</strong>",
        message: "<br>Login successfully.",
        icon: 'glyphicon glyphicon-ok-sign'
      },{
        type: "success",
        onShow: function() {
          this.css({'width':'auto','height':'auto'});
        }
      });
    }
  }

  //================== PASSWORD EXPIRED ===================//
  $.ajax({
    url : "home_pwdcheck.php",
    type: "POST",
    success: function(data)
    {
      var data = jQuery.parseJSON(data);
      if(data == 1){
        $("#modalpwdexpired").modal({
          backdrop: "static",
          keyboard: false,
          show: true
        });
      }else{
        //$("#modalpwdexpired").modal('hide');
      }
    }
  });

  $(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
  });

  $(".toggle-verify").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
  });

  $(".close").click(function() {
    swal({
      title: "Close changing passsword.",
      text: "Are your sure? \n This will automatically logout the system.",
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
        $("#modalpwdexpired").modal('hide');
        $(".btnsignout").trigger('click');
      } else {
        $("#pwd").focus();
        swal({
          title: "Cancelled",
          text: "You can now proceed changing your password. 😃",
          type: "error",
          showCancelButton: false,
          confirmButtonColor: "#00a65a",
          confirmButtonText: "OK"
        });
        return;
      }
    });
  });

  $("#btnupdatepwd").click(function() {
    var pword = $("#pwd").val().trim();
    var pverify = $("#verify").val().trim();

    if(pword == '' || pword == null){
      $("#pwd").focus();
      swal({
        title: "Warning!",
        text: "Please fill password.",
        type: "warning",
        showCancelButton: false,
        confirmButtonColor: "#00a65a",
        confirmButtonText: "OK"
      });
      return;
    } else if(pverify == '' || pverify == null){
      $("#verify").focus();
      swal({
        title: "Warning!",
        text: "Please fill verify password.",
        type: "warning",
        showCancelButton: false,
        confirmButtonColor: "#00a65a",
        confirmButtonText: "OK"
      });
      return;
    }

    if(pword != pverify) {
      $("#verify").focus();
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

    if (isValidPassword(pword) === false) {
      $("#pwd").focus();
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

    $.ajax({
      url : "home_pwdsave.php",
      type: "POST",
      data : { pword:pword },
      success: function(data)
      {
        var data = jQuery.parseJSON(data);
        if(data == 1){
          /*$.notify('Successfull save data');*/
          swal({
            title: "Success!",
            text: "✅ Password has been updated successfully and will require a reset after 90 days upon expiration.",
            type: "success",
            showCancelButton: false,
            confirmButtonColor: "#00a65a",
            confirmButtonText: "OK"
          }, function(){
            $("#modalpwdexpired").modal('hide');
          });
        } else if(data == 2){
          $("#pwd").focus();
          swal({
            title: "Matched!",
            text: "❌ The new password matches to the current one.\nPlease enter a different password.",
            type: "warning",
            showCancelButton: false,
            confirmButtonColor: "#00a65a",
            confirmButtonText: "OK"
          });
          return;
        }else{
          swal({
            title: "Error!",
            text: "Can't save user.",
            type: "error",
            showCancelButton: false,
            confirmButtonColor: "#00a65a",
            confirmButtonText: "OK"
          });
          return;
        }
      }
    });
  });

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
  //================== END PASSWORD EXPIRED ===================//

  //================== Date picker ===================//
    $("#dpdate").datepicker({
      autoclose: true,
      format:'dd/mm/yyyy',
      todayHighlight : true
    }).datepicker("setDate", new Date());
    //==================================================//

    //================== Combo Box ===================//
    $("#cbofiltersc").select2({
      allowClear: false,
      width: "100%",
      placeholder: "PLEASE SELECT"
    });
    //==================================================//

    // showData1();
    // showData2();
    // showChart1();
    // showChart2();
});

function capitalizeFirstLetter(words) {
  var separateWord = words.toLowerCase().split(' ');
  for (var i = 0; i < separateWord.length; i++) {
    separateWord[i] = separateWord[i][0].toUpperCase() + separateWord[i].slice(1);
  }
  return separateWord.join(' ');
}

function showData1() {
  const dpdate = $("#dpdate").val().trim();

  // Validate date format: DD/MM/YYYY
  const dateRegex = /^\d{2}\/\d{2}\/\d{4}$/;
  if (!dateRegex.test(dpdate)) {
    alert("Invalid date format. Please use DD/MM/YYYY.");
    return;
  }

  const [day, month, year] = dpdate.split("/");
  const d = new Date(`${year}-${month}-${day}`);

  if (isNaN(d.getTime())) {
    alert("Invalid date.");
    return;
  }

  // Format for backend
  const dpdateyear = d.getFullYear();
  const dpdatemonth = ('0' + (d.getMonth() + 1)).slice(-2);
  const dpdatetoday = `${dpdateyear}-${dpdatemonth}-${('0' + d.getDate()).slice(-2)}`;
  const filterby = $("#cbofiltersc").val();

  // Destroy existing table if needed
  const $table = $('#table_callstatus');
  if ($.fn.dataTable.isDataTable($table)) {
    $table.DataTable().clear().destroy();
  }

  // Init DataTable
  $table.DataTable({
    language: {
      processing: "Loading Call Status...",
      emptyTable: "No data available for selected date."
    },
    processing: true,
    serverSide: false,
    deferRender: true,
    autoWidth: false,
    searching: false,
    info: false,
    paging: false,
    ordering: false,
    ajax: {
      url: "home_data1.php",
      type: "POST",
      data: {
        dpdateyear,
        dpdatemonth,
        dpdatetoday,
        filterby
      },
      error: function (xhr) {
        const err = xhr.responseJSON?.error || "Failed to load data.";
        alert(err);
      }
    },
    columns: [
      {
        data: "Call_Status",
        title: "Call Status",
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).css({
            "text-align": "left",
            "font-weight": "bold"
          });
        }
      },
      { data: "TODAY", title: "Today" },
      { data: "MTD", title: "MTD" },
      { data: "YTD", title: "YTD" }
    ]
  });
}

function showData2() {
  const dpdate = $("#dpdate").val().trim();

  // Validate date format: DD/MM/YYYY
  const dateRegex = /^\d{2}\/\d{2}\/\d{4}$/;
  if (!dateRegex.test(dpdate)) {
    alert("Invalid date format. Please use DD/MM/YYYY.");
    return;
  }

  const [day, month, year] = dpdate.split("/");
  const d = new Date(`${year}-${month}-${day}`);

  if (isNaN(d.getTime())) {
    alert("Invalid date.");
    return;
  }

  // Format parts for backend
  const dpdateyear = d.getFullYear();
  const dpdatemonth = ('0' + (d.getMonth() + 1)).slice(-2);
  const filterby = $("#cbofiltersc").val();

  // Target table
  const $table = $('#table_callstatusdetail');
  if ($.fn.dataTable.isDataTable($table)) {
    $table.DataTable().clear().destroy();
  }

  // Initialize DataTable
  $table.DataTable({
    language: {
      processing: "Loading Call Status...",
      emptyTable: "No data available for selected date."
    },
    processing: true,
    serverSide: false,
    deferRender: true,
    autoWidth: false,
    searching: false,
    info: false,
    paging: false,
    ordering: false,

    ajax: {
      url: "home_data2.php",
      type: "POST",
      data: {
        dpdateyear,
        dpdatemonth,
        filterby
      },
      dataSrc: function(json) {
        let lastStatus = null;

        // Suppress repeated Call_Status in frontend (for safety)
        json.data.forEach(row => {
          if (row.Call_Status === lastStatus) {
            row.Call_Status = '';
          } else {
            lastStatus = row.Call_Status;
          }
        });

        // Show total in table footer
        $("#total-count").html(json.total.toLocaleString());

        return json.data;
      },
      error: function(xhr) {
        const err = xhr.responseJSON?.error || "Failed to load data.";
        alert(err);
      }
    },

    columns: [
      {
        data: "Call_Status",
        title: "Call Status",
        createdCell: function(td) {
          $(td).css({
            "text-align": "left",
            "font-weight": "bold"
          });
        }
      },
      {
        data: "Reason_Desc",
        title: "Reason Description",
        createdCell: function(td) {
          $(td).css("text-align", "left");
        }
      },
      {
        data: "Reason_Count",
        title: "Count",
        createdCell: function(td) {
          $(td).css("text-align", "center");
        }
      }
    ]
  });
}

 // Declare chart variable globally to reuse/destroy
let Chart1 = null;

function showChart1() {
    const dpdate = $("#dpdate").val(); // expects dd/mm/yyyy input
    
    if (!dpdate) {
        alert("Please select a date.");
        return;
    }
    
    // Convert dd/mm/yyyy to Date object
    const parts = dpdate.split("/");
    if (parts.length !== 3) {
        alert("Invalid date format. Please use dd/mm/yyyy.");
        return;
    }
    const d = new Date(parts[2], parts[1] - 1, parts[0]); // year, month (0-based), day
    
    if (isNaN(d)) {
        alert("Invalid date.");
        return;
    }
    
    // Prepare date strings for API
    const dpdateyear = `${d.getFullYear()}-01-01`;
    const dpdatemonth = `${d.getFullYear()}-${('0' + (d.getMonth() + 1)).slice(-2)}-01`;
    const dpdatetoday = `${d.getFullYear()}-${('0' + (d.getMonth() + 1)).slice(-2)}-${('0' + d.getDate()).slice(-2)}`;
    const filterby = $("#cbofiltersc").val(); // expected to be 'MONTH' or 'YEAR'

    // Use Intl.DateTimeFormat to get the full month name
    const monthName = new Intl.DateTimeFormat('en-US', { month: 'long' }).format(d);
   
    var boxtitle;
    var charttitle;

    if (filterby === "MONTH") {
      boxtitle = "Monthly Recap Report - Summary";
      charttitle = "Daily Service Call Outcomes by Status – "+monthName+" "+d.getFullYear();
    } else if (filterby === "YEAR") {
      boxtitle = "Yearly Recap Report - Summary";
      charttitle = "Monthly Service Call Outcomes by Status – "+d.getFullYear();
    }

    $("#boxtitle1").text(boxtitle);
    $("#charttitle1").text(charttitle);

    $.ajax({
        type: "POST",
        url: "home_chart1.php",
        data: { dpdateyear, dpdatemonth, dpdatetoday, filterby },
        success: function(response) {
            if (response.error) {
                alert("Error: " + response.error);
                return;
            }

            const labels = [];
            const pending = [];
            const success = [];
            const unsuccess = [];
            var totalPending = 0;
            var totalSuccess = 0;
            var totalUnsuccess = 0;
            var totalStatus = 0;

            response.forEach(item => {
                totalPending += item.PENDING;
                totalSuccess += item.SUCCESSFUL;
                totalUnsuccess += item.UNSUCCESSFUL;
                labels.push(item.DAILY);
                pending.push(item.PENDING);
                success.push(item.SUCCESSFUL);
                unsuccess.push(item.UNSUCCESSFUL);
            });

            
            totalStatus = totalPending + totalSuccess + totalUnsuccess;

            const pendingPct = totalStatus ? ((totalPending / totalStatus) * 100).toFixed(1) : 0;
            const successPct = totalStatus ? ((totalSuccess / totalStatus) * 100).toFixed(1) : 0;
            const unsuccessPct = totalStatus ? ((totalUnsuccess / totalStatus) * 100).toFixed(1) : 0;
            const totalPct = totalStatus ? ((totalStatus / totalStatus) * 100).toFixed(1) : 0;

            $("#tpending").text(totalPending);
            $("#tsuccess").text(totalSuccess);
            $("#tunsuccess").text(totalUnsuccess);
            $("#tcallstatus").text(totalStatus);

            $("#tpendingp").text(`${pendingPct} %`);
            $("#tsuccessp").text(`${successPct} %`);
            $("#tunsuccessp").text(`${unsuccessPct} %`);
            $("#tcallstatusp").text(`${totalPct} %`);

            const data = {
                labels,
                datasets: [
                    {
                        label: 'PENDING',
                        backgroundColor: 'rgba(255,165,0,0.8)',
                        borderColor: 'rgba(255,165,0,1)',
                        data: pending
                    },
                    {
                        label: 'SUCCESSFUL',
                        backgroundColor: 'rgba(15,135,0,0.8)',
                        borderColor: 'rgba(15,135,0,1)',
                        data: success
                    },
                    {
                        label: 'UNSUCCESSFUL',
                        backgroundColor: 'rgba(255,0,0,0.8)',
                        borderColor: 'rgba(255,0,0,1)',
                        data: unsuccess
                    }
                ]
            };

            //++++++++++++++ BAR CHART ++++++++++++++//
            // const options = {
            //     plugins: {
            //         legend: {
            //             display: true,
            //             labels: {
            //                 font: { size: 11, weight: 'bold' },
            //                 boxWidth: 10
            //             }
            //         },
            //         datalabels: {
            //             display: ctx => ctx.dataset.data[ctx.dataIndex] > 0,
            //             color: '#000',
            //             font: { size: 9, weight: 'bold' },
            //             anchor: 'end'
            //         }
            //     },
            //     responsive: true,
            //     maintainAspectRatio: false,
            //     elements: {
            //         bar: { borderWidth: 2 }
            //     },
            //     scales: {
            //         y: {
            //             beginAtZero: true,
            //             title: {
            //                 display: true,
            //                 text: 'Number of Calls'
            //             }
            //         },
            //         x: {
            //             title: {
            //                 display: true,
            //                 text: filterby === 'MONTH' ? 'Day' : 'Month'
            //             }
            //         }
            //     }
            // };

            //++++++++++++++ STACKED BAR CHART ++++++++++++++//
            const options = {
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            font: { size: 11, weight: 'bold' },
                            boxWidth: 10
                        }
                    },
                    datalabels: {
                        display: ctx => ctx.dataset.data[ctx.dataIndex] > 0,
                        color: '#000',
                        font: { size: 9, weight: 'bold' },
                        anchor: 'middle'
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                elements: {
                    bar: { borderWidth: 2 }
                },
                scales: {
                    x: {
                        stacked: true,
                        title: {
                            display: true,
                            text: filterby === 'MONTH' ? 'Day' : 'Month'
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Call Count'
                        }
                    }
                }
            };

            const ctx = document.getElementById("Chart1").getContext("2d");

            // Destroy existing chart instance if exists
            if (Chart1) {
                Chart1.destroy();
            }

            Chart1 = new Chart(ctx, {
                type: 'bar',
                data,
                options,
                plugins: [ChartDataLabels]
            });
        },
        error: function(xhr, status, error) {
            alert("AJAX Error: " + error);
        }
    });
}

// Declare chart variable globally
let Chart2;

function showChart2() {
  const dpdate = $("#dpdate").val();
  const filterby = $("#cbofiltersc").val();

  if (!dpdate) {
    alert("Please select a date.");
    return;
  }

  const parts = dpdate.split("/");
  if (parts.length !== 3) {
    alert("Invalid date format. Please use dd/mm/yyyy.");
    return;
  }

  const d = new Date(parts[2], parts[1] - 1, parts[0]);
  if (
    d.getDate() != parts[0] ||
    d.getMonth() != parts[1] - 1 ||
    d.getFullYear() != parts[2]
  ) {
    alert("Invalid date.");
    return;
  }

  const dpdateyear = `${d.getFullYear()}-01-01`;
  const dpdatemonth = `${d.getFullYear()}-${('0' + (d.getMonth() + 1)).slice(-2)}-01`;
  const dpdatetoday = `${d.getFullYear()}-${('0' + (d.getMonth() + 1)).slice(-2)}-${('0' + d.getDate()).slice(-2)}`;
  const monthName = new Intl.DateTimeFormat('en-US', { month: 'long' }).format(d);

  let boxtitle;
  let charttitle;

  if (filterby === "MONTH") {
    boxtitle = "Monthly Recap Report - Details";
    charttitle = "Call Reasons by Status (Stacked Breakdown) – " + monthName + " " + parts[2];
  } else if (filterby === "YEAR") {
    boxtitle = "Yearly Recap Report - Details";
    charttitle = "Call Reasons by Status (Stacked Breakdown) – " + parts[2];
  }

  $("#boxtitle2").text(boxtitle);
  $("#charttitle2").text(charttitle);

  $.ajax({
    type: "POST",
    url: "home_Chart2.php",
    data: { dpdateyear, dpdatemonth, dpdatetoday, filterby },
    success: function (response) {
      if (response.error) {
        alert("Error: " + response.error);
        return;
      }

      if (!Array.isArray(response)) {
        alert('Unexpected response format.');
        return;
      }

      const labels = ["PENDING", "SUCCESSFUL", "UNSUCCESSFUL"];
      const colors = [
        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
        '#9966FF', '#FF9F40', '#8A2BE2', '#00CED1',
        '#FFD700', '#FF4500', '#7CFC00', '#DC143C',
        '#00FA9A', '#8B008B', '#1E90FF', '#FF1493',
        '#00BFFF', '#228B22', '#DAA520', '#FF6347'
      ];

      const datasets = response.map((item, index) => ({
        label: item.REASON,
        data: [item.PENDING, item.SUCCESSFUL, item.UNSUCCESSFUL],
        backgroundColor: colors[index % colors.length],
        stack: 'Stack 0',
        rawStatus: item.STATUS  // Store status here
      }));

      const ctx = document.getElementById('Chart2').getContext('2d');
      if (Chart2) Chart2.destroy();

      Chart.register(ChartDataLabels);

      Chart2 = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: datasets
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            datalabels: {
              display: ctx => ctx.dataset.data[ctx.dataIndex] > 0,
              color: '#000',
              font: { size: 9, weight: 'bold' },
              anchor: 'middle'
            }
          },
          scales: {
            x: {
              stacked: true,
              title: { display: true, text: 'Call Status' }
            },
            y: {
              stacked: true,
              beginAtZero: true,
              title: { display: true, text: 'Reason Count' },
              ticks: { precision: 0 }
            }
          }
        }
      });

      renderCustomLegend(Chart2);
    },
    error: function (xhr, status, error) {
      alert(`An error occurred: ${xhr.status} ${xhr.statusText}\nDetails: ${xhr.responseText}`);
    }
  });
}

function renderCustomLegend(chart) {
  const container = document.getElementById('legend-container');
  container.innerHTML = ''; // Clear previous legend

  // ➤ Title
  const title = document.createElement('div');
  title.textContent = 'Legend: Call Reasons by Status';
  title.className = 'legend-title';
  container.appendChild(title);

  // ➤ Columns wrapper
  const columnsWrapper = document.createElement('div');
  columnsWrapper.className = 'legend-columns';
  container.appendChild(columnsWrapper);

  // ➤ Column containers
  const leftColumn = document.createElement('div');
  const rightColumn = document.createElement('div');

  leftColumn.className = 'legend-column';
  rightColumn.className = 'legend-column';

  columnsWrapper.appendChild(leftColumn);
  columnsWrapper.appendChild(rightColumn);

  // ➤ Group datasets by status
  const legendGroups = {
    SUCCESSFUL: [],
    UNSUCCESSFUL: [],
    PENDING: []
  };

  chart.data.datasets.forEach((dataset, index) => {
    const status = dataset.rawStatus?.toUpperCase();
    if (legendGroups[status]) {
      legendGroups[status].push({
        reason: dataset.label,
        index,
        color: dataset.backgroundColor
      });
    }
  });

  const renderGroup = (column, status, items) => {
    if (!items.length) return;

    const header = document.createElement('div');
    header.textContent = status;
    header.className = 'legend-header';
    column.appendChild(header);

    items.forEach(({ reason, index, color }) => {
      const item = document.createElement('div');
      item.className = 'legend-item';
      if (!chart.isDatasetVisible(index)) {
        item.classList.add('hidden');
      }

      item.onclick = () => {
        chart.toggleDataVisibility(index);
        chart.update();
        item.classList.toggle('hidden');
      };

      const colorBox = document.createElement('span');
      colorBox.className = 'legend-box';
      colorBox.style.backgroundColor = color;

      const label = document.createElement('span');
      label.className = 'legend-label';
      label.textContent = reason;

      item.appendChild(colorBox);
      item.appendChild(label);
      column.appendChild(item);
    });
  };

  // ➤ Render into left and right columns
  renderGroup(leftColumn, 'SUCCESSFUL', legendGroups.SUCCESSFUL);
  renderGroup(rightColumn, 'UNSUCCESSFUL', legendGroups.UNSUCCESSFUL);
  renderGroup(rightColumn, 'PENDING', legendGroups.PENDING);
}



$(document).on("click","#btngo",function(){
  showData1();
  showData2();
  showChart1();
  showChart2();
});

$(document).on("change","#cbofiltersc",function(){
  $("#btngo").trigger("click");
});

let lastUpdateTime = null;

function monitorServiceForecast() {
  $.ajax({
    url: "check_service_forecast_update.php",
    method: "GET",
    dataType: "json",
    success: function(response) {
      if (response.error) {
        console.warn("❌ Server Error:", response.error);
        return;
      }

      const currentUpdateTime = response.last_update;

      if (!lastUpdateTime) {
        lastUpdateTime = currentUpdateTime;
        return;
      }

      if (currentUpdateTime !== lastUpdateTime) {
        lastUpdateTime = currentUpdateTime;

        // Refresh visualizations
        showData1();
        showData2();
        showChart1();
        showChart2();

        $("#refresh-status").text("🔄 Updated: " + new Date().toLocaleTimeString());
      }
    },
    error: function(xhr, status, error) {
      console.error("AJAX error:", error);
    }
  });
}

// // Start polling every 10s
// setInterval(monitorServiceForecast, 10000);
// monitorServiceForecast(); // Also call immediately
