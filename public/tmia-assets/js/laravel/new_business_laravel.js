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