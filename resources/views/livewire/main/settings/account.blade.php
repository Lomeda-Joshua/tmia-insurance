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
          <button class="btn btn-success pull-right" id="btnedit"><i class="fa fa-edit"></i> Click Here To Modify!</button>
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
                      <form id="frmUserProfile" action="{{ route('user_account.update', $user->User_ID) }}" method="POST">
                          @csrf
                          @method('PUT')

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
                      <div class="box-footer pull-right actionbtn" hidden>
                        <button type="button" class="btn btn-success" id="btnsave"><i class="fa fa-save"></i> Save</button>
                        <button type="button" class="btn btn-success" id ="btncancel"><i class="fa fa-remove"></i> Cancel</button>
                      </div>
                    </form>
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
$(document).ready(function () {
    // Context variable passed from Laravel auth state
    const userLevel = "{{ auth()->user()->User_Level_Description ?? '' }}";
    
    // Save state before editing for rollback on cancellation
    let originalFormData = {};

    // -------------------------------------------------------------------------
    // Event Listeners: Modify, Save, Cancel
    // -------------------------------------------------------------------------
    $(document).on("click", "#btnedit", function (e) {
        e.preventDefault();
        captureFormState();
        toggleFormState(false);
    });

    $(document).on("click", "#btncancel", function (e) {
        e.preventDefault();
        restoreFormState();
        toggleFormState(true);
    });

    // -------------------------------------------------------------------------
    // Field Auto-Formatting (Name concatenation & casing)
    // -------------------------------------------------------------------------
    $(document).on("blur", "#txtlname, #txtfname", function () {
        let lname = $("#txtlname").val().toUpperCase().trim();
        let fname = $("#txtfname").val().toUpperCase().trim();
        
        $("#txtlname").val(lname);
        $("#txtfname").val(fname);

        if (fname !== '' && lname !== '') {
            $("#txtdname").val(`${fname} ${lname}`);
        } else {
            $("#txtdname").val(fname || lname);
        }
    });

    $(document).on("blur", "#txtmname, #txtsname, #txtdname", function () {
        $(this).val($(this).val().toUpperCase().trim());
    });

    // -------------------------------------------------------------------------
    // Password Visibility Toggle
    // -------------------------------------------------------------------------
    $(document).on("click", "#btnpass, #btnrpass", function () {
        const $input = $(this).closest(".input-group").find("input");
        const $icon = $(this).find("i");

        const isPassword = $input.attr("type") === "password";
        $input.attr("type", isPassword ? "text" : "password");

        $icon.toggleClass("fa-eye fa-eye-slash");
    });

    // -------------------------------------------------------------------------
    // Form Enable / Disable Helper
    // -------------------------------------------------------------------------
    function toggleFormState(disabled) {
        // 1. Target fields explicitly
        const $editableFields = $(
            "#txtlname, #txtfname, #txtmname, #txtsname, #txtdname, " +
            "#txtcontactno, #txtemailadd, #txtuname, #txtpass, #txtrpass"
        );

        $editableFields.prop("disabled", disabled);

        // 2. Role-restricted Fields (Case-insensitive check)
        if (typeof userLevel !== "undefined" && String(userLevel).toUpperCase() === "ADMINISTRATOR") {
            $("#dppwdexpdate, #chk2fa").prop("disabled", disabled);
        }

        // 3. Action Buttons & HTML hidden attribute handling
        if (disabled) {
            $("#btnedit").show();
            $(".actionbtn").hide().prop("hidden", true);
        } else {
            $("#btnedit").hide();
            $(".actionbtn").show().removeAttr("hidden");
            $("#txtlname").focus();
        }
    }

    // -------------------------------------------------------------------------
    // State Preservation Helpers
    // -------------------------------------------------------------------------
    function captureFormState() {
        originalFormData = {
            lname: $("#txtlname").val(),
            fname: $("#txtfname").val(),
            mname: $("#txtmname").val(),
            sname: $("#txtsname").val(),
            dname: $("#txtdname").val(),
            contactno: $("#txtcontactno").val(),
            email: $("#txtemailadd").val(),
            uname: $("#txtuname").val(),
            pwdexpdate: $("#dppwdexpdate").val(),
            chk2fa: $("#chk2fa").is(":checked")
        };
    }

    function restoreFormState() {
        $("#txtlname").val(originalFormData.lname);
        $("#txtfname").val(originalFormData.fname);
        $("#txtmname").val(originalFormData.mname);
        $("#txtsname").val(originalFormData.sname);
        $("#txtdname").val(originalFormData.dname);
        $("#txtcontactno").val(originalFormData.contactno);
        $("#txtemailadd").val(originalFormData.email);
        $("#txtuname").val(originalFormData.uname);
        $("#txtpass").val("");
        $("#txtrpass").val("");
        $("#dppwdexpdate").val(originalFormData.pwdexpdate);
        $("#chk2fa").prop("checked", originalFormData.chk2fa).trigger("change");
    }
});
</script>
@endpush


</x-layouts.main>