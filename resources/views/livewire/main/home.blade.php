<x-layouts.main>

  @push('styles')
<link
    rel="stylesheet"
    href="{{ asset('tmia-assets/css/home.css') }}"
>
@endpush

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
    </h1>
    <ol class="breadcrumb">
      <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- ========================================================================================================== -->
  <!-- Main content -->
  <section class="content home">

    


    <!-- BIRTH DAY AND ANNIVERSARRY -->
    <div class="box">
      <div class="box-body dashboard-container">
        
        <header class="dashboard-header">
          <h1>Client Milestones Overview</h1>
          <p>March 2026 • Personal & Asset Milestones</p>
        </header>

            <div id='bg'>
              <img src="{{ asset('tmia-assets/images/home/tmi' . strtolower(Auth::user()?->Dealer_ID) . '_building.png') }}" alt="Dealer Building">
              <IMG SRC="{{ asset('tmia-assets/images/background.webp') }}">
            </div>

            <div id='bg-logo'>
              <IMG SRC="{{ asset('tmia-assets/images/logo.png') }}">
            </div>

            {{-- <!--begin::Row-->
            <div class="box" style="padding: 5px 10px;">
              <div class="box-body" style="border: 1.5px solid #ddd; border-radius: 15px;">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Date *</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input id="dpdate" type="text" class="form-control pull-right" required="required" data-error="Date is required.">
                        <span class="input-group-btn">
                          <label id="btngo" type="button" class="btn btn-success">Go!</label>
                        </span>
                      </div>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Filter Charts View</label>
                      <select id="cbofiltersc" class="form-control input-sm">
                        <option Value="MONTH" seleted>MONTH</option>
                        <option Value="YEAR">YEAR</option>
                      </select>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-12">
                    <div class="box">
                      <div class="box-header with-border">
                        <h3 class="box-title">Call Status Total Counts</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                      </div>
                      <div class="box-footer" style="background-color: #f4f4f4;">
                        <div class="row">
                          <div class="col-sm-3 col-xs-6" style="border-right: 1px solid #ddd;">
                            <div class="description-block border-right">
                              <span class="description-percentage text-yellow" style="font-weight: bold;" id="tpendingp" > 0%</span>
                              <h5 class="description-header" style="font-weight: bold;" id="tpending">0</h5>
                              <span class="description-text" style="font-weight: bold;">TOTAL PENDING</span>
                            </div>
                          </div>
                          <div class="col-sm-3 col-xs-6" style="border-right: 1px solid #ddd;">
                            <div class="description-block border-right">
                              <span class="description-percentage text-green" style="font-weight: bold;" id="tsuccessp"> 0%</span>
                              <h5 class="description-header" style="font-weight: bold;" id="tsuccess">0</h5>
                              <span class="description-text" style="font-weight: bold;">TOTAL SUCCESSFUL</span>
                            </div>
                          </div>
                          <div class="col-sm-3 col-xs-6" style="border-right: 1px solid #ddd;">
                            <div class="description-block border-right">
                              <span class="description-percentage text-red" style="font-weight: bold;" id="tunsuccessp"> 0%</span>
                              <h5 class="description-header" style="font-weight: bold;" id="tunsuccess">0</h5>
                              <span class="description-text" style="font-weight: bold;">TOTAL UNSUCCESSFUL</span>
                            </div>
                          </div>
                          <div class="col-sm-3 col-xs-6">
                            <div class="description-block">
                              <span class="description-percentage text-blue" style="font-weight: bold;" id="tcallstatusp"> 0%</span>
                              <h5 class="description-header" style="font-weight: bold;" id="tcallstatus">0</h5>
                              <span class="description-text" style="font-weight: bold;">TOTAL STATUS</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="box">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="boxtitle1">Monthly Recap Report - Summary</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                      </div>
                      <div class="box-body">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="col-md-5">
                              <p class="text-center">
                                <strong>Call Status Summary</strong>
                              </p>
                              <table id="table_callstatus" class="table table-striped table-bordered table-hover">
                                <thead>
                                  <tr class="tableheader">
                                    <th>Call Status</th>
                                    <th>TODAY</th>
                                    <th>MTD</th>
                                    <th>YTD</th>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>
                            </div>
                            <div class="col-md-7" style="border-left: 1px solid #ddd;">
                              <p class="text-center">
                                <strong id="charttitle1">Daily Service Call Outcomes by Status – September 2025</strong>
                              </p>
                              <div id="chart-container">
                                <canvas id="Chart1"></canvas>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="box">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="boxtitle2">Monthly Recap Report - Details</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                      </div>
                      <div class="box-body">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="col-md-5" style="border-right: 1px solid #ddd;">
                              <p class="text-center">
                                <strong>Call Status Summary Detail</strong>
                              </p>
                              <table id="table_callstatusdetail" class="table table-striped table-bordered table-hover">
                                <thead>
                                  <tr class="tableheader">
                                    <th>Call Status</th>
                                    <th>Reason Description</th>
                                    <th>Total Count</th>
                                  </tr>
                                </thead>
                                <tfoot>
                                  <tr>
                                    <th colspan="2" style="text-align:right">Total:</th>
                                    <th id="total-count" style="text-align:center">0</th>
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                            <div class="col-md-7">
                              <p class="text-center">
                                <strong id="charttitle2">Call Reasons by Status (Stacked Breakdown) — September 2025</strong>
                              </p>
                              <div id="chart-container2">
                                <div class="chart-wrapper">
                                  <canvas id="Chart2"></canvas>
                                </div>
                                <div id="legend-container"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>     
            <!--end::Row--> --}}

            <div class="row">

              <!-- Birthdays -->
              <div class="col-md-5">
                <div class="panel">
                  <div class="panel-header">
                    <h6><i class="fa fa-birthday-cake text-yellow"></i> Monthly Birthdays</h6>
                  </div>

                  <div class="table-responsive">
                    <table id="birthTable" class="table table-hover w-100">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Client</th>
                          <th>Turning Age</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><span class="badge badge-muted">Mar 04</span></td>
                          <td>
                            <span class="client-name">Jonathan Wick</span>
                            <span class="client-id">UID: 4402</span>
                          </td>
                          <td>45</td>
                        </tr>
                        <tr>
                          <td><span class="badge badge-muted">Mar 12</span></td>
                          <td>
                            <span class="client-name">Elena Rodriguez</span>
                            <span class="client-id">UID: 3912</span>
                          </td>
                          <td>32</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <!-- Vehicle Anniversaries -->
              <div class="col-md-7">
                <div class="panel">
                  <div class="panel-header">
                    <h6><i class="fa fa-car text-black"></i> Vehicle Purchase Anniversaries</h6>
                  </div>

                  <div class="table-responsive">
                    <table id="anniTable" class="table table-hover w-100">
                      <thead>
                        <tr>
                          <th>Client</th>
                          <th>Vehicle</th>
                          <th>Purchase Date</th>
                          <th>Years Owned</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <span class="client-name">Thomas Miller</span>
                            <span class="client-id">UID: 8821</span>
                          </td>
                          <td class="text-muted">2021 Toyota RAV4</td>
                          <td><span class="badge badge-muted">Mar 02, 2021</span></td>
                          <td><span class="badge badge-info">5 yrs</span></td>
                        </tr>
                        <tr>
                          <td>
                            <span class="client-name">Gregory House</span>
                            <span class="client-id">UID: 1042</span>
                          </td>
                          <td class="text-muted">2016 BMW X5</td>
                          <td><span class="badge badge-muted">Mar 22, 2016</span></td>
                          <td><span class="badge badge-info">10 yrs</span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

            </div>
      </div>
    </div>



    
  </section>

</div>
<!-- /.content-wrapper -->
</x-layouts.main>
