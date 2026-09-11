<x-layouts.main>

    <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Vehicle List
    </h1>
    <ol class="breadcrumb">
      <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href=""><i class="fa fa-tasks"></i> Transactions</a></li>
      <li class="active"><i class="fa fa-list-alt"></i> Vehicle List</li>
    </ol>
  </section>

  <!-- ========================================================================================================== -->
  <!-- Main content -->
  <section class="content">
    <!-- box -->
    <div class="box box-warning">
      <div class="box-body">
        <div class="box-body" style="max-width:100%;">

          @if(Auth::user()->User_Level_ID = 1 || Auth::user()->User_Level_ID = 6)
            <div class="row btnactionud">
              <div class="col-md-12">
                <button type="submit" class="btn btn-success" id="btnadd" style="display: block;"><i class="fa fa-plus"></i> Add Data</button>
                <button type="submit" class="btn btn-success pull-right" id="btnupload" style="display: none;"><i class="fa fa-upload"></i> Import Excel File</button>
              </div>
            </div>
          @endif
          
          <div class="box center">
            <div class="box-body">
              <div class="row">
                <div class="col-md-12 cellcenter">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="txtsearch">Search </label>
                      <div class="input-group input-group-sm">
                        <input type="text" id="txtsearch" class="form-control input-sm clearable" placeholder="Press <Enter> key or click icon search button to search." autocomplete="off">
                        <span class="input-group-btn">
                          <button type="button" id="btnfind" class="btn btn-success btn-flat"><i class="fa fa-search"></i></button>
                        </span>
                      </div>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="dpdatefrom">Date From</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input id="dpdatefrom" type="text" class="form-control input-sm pull-right">
                      </div>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="dpdateto">Date To</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input id="dpdateto" type="text" class="form-control input-sm pull-right">
                      </div>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-2" hidden>
                    <div class="form-group">
                      <input type="checkbox" id="chkall"/>
                      <label for="chkall">All Data</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <br>
          <table id="table_trans" class="table table-striped table-bordered table-hover">
            <thead>
              <tr class="tableheader">
                <th>No.</th>
                <th>VIN</th>
                <th>Model</th>
                <th>Model Year</th>
                <th>Variant</th>
                <th>Color</th>
                <th>Engine No.</th>
                <th>CS No.</th>
                <th>Plate No.</th>
                <th>VSI Date</th>
                <th>SRP</th>
                <th>Customer No.</th>
                <th>Customer Name</th>
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
    <!-- /box -->
    <!-- MODAL MODIFY -->
    <div id="modal-modify" aria-hidden="false" aria-labelledby="modal-modify" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box box-solid">
        <div class="box-body" style="max-width:100%;">
          <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div id="viewaction" class="row" hidden>
              <div class="col-md-12 cellborder">
                <label><u>Modify Button</u></label>
                <div class="col-md-12">
                  <button type="button" id="btnedit" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Edit</button>
                  <button type="button" id="btndelete" data-toggle="tooltip" data-placement="top" title="Delete" style="display:none;" class="btn btn-success btn-sm"><i class="fa fa-remove"></i> Delete</button>
                  <button type="button" id="btnprint" data-toggle="tooltip" data-placement="top" title="Print" style="display:none;" class="btn btn-success btn-sm"><i class="fa fa-print"></i> Print</button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txtvin">VIN *</label>
                  <input type="text" id="txtvin" class="form-control input-sm" required="required" data-error="VIN is required." disabled>
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txtmake">Make *</label>
                  <input type="text" id="txtmake" class="form-control input-sm" required="required" data-error="Make is required.">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txtmodel">Model *</label>
                  <input type="text" id="txtmodel" class="form-control input-sm" required="required" data-error="Model is required.">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txtmodelyear">Mode Year *</label>
                  <input type="text" id="txtmodelyear" class="form-control input-sm" required="required" data-error="Model Year is required.">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txtcolor">Color *</label>
                  <input type="text" id="txtcolor" class="form-control input-sm" required="required" data-error="Color is required.">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txtengineno">Engine No. *</label>
                  <input type="text" id="txtengineno" class="form-control input-sm" required="required" data-error="Engine No. is required.">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txtcsno">CS No. *</label>
                  <input type="text" id="txtcsno" class="form-control input-sm" required="required" data-error="CS No. is required.">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txtplateno">Plate No. *</label>
                  <input type="text" id="txtplateno" class="form-control input-sm" required="required" data-error="Plate No. is required.">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
            </div>
            <!-- <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txtorderno">Order No. *</label>
                  <input type="text" id="txtorderno" class="form-control input-sm" required="required" data-error="Order No. is required.">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txtorderstatus">Order Status *</label>
                  <input type="text" id="txtorderstatus" class="form-control input-sm" required="required" data-error="Order Status is required.">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
            </div> -->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txtsrp">Paid Price *</label>
                  <input type="text" id="txtsrp" class="form-control input-sm" required="required" data-error="Paid Price is required.">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="dpvsidate">VSI Date *</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input id="dpvsidate" type="text" class="form-control input-sm pull-right"  required="required" data-error="VSI Date is required.">
                  </div>
                  <div class="help-block with-errors"></div>
                </div>
              </div>
            </div>
            <div class="row">
              <!-- <div class="col-md-6">
                <div class="form-group">
                  <label for="txtmsalecode">Model Sales Code *</label>
                  <input type="text" id="txtmsalecode" class="form-control input-sm" required="required" data-error="Model Sales Code is required.">
                  <div class="help-block with-errors"></div>
                </div>
              </div> -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="dpreldate">Released Date *</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input id="dpreldate" type="text" class="form-control input-sm pull-right" required="required" data-error="Released Date is required." disabled>
                  </div>
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="dptechdate">Technical Date (Optional)</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input id="dptechdate" type="text" class="form-control input-sm pull-right" disabled>
                  </div>
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txtvariant">Variant *</label>
                  <textarea id="txtvariant" class="form-control input-sm" rows="2" required="required" data-error="Variant is required."></textarea>
                  <div class="help-block with-errors"></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="cbobodytype">Body Type *</label>
                  <select id="cbobodytype" class="form-control input-sm" required="required" data-error="Body Type is required.">
                    <option Value="">PLEASE SELECT</option>
                  </select>
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txttransmission">Power Transmission *</label>
                  <input type="text" id="txttransmission" class="form-control input-sm" required="required" data-error="Power Transmission is required.">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="cbofueltype">Fuel Type *</label>
                  <select id="cbofueltype" class="form-control input-sm" required="required" data-error="Fuel Type is required.">
                    <option Value="">PLEASE SELECT</option>
                  </select>
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txtseats">Seats *</label>
                  <input type="text" id="txtseats" class="form-control input-sm" required="required" data-error="Seats is required.">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
            </div>
            <!-- <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txtunloadweight">Unloaded Weight *</label>
                  <input type="text" id="txtunloadweight" class="form-control input-sm" required="required" data-error="Unloaded Weight is required.">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txtmaxweight">Maximum Weight *</label>
                  <input type="text" id="txtmaxweight" class="form-control input-sm" required="required" data-error="Maximum Weight is required."></input>
                  <div class="help-block with-errors"></div>
                </div>
              </div>
            </div> -->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="cboprodclass">Product Classification *</label>
                  <select id="cboprodclass" class="form-control input-sm" required="required" data-error="Product Classification is required.">
                    <option Value="">PLEASE SELECT</option>
                  </select>
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="cboowntype">Owner Type *</label>
                  <select id="cboowntype" class="form-control input-sm" required="required" data-error="Owner Type is required.">
                    <option Value="">PLEASE SELECT</option>
                  </select>
                  <div class="help-block with-errors"></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txtvoname">Vehicle Owner Name *</label>
                  <input type="text" id="txtvoname" class="form-control input-sm" required="required" data-error="Vehicle Owner Name is required.">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txtmpname">Marketing Professional *</label>
                  <input type="text" id="txtmpname" class="form-control input-sm" required="required" data-error="Marketing Professional is required.">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12" hidden>
                <div class="form-group">
                  <label for="txtremarks">Remarks</label>
                  <textarea id="txtremarks" class="form-control input-sm" placeholder="Remarks here!" rows="2" disabled></textarea>
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-12" id="viewaction1" hidden>
                <div class="col-md-6">
                  <!-- Nothing here -->
                </div>
                <div class="col-md-6 cellborder" style="margin-top: 10px;">
                  <label><u>Save & Cancel Buttons</u></label>
                  <div class="col-md-12">
                    <button type="button" id="btnsave" data-toggle="tooltip" data-placement="top" title="Save" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
                    <button type="button" id="btncancel" data-toggle="tooltip" data-placement="top" title="Cancel" class="btn btn-success btn-sm" style="display:none;"><i class="fa fa-ban"></i> Cancel</button>
                    <button type="button" id="btnclose" data-toggle="tooltip" data-placement="top" title="Close" class="btn btn-success btn-sm" style="display:none;"><i class="fa fa-close"></i> Close</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END MODAL MODIFY -->
    <!-- MODAL CUSTOMER LIST -->
    <div id="modal-customerlist" aria-hidden="false" aria-labelledby="modal-upload" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box">
        <div class="box-header with-border">
          <!-- <h2 class="box-title">Customer List</h2> -->
          <div class="row">
            <div class="col-md-6" style="padding: 0; margin-bottom: 5px;">
              <div class="form-group">
                <label>Search </label>
                <div class="input-group input-group-sm">
                  <input type="text" id="txtcustomersearch" class="form-control input-sm clearable-s" placeholder="Press <Enter> key or click icon search button to search." autocomplete="off">
                  <span class="input-group-btn">
                    <button type="button" id="btnfindcust" class="btn btn-success btn-flat"><i class="fa fa-search"></i></button>
                  </span>
                </div>
                <div class="help-block with-errors"></div>
              </div>
            </div>
          </div>  
          <div class="alphabet-buttons" id="alphabet-container"></div>  
        </div>
        <div class="box-body">
          <table id="table_customerlist" class="table table-striped table-bordered table-hover nowrap" style="width:100%">
            <thead>
              <tr class="tableheader">
                <th>No.</th>
                <th>Customer No.</th>
                <th>Group</th>
                <th>Customer Name</th>
                <th>Birth Date</th>
                <th>Contact No.</th>
                <th>Email Add</th>
                <th>Address</th>
                <th>Status</th>
                <th>Inactive Date</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="box-footer with-border">
          <div class="pull-right">
            <button type="button" id="btncustselect" class="btn btn-success"><i class="fa-solid fa-clipboard-check"></i> Assigned Now!</button>
          </div>
        </div>  
      </div>
    </div>
    <!-- END MODAL CUSTOMER LIST -->
    <!-- MODAL UPLOAD -->
    <div id="modal-upload" aria-hidden="false" aria-labelledby="modal-upload" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Uploading Excel File Data</h3>
        </div>
        <div class="box-body">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-10">
                  <div class="form-group">
                    <label for="filexls">Choose Excel File</label>
                    <input type="file" name="filexls" id="filexls" accept=".xls,.xlsx" class="form-control input-sm" required="required" data-error="File excel is required.">
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
                <div class="col-md-2 pull-right cellcenter">
                  <button type="button" class="btn btn-success" id="btnimport"><i class="fa fa-upload"></i> Import File</button>
                </div>
              </div>
            </div>
            <hr>
            <h4 class="box-title">Data uploaded from excel file results.</h4>
            <p style="font-size:12px;font-style: italic;">
              <b>Note:</b>
              Records marked as <b>GOOD</b> have been successfully imported into the system.
              Records with the status <b>UPDATED</b> indicate that existing entries were modified because the provided release date is more recent than the one currently stored.
              Entries labeled as <b>DUPLICATE</b> already exist in the system with the same or a more recent release date; therefore, no changes were applied.
              Records marked as <b>FAILED</b> could not be uploaded due to an error during processing.
            </p>
            <div class="row">
              <div class="col-md-12">
                <label style="font-weight:bold">LEGEND&emsp;</label>
                <span class="label" style="background-color:green;" id="cntgood">GOOD : 0 Record(s)</span>
                <span class="label" style="background-color:orange;" id="cntduplicate">DUPLICATE : 0 Record(s)</span>
                <span class="label" style="background-color:red;" id="cntfailed">FAILED : 0 Record(s)</span>
                <span class="label" style="color:black;" id="cnttotal">TOTAL : 0 Record(s)</span>
              </div>
            </div>
            <br>
            <table id="table_upload" class="table table-striped table-bordered table-hover nowrap" style="width:100%">
              <thead>
                <tr class="tableheader">
                  <th>#</th>
                  <th>Order No.</th>
                  <th>Doc Date</th>
                  <th>Job Type</th>
                  <th>Job Description</th>
                  <th>Order Type</th>
                  <th>SA No.</th>
                  <th>SA Name</th>
                  <th>KM Reading</th>
                  <th>Vehicle Model</th>
                  <th>VIN</th>
                  <th>CS No.</th>
                  <th>Plate No.</th>
                  <th>Vehicle Model Description</th>
                  <th>Customer No.</th>
                  <th>Customer First Name</th>
                  <th>Customer Middle Name</th>
                  <th>Customer Last Name</th>
                  <th>Customer Suffix Name</th>
                  <th>Import Status</th>
                  <th>Status</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- END MODAL UPLOAD -->
    <!-- MODAL SAVING -->
    <div id="modalsaving" class="modal fade" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-success modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Saving data!</h4>
          </div>
          <!--/modal-header-->
          <div class="modal-body">
            <div class="loader"></div>
            <hr>
            Pleasee wait while saving data...
          </div>
        </div>
        <!--/modal-content-->
      </div>
      <!-- /modal-dialog -->
    </div>
    <!-- END MODAL SAVING -->
    <!-- MODAL UPLOADING -->
    <div id="modaluploading" aria-hidden="false" aria-labelledby="modal-upload" role="dialog" class="iziModal isAttached hasScroll">
      <h4 class="modal-title" style="text-align:center;">Importing data!</h4>

      <div class="loader-container">
        <div class="loader"></div> <!-- Only the circle spins -->
        <div class="loader-text">
          <span id="uploadPercentage">0%</span> <!-- This stays still -->
        </div>
      </div>

      <hr>
      <p style="text-align:center;">Please wait while importing data...</p>
    </div>
    <!-- END MODAL UPLOADING -->
    <!-- MODAL TIME OUT -->
    <div id="timeout" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-warning modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <!--<button type="button" class="btn btn-outline close" data-dismiss="modal">×</button>-->
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
              <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!--/modal-content-->
        </div>
        <!-- /modal-dialog -->
    </div>
    <!-- END MODAL TIME OUT -->
  </section>
