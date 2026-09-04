<x-layouts.main>
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      User Account Settings
    </h1>
    <ol class="breadcrumb">
       <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-dashboard"></i> Home
            </a>
        </li>
        <li>
            <a href="{{ route('user_account') }}">
                <i class="fa fa-gears"></i> Settings
            </a>
        </li>
        <li class="active">
            <i class="fa fa-user"></i> Account
        </li>
    </ol>
  </section>

  <!-- ========================================================================================================== -->
  <!-- Main content -->
  <section class="content">
    <!-- box -->
    <div class="box box-warning">
      <div class="box-body">
        <div class="box-header with-border">
          <h3 class="box-title">User Accounts Information</h3>
          <!-- Edit Button Header -->
          <button type="button" class="btn btn-success pull-right" id="btnedit">
              <i class="fa fa-edit"></i> Click Here To Modify!
          </button>
        </div>
      </div>
      <div class="box-body" style="max-width:100%;">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                
                    <div class="box center">
                      <!-- /.box-header -->
                      <!-- form start -->
                      <div class="box-body">
                        <div class="form-horizontal">
                          <div class="controls">
                            <input type="hidden" id="txtid" value="{{ $user->User_ID }}">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label>Last Name *</label>
                                    <input
                                        type="text"
                                        id="txtlname"
                                        class="form-control input-sm"
                                        value="{{ $user->Last_Name }}"
                                        required
                                        data-error="Last name is required."
                                        disabled
                                    >
                                    <div class="help-block with-errors"></div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label>First Name *</label>
                                    <input
                                        type="text"
                                        id="txtfname"
                                        class="form-control input-sm"
                                        value="{{ $user->First_Name }}"
                                        required
                                        data-error="First name is required."
                                        disabled
                                    >
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
                                    <input
                                        type="text"
                                        id="txtmname"
                                        class="form-control input-sm"
                                        value="{{ $user->Middle_Name }}"
                                        disabled
                                    >
                                    <div class="help-block with-errors"></div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label>Suffix Name</label>
                                    <input
                                        type="text"
                                        id="txtsname"
                                        class="form-control input-sm"
                                        value="{{ $user->Suffix_Name }}"
                                        disabled
                                    >
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
                                    <input
                                        type="text"
                                        id="txtdname"
                                        class="form-control input-sm"
                                        value="{{ $user->Display_Name }}"
                                        required
                                        data-error="Display name is required."
                                        disabled
                                    >
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
                                      <input
                                            type="text"
                                            id="txtcontactno"
                                            class="form-control input-sm"
                                            value="{{ $user->Contact_No }}"
                                            disabled
                                        >
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
                                      <input
                                            type="email"
                                            id="txtemailadd"
                                            class="form-control input-sm"
                                            value="{{ $user->Email_Address }}"
                                            required
                                            data-error="Email is required."
                                            disabled
                                        >
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
                                      <input
                                            type="text"
                                            id="txtuname"
                                            class="form-control input-sm"
                                            value="{{ $user->User_Name }}"
                                            required
                                            data-error="Username is required."
                                            disabled
                                        >
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
                                      <input type="password" id="txtpass" class="form-control input-sm" data-error="Password is required." disabled>
                                      <span class="input-group-btn">
                                        <button id="btnpass" type="button" class="btn btn-success btn-eye"><i class="fa-solid fa-eye ipass"></i></i></button>
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
                                      <input type="password" id="txtrpass" class="form-control input-sm" required="required" data-error="Repeat password is required." disabled>
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
                                    <label>User Level</label>
                                    <input type="text" id="txtulevel" class="form-control input-sm"  value="{{ $userLevel?->User_Level_Description ?? 'N/A' }}" disabled>
                                    <div class="help-block with-errors"></div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label>User Active?</label>
                                    <input type="text" id="txtuseractive" class="form-control input-sm"   value="{{ $user->Active ? 'Yes' : 'No' }}" disabled>
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
                                      <input id="dppwdexpdate" type="text" class="form-control input-sm pull-right" value="{{ $user->ExpireDate ? \Carbon\Carbon::parse($user->ExpireDate)->format('d/m/Y') : '' }}" autocomplete="off" disabled>
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
                                      <input type="checkbox" id="chk2fa" {{ $user->Enable2FA ? 'checked' : '' }} disabled>
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
                      <!-- /.box-body -->
                        <!-- Action Buttons Footer -->
                        <div class="box-footer pull-right actionbtn" hidden>
                            <button type="button" class="btn btn-success" id="btnsave"><i class="fa fa-save"></i> Save</button>
                            <button type="button" class="btn btn-success" id="btncancel"><i class="fa fa-remove"></i> Cancel</button>
                        </div>
                    </div>
                
                <!-- /.box -->
            </div>
          </div>
        </div>
      </div>
      <!-- / box-body -->
    </div>
    <!-- /box -->
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
  window.dataRoutes = {
    userAccountSession : @json(route('getSession.variables')),
    userAccountData : @json(route('get_user_profile_data')),
    checkUserName: @json(route('user.check_username')),
    userAccountUpdate: @json(route('user_account.update')),
  }
</script>

<script src ="{{ asset('tmia-assets/js/laravel/account_laravel.js') }}"></script>
@endpush


</x-layouts.main>