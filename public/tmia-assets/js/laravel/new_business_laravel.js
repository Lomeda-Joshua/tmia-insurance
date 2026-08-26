(function ($) {
    'use strict';

    $(function () {
        const addModal = $('#modal-add');
        const staffModal = $('#modal-modify-ise');
        const customerModal = $('#modal-customerlist');
        const vehicleModal = $('#modal-vehiclelist');
        const paymentModal = $('#modal-modify-pay');
        const statusModal = $('#modal-modify-status');
        const netRemModal = $('#modal-modify-netrem');
        const callModal = $('#modal-call');
        const logsModal = $('#modal-logs');

        if (!$.fn.iziModal) {
            console.error('iziModal is not loaded.');
            return;
        }

        initializeModals();

        function initializeModals() {
            addModal.iziModal({
                title: 'Create New Business Insurance',
                subtitle: 'Fill out all details required here.',
                width: 1000,
                padding: 20,
                fullscreen: false,
                overlay: true,
                overlayClose: false
            });


            staffModal.iziModal({
                title: 'Select Insurance Staff',
                subtitle: 'Select insurance staff assigned to new insurance.',
                width: 450,
                padding: 20,
                fullscreen: true,
                overlay: true,
                overlayClose: false
            });

            customerModal.iziModal({
                title: 'Customer List',
                subtitle: 'List of customers.',
                width: 1400,
                padding: 20,
                fullscreen: false,
                overlay: true,
                overlayClose: false
            });

            // * * * To follow implmentation * * */
            // vehicleModal.iziModal({
            //     title: 'Customer Vehicle List',
            //     subtitle: 'List of vehicles owned by the customer.',
            //     width: 1400,
            //     padding: 0,
            //     fullscreen: false,
            //     overlay: true,
            //     overlayClose: false,
            //     zindex: 10002
            // });

            // paymentModal.iziModal({
            //     title: 'Payment Information Details',
            //     subtitle: 'Fill out all payment details here.',
            //     width: 1400,
            //     padding: 0,
            //     fullscreen: false,
            //     overlay: true,
            //     overlayClose: false,
            //     zindex: 10003
            // });

            // statusModal.iziModal({
            //     title: 'Modify Transaction Status',
            //     subtitle: 'Update the transaction status.',
            //     width: 500,
            //     padding: 20,
            //     fullscreen: false,
            //     overlay: true,
            //     overlayClose: false,
            //     zindex: 10003
            // });

            // netRemModal.iziModal({
            //     title: 'Modify GP / Net Rem',
            //     subtitle: 'Update gross premium and net remittance.',
            //     width: 350,
            //     padding: 20,
            //     fullscreen: false,
            //     overlay: true,
            //     overlayClose: false,
            //     zindex: 10003
            // });

            // callModal.iziModal({
            //     title: 'Call Status Modification',
            //     subtitle: 'Update call status information.',
            //     width: 900,
            //     padding: 20,
            //     fullscreen: false,
            //     overlay: true,
            //     overlayClose: false,
            //     zindex: 10003
            // });

            // logsModal.iziModal({
            //     title: 'Call Logs History',
            //     subtitle: 'View call history.',
            //     width: 1400,
            //     padding: 0,
            //     fullscreen: false,
            //     overlay: true,
            //     overlayClose: false,
            //     zindex: 10003
            // });
        }

      
        $('#btnadd').on('click', function () {
            window.newdata = true;
            window.editinfo = true;

            resetNewBusinessForm();
            setNewBusinessFormDisabled(false);

            const userLevel = $('#btnadd').data('user-level');
            const userId = $('#btnadd').data('user-id');

            if (userLevel === 'INSURANCE STAFF') {
                $('#cboise')
                    .val(userId)
                    .trigger('change');

                addModal.iziModal('open');
                return;
            }

            staffModal.iziModal('open');
        });

        addModal.on('opened', function () {
            $('#modal-add .iziModal-content').scrollTop(0);

            loadCustomerData();

            customerModal.iziModal('open');
        });

        $('#btnselectise').on('click', function () {
            const insuranceStaff = $('#cboise').val();

            if (!insuranceStaff) {
                $('#cboise').focus();

                window.alert('Please select Insurance Staff.');
                return;
            }

            staffModal.iziModal('close');
            addModal.iziModal('open');
        });

        $('#btncancelise').on('click', function () {
            staffModal.iziModal('close');
        });

        addModal.on('closed', function () {
            window.newdata = false;
            window.editinfo = false;

            resetNewBusinessForm();
            setNewBusinessFormDisabled(true);
        });

        function resetNewBusinessForm() {
            const form = document.querySelector('#multiStepForm');

            if (form) {
                form.reset();
            }

            $('#cbocountry')
                .val('PHILIPPINES')
                .trigger('change');

            $('#txtgrosspremium, #txtnetremittance, #txtcommission')
                .val('0.00');

            $('#txtterms').val('1');
            $('#txtmonthpay').val('0.00');

            $('input[name="rdoptiontype"][value="FREE"]')
                .prop('checked', true)
                .trigger('change');

            $('#chkpayment')
                .prop('checked', false)
                .trigger('change');

            showStep(1);
        }

        function setNewBusinessFormDisabled(disabled) {
            $('#modal-add')
                .find('input, select, textarea, button')
                .not('#btnsubmit, #prevBtn, #nextBtn')
                .prop('disabled', disabled);
        }

        function showStep(step) {
            $('.step').removeClass('active');
            $(`.step[data-step="${step}"]`).addClass('active');

            $('.page').removeClass('active');
            $(`#page${step}`).addClass('active');

            const totalSteps = $('.step').length;
            const progress = ((step - 1) / (totalSteps - 1)) * 100;

            $('#progressBar').css('width', `${progress}%`);
        }

        let currentStep = 1;

        $(document).on('click', '.step', function () {
            currentStep = Number($(this).data('step'));
            showStep(currentStep);
        });

        $(document).on('click', '#nextBtn', function () {
            if (currentStep < 5) {
                currentStep++;
                showStep(currentStep);
            }
        });

        $(document).on('click', '#prevBtn', function () {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });

        function loadCustomerData() {
            if ($.fn.DataTable.isDataTable('#table_customerlist')) {
                $('#table_customerlist').DataTable().clear().destroy();
            }

            $('#table_customerlist').DataTable({
                processing: true,
                serverSide: false,
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                scrollX: true,
                ajax: {
                    url: '/new-business/customers',
                    method: 'GET',
                    data: function (data) {
                        data.searchval = $('#txtcustomersearch').val().trim();
                    }
                },
                columns: [
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { data: 'Customer_No', defaultContent: '' },
                    { data: 'Group', defaultContent: '' },
                    { data: 'Full_Name', defaultContent: '' },
                    { data: 'Birth_Date', defaultContent: '' },
                    { data: 'Contact_No', defaultContent: '' },
                    { data: 'Email_Address', defaultContent: '' },
                    { data: 'Address', defaultContent: '' },
                    { data: 'Upload_Cust_No', defaultContent: '' },
                    { data: 'VIN', defaultContent: '' },
                    { data: 'CS_No', defaultContent: '' },
                    { data: 'Plate_No', defaultContent: '' },
                    { data: 'Variant', defaultContent: '' }
                ]
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

        if ($.fn.dataTable.isDataTable('#table_trans')) {
            $('#table_trans').DataTable().clear().destroy();               
        }

        table = $('#table_trans').DataTable({
            language: {
            processing: "Loading Transaction List..."
            },
            processing: true,
            serverSide: false,
            pageLength: 10,
            responsive: true,
            autoWidth: false,
            ajax: {
            url: "new_business_data.php",
            type: "POST",
            data: value
            },
            columns: [
            { data: "urutan" },
            { data: "Insurance_No" },
            { data: "Trans_Date" },
            { data: "Trans_Status" },
            { data: "Customer_No" },
            { data: "Full_Name" },
            { data: "Contact_No" },
            { data: "VIN" },
            { data: "CS_No" },
            { data: "Plate_No" },
            { data: "Model" },
            { data: "Variant" },
            { data: "Insurance_Company" },
            { data: "ISE_Name" },
            { data: "MP_Name" },
            { data: "button" }
            ],
            columnDefs: [
            {
                targets: [5, 11, 12, 13, 14],
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
        
        viewpending = false;
        viewexpiring = false;
        }
        //======================================//


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


    });

    document.addEventListener('DOMContentLoaded', function () {
        const table = $('#table_trans').DataTable({
                processing: true,
                serverSide: true,
                deferLoading: 0,
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                order: [[2, 'desc']],
                ajax: {
                    url: @json(route('new_business.data')),
                    data: function (data) {
                        data.viewpending = window.viewpending === true;
                        data.viewexpiring = window.viewexpiring ?? true;
                        data.searchval = $('#txtsearch').val().trim();
                        data.datefrom = $('#dpdatefrom').val();
                        data.dateto = $('#dpdateto').val();
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
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
                    {
                        data: 'button',
                        name: 'button',
                        searchable: false,
                        orderable: false
                    }
                ]
        })
    });

    $('#btnfind').on('click', function () {
        window.viewpending = false;
        window.viewexpiring = false;
        table.ajax.reload();
    });

    $('#btnrefresh').on('click', function () {
        $('#txtsearch').val('');
        table.ajax.reload();
    });

    $('#viewpending').on('click', function () {
        window.viewpending = true;
        window.viewexpiring = false;
        table.ajax.reload();
    });

    $('#viewexpiring').on('click', function () {
        window.viewpending = false;
        window.viewexpiring = true;
        table.ajax.reload();
    });

    $('#dpdatefrom, #dpdateto').on('change', function () {
        table.ajax.reload();
    });

    $('#txtsearch').on('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();

            window.viewpending = false;
            window.viewexpiring = false;

            table.ajax.reload();
        }
    });

});



// Seting up date to and from on New Business page date range picker
const dateTo = new Date();
const dateFrom = new Date();
dateFrom.setDate(dateFrom.getDate() - 30);

$('#dpdatefrom, #dpdateto').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy',
    todayHighlight: true
});

$('#dpdatefrom').datepicker('setDate', dateFrom);
$('#dpdateto').datepicker('setDate', dateTo);



  // Function to hide empty <td> elements in mobile view
  function hideEmptyCellsOnMobile() {
    // Check if the screen width is less than or equal to 600px (mobile view)
    if (window.innerWidth <= 600) {
      // Get all td elements in the table
      const cells = document.querySelectorAll('.insurance-calc .calculation-section td');

      // Loop through each td
      cells.forEach(cell => {
        // Check if the cell has no visible text or no child elements
        if (!cell.textContent.trim() && !cell.querySelector('*')) {
          // Hide the td element if it's empty
          cell.style.display = 'none';
        } else {
          // Ensure it's visible if it contains something
          cell.style.display = '';
        }
      });
    }
  }

  // Run on page load
  window.onload = hideEmptyCellsOnMobile;

  // Run again on window resize to adjust the behavior when resizing the screen
  window.onresize = hideEmptyCellsOnMobile;


  fetch(@json(route('new_business.counts')))
      .then(response => response.json())
      .then(data => {
          $('#pending-counts').text(
              Number(data.Pending_Counts).toLocaleString()
          );

          $('#expiring-counts').text(
              Number(data.Expiring_Counts).toLocaleString()
          );
      })
      .catch(error => {
          console.error('Unable to load policy counts:', error);
      });

})(jQuery);

function loadInsuranceStaff() {
    $.ajax({
        url: '/new-business/insurance-staff',
        method: 'GET',
        dataType: 'json',
        success: function (staff) {
            const select = $('#cboise');

            select.empty().append(
                $('<option>', {
                    value: '',
                    text: 'PLEASE SELECT'
                })
            );

            staff.forEach(function (member) {
                select.append(
                    $('<option>', {
                        value: member.ISE_No,
                        text: member.ISE_Name
                    })
                );
            });
        },
        error: function (xhr) {
            console.error('Unable to load insurance staff:', xhr.responseText);
        }
    });
}

$(function () {
    loadInsuranceStaff();
});