</div>
<!-- /.content-wrapper -->

@push('scripts')
  <script>
    window.userAccount = {
        ulevel: @json("{{ Auth::user()?->User_Level_ID }}")
    };

    window.LaravelRoutes = {
        csrfToken: "{{ csrf_token() }}",
        saveAssignedVehicle: @json(route('vehicle.assign-customer'))
    }

    window.tableRoutes = {
        customerData: @json(route('customers.data')),
    }

    window.getData = {
        vehicleSpecific: @json(route('vehicle.search')),
    }

    window.tableRoute = {
        vehicleData : @json(route('vehicletable.data'))
    }

    window.formRoutes = {
        insuranceStaffData: @json(route('insurance_staff.data')),
        customerTypeData: @json(route('customers_type.data')),

        // Location
        regionData: @json(route('region.data')),
        provinceData: @json(route('province.data')),
        cityMunicipalData: @json(route('citymunicipal.data')),
        barangayData: @json(route('barangay.data')),

        // vehicle info
        bodyTypeData: @json(route('bodytype.data')),
        fuelTypeData: @json(route('fueltype.data')),
        productClassData: @json(route('productclass.data')),

        // Payment type
        paymentTypeData: @json(route('payments.data')),
        ewalletTypeData: @json(route('ewalletype.data')),

        // Insurances
        insuranceTypeData: @json(route('insurancetype.data')),
        insuranceCoData: @json(route('insuranceco.data')),

        // Bank
        bankData: @json(route('banks.data')),

        // Transaction status
        transactionStatusData: @json(route('transactionstatus.data')),

        // Communication type
        communicationTypeData: @json(route('communicationtype.data')),

        // Call status
        callStatusData: @json(route('callstatus.data')),
    }
  
  </script>

  <script src="{{ asset('tmia-assets/js/laravel/vehicle_laravel.js') }}"></script>

    {{-- <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });

            // DataTables Initialization
            let table = $('#table_trans').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('vehicle.datatable') }}",
                    type: "POST",
                    data: function(d) {
                        d.searchval = $('#txtsearch').val();
                        d.datefrom  = $('#dpdatefrom').val();
                        d.dateto    = $('#dpdateto').val();
                        d.chkall    = $('#chkall').is(':checked') ? 1 : 0;
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'VIN', name: 'VIN' },
                    { data: 'Model', name: 'Model' },
                    { data: 'Year_Model', name: 'Year_Model' },
                    { data: 'Variant', name: 'Variant' },
                    { data: 'Color', name: 'Color' },
                    { data: 'Engine_No', name: 'Engine_No' },
                    { data: 'CS_No', name: 'CS_No' },
                    { data: 'Plate_No', name: 'Plate_No' },
                    { data: 'VSI_Date', name: 'VSI_Date' },
                    { data: 'SRP', name: 'SRP' },
                    { data: 'Customer_No', name: 'Customer_No' },
                    { data: 'Customer_Name', name: 'Customer_Name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            // Trigger grid search
            $('#btnfind').on('click', function() {
                table.draw();
            });

            $('#txtsearch').on('keyup', function(e) {
                if (e.key === 'Enter') {
                    table.draw();
                }
            });

            // Fetch and Populate Vehicle Details into Modal
            $(document).on('click', '.btnview', function() {
                let vin = $(this).data('vin');
                let url = "{{ route('vehicle.show', ':vin') }}".replace(':vin', vin);

                $.get(url, function(data) {
                    $('#txtvin').val(data.VIN);
                    $('#txtmake').val(data.Make);
                    $('#txtmodel').val(data.Model);
                    $('#txtmodelyear').val(data.Year_Model);
                    $('#txtcolor').val(data.Color);
                    $('#txtengineno').val(data.Engine_No);
                    $('#txtcsno').val(data.CS_No);
                    $('#txtplateno').val(data.Plate_No);
                    $('#txtsrp').val(data.SRP);
                    $('#dpvsidate').val(data.VSI_Date);
                    $('#txtvariant').val(data.Variant);
                    $('#cbobodytype').val(data.Body_Type);
                    $('#txttransmission').val(data.Power_Transmission);
                    $('#cbofueltype').val(data.Fuel_Type);
                    $('#txtseats').val(data.Seats);
                    $('#cboprodclass').val(data.Product_Classification);
                    $('#cboowntype').val(data.Owner_Type);
                    $('#txtvoname').val(data.Vehicle_Owner_Name);
                    $('#txtmpname').val(data.Marketing_Professional);

                    $('#modal-modify').iziModal('open');
                });
            });

            // Save/Update Action
            $('#btnsave').on('click', function() {
                $('#modalsaving').modal('show');

                let payload = {
                    vin: $('#txtvin').val(),
                    make: $('#txtmake').val(),
                    model: $('#txtmodel').val(),
                    model_year: $('#txtmodelyear').val(),
                    color: $('#txtcolor').val(),
                    engine_no: $('#txtengineno').val(),
                    cs_no: $('#txtcsno').val(),
                    plate_no: $('#txtplateno').val(),
                    srp: $('#txtsrp').val(),
                    vsi_date: $('#dpvsidate').val(),
                    variant: $('#txtvariant').val(),
                    body_type: $('#cbobodytype').val(),
                    transmission: $('#txttransmission').val(),
                    fuel_type: $('#cbofueltype').val(),
                    seats: $('#txtseats').val(),
                    prod_class: $('#cboprodclass').val(),
                    owner_type: $('#cboowntype').val(),
                    vehicle_owner: $('#txtvoname').val(),
                    marketing_prof: $('#txtmpname').val()
                };

                $.ajax({
                    url: "{{ route('vehicle.save') }}",
                    type: "POST",
                    data: payload,
                    success: function(response) {
                        $('#modalsaving').modal('hide');
                        $('#modal-modify').iziModal('close');
                        table.draw();
                    },
                    error: function(xhr) {
                        $('#modalsaving').modal('hide');
                        alert('An error occurred while saving the record.');
                    }
                });
            });
        });
    </script> --}}
@endpush

</x-layouts.main>