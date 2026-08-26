<x-layouts.main>

    <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      User Accounts Maintenance
    </h1>
    <ol class="breadcrumb">
      <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href=""><i class="fa fa-gears"></i> Settings</a></li>
      <li class="active"><i class="fa fa-user"></i> Users</li>
    </ol>
  </section>

  <!-- ========================================================================================================== -->
  <!-- Main content -->
  <section class="content">
    <div class="box box-warning">
      <div class="box-body">
        <button type="submit" class="btn btn-success" id="btnadd" name="btnadd"><i class="fa fa-plus"></i> Add User</button>
        <div class="box-header with-border">
          <h3 class="box-title">List of User Accounts</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="max-width:100%;" >
          <table id="table_user" class="table table-striped table-bordered table-hover">
            <thead>
              <tr class="tableheader">
                <th>#</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>User Level</th>
                <th>Active</th>
                <th>Enabled 2FA</th>
                <th>Password Expiration</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <!-- / box-body -->
    </div>

    <!-- MODAL MODIFY -->
    <div id="modal-modify" aria-hidden="false" aria-labelledby="modal-modify" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">User Accounts Modification</h3>
        </div>
        <div class="box-body">
          <div class="form-horizontal">
            <div class="controls">
              <input type="hidden" id="appmethod" value="N">
              <input type="hidden" id="txtid" value="0">
              <div class="row">
                <div class="col-md-6">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Last Name *</label>
                      <input type="text" id="txtlname" class="form-control input-sm" required="required" data-error="Last name is required.">
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>First Name *</label>
                      <input type="text" id="txtfname" class="form-control input-sm" required="required" data-error="First name is required.">
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Middle Name</label>
                      <input type="text" id="txtmname" class="form-control input-sm">
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Suffix Name</label>
                      <input type="text" id="txtsname" class="form-control input-sm">
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Display Name *</label>
                      <input type="text" id="txtdname" class="form-control input-sm" required="required" data-error="Display name is required.">
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Contact No.</label>
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="fa fa-phone"></i>
                        </span>
                        <input type="text" id="txtcontactno" class="form-control input-sm">
                      </div>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>E-Mail Address *</label>
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="fa fa-envelope"></i>
                        </span>
                        <input type="text" id="txtemailadd" class="form-control input-sm" required="required" data-error="Email is required.">
                      </div>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Username *</label>
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="fa fa-user"></i>
                        </span>
                        <input type="text" id="txtuname" class="form-control input-sm" required="required" data-error="Username is required.">
                      </div>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Password *</label>
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="fa fa-lock"></i>
                        </span>
                        <input type="password" id="txtpass" class="form-control input-sm" required="required" data-error="Password is required.">
                        <span class="input-group-btn">
                          <button id="btnpass" type="button" class="btn btn-success btn-eye"><i class="fa-solid fa-eye ipass"></i></button>
                        </span>
                      </div>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Repeat Password *</label>
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="fa fa-lock"></i>
                        </span>
                        <input type="password" id="txtrpass" class="form-control input-sm" required="required" data-error="Repeat password is required.">
                        <span class="input-group-btn">
                          <button id="btnrpass" type="button" class="btn btn-success btn-eye"><i class="fa-solid fa-eye irpass"></i></button>
                        </span>
                      </div>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>User Level *</label>
                      <select id="cboulevel" class="form-control input-sm" required="required" data-error="User Level is required.">
                        <option Value="">PLEASE SELECT</option>
                      </select>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>User Active? *</label>
                      <select id="cbouseractive" class="form-control" Value="YES" required="required" data-error="User active is required.">
                        <option Value="YES">YES</option>
                        <option Value="NO">NO</option>
                      </select>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-6">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Password Expiration Date</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input id="dppwdexpdate" type="text" class="form-control input-sm pull-right" autocomplete="off">
                      </div>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 cellcenter">
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="icheck-success d-inline">
                        <input type="checkbox" id="chk2fa">
                        <label for="chk2fa"> Two-Factor Authentication (2FA) </label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="pull-right view2fa" hidden>
                      <button type="button" class="btn btn-sm btn-success" id="btntotp"><i class="fa fa-key"></i> Set TOTP</button>
                      <button type="button" class="btn btn-sm btn-success" id="btnunbind" style="display: none;"><i class="fa fa-unlink"></i> Unbind TOTP</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box-footer pull-right">
          <button type="button" class="btn btn-success" id="btnsave"><i class="fa fa-save"></i> Save</button>
          <button type="button" class="btn btn-success" id ="btncancel"><i class="fa fa-remove"></i> Cancel</button>
        </div>
      </div>
    </div>
    <!-- END MODAL MODIFY -->              
    <!-- MODAL SAVING -->
    <div id="modalsaving" class="modal fade" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-success modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="modaltitle">Saving data!</h4>
          </div>
          <!--/modal-header-->
          <div class="modal-body">
            Pleasee wait while saving data....
          </div>
          <!-- Loading (remove the following to stop the loading)-->
          <div class="overlay">
            <i class="fa fa-spinner fa-spin"></i>
          </div>
          <!-- end loading -->
        </div>
        <!--/modal-content-->
      </div>
      <!-- /modal-dialog -->
    </div>
    <!-- END MODAL SAVING -->
    <!-- MODAL TIMEOUT -->
    <div id="timeout" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-warning modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <!--<button type="button" class="btn btn-outline close" data-dismiss="modal">×</button>-->
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Session About To Timeout</h4>
          </div>
          <!--/modal-header-->
          <div class="modal-body">
            <p id="countdown"></p>
            <p>
                    You will be automatically logged out in 30 seconds.<br />
                To remain logged in move your mouse over this window.
            </p>
          </div>
          <!--/modal-body-->
          <div class="modal-footer">
            <button type="button" class="btn btn-outline close" data-dismiss="modal" aria-hidden="true">Close</button>
          </div>
        </div>
        <!--/modal-content-->
      </div>
      <!-- /modal-dialog -->
    </div>
    <!-- END MODAL TIMEOUT -->
  </section>
