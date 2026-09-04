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
  window.LaravelRoutes = {
    csrfToken: "{{ csrf_token() }}",
  }

  window.tableRoute = {
    userData: @json(route("users.data")),
    userLevelData: @json(route("users.levels.data")),
  }

  console.log(window.tableRoute.userLevelData);
</script>

<script src=" {{ asset('tmia-assets/js/laravel/user_laravel.js') }}"></script>
@endpush

</x-layouts.main>
