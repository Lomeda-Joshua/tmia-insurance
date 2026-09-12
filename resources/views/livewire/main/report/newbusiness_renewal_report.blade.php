<x-layouts.main>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      New Business / Renewal Business Report
    </h1>
    <ol class="breadcrumb">
      <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href=""><i class="fa fa-book"></i> Reports</a></li>
      <li class="active"><i class="fa fa-file-text"></i> New Business / Renewal Business Report</li>
    </ol>
  </section>

  <!-- ========================================================================================================== -->
  <!-- Main content -->
  <section class="content">
    <!-- box -->
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Selection Criteria</h3>
      </div>
      <div class="box-body" style="max-width:100%;">
        <div class="row">
          <div class="col-md-12">
              <!-- general form elements -->
              <div class="box center">
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body ">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="cbocategory">Category *</label>
                        <select id="cbocategory" class="form-control input-sm" required="required" data-error="Category is required.">
                          <option Value="">PLEASE SELECT</option>
                          <option Value="DETAILED REPORT" selected>DETAILED REPORT</option>
                        </select>
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="cbobustype">Insurance Type *</label>
                        <select id="cbobustype" class="form-control input-sm" required="required" data-error="Insurance Type is required.">
                          <option Value="">PLEASE SELECT</option>
                          <option Value="ALL" selected>ALL</option>
                          <option Value="NEW BUSINESS">NEW BUSINESS</option>
                          <option Value="RENEWAL BUSINESS">RENEWAL BUSINESS</option>
                        </select>
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="cbotranstatus">Transaction Status *</label>
                        <select id="cbotranstatus" class="form-control input-sm" required="required" data-error="Transaction Status is required.">
                          <option Value="">PLEASE SELECT</option>
                        </select>
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="dpdatefrom">Date From *</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input id="dpdatefrom" type="text" class="form-control input-sm pull-right"  required="required" data-error="Date From is required.">
                          <div class="help-block with-errors"></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="dpdateto">Date To *</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input id="dpdateto" type="text" class="form-control input-sm pull-right"  required="required" data-error="Date To is required.">
                          <div class="help-block with-errors"></div>
                        </div>
                      </div>
                    </div>
                    <div hidden>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="cbomonth">Month *</label>
                          <select id="cbomonth" class="form-control input-sm" required="required" data-error="Month is required.">
                            <option Value="">PLEASE SELECT</option>
                          </select>
                          <div class="help-block with-errors"></div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="cboyear">Year *</label>
                          <select id="cboyear" class="form-control input-sm" required="required" data-error="Year is required.">
                            <option Value="">PLEASE SELECT</option>
                          </select>
                          <div class="help-block with-errors"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <label type="submit" class="btn btn-success" id="btnprocess"><i class="fa fa-spinner"></i> Process Now</label>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box -->
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-body">
                <div class="box-header with-border">
                  <div class="row">
                    <div class="col-md-8">
                      <h3 class="box-title">Generated Data Results</h3>
                    </div>
                    <div class="col-md-4">
                      <button type="submit" class="btn btn-success pull-right" id="btnexportxls" disabled><i class="fa-regular fa-file-excel"></i> Export Excel</button>
                    </div>
                  </div>
                </div>
                <div class="box-body">
                  <div id="viewreportDetail" hidden>
                    <center><h3>Detailed Report</h3></center>
                    <table id="table_detail" class="table table-striped table-bordered table-hover nowrap" style="width:100%">
                      <thead>
                        <tr class="tableheader">
                          <th>#</th>
                          <th>Insurance No</th>
                          <th>Trans. Date & Time</th>
                          <th>Status</th>
                          <th>Customer No</th>
                          <th>Customer Name</th>
                          <th>Contact No.</th>
                          <th>VIN</th>
                          <th>CS No.</th>
                          <th>Plate No.</th>
                          <th>Model</th>
                          <th>Variant</th>
                          <th>Insurance Partner</th>
                          <th>I.S.E</th>
                          <th>User</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
          </div>
        </div>
      </div>
      <!-- / box-body -->
    </div>
    <!-- /box -->
    <!-- MODAL SAVING -->
    <div id="modalloading" class="modal fade" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-success modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Loading data!</h4>
          </div>
          <!--/modal-header-->
          <div class="modal-body">
            <div class="loader1"></div>
            <br>
            Pleasee wait while loading data...
          </div>
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

</x-layouts.main>



@push('scripts')
<script type="text/javascript" src="{{ asset('tmia-assets/js/nbrb_report_laravel.js') }}"></script>
@endpush
