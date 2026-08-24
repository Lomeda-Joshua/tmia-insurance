<x-layouts.main>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      New Business Insurance
    </h1>
    <ol class="breadcrumb">
      <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href=""><i class="fa fa-tasks"></i> Transactions</a></li>
      <li class="active"><i class="fa-solid fa-car"></i> New Business Insurance</li>
    </ol>
  </section>

    <!-- Main content -->
  <section class="content">
    <!-- box -->
    <div class="box box-warning">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-default">
            <div class="inner">
              <h3 id="pending-counts">0</h3>
              <p>Pending Policies</p>
            </div>
            <div class="icon">
              <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            {{-- <label id="viewpending" class="btn small-box-footer">View <i class="fa-solid fa-angles-right"></i></label> --}}
            <button type="button" id="viewpending" class="btn small-box-footer">
                View <i class="fa-solid fa-angles-right"></i>
            </button>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-default">
            <div class="inner">
              <h3 id="expiring-counts">0</h3>
              <p>Expiring soon policies (90 Days)</p>
            </div>
            <div class="icon">
              <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <label id="viewexpiring" class="btn small-box-footer">View <i class="fa-solid fa-angles-right"></i></label>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- Search, Date Filter and Add New -->
      <div class="box-header with-border">
        <div class="row">
          <div class="col-md-12">
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
            <div class="col-md-2">
              <div style="padding: 10px 0; width: 85px;">
                <label id="btnrefresh" class="btn btn-box-tool" style="font-size: 15px !important; display: block;"><i class="fa-solid fa-rotate"></i> Refresh</label>
              </div>
            </div>
          </div>
        </div>
        @if(Auth::user()->User_Level_ID == 1)
        <div class="row">
          <div class="btnactionud pull-right">
            <button
                  type="button"
                  id="btnadd"
                  class="btn btn-box-tool"
                  data-user-id="{{ Auth::user()->User_ID }}"
                  data-user-level="{{ Auth::user()->userLevel?->User_Level_Description }}"
                >
                <i class="fa fa-plus"></i> Add New
            </button>
          </div>
        </div>
        @endif
      </div>
      <div class="box-body" style="max-width:100%;">
        <table id="table_trans" class="table table-striped table-bordered table-hover">
          <thead>
              <tr class="tableheader">
                  <th>No.</th>
                  <th>Insurance No.</th>
                  <th>Trans. Date & Time</th>
                  <th>Status</th>
                  <th>Customer No.</th>
                  <th>Customer Name</th>
                  <th>Contact No.</th>
                  <th>VIN</th>
                  <th>CS No.</th>
                  <th>Plate No.</th>
                  <th>Model</th>
                  <th>Variant</th>
                  <th>Insurance Partner</th>
                  <th>I.S.E</th>
                  <th>MP Name</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>
          </tbody>
      </table>
      </div>
    </div>
    
    <!-- MODAL MODIFY ISE -->
    <div id="modal-modify-ise" aria-hidden="false" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box box-solid">
        <div class="box-body" style="max-width:100%;">
          <div class="insurer-info">
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="cboise">Insurance Staff *</label>
                      <select id="cboise" class="form-control input-sm" required="required" data-error="Insurance Staff is required.">
                        <option Value="">PLEASE SELECT</option>
                      </select>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box-footer with-border">
          <div class="pull-right">
            <button type="button" id="btncancelise" class="btn btn-success"><i class="fa fa-ban"></i> Cancel</button>
            <button type="button" id="btnselectise" class="btn btn-success"><i class="fa-regular fa-circle-check"></i> Select</button>
          </div>
        </div>  
      </div>
    </div>
    <!-- END MODAL MODIFY ISE -->
    <!-- MODAL ADD -->
    <div id="modal-add" aria-hidden="false" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box box-solid">
        <div class="box-body" style="max-width:100%;">
          <!-- Stepper -->
          <div class="stepper" id="stepper">
              <div class="step active" data-step="1">
                  <div class="step-number">Step 1</div>
                  <div class="icon"><i class="fa fa-user"></i></div>
                  <div class="step-text">Customer Information</div>
              </div>
              <div class="step" data-step="2">
                  <div class="step-number">Step 2</div>
                  <div class="icon"><i class="fa fa-car"></i></div>
                  <div class="step-text">Vehicle Information</div>
              </div>
              <div class="step" data-step="3">
                  <div class="step-number">Step 3</div>
                  <div class="icon"><i class="fa fa-calculator"></i></div>
                  <div class="step-text">Insurance Calculation</div>
              </div>
              <div class="step" data-step="4">
                  <div class="step-number">Step 4</div>
                  <div class="icon"><i class="fa fa-building-shield"></i></div>
                  <div class="step-text">Insurance Company</div>
              </div>
              <div class="step" data-step="5">
                  <div class="step-number">Step 5</div>
                  <div class="icon"><i class="fa fa-check"></i></div>
                  <div class="step-text">Final Submit</div>
              </div>
          </div>

          <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" id="progressBar"></div>
          </div>

          <!-- Form -->
          <form id="multiStepForm">
              <!-- Step 1 -->
              <div class="page active" id="page1">
                <div class="box box-solid">
                  <div class="box-header with-border">
                    <h2 class="box-title"><i class="fa-regular fa-circle-user"></i> Customer Information</h2>
                  </div>
                  <div class="box-body" style="max-width:100%;">
                    <div class="customer-info">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtcustno">Customer No. *</label>
                                <div class="input-group input-group-sm">
                                  <input type="text" id="txtcustno" class="form-control input-sm" placeholder="Auto Generated" disabled>
                                  <input type="hidden" id="txtcustnoupload" class="form-control input-sm">
                                  <span class="input-group-btn">
                                    <button type="button" id="btnfindcustomer" data-toggle="tooltip" data-placement="top" title="Find Customer" class="btn btn-success btn-flat"><i class="fa fa-search"></i></button>
                                  </span>
                              </div>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="cbogroup">Group *</label>
                                <select id="cbogroup" class="form-control input-sm" required="required" data-error="Group is required." disabled>
                                  <option Value="">PLEASE SELECT</option>
                                </select>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                          </div>
                          <div class="customer-fleet-corp" hidden>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="txtcustname">Customer Name *</label>
                                  <textarea id="txtcustname" class="form-control input-sm" rows="2" required="required" data-error="Customer Name is required." disabled></textarea>
                                  <div class="help-block with-errors"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="customer-individual">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="txtcustfname">First Name *</label>
                                  <input type="text" id="txtcustfname" class="form-control input-sm" required="required" data-error="First Name is required." disabled>
                                  <div class="help-block with-errors"></div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="txtcustmname">Middle Name</label>
                                  <input type="text" id="txtcustmname" class="form-control input-sm" placeholder="Optional" disabled>
                                  <div class="help-block with-errors"></div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="txtcustlname">Last Name *</label>
                                  <input type="text" id="txtcustlname" class="form-control input-sm" required="required" data-error="Last Name is required." disabled>
                                  <div class="help-block with-errors"></div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="txtcustsname">Suffix Name</label>
                                  <input type="text" id="txtcustsname" class="form-control input-sm" placeholder="Optional Ex. Jr, II & etc." disabled>
                                  <div class="help-block with-errors"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6 birth-date">
                              <div class="form-group">
                                <label for="dpbirthdate">Birth Date *</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input id="dpbirthdate" type="text" class="form-control input-sm pull-right" required="required" data-error="Birth Date  is required." disabled>
                                </div>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txttin">TIN *</label>
                                <input type="text" id="txttin" class="form-control input-sm" required="required" data-error="TIN is required." disabled>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtcontactno">Contact No. *</label>
                                <input type="text" id="txtcontactno" class="form-control input-sm" required="required" data-error="Contact No. is required." disabled>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtemailadd">E-Mail Address *</label>
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
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="txtaddress">Address *</label>
                                <textarea id="txtaddress" class="form-control input-sm" placeholder="Address here!" rows="3" required="required" data-error="Address is required." disabled></textarea>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="cboregion">Region *</label>
                                <select id="cboregion" class="form-control input-sm" required="required" data-error="Region is required." disabled>
                                  <option Value="">PLEASE SELECT</option>
                                </select>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="cboprovince">Province *</label>
                                <select id="cboprovince" class="form-control input-sm" required="required" data-error="Province is required." disabled>
                                  <option Value="">PLEASE SELECT</option>
                                </select>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="cbocity">City / Municipal *</label>
                                <select id="cbocity" class="form-control input-sm" required="required" data-error="City / Municipal is required." disabled>
                                  <option Value="">PLEASE SELECT</option>
                                </select>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="cbobrgy">Barangay *</label>
                                <select id="cbobrgy" class="form-control input-sm" required="required" data-error="Barangay is required." disabled>
                                  <option Value="">PLEASE SELECT</option>
                                </select>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtzipcode">Zip Code / Postal Code *</label>
                                <input type="text" id="txtzipcode" class="form-control input-sm" required="required" data-error="Zip Code / Postal Code is required." disabled>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="cbocountry">Country *</label>
                                <select id="cbocountry" class="form-control input-sm" required="required" data-error="Country is required." disabled>
                                  <option Value="PHILIPPINES" selected>PHILIPPINES</option>
                                </select>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="box-footer with-border">
                    <div class="pull-right">
                      <button type="button" id="nextBtn" data-toggle="tooltip" data-placement="top" title="Next" class="btn btn-success"><i class="fa-solid fa-forward-step"></i> Next</button>
                    </div>
                  </div>  
                </div>
              </div>

              <!-- Step 2 -->
              <div class="page" id="page2">
                <div class="box box-solid">
                  <div class="box-header with-border">
                    <h2 class="box-title"><i class="fa-solid fa-car"></i> Vehicle Information</h2>
                  </div>
                  <div class="box-body" style="max-width:100%;"> 
                    <div class="vehicle-info">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtvin">VIN *</label>
                                <div class="input-group input-group-sm">
                                  <input type="text" id="txtvin" class="form-control input-sm" required="required" data-error="VIN is required." disabled>
                                  <span class="input-group-btn">
                                    <button type="button" id="btnfindvehicle" data-toggle="tooltip" data-placement="top" title="Find Vehicle" class="btn btn-success btn-flat"><i class="fa fa-search"></i></button>
                                  </span>
                              </div>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtmake">Make *</label>
                                <input type="text" id="txtmake" class="form-control input-sm" required="required" data-error="Make is required." disabled>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtmodel">Model *</label>
                                <input type="text" id="txtmodel" class="form-control input-sm" required="required" data-error="Model is required." disabled>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtmodelyear">Mode Year *</label>
                                <input type="text" id="txtmodelyear" class="form-control input-sm" required="required" data-error="Model Year is required." disabled>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtcolor">Color *</label>
                                <input type="text" id="txtcolor" class="form-control input-sm" required="required" data-error="Color is required." disabled>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtengineno">Engine No. *</label>
                                <input type="text" id="txtengineno" class="form-control input-sm" required="required" data-error="Engine No. is required." disabled>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtcsno">CS No. *</label>
                                <input type="text" id="txtcsno" class="form-control input-sm" required="required" data-error="CS No. is required." disabled>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtplateno">Plate No. *</label>
                                <input type="text" id="txtplateno" class="form-control input-sm" required="required" data-error="Plate No. is required." disabled>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                          </div>
                          <!-- <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtorderno">Order No. *</label>
                                <input type="text" id="txtorderno" class="form-control input-sm" required="required" data-error="Order No. is required." disabled>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtorderstatus">Order Status *</label>
                                <input type="text" id="txtorderstatus" class="form-control input-sm" required="required" data-error="Order Status is required." disabled>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                          </div> -->
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtsrp">Paid Price *</label>
                                <input type="text" id="txtsrp" class="form-control input-sm" required="required" data-error="Paid Price is required." disabled>
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
                                  <input id="dpvsidate" type="text" class="form-control input-sm pull-right" required="required" data-error="VSI Date is required." disabled>
                                </div>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <!-- <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtmsalecode">Model Sales Code *</label>
                                <input type="text" id="txtmsalecode" class="form-control input-sm" required="required" data-error="Model Sales Code is required." disabled>
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
                                <textarea id="txtvariant" class="form-control input-sm" rows="2" required="required" data-error="Variant is required." disabled></textarea>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="cbobodytype">Body Type *</label>
                                <select id="cbobodytype" class="form-control input-sm" required="required" data-error="Body Type is required." disabled>
                                  <option Value="">PLEASE SELECT</option>
                                </select>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txttransmission">Power Transmission *</label>
                                <input type="text" id="txttransmission" class="form-control input-sm" required="required" data-error="Power Transmission is required." disabled>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="cbofueltype">Fuel Type *</label>
                                <select id="cbofueltype" class="form-control input-sm" required="required" data-error="Fuel Type is required." disabled>
                                  <option Value="">PLEASE SELECT</option>
                                </select>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtseats">Seats *</label>
                                <input type="text" id="txtseats" class="form-control input-sm" required="required" data-error="Seats is required." disabled>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                          </div>
                          <!-- <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtunloadweight">Unloaded Weight *</label>
                                <input type="text" id="txtunloadweight" class="form-control input-sm" required="required" data-error="Unloaded Weight is required." disabled>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtmaxweight">Maximum Weight *</label>
                                <input type="text" id="txtmaxweight" class="form-control input-sm" required="required" data-error="Maximum Weight is required." disabled></input>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                          </div> -->
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="cboprodclass">Product Classification *</label>
                                <select id="cboprodclass" class="form-control input-sm" required="required" data-error="Product Classification is required." disabled>
                                  <option Value="">PLEASE SELECT</option>
                                </select>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="cboowntype">Owner Type *</label>
                                <select id="cboowntype" class="form-control input-sm" required="required" data-error="Owner Type is required." disabled>
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
                                <input type="text" id="txtvoname" class="form-control input-sm" required="required" data-error="Vehicle Owner Name is required." disabled>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtmpname">Marketing Professional *</label>
                                <input type="text" id="txtmpname" class="form-control input-sm" required="required" data-error="Marketing Professional is required." disabled>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="box-footer with-border">
                    <div class="pull-left">
                      <button type="button" id="prevBtn" data-toggle="tooltip" data-placement="top" title="Previous" class="btn btn-success"><i class="fa-solid fa-backward-step"></i> Previous</button>
                    </div>
                    <div class="pull-right">
                      <button type="button" id="nextBtn" data-toggle="tooltip" data-placement="top" title="Next" class="btn btn-success"><i class="fa-solid fa-forward-step"></i> Next</button>
                    </div>
                  </div>  
                </div>
              </div>

              <!-- Step 3 -->
              <div class="page" id="page3">
                <div class="box box-solid">
                  <div class="box-header with-border">
                    <h2 class="box-title"><i class="fa fa-calculator"></i> Insurance Calculation</h2>
                  </div>
                  <div class="box-body" style="max-width:100%;"> 
                    <div class="insurance-calc">
                      <form>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="txtgrosspremium">Gross Premium *</label>
                              <input type="text" id="txtgrosspremium" class="form-control input-sm" value="0.00" required="required" data-error="Gross Premium is required." disabled>
                              <div class="help-block with-errors"></div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="txtnetremittance">Net Remittance *</label>
                              <input type="text" id="txtnetremittance" class="form-control input-sm" value="0.00" required="required" data-error="Net Remittance is required." disabled>
                              <div class="help-block with-errors"></div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="txtcommission">Commission *</label>
                              <input type="text" id="txtcommission" class="form-control input-sm" value="0.00" style="font-weight: bold; background: #F3F3F3;" required="required" data-error="Commission is required."  disabled>
                              <div class="help-block with-errors"></div>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-md-12">
                            <label>Option Type</label>
                            <div class="radio-group">
                              <label class="custom-radio">
                                <input type="radio" name="rdoptiontype" value="FREE" checked>
                                <span class="checkmark"></span>
                                FREE
                              </label>
                              <label class="custom-radio">
                                <input type="radio" name="rdoptiontype" value="PAID">
                                <span class="checkmark"></span>
                                PAID
                              </label>
                            </div>
                          </div>  
                        </div>
                        <table class="installment-section" hidden>
                          <tbody>
                            <tr>
                              <td data-label="" style="text-align: left;">
                                <label class="custom-checkbox">
                                  <input type="checkbox" id="chkpayment"/>
                                  <span class="checkbox-icon"></span>
                                  <span class="checkbox-label">Installment Payment</span>
                                </label>
                              </td>
                              <td data-label="" id="installpay-terms" hidden>
                                <div class="form-group">
                                  <label for="txtterms">Terms (months)</label>
                                  <input type="text" id="txtterms">
                                  <div class="help-block with-errors"></div>
                                </div>
                              </td>
                              <td data-label="" id="installpay-mpay" hidden>
                                <div class="form-group">
                                  <label for="txtmonthpay">Monthly Payment(₱/month)</label>
                                  <input type="text" id="txtmonthpay" style="font-weight: bold; background: #F3F3F3;" disabled>
                                  <div class="help-block with-errors"></div>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </form>
                      <hr>
                      <div class="box box-solid payment-new" hidden>
                        <div class="box-body" style="max-width:100%;">
                          <div class="payment-info-n" >
                            <div class="row">
                              <div class="col-md-12">
                                <div class="row pay-section-n">
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="cbopaytype-n">Payment Type *</label>
                                      <select id="cbopaytype-n" class="form-control input-sm" required data-error="Payment Type is required." disabled>
                                        <option value="">PLEASE SELECT</option>
                                      </select>
                                      <div class="help-block with-errors"></div>
                                    </div>
                                  </div>
                                </div>

                                <!-- Credit Card Section -->
                                <div class="row cc-section-n" hidden>
                                  <div class="col-md-12">
                                    <div class="credit-card">
                                      <div class="cc-header">
                                        <h3>Credit Card Details</h3>
                                        <div class="cc-icons">
                                          <img src="{{ asset('tmia-assets/images/credit/visa.svg') }}" alt="visa">
                                          <img src="{{ asset('tmia-assets/images/credit/mastercard.svg') }}" alt="mastercard">
                                          <img src="{{ asset('tmia-assets/images/credit/jcb.svg') }}" alt="jcb">
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label for="txtccno-n">Card No. *</label>
                                            <input type="text" id="txtccno-n" class="form-control input-sm" required data-error="Card No. is required." disabled>
                                            <div class="help-block with-errors"></div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">
                                            <label for="txtccholder-n">Holder Name *</label>
                                            <input type="text" id="txtccholder-n" class="form-control input-sm" required data-error="Holder Name is required." disabled>
                                            <div class="help-block with-errors"></div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label for="txtccexpirydate-n">Expiry Date (MM/YY) *</label>
                                            <input type="text" id="txtccexpirydate-n" class="form-control input-sm" required data-error="Expiry Date is required." disabled>
                                            <div class="help-block with-errors"></div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label for="txtccvv-n">CVV / CVC *</label>
                                            <input type="text" id="txtccvv-n" class="form-control input-sm" required data-error="CVV / CVC is required." disabled>
                                            <div class="help-block with-errors"></div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <!-- PDC Section -->
                                <div class="row pdc-section-n" hidden>
                                  <div class="col-md-12">
                                    <div class="post-dated-check">
                                      <div class="pdc-header">
                                        <h3>Post-Dated Check (PDC) Details</h3>
                                        <div class="pdc-icons">
                                          <img src="{{ asset('tmia-assets/images/credit/check.png') }}" alt="cheque">
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label for="txtpdcno-n">Check No. *</label>
                                            <input type="text" id="txtpdcno-n" class="form-control input-sm" required data-error="Check No. is required." disabled>
                                            <div class="help-block with-errors"></div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">
                                            <label for="txtpdcholdername-n">Account Holder Name *</label>
                                            <input type="text" id="txtpdcholdername-n" class="form-control input-sm" required data-error="Account Holder Name is required." disabled>
                                            <div class="help-block with-errors"></div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label for="txtpdcbankname-n">Bank Name *</label>
                                            <input type="text" id="txtpdcbankname-n" class="form-control input-sm" required data-error="Bank Name is required." disabled>
                                            <div class="help-block with-errors"></div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="dppdccheckdate-n">Check Date *</label>
                                            <div class="input-group date">
                                              <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                              </div>
                                              <input id="dppdccheckdate-n" type="text" class="form-control input-sm pull-right"  required="required" data-error="Check Date is required." disabled>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <!-- E-Wallet Section -->
                                <div class="row ew-section-n" hidden>
                                  <div class="col-md-12">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label for="cboewallet-n">E-Wallet Type *</label>
                                        <select id="cboewallet-n" class="form-control input-sm" required data-error="E-Wallet Type is required." disabled>
                                          <option value="">PLEASE SELECT</option>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                      </div>
                                    </div>
                                    <div class="col-md-8 ew-icons-col">
                                      <div class="ew-icons">
                                        <img id="pgcash-n" src="{{ asset('tmia-assets/images/e-wallet/gcash.svg') }}" alt="gcash">
                                        <img id="pmaya-n" src="{{ asset('tmia-assets/images/e-wallet/maya.svg') }}" alt="maya">
                                        <img id="ptwallet-n" src="{{ asset('tmia-assets/images/e-wallet/toyotawallet.svg') }}" alt="toyotawallet">
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="row term-amount-section-n">  
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="txtpayterms-n">Terms</label>
                                      <input type="text" id="txtpayterms-n" class="form-control input-sm" disabled>
                                      <div class="help-block with-errors"></div>
                                    </div>
                                  </div>

                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="txtpayamount-n">Amount *</label>
                                      <input type="text" id="txtpayamount-n" class="form-control input-sm" required data-error="Amount is required." disabled>
                                      <div class="help-block with-errors"></div>
                                    </div>
                                  </div>

                                </div>

                                <!-- Button Row -->
                                <div class="row btnadd-section-n">
                                  <div class="col-md-12 text-right">
                                    <label type="button" id="btnaddpay-n" class="btn btn-success">
                                      <i class="fa fa-plus-circle"></i> Add Payment
                                    </label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            <div class="table-responsive">
                              <table id="table_payment-n" class="table m-0" style="width:100%; table-layout:fixed;">
                                <thead>
                                  <tr>
                                    <th>No.</th>
                                    <th>Payment ID</th>
                                    <th>Mode of Payment</th>
                                    <th>E-wallet Type</th>
                                    <!-- <th>CC No.</th>
                                    <th>CC Holder Name</th>
                                    <th>CC Expiry Date</th>
                                    <th>CC CVV</th> -->
                                    <th>PDC No.</th>
                                    <th>PDC Account Name</th>
                                    <th>PDC Bank Name</th>
                                    <th>PDC Date</th>
                                    <th>Terms</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th class="col-action-n">Action</th>
                                  </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot></tfoot>
                              </table>
                              <table class="table m-0" style="width:100%; table-layout:fixed;">
                                <thead>
                                  <tr>
                                    <th style="text-align:right; background-color: #f4f4f4;">Total Premium:</th>
                                    <th id="tfoot_tpremium-n" style="text-align:right; background-color: #f4f4f4;">0.00</th>
                                    <th style="text-align:right; background-color: #f4f4f4;">Total Amount:</th>
                                    <th id="tfoot_total-n" style="text-align:right; background-color: #f4f4f4;">0.00</th>
                                    <th style="text-align:right; background-color: #f4f4f4;">Total Balance:</th>
                                    <th id="tfoot_balance-n" style="text-align:right; background-color: #f4f4f4;">0.00</th>
                                  </tr>
                                </thead>
                              </table>
                              <p style="font-size:12px;font-style: italic;">
                                <b>Note:</b> To modify or update a payment, double-click the row you wish to edit. After making the necessary changes in the input fields, click the ‘Add Payment’ button to save the updates to the payment list.
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="box-footer with-border">
                    <div class="pull-left">
                      <button type="button" id="prevBtn" data-toggle="tooltip" data-placement="top" title="Previous" class="btn btn-success"><i class="fa-solid fa-backward-step"></i> Previous</button>
                    </div>
                    <div class="pull-right">
                      <button type="button" id="nextBtn" data-toggle="tooltip" data-placement="top" title="Next" class="btn btn-success"><i class="fa-solid fa-forward-step"></i> Next</button>
                    </div>
                  </div>  
                </div>
              </div>

              <!-- Step 4 -->
              <div class="page" id="page4">
                <div class="box box-solid">
                  <div class="box-header with-border">
                    <h2 class="box-title"><i class="fa fa-building-shield"></i> Insurer Information</h2>
                  </div>
                  <div class="box-body" style="max-width:100%;"> 
                    <div class="insurer-info">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="cboinstype">Insurance Type *</label>
                                <select id="cboinstype" class="form-control input-sm" required="required" data-error="Insurance Type is required." disabled>
                                  <option Value="">PLEASE SELECT</option>
                                </select>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="cboinsco">Insurance Company *</label>
                                <select id="cboinsco" class="form-control input-sm" required="required" data-error="Insurance Company is required." disabled>
                                  <option Value="">PLEASE SELECT</option>
                                </select>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="dpstartdate">Start / Inception Date *</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input id="dpstartdate" type="text" class="form-control input-sm pull-right" required="required" data-error="Start / Inception Date is required.">
                                </div>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="txtpolicyno">Policy No. *</label>
                                <input type="text" id="txtpolicyno" class="form-control input-sm" required="required" data-error="Policy No. is required.">
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="dpissuedate">Issue Date *</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input id="dpissuedate" type="text" class="form-control input-sm pull-right" required="required" data-error="Issue Date is required.">
                                </div>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="dppexpiredate">Policy Expiration Date *</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input id="dppexpiredate" type="text" class="form-control input-sm pull-right" required="required" data-error="Expiration Date is required.">
                                </div>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="cbomortgage">Mortgage *</label>
                                <select id="cbomortgage" class="form-control input-sm" required="required" data-error="Mortgage is required.">
                                  <option Value="">PLEASE SELECT</option>
                                </select>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="box-footer with-border">
                    <div class="pull-left">
                      <button type="button" id="prevBtn" data-toggle="tooltip" data-placement="top" title="Save" class="btn btn-success"><i class="fa-solid fa-backward-step"></i> Previous</button>
                    </div>
                    <div class="pull-right">
                      <button type="button" id="nextBtn" data-toggle="tooltip" data-placement="top" title="Save" class="btn btn-success"><i class="fa-solid fa-forward-step"></i> Next</button>
                    </div>
                  </div>  
                </div>
              </div>

              <!-- Step 5 -->
              <div class="page" id="page5">
                <div class="box box-solid">
                  <div class="box-header with-border">
                    <h2 class="box-title"><i class="fa fa-check"></i> Final Step: Submit</h2>
                  </div>
                  <div class="box-body" style="max-width:100%;"> 
                    <div class="final-submit">
                      <h4>Please review your information one last time. If everything looks correct, click "Submit" to proceed.</h4>
                    </div>
                  </div>
                  <div class="box-footer with-border">
                    <div class="pull-left">
                      <button type="button" id="prevBtn" data-toggle="tooltip" data-placement="top" title="Previous" class="btn btn-success"><i class="fa-solid fa-backward-step"></i> Previous</button>
                    </div>
                    <div class="pull-right">
                      <button type="button" id="btnsubmit" data-toggle="tooltip" data-placement="top" title="Submit" class="btn btn-success"><i class="fa-solid fa-forward-step"></i> Submit</button>
                    </div>
                  </div>  
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>
    <!-- END MODAL ADD -->
    <!-- MODAL CUSTOMER LIST -->
    <div id="modal-customerlist" aria-hidden="false" role="dialog" class="iziModal isAttached hasScroll">
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
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs customertab">
              <li class="active"><a href="#tmiatab" data-toggle="tab">TMIA Customer List</a></li>
              <li><a href="#uploadtab" data-toggle="tab">Uploaded Customer List (EDAF/SAP)</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="tmiatab">
                <div class="box">
                  <div class="box-body">
                    <!-- /.box-header -->
                    <div class="box-body" style="max-width:100%;">
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
                            <th>Upload Cust. No</th>
                            <th>VIN</th>
                            <th>CS No.</th>
                            <th>Plate No.</th>
                            <th>Variant</th>
                            <!-- <th>Status</th>
                            <th>Inactive Date</th> -->
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                  <!-- / box-body -->
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="uploadtab">
                <div class="box">
                  <div class="box-body">
                    <!-- /.box-header -->
                    <div class="box-body" style="max-width:100%;">
                      <table id="table_customerlistupload" class="table table-striped table-bordered table-hover nowrap" style="width:100%">
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
                            <th>VIN</th>
                            <th>CS No.</th>
                            <th>Plate No.</th>
                            <th>Variant</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                  <!-- / box-body -->
                </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
        </div>
        <div class="box-footer with-border">
          <div class="pull-right">
            <button type="button" id="btncustselect" data-toggle="tooltip" data-placement="top" title="Go" class="btn btn-success"><i class="fa-solid fa-clipboard-check"></i> Go</button>
          </div>
        </div>  
      </div>
    </div>
    <!-- END MODAL CUSTOMER LIST -->
    <!-- MODAL VEHICLE LIST -->
    <div id="modal-vehiclelist" aria-hidden="false" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box">
        <!-- <div class="box-header with-border">
          <h2 class="box-title">Vehicle List</h2>
        </div> -->
        <div class="box-body">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs customervehtab">
              <li class="active"><a href="#tmiavehtab" data-toggle="tab">TMIA Customer Vehicle List</a></li>
              <li><a href="#uploadvehtab" data-toggle="tab">Uploaded Customer Vehicle List (EDAF/SAP)</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="tmiavehtab">
                <div class="box-body">
                  <table id="table_vehiclelist" class="table table-striped table-bordered table-hover nowrap" style="width:100%">
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
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="uploadvehtab">
                <div class="box-body">
                  <table id="table_uploadvehlist" class="table table-striped table-bordered table-hover nowrap" style="width:100%">
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
                      </tr>
                    </thead>
                  </table>
                </div>    
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->  
          </div>
        </div>
        <div class="box-footer with-border">
          <div class="pull-right">
            <button type="button" id="btnvehselect" data-toggle="tooltip" data-placement="top" title="Go" class="btn btn-success"><i class="fa-solid fa-clipboard-check"></i> Go</button>
          </div>
        </div>  
      </div>
    </div>
    <!-- END MODAL VEHICLE LIST -->
    <!-- MODAL MODIFY PAYMENT INFO -->
    <div id="modal-modify-pay" aria-hidden="false" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box box-solid">
        <div class="box-body" style="max-width:100%;">
          <div class="payment-info">
            <div class="row">
              <div class="col-md-12">
                <div class="row pay-section">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="cbopaytype">Payment Type *</label>
                      <select id="cbopaytype" class="form-control input-sm" required data-error="Payment Type is required." disabled>
                        <option value="">PLEASE SELECT</option>
                      </select>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>

                <!-- Credit Card Section -->
                <div class="row cc-section" hidden>
                  <div class="col-md-12">
                    <div class="credit-card">
                      <div class="cc-header">
                        <h3>Credit Card Details</h3>
                        <div class="cc-icons">
                          <img src="{{ asset('tmia-assets/images/credit/visa.svg') }}" alt="visa">
                          <img src="{{ asset('tmia-assets/images/credit/mastercard.svg') }}" alt="mastercard">
                          <img src="{{ asset('tmia-assets/images/credit/jcb.svg') }}" alt="jcb">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="txtccno">Card No. *</label>
                            <input type="text" id="txtccno" class="form-control input-sm" required data-error="Card No. is required." disabled>
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="txtccholder">Holder Name *</label>
                            <input type="text" id="txtccholder" class="form-control input-sm" required data-error="Holder Name is required." disabled>
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="txtccexpirydate">Expiry Date (MM/YY) *</label>
                            <input type="text" id="txtccexpirydate" class="form-control input-sm" required data-error="Expiry Date is required." disabled>
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="txtccvv">CVV / CVC *</label>
                            <input type="text" id="txtccvv" class="form-control input-sm" required data-error="CVV / CVC is required." disabled>
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- PDC Section -->
                <div class="row pdc-section" hidden>
                  <div class="col-md-12">
                    <div class="post-dated-check">
                      <div class="pdc-header">
                        <h3>Post-Dated Check (PDC) Details</h3>
                        <div class="pdc-icons">
                          <img src="{{ asset('tmia-assets/images/credit/check.png') }}" alt="cheque">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="txtpdcno">Check No. *</label>
                            <input type="text" id="txtpdcno" class="form-control input-sm" required data-error="Check No. is required." disabled>
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="txtpdcholdername">Account Holder Name *</label>
                            <input type="text" id="txtpdcholdername" class="form-control input-sm" required data-error="Account Holder Name is required." disabled>
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="txtpdcbankname">Bank Name *</label>
                            <input type="text" id="txtpdcbankname" class="form-control input-sm" required data-error="Bank Name is required." disabled>
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="dppdccheckdate">Check Date *</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input id="dppdccheckdate" type="text" class="form-control input-sm pull-right"  required="required" data-error="Check Date is required." disabled>
                            </div>
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- E-Wallet Section -->
                <div class="row ew-section" hidden>
                  <div class="col-md-12">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="cboewallet">E-Wallet Type *</label>
                        <select id="cboewallet" class="form-control input-sm" required data-error="E-Wallet Type is required." disabled>
                          <option value="">PLEASE SELECT</option>
                        </select>
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="col-md-8 ew-icons-col">
                      <div class="ew-icons">
                        <img id="pgcash" src="{{ asset('tmia-assets/images/e-wallet/gcash.svg') }}" alt="gcash">
                        <img id="pmaya" src="{{ asset('tmia-assets/images/e-wallet/maya.svg') }}" alt="maya">
                        <img id="ptwallet" src="{{ asset('tmia-assets/images/e-wallet/toyotawallet.svg') }}" alt="toyotawallet">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row term-amount-section">  
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="txtpayterms">Terms</label>
                      <input type="text" id="txtpayterms" class="form-control input-sm" disabled>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="txtpayamount">Amount *</label>
                      <input type="text" id="txtpayamount" class="form-control input-sm" required data-error="Amount is required." disabled>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>

                </div>

                <!-- Button Row -->
                <div class="row btnadd-section">
                  <div class="col-md-12 text-right">
                    <label type="button" id="btnaddpay" class="btn btn-success">
                      <i class="fa fa-plus-circle"></i> Add Payment
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table id="table_payment" class="table m-0">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Payment ID</th>
                  <th>Mode of Payment</th>
                  <th>E-wallet Type</th>
                  <!-- <th>CC No.</th>
                  <th>CC Holder Name</th>
                  <th>CC Expiry Date</th>
                  <th>CC CVV</th> -->
                  <th>PDC No.</th>
                  <th>PDC Account Name</th>
                  <th>PDC Bank Name</th>
                  <th>PDC Date</th>
                  <th>Terms</th>
                  <th>Amount</th>
                  <th>Date</th>
                  <th class="col-action">Action</th>
                </tr>
                </thead>
                <tbody></tbody>
                </tfoot>
              </table>
              <table class="table m-0">
                <thead>
                  <tr>
                    <th style="text-align:right; background-color: #f4f4f4;">Total Premium:</th>
                    <th id="tfoot_tpremium" style="text-align:right; background-color: #f4f4f4;">0.00</th>
                    <th style="text-align:right; background-color: #f4f4f4;">Total Amount:</th>
                    <th id="tfoot_total" style="text-align:right; background-color: #f4f4f4;">0.00</th>
                    <th style="text-align:right; background-color: #f4f4f4;">Total Balance:</th>
                    <th id="tfoot_balance" style="text-align:right; background-color: #f4f4f4;">0.00</th>
                  </tr>
                </thead>
              </table>
              <p style="font-size:12px;font-style: italic;">
                <b>Note:</b> To modify or update a payment, double-click the row you wish to edit. After making the necessary changes in the input fields, click the ‘Add Payment’ button to save the updates to the payment list.
              </p>
            </div>
          </div>
        </div>
        <div class="box-footer with-border">
          <div class="pull-right">
            <button type="button" id="btneditpay" class="btn btn-success"><i class="fa fa-edit"></i> Edit</button>
            <button type="button" id="btnclosepay" class="btn btn-success"><i class="fa fa-close"></i> Close</button>
            <label type="button" id="btncancelpay" class="btn btn-success" style="display:none;"><i class="fa fa-ban"></i> Cancel</label>
            <label type="button" id="btnupdatepay" class="btn btn-success" style="display:none;"><i class="fa fa-save"></i> Update Info.</label>
          </div>
        </div>  
      </div>
    </div>
    <!-- END MODAL MODIFY PAYMENT INFO -->
    <!-- MODAL MODIFY CHANGE STATUS -->
    <div id="modal-modify-status" aria-hidden="false" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box box-solid">
        <div class="box-body" style="max-width:100%;">
          <div class="insurer-info">
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="cbotransstatus">Status *</label>
                      <select id="cbotransstatus" class="form-control input-sm" required="required" data-error="Status is required." disabled>
                        <option Value="">PLEASE SELECT</option>
                      </select>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="txttranssremarks">Remarks</label>
                      <textarea id="txttranssremarks" class="form-control input-sm" placeholder="Address here!" rows="2" disabled></textarea>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box-footer with-border">
          <div class="pull-right">
            <button type="button" id="btneditstatus" class="btn btn-success"><i class="fa fa-edit"></i> Edit</button>
            <button type="button" id="btnclosestatus" class="btn btn-success"><i class="fa fa-close"></i> Close</button>
            <button type="button" id="btncancelstatus" class="btn btn-success" style="display:none;"><i class="fa fa-ban"></i> Cancel</button>
            <button type="button" id="btnupdatestatus" class="btn btn-success" style="display:none;"><i class="fa fa-save"></i> Update</button>
          </div>
        </div>  
      </div>
    </div>
    <!-- END MODAL MODIFY CHANGE STATUS -->
    <!-- MODAL MODIFY NET REM -->
    <div id="modal-modify-netrem" aria-hidden="false" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box box-solid">
        <div class="box-body" style="max-width:100%;">
          <div class="insurer-info">
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="txtinsgpremium">Gross Premium *</label>
                      <input type="text" id="txtinsgpremium" class="form-control input-sm" required="required" data-error="Gross Premium is required." disabled>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="txtnetrem">Net Rem *</label>
                      <input type="text" id="txtnetrem" class="form-control input-sm" required="required" data-error="Net Rem is required." disabled>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="txtinscommission">Commission *</label>
                      <input type="text" id="txtinscommission" class="form-control input-sm" disabled>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box-footer with-border">
          <div class="pull-right">
            <button type="button" id="btneditnetrem" class="btn btn-success"><i class="fa fa-edit"></i> Edit</button>
            <button type="button" id="btnclosenetrem" class="btn btn-success"><i class="fa fa-close"></i> Close</button>
            <button type="button" id="btncancelnetrem" class="btn btn-success" style="display:none;"><i class="fa fa-ban"></i> Cancel</button>
            <button type="button" id="btnupdatenetrem" class="btn btn-success" style="display:none;"><i class="fa fa-save"></i> Update</button>
          </div>
        </div>  
      </div>
    </div>
    <!-- END MODAL MODIFY NET REM -->
    <!-- MODAL CALL STATUS -->
    <div id="modal-call" aria-hidden="false" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box box-solid">
        <div class="box-body" style="max-width:100%;">
          <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="row">
              <h4>Customer Information</h4>
              <hr class="newline">
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="txtinsuranceno">Insurance No.</label>
                      <input type="text" id="txtinsuranceno" class="form-control input-sm" disabled>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="txtsfcustname">Customer Name</label>
                      <textarea id="txtsfcustname" class="form-control input-sm" rows="2" disabled></textarea>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="txtsfcontactno">Contact No.</label>
                      <input type="text" id="txtsfcontactno" class="form-control input-sm" disabled>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="txtsfvin">VIN</label>
                      <input type="text" id="txtsfvin" class="form-control input-sm" disabled>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <h4>Call Status Information</h4>
                  <hr class="newline">
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="cbomodecomm">Mode of Communication *</label>
                      <select id="cbomodecomm" class="form-control input-sm" required="required" data-error="Call Status is required." disabled>
                        <option Value="">PLEASE SELECT</option>
                      </select>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="cbocallstatus">Call Status *</label>
                      <select id="cbocallstatus" class="form-control input-sm" required="required" data-error="Call Status is required." disabled>
                        <option Value="">PLEASE SELECT</option>
                      </select>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="cbocallreason">Call Reason *</label>
                      <select id="cbocallreason" class="form-control input-sm" required="required" data-error="Call Reason is required." disabled>
                        <option Value="">PLEASE SELECT</option>
                      </select>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="dpppdate">Promised Pay Date *</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input id="dpppdate" type="text" class="form-control input-sm pull-right" required="required" data-error="Promised Pay Date is required." disabled>
                      </div>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="txtcallremarks">Call Remarks</label>
                      <textarea id="txtcallremarks" class="form-control input-sm" placeholder="Call Remarks here!" rows="2" disabled></textarea>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
              </div>  
            </div>
          </div>
        </div>
        <div class="box-footer with-border">
          <div class="pull-right">
            <button type="button" id="btneditcall" class="btn btn-success"><i class="fa fa-edit"></i> Edit</button>
            <button type="button" id="btnclosecall" class="btn btn-success"><i class="fa fa-close"></i> Close</button>
            <button type="button" id="btncancelcall" class="btn btn-success" style="display:none;"><i class="fa fa-ban"></i> Cancel</button>
            <button type="button" id="btnupdatecall" class="btn btn-success" style="display:none;"><i class="fa fa-save"></i> Update</button>
          </div>
        </div>  
      </div>
    </div>
    <!-- END MODAL CALL STATUS -->
    <!-- MODAL CALL LOGS -->
    <div id="modal-logs" aria-hidden="false" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box">
        <!-- <div class="box-header with-border">
          <h3 class="box-title">Call Logs History</h3>
        </div> -->
        <div class="box-body">
          <div class="col-md-12">
            <table id="table_logs" class="table table-striped table-bordered table-hover nowrap" style="width:100%">
              <thead>
                <tr class="tableheader">
                  <th>No.</th>
                  <th>Call Log ID</th>
                  <th>Call Log Date</th>
                  <th>Insurance No.</th>
                  <th>Customer Name</th>
                  <th>Contact No.</th>
                  <th>VIN</th>
                  <th>Mode of Comm.</th>
                  <th>Call Status</th>
                  <th>Reason Desc</th>
                  <th>Promised Pay Date</th>
                  <th>Call Remarks</th>
                  <th>User Name</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- END MODAL CALL LOGS -->
  </section>
<!-- /.content-wrapper -->
</div>

@push('scripts')
<script>
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
</script>

<script>

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

</script>

{{-- <script type="text/javascript" src="{{ asset('tmia-assets/js/new_business.js') }}"></script> --}}
<script src="{{ asset('tmia-assets/js/laravel/new_business_laravel.js') }}"></script>
@endpush

</x-layouts.main>