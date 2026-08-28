<x-layouts.main>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Customer List
    </h1>
    <ol class="breadcrumb">
      <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href=""><i class="fa fa-tasks"></i> Transactions</a></li>
      <li class="active"><i class="fa fa-list-alt"></i> Customer List</li>
    </ol>
  </section>

  <!-- ========================================================================================================== -->
  <!-- Main content -->
  <section class="content">
    <!-- box -->
    <div class="box box-warning">
      <div class="box-body">
        <div class="box-body" style="max-width:100%;">
          
          @if (Auth::user()->User_Level_ID == 1 || Auth::user()->User_Level_ID == 7 )
            <div class="row btnactionud">
              <div class="col-md-12">
                <button type="submit" class="btn btn-success pull-left" id="btnadd" style="display: block;"><i class="fa fa-plus"></i> Add Data</button>
                <button type="submit" class="btn btn-success pull-right" id="btnupload" style="display: block;"><i class="fa fa-upload"></i> Import Excel File</button>
              </div>
            </div>
          @endif
          
          <div class="box center">
            <div class="box-body">
              <div class="row">
                <div class="col-md-6" style="padding: 0; margin-bottom: 5px;">
                  <div class="form-group">
                    <label>Search </label>
                    <div class="input-group input-group-sm">
                      <input type="text" id="txtsearch" class="form-control input-sm clearable" placeholder="Press <Enter> key or click icon search button to search." autocomplete="off">
                      <span class="input-group-btn">
                        <button type="button" id="btnfind" class="btn btn-success btn-flat"><i class="fa fa-search"></i></button>
                      </span>
                    </div>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
              </div>  
              <div class="alphabet-buttons" id="alphabet-container"></div>  
            </div>
          </div>
          <br>
          <table id="table_trans" class="table table-striped table-bordered table-hover">
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
                <th>Remarks</th>
                <th>Status</th>
                <th>Inactive Date</th>
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
                  <button type="button" id="btndelete" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-success btn-sm" style="display:none;"><i class="fa fa-remove"></i> Delete</button>
                  <button type="button" id="btnprint" data-toggle="tooltip" data-placement="top" title="Print" class="btn btn-success btn-sm" style="display:none;"><i class="fa fa-print"></i> Print</button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="txtcustno">Customer No. *</label>
                  <input type="text" id="txtcustno" class="form-control input-sm" required="required" data-error="Customer No. is required." disabled>
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
                    <input id="dpbirthdate" type="text" class="form-control input-sm pull-right" disabled>
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
            <div class="row">
              <div class="col-md-12">
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
     <!-- MODAL Vehicle List -->
    <div id="modal-vehlist" aria-hidden="false" aria-labelledby="modal-upload" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box">
        <div class="box-header with-border">
          <h2 class="box-title">Vehicle Owned List</h2>
          <button type="submit" class="btn btn-success pull-right" id="btnaddveh" style="display:none;"><i class="fa fa-plus"></i> Add Vehicle</button>
        </div>
        <div class="box-body">
          <table id="table_vehlist" class="table table-striped table-bordered table-hover nowrap" style="width:100%">
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
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    <!-- END MODAL Vehicle List -->
    <!-- MODAL MODIFY VEHICLE -->
    <div id="modal-modifyveh" aria-hidden="false" aria-labelledby="modal-modify" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box box-solid">
        <div class="box-body" style="max-width:100%;">
          <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div id="viewactionveh" class="row" hidden>
              <div class="col-md-12 cellborder">
                <label><u>Modify Button</u></label>
                <div class="col-md-12">
                  <button type="button" id="btneditveh" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Edit</button>
                  <button type="button" id="btndeleteveh" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-success btn-sm" style="display:none;"><i class="fa fa-remove"></i> Delete</button>
                  <button type="button" id="btnprintveh" data-toggle="tooltip" data-placement="top" title="Print" class="btn btn-success btn-sm" style="display:none;"><i class="fa fa-print"></i> Print</button>
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
                  <label for="txtremarksveh">Remarks</label>
                  <textarea id="txtremarksveh" class="form-control input-sm" placeholder="Remarks here!" rows="2" disabled></textarea>
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-12" id="viewactionveh1" hidden>
                <div class="col-md-6">
                  <!-- Nothing here -->
                </div>
                <div class="col-md-6 cellborder" style="margin-top: 10px;">
                  <label><u>Save & Cancel Buttons</u></label>
                  <div class="col-md-12">
                    <button type="button" id="btnsaveveh" data-toggle="tooltip" data-placement="top" title="Save" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
                    <button type="button" id="btncancelveh" data-toggle="tooltip" data-placement="top" title="Cancel" class="btn btn-success btn-sm" style="display:none;"><i class="fa fa-ban"></i> Cancel</button>
                    <button type="button" id="btncloseveh" data-toggle="tooltip" data-placement="top" title="Close" class="btn btn-success btn-sm" style="display:none;"><i class="fa fa-close"></i> Close</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END MODAL MODIFY VEHICLE -->
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
              Entries labeled as <b>FAILED</b> could not be uploaded due to an error during processing.
            </p>
            <div class="row">
              <div class="col-md-12">
                <label style="font-weight:bold">LEGEND&emsp;</label>
                <span class="label" style="background-color:green;" id="cntgood">GOOD : 0 Record(s)</span>
                <span class="label" style="background-color:blue;" id="cntupdated">UPDATED : 0 Record(s)</span>
                <span class="label" style="background-color:red;" id="cntfailed">FAILED : 0 Record(s)</span>
                <span class="label" style="color:black;" id="cnttotal">TOTAL : 0 Record(s)</span>
              </div>
            </div>
            <br>
            <!-- <h4 class="box-title"><center>Showing only records with <b>UPDATED</b>, <b>DUPLICATE</b> or <b>FAILED</b> Status.</center></h4> -->
            <table id="table_upload" class="table table-striped table-bordered table-hover nowrap" style="width:100%">
              <thead>
                <tr class="tableheader">
                  <th>#</th>
                  <th>Customer No.</th>
                  <th>Group</th>
                  <th>Full Name</th>
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Last Name</th>
                  <th>suffix Name</th>
                  <th>Birth Date</th>
                  <th>TIN</th>
                  <th>Contact No.</th>
                  <th>Email Address</th>
                  <th>Address</th>
                  <th>Reg Code</th>
                  <th>Prov Code</th>
                  <th>CityMun Code</th>
                  <th>Brgy Code</th>
                  <th>Zip Code</th>
                  <th>Country</th>
                  <th>VIN</th>
                  <th>Make</th>
                  <th>Model</th>
                  <th>Model Year</th>
                  <th>Color</th>
                  <th>Engine No.</th>
                  <th>CS No.</th>
                  <th>Plate No.</th>
                  <th>SRP</th>
                  <th>VSI Date</th>
                  <th>Released Date</th>
                  <th>Variant</th>
                  <th>Body Type</th>
                  <th>Transmission</th>
                  <th>Fuel Type</th>
                  <th>Seats</th>
                  <th>Product Class</th>
                  <th>Owner Type</th>
                  <th>Owner First Name</th>
                  <th>Marketing Professional</th>
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
     <!-- MODAL HISTORY -->
    <div id="modal-history" aria-hidden="false" aria-labelledby="modal-history" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Vehicle List</h3>
        </div>
        <div class="box-body">
          <div class="col-md-12">
            <table id="table_history" class="table table-striped table-bordered table-hover nowrap" style="width:100%">
              <thead>
                <tr class="tableheader">
                  <th>No.</th>
                  <th>Order No.</th>
                  <th>Doc Date</th>
                  <th>Job Type</th>
                  <th>Job Description</th>
                  <th>Plate No.</th>
                  <th>KM Reading</th>
                  <th>SA Name</th>
                  <th>VIN</th>
                  <th>Vehicle Model Description</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- END MODAL HISTORY -->
    <!-- MODAL SAVING -->
    <div id="modalsaving" aria-hidden="false" aria-labelledby="modal-upload" role="dialog" class="iziModal isAttached hasScroll">
      <h4 class="modal-title" style="text-align:center;">Saving data!</h4>

      <div class="loader-container">
        <div class="loader"></div> <!-- Only the circle spins -->
        <!-- <div class="loader-text">
          <span id="uploadPercentage">0%</span>
        </div> -->
      </div>

      <hr>
      <p style="text-align:center;">Please wait while saving data...</p>
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

    const container = document.getElementById('alphabet-container');

    // Function to create a button
    function createButton(label, isActive = false) {
      const button = document.createElement('button');
      button.textContent = label;
      if (isActive) {
        button.classList.add('active');
      }
      button.addEventListener('click', () => {
        document.querySelectorAll('.alphabet-buttons button').forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
        // You can add your custom action here (e.g., filter items)
        btnselect = `${label}`;
        // LoadCustomerData();
      });
      return button;
    }

    // Add "All" button first
    container.appendChild(createButton("ALL"));

    // Add A-Z buttons
    for (let i = 65; i <= 90; i++) {
      const letter = String.fromCharCode(i);
      const isActive = letter === 'A'; // Set "A" as default
      container.appendChild(createButton(letter, isActive));
    }

    // Add Other button first
    container.appendChild(createButton("[0-9]"));
    container.appendChild(createButton("[SPECIAL CHAR]"));

    btnselect = 'A';
    // LoadCustomerData();


    $(document).ready(function() {

        /* MODAL MODIFY */
        $("#modal-modify").iziModal({
          title: 'Customer Information Details',
          subtitle: 'Fill out all details required here.',
          headerColor: 'linear-gradient(0deg, #505050, #bbb, #505050)',
          icon: 'fa-regular fa-circle-user',
          iconColor: '#000',
          zindex: 9999,
          width: 600,
          padding: 20,
          radius: 10,
          focusInput: true,
          loop: true,
          arrowKeys: true,
          navigateCaption: true,
          navigateArrows: true, // Boolean, 'closeToModal', 'closeScreenEdge'
          //history: true,
          //restoreDefaultContent: true,
          fullscreen: true,
          // openFullscreen: true,
          overlay: true,
          overlayClose: false,
          overlayColor: 'rgba(0, 0, 0, 0.4)',
          transitionIn: 'bounceInDown',
          transitionOut: 'bounceOutDown',
          transitionInOverlay: 'fadeIn',
          transitionOutOverlay: 'fadeOut',
          onResize: function(modal){
            // console.log(modal.modalHeight);
          },
          afterRender: function(modal){
            // modal.open();
          }
        });

        $(document).on( "click", "#btnadd", function () {
          // newdata = true;
          // transid = '';
          // editinfo = true;
          // FormClear();
          // FormDisable(false);
          $('#modal-modify').iziModal('open');
        });

        $('#table_trans').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('customer.data') }}", // Update to your defined route name
                type: "GET",
                data: function (d) {
                    // Attach custom request parameters for search and letter filtering
                    d.search = $('#txtsearch').val(); 
                    d.letter = $('#selected_letter').val(); 
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'Customer_No', name: 'Customer_No' },
                { data: 'Group', name: 'Group', defaultContent: '' },
                { data: 'Full_Name', name: 'Full_Name' },
                { data: 'Birth_Date', name: 'Birth_Date', defaultContent: '' },
                { data: 'Contact_No', name: 'Contact_No', defaultContent: '' },
                { data: 'Email_Address', name: 'Email_Address', defaultContent: '' },
                { data: 'Address', name: 'Address', defaultContent: '' },
                { data: 'Remarks', name: 'Remarks', defaultContent: '' },
                { data: 'Active_Status', name: 'Active_Status', defaultContent: 'INACTIVE' },
                { data: 'Inactive_Date', name: 'Inactive_Date', defaultContent: '' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[1, 'asc']]
        });

        // Handler for View Vehicle button click (.btnvehicle)
        $(document).on('click', '.btnvehicle', function () {
            var custNo = $(this).attr('custno');
            console.log('View Vehicle for Customer No:', custNo);
            // Add your legacy vehicle modal or redirection logic here
        });

        // Handler for View & Modify button click (.btnedit)
        $(document).on('click', '.btnedit', function () {
            var custNo = $(this).attr('custno');
            console.log('View & Modify Customer No:', custNo);
            // Add your legacy edit modal or redirection logic here
        });

        // Re-bind Bootstrap Tooltips every time DataTables redraws
        $('#table_trans').on('draw.dt', function () {
            $('[data-toggle="tooltip"]').tooltip();
        });


        function FormClear() {
            // 1. Reset all text/number inputs, textareas, and default native selects inside the container
            $('#modal-modify').find('input, textarea, select').val('');

            // 2. Clear & trigger updates for all Select2 dropdowns at once
            $('#modal-modify select').val('').trigger('change.select2');

            // 3. Set default fallback value for country
            $('#cbocountry').val('PHILIPPINES').trigger('change.select2');

            // 4. Reset form validation UI state
            $('.box-body').validator('reset');
        }

        
        const userLevel = {{ Auth::user()?->User_Level_ID ?? 'null' }}; 

        function FormDisable(val) {
            // 1. Role-restricted view toggles (e.g., 1 = Administrator, 7 = Insurance Staff)
            if (userLevel === 1 || userLevel === 7) {
                if (val) {
                    $("#viewaction").show().removeAttr("hidden");
                    $("#viewaction1").hide();
                } else {
                    $("#viewaction").hide();
                    $("#viewaction1").show().removeAttr("hidden");
                }
            }

            // 2. Dynamic button visibility check
            if (typeof newdata !== 'undefined' && newdata === true) {
                $("#btncancel").hide();
                $("#btnclose").show().removeAttr("hidden");
            } else {
                $("#btncancel").show().removeAttr("hidden");
                $("#btnclose").hide();
            }

            // 3. Disable/Enable all modal form fields at once (Replaces 20+ individual lines)
            $('#modal-modify').find('input, select, textarea').prop('disabled', val);

            // 4. Reset validation UI state
            $('.box-body').validator('reset');
        }



    });
</script>
@endpush

</x-layouts.main>