</div>
<!-- /.content-wrapper -->

@push('scripts')
<script>  
  (function ($) {
    'use strict';

    $(function () {
        const modal = $('#modal-modify');

        modal.iziModal({
            title: 'User Account Information Maintenance',
            subtitle: 'Fill out all required user details.',
            width: 900,
            padding: 20,
            fullscreen: false,
            overlay: true,
            overlayClose: false,
            zindex: 9999
        });

        const table = $('#table_user').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            pageLength: 10,
            ajax: {
                url: '/settings/users/data',
                method: 'GET'
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                { data: 'User_ID', name: 'User_ID' },
                { data: 'Full_Name', name: 'Full_Name' },
                { data: 'User_Name', name: 'User_Name' },
                {
                    data: 'User_Level_Description',
                    name: 'User_Level_Description'
                },
                { data: 'Active', name: 'Active' },
                { data: 'Enable2FA', name: 'Enable2FA' },
                { data: 'ExpireDate', name: 'ExpireDate' },
                {
                    data: 'button',
                    name: 'button',
                    orderable: false,
                    searchable: false
                }
            ],
            columnDefs: [
                {
                    targets: [8],
                    orderable: false
                }
            ]
        });

        loadUserLevels();

        $('#btnadd').on('click', function () {
            clearForm();

            $('#appmethod').val('N');
            $('#txtid').val('0');
            $('#modal-modify').iziModal('open');
        });

        $(document).on('click', '.btnedit', function () {
            const userId = $(this).data('uid');

            clearForm();

            $.get(`/users/${userId}`, function (user) {
                $('#appmethod').val('E');
                $('#txtid').val(user.User_ID);
                $('#txtlname').val(user.Last_Name);
                $('#txtfname').val(user.First_Name);
                $('#txtmname').val(user.Middle_Name || '');
                $('#txtsname').val(user.Suffix_Name);
                $('#txtdname').val(user.Display_Name);
                $('#txtcontactno').val(user.Contact_No);
                $('#txtemailadd').val(user.Email_Address);
                $('#txtuname').val(user.User_Name);
                $('#cboulevel').val(user.User_Level_ID).trigger('change');
                $('#cbouseractive').val(user.Active).trigger('change');
                $('#chk2fa').prop('checked', user.Enable2FA === 'YES');

                if (user.ExpireDate) {
                    const date = new Date(user.ExpireDate);

                    $('#dppwdexpdate')
                        .datepicker('setDate', date);
                }

                modal.iziModal('open');
            });
        });

        $('#btnsave').on('click', function () {
            const formData = new FormData();

            formData.append('_token', csrfToken());
            formData.append('_method', 'POST');

            formData.append('uid', $('#txtid').val());
            formData.append('lname', $('#txtlname').val().trim());
            formData.append('fname', $('#txtfname').val().trim());
            formData.append('mname', $('#txtmname').val().trim());
            formData.append('sname', $('#txtsname').val().trim());
            formData.append('dname', $('#txtdname').val().trim());
            formData.append('contactno', $('#txtcontactno').val().trim());
            formData.append('email', $('#txtemailadd').val().trim());
            formData.append('uname', $('#txtuname').val().trim());
            formData.append('pword', $('#txtpass').val());
            formData.append('ulevel', $('#cboulevel').val());
            formData.append('useractive', $('#cbouseractive').val());
            formData.append('pwdexpdate', $('#dppwdexpdate').val());
            formData.append(
                'chk2fa',
                $('#chk2fa').is(':checked') ? 'YES' : 'NO'
            );

            $.ajax({
                url: '/users/store',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function () {
                    modal.iziModal('close');
                    table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    const errors = xhr.responseJSON?.errors;

                    if (errors) {
                        alert(Object.values(errors).flat().join('\n'));
                    }
                }
            });
        });

        $(document).on('click', '.btndelete', function () {
            const userId = $(this).data('uid');

            if (!window.confirm('Delete this user?')) {
                return;
            }

            $.ajax({
                url: `/users/${userId}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken()
                },
                success: function () {
                    table.ajax.reload(null, false);
                }
            });
        });

        $('#btncancel').on('click', function () {
            modal.iziModal('close');
        });

        function loadUserLevels() {
            $.get('/users/levels', function (response) {
                const select = $('#cboulevel');

                select.empty().append(
                    $('<option>', {
                        value: '',
                        text: 'PLEASE SELECT'
                    })
                );

                response.data.forEach(function (level) {
                    select.append(
                        $('<option>', {
                            value: level.User_Level_ID,
                            text: level.User_Level_Description
                        })
                    );
                });
            });
        }

        function clearForm() {
            $('#txtid').val('0');
            $('#txtlname, #txtfname, #txtmname, #txtsname').val('');
            $('#txtdname, #txtcontactno, #txtemailadd, #txtuname').val('');
            $('#txtpass, #txtrpass, #dppwdexpdate').val('');

            $('#cboulevel').val('');
            $('#cbouseractive').val('YES');
            $('#chk2fa').prop('checked', false);
        }

        function csrfToken() {
            return document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content');
        }
    });
})(jQuery);
  
</script>
@endpush

</x-layouts.main>
