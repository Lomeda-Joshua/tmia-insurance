<x-layouts.main>
    <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      New Business Insurance Information
    </h1>
    <ol class="breadcrumb">
      <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href=""><i class="fa fa-tasks"></i> Transactions</a></li>
      <li><a href="new_business"><i class="fa-solid fa-car"></i> New Business Insurance</a></li>
      <li class="active"><i class="fa fa-list-alt"></i> Modify Info.</li>
    </ol>
  </section>

  <!-- ========================================================================================================== -->
  <!-- Main content -->
  <section class="content">
    <!-- box -->
    <div class="box box-warning">
      <div class="box-header with-border">
        <h1 class="box-title" id="insurance-no" style="font-size: 20px; font-weight: 800; padding: 10px 20px;">TRANSACTION NO.:</h1>
      </div>
      <div class="box-body" style="max-width:100%;">
        <div class="nvi-modify">
          <!-- CUSTOMER INFO -->
          <div class="box customer-info">
            <div class="header">
              <h2 class="title" id="cust-title" tabindex="0">
                <i class="fa-regular fa-circle-user fa-xl"></i>
                Customer Information
              </h2>
              
              @if( Auth::user()->User_Level_ID == 1 || Auth::user()->User_Level_ID == 7 )
                <a id="btneditcust" class="edit-btn" aria-label="Edit Customer Information">
                  <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M3 17.25V21h3.75l11.065-11.065-3.75-3.75L3 17.25zM21.414 6.586a2 2 0 0 0 0-2.828l-1.172-1.172a2 2 0 0 0-2.828 0l-1.415 1.414 3.75 3.75 1.665-1.664z"/>
                  </svg>
                  Edit
                </a>
              @endif
            </div>

            <div class="fields">
              <div class="field">
                <div class="label">Name</div>
                <div class="value" id="custfullname">-</div>
              </div>
              <div class="field">
                <div class="label">Birth Date</div>
                <div class="value" id="custbirthdate">-</div>
              </div>
              <div class="field">
                <div class="label">TIN</div>
                <div class="value" id="custtin">-</div>
              </div>
              <div class="field">
                <div class="label">Contact No.</div>
                <div class="value" id="custcontactno">-</div>
              </div>
              <div class="field">
                <div class="label">Email Address</div>
                <div class="value" id="custemailadd">-</div>
              </div>
              <div class="field">
                <div class="label">Customer No.</div>
                <div class="value" id="custno">-</div>
              </div>
              <div class="field wide-field">
                <div class="label">Main Address</div>
                <div class="value" id="custaddress">-</div>
              </div>
            </div>
          </div>

          <!-- VEHICLE INFO -->
          <div class="box vehicle-info">
            <div class="header">
              <h2 class="title" id="veh-title" tabindex="0">
                <i class="fa-solid fa-car fa-xl"></i>
                Vehicle Information
              </h2>
              @if( Auth::user()->User_Level_ID == 1 || Auth::user()->User_Level_ID == 7 ))
              <a id="btneditveh" class="edit-btn" aria-label="Edit Vehicle Information" style="display:none;">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M3 17.25V21h3.75l11.065-11.065-3.75-3.75L3 17.25zM21.414 6.586a2 2 0 0 0 0-2.828l-1.172-1.172a2 2 0 0 0-2.828 0l-1.415 1.414 3.75 3.75 1.665-1.664z"/>
                </svg>
                Edit
              </a>
              @endif
            </div>

            <div class="fields">
              <div class="field">
                <div class="label">VIN</div>
                <div class="value" id="vehvin">-</div>
              </div>
              <div class="field">
                <div class="label">Make</div>
                <div class="value" id="vehmake">-</div>
              </div>
              <div class="field">
                <div class="label">Model</div>
                <div class="value" id="vehmodel">-</div>
              </div>
              <div class="field">
                <div class="label">Model Year</div>
                <div class="value" id="vehmodelyear">-</div>
              </div>
              <div class="field">
                <div class="label">Color</div>
                <div class="value" id="vehcolor">-</div>
              </div>
              <div class="field">
                <div class="label">Engine No.</div>
                <div class="value" id="vehengineno">-</div>
              </div>
              <div class="field">
                <div class="label">CS No</div>
                <div class="value" id="vehcsno">-</div>
              </div>
              <div class="field">
                <div class="label">Plate No</div>
                <div class="value" id="vehplateno">-</div>
              </div>
              <!-- <div class="field">
                <div class="label">Oder No.</div>
                <div class="value" id="vehorderno">-</div>
              </div>
              <div class="field">
                <div class="label">Oder Status</div>
                <div class="value" id="vehorderstatus">-</div>
              </div> -->
              <div class="field">
                <div class="label">Paid Price</div>
                <div class="value" id="vehsrp">-</div>
              </div>
              <div class="field">
                <div class="label">VSI Date</div>
                <div class="value" id="vehvsidate">-</div>
              </div>
              <div class="field">
                <div class="label">Released Date</div>
                <div class="value" id="vehreldate">-</div>
              </div>
              <div class="field">
                <div class="label">Technical Date</div>
                <div class="value" id="vehtechdate">-</div>
              </div>
              <!-- <div class="field">
                <div class="label">Model Sales Code</div>
                <div class="value" id="vehmsalescode">-</div>
              </div> -->
              <div class="field">
                <div class="label">Variant</div>
                <div class="value" id="vehvariant">-</div>
              </div>
              <div class="field">
                <div class="label">Body Type</div>
                <div class="value" id="vehbodytype">-</div>
              </div>
              <div class="field">
                <div class="label">Power Transmission</div>
                <div class="value" id="vehtransmission">-</div>
              </div>
              <div class="field">
                <div class="label">Fuel Type</div>
                <div class="value" id="vehfueltype">-</div>
              </div>
              <div class="field">
                <div class="label">Seats</div>
                <div class="value" id="vehseats">-</div>
              </div>
              <!-- <div class="field">
                <div class="label">Unloaded Weight</div>
                <div class="value" id="vehunloadweight">-</div>
              </div>
              <div class="field">
                <div class="label">Maximum Weight</div>
                <div class="value" id="vehmaxweight">-</div>
              </div> -->
              <div class="field">
                <div class="label">Product Classification</div>
                <div class="value" id="vehprodclass">-</div>
              </div>
              <div class="field">
                <div class="label">Owner Type</div>
                <div class="value" id="vehownertype">-</div>
              </div>
              <div class="field">
                <div class="label">Owner First Name</div>
                <div class="value" id="vehownername">-</div>
              </div>
              <div class="field">
                <div class="label">Marketing Professional</div>
                <div class="value" id="vehmpname">-</div>
              </div>
            </div>
          </div>

          <!-- INSURANCE CALCULATION -->
          <div class="box insurance-calc">
            <div class="header">
              <h2 class="title" id="veh-title" tabindex="0">
                <i class="fa fa-calculator fa-xl"></i>
                Insurance Calculations
              </h2>
              @if( Auth::user()->User_Level_ID == 1 || Auth::user()->User_Level_ID == 7 )
              <a id="btneditinscalc" class="edit-btn" aria-label="Edit Insurance Calculations">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M3 17.25V21h3.75l11.065-11.065-3.75-3.75L3 17.25zM21.414 6.586a2 2 0 0 0 0-2.828l-1.172-1.172a2 2 0 0 0-2.828 0l-1.415 1.414 3.75 3.75 1.665-1.664z"/>
                </svg>
                Edit
              </a>
              @endif
            </div>

            <div class="calc-row">
              <div class="calc-col">
                <div class="form-group">
                  <label for="rowgrosspremium">Gross Premium</label>
                  <input type="text" id="rowgrosspremium" value="0.00" disabled>
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="calc-col">
                <div class="form-group">
                  <label for="rownetremittance">Net Remittance</label>
                  <input type="text" id="rownetremittance" value="0.00" disabled>
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="calc-col">
                <div class="form-group">
                  <label for="rowcommission">Commission</label>
                  <input type="text" id="rowcommission" value="0.00" style="font-weight: bold;" disabled>
                  <div class="help-block with-errors"></div>
                </div>
              </div>
            </div>
            <!-- <hr> -->
            <!-- OPTIONS -->
            <div class="calc-row calc-options">
              <div class="calc-col">
                <label>Option Type</label>
                <div class="radio-group">
                  <label class="custom-radio">
                    <input type="radio" name="rowoptiontype" value="FREE" checked disabled>
                    <span class="checkmark"></span>
                    FREE
                  </label>
                  <label class="custom-radio">
                    <input type="radio" name="rowoptiontype" value="PAID" disabled>
                    <span class="checkmark"></span>
                    PAID
                  </label>
                </div>
              </div> 
            </div>
            <div class="calc-paid-section">
              <div class="calc-row calc-options">
                <div class="calc-col calc-payment">
                  <label class="custom-checkbox">
                    <input type="checkbox" id="rowpayment" disabled />
                    <span class="checkbox-icon"></span>
                    <span class="checkbox-label">Installment Payment</span>
                  </label>
                </div>
                <div class="calc-col calc-terms">
                  <div class="form-group">
                    <label for="rowterms">Terms (months)</label>
                    <input type="text" id="rowterms" disabled/>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
                <div class="calc-col calc-monthpay">
                  <div class="form-group">
                    <label for="rowmonthpay">Monthly Payment(₱/month)</label>
                    <input type="text" id="rowmonthpay" style="font-weight: bold;" disabled>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
              </div>
              <!-- <div class="calc-row calc-options">
                <div class="calc-col calc-nonvat">
                  <label class="custom-checkbox">
                    <input type="checkbox" id="rownonvat" disabled />
                    <span class="checkbox-icon"></span>
                    <span class="checkbox-label">Non-VAT</span>
                  </label>
                </div>
              </div>   -->
            </div> 
          </div>
          <!-- PAYMENT INFORMATION -->
          <div class="box payment-info">
            <div class="header">
              <h2 class="title" id="cust-title" tabindex="0">
                <i class="fa-solid fa-peso-sign fa-xl"></i>
                Payment Information
              </h2>
              @if( Auth::user()->User_Level_ID == 1 || Auth::user()->User_Level_ID == 7 ) 
              <a id="btneditpayment" class="edit-btn" aria-label="Edit Payment Information">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M3 17.25V21h3.75l11.065-11.065-3.75-3.75L3 17.25zM21.414 6.586a2 2 0 0 0 0-2.828l-1.172-1.172a2 2 0 0 0-2.828 0l-1.415 1.414 3.75 3.75 1.665-1.664z"/>
                </svg>
                Edit
              </a>
              @endif
            </div>
            <div class="table-responsive">
              <table id="table_paymentdisplay" class="table m-0">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Payment ID</th>
                  <th>Mode of Payment</th>
                  <th>E-wallet Type</th>
                  <th>Terms</th>
                  <th>Amount</th>
                  <th>Date</th>
                </tr>
                </thead>
                <tbody></tbody>
              </table>
              <table class="table m-0">
                <thead>
                  <tr>
                    <th style="text-align:right; background-color: #f4f4f4;">Total Premium:</th>
                    <th id="tfoot_tpremiumd" style="text-align:right; background-color: #f4f4f4;">0.00</th>
                    <th style="text-align:right; background-color: #f4f4f4;">Total Amount:</th>
                    <th id="tfoot_totald" style="text-align:right; background-color: #f4f4f4;">0.00</th>
                    <th style="text-align:right; background-color: #f4f4f4;">Total Balance:</th>
                    <th id="tfoot_balanced" style="text-align:right; background-color: #f4f4f4;">0.00</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <!-- INSURER INFO -->
              <div class="box insurer-info">
                <div class="header">
                  <h2 class="title" id="cust-title" tabindex="0">
                    <i class="fa fa-building-shield fa-xl"></i>
                    Insurer Information
                  </h2>
                  @if( Auth::user()->User_Level_ID == 1 || Auth::user()->User_Level_ID == 7 )
                  <a id="btneditinsurer" class="edit-btn" aria-label="Edit Insurer Information">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                      <path d="M3 17.25V21h3.75l11.065-11.065-3.75-3.75L3 17.25zM21.414 6.586a2 2 0 0 0 0-2.828l-1.172-1.172a2 2 0 0 0-2.828 0l-1.415 1.414 3.75 3.75 1.665-1.664z"/>
                    </svg>
                    Edit
                  </a>
                  @endif
                </div>

                <div class="fields">
                  <div class="field">
                    <div class="label">Insurance Type</div>
                    <div class="value" id="insurertype">-</div>
                  </div>
                  <div class="field">
                    <div class="label">Insurance Company </div>
                    <div class="value" id="insurercompany">-</div>
                  </div>
                  <div class="field">
                    <div class="label">Start / Inception Date</div>
                    <div class="value" id="insurersdate">-</div>
                  </div>
                  <div class="field">
                    <div class="label">Policy No.</div>
                    <div class="value" id="insurerpolicyno">-</div>
                  </div>
                  <div class="field">
                    <div class="label">Issue Date</div>
                    <div class="value" id="insurerissuedate">-</div>
                  </div>
                  <div class="field">
                    <div class="label">Policy Expiration Date</div>
                    <div class="value" id="insurerpexpiredate">-</div>
                  </div>
                  <div class="field">
                    <div class="label">Mortgage</div>
                    <div class="value" id="insurermortgage">-</div>
                  </div>
                  <!-- <div class="field">
                    <div class="label">Mortgage Address</div>
                    <div class="value" id="insurermortgageaddress">-</div>
                  </div> -->
                  <!-- <div class="field">
                    <div class="label">
                      <label>Insurance Promo Availment</label>
                    </div>
                    <div class="value">
                      <div class="radio-group">
                        <label class="custom-radio">
                          <input type="radio" name="insurerpromo" value="NO" checked disabled>
                          <span class="checkmark"></span>
                          No
                        </label>
                        <label class="custom-radio">
                          <input type="radio" name="insurerpromo" value="YES" disabled>
                          <span class="checkmark"></span>
                          Yes
                        </label>
                      </div>
                    </div>  
                  </div> -->
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <!-- FILE UPLOADS -->
              <div class="box file-upload">
                <div class="header">
                  <h2 class="title" id="cust-title" tabindex="0">
                    <i class="fa-solid fa-upload fa-xl"></i>
                    File Attachment Upload
                  </h2>
                </div>
                
                <p style="font-size: 12px; font-style: italic; border: 1px; background: #FFFFCC; padding: 10px;">
                <b>Note:</b> There are some restrictions or limitations on the files that are allowed to be uploaded.
                        Allowed File Extensions <b>(jpg, jpeg, png, webp, pdf, doc, docx, xls, xlsx, ppt, pptx)</b>.
                        Maximum file size limit per file for upload must be at least <b>5 MB</b>.
                        Maximum number of files being uploaded is only <b>5 files</b>.
                </p>
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="file">Select File</label>
                        <input id="file" name="file[]" type="file" accept=".jpg, .jpeg, .png, .webp, .pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx" multiple class="file-loading">
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                <div class="row btnall" hidden>
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <button type="button" id="btndownloadall" data-toggle="tooltip" data-placement="top" title="Download All" class="btn btn-success btn-sm"><i class="fa fa-download"></i> Download All</button>
                      <button type="button" id="btndeleteall" data-toggle="tooltip" data-placement="top" title="Delete All" class="btn btn-success btn-sm"><i class="fa fa-remove"></i> Delete All</button>
                    </div>
                  </div>  
                </div>
              </div> 
            </div>
          </div>

        </div>
      </div>
      <!-- / box-body -->
    </div>
    <!-- /box -->
    <!-- MODAL MODIFY CUSTOMER INFO -->
    <div id="modal-modify-cust" aria-hidden="false" aria-labelledby="modal-modify" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box box-solid">
        <div class="box-body" style="max-width:100%;">
          <div class="customer-info">
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="txtcustno">Customer No. *</label>
                      <div class="input-group input-group-sm">
                        <input type="text" id="txtcustno" class="form-control input-sm" required="required" data-error="Customer No. is required.">
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
                      <select id="cbogroup" class="form-control input-sm" required="required" data-error="Group is required.">
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
                        <textarea id="txtcustname" class="form-control input-sm" rows="2" required="required" data-error="Customer Name is required."></textarea>
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
                        <input type="text" id="txtcustfname" class="form-control input-sm" required="required" data-error="First Name is required.">
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="txtcustmname">Middle Name</label>
                        <input type="text" id="txtcustmname" class="form-control input-sm" placeholder="Optional">
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="txtcustlname">Last Name *</label>
                        <input type="text" id="txtcustlname" class="form-control input-sm" required="required" data-error="Last Name is required.">
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="txtcustsname">Suffix Name</label>
                        <input type="text" id="txtcustsname" class="form-control input-sm" placeholder="Optional Ex. Jr, II & etc.">
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
                        <input id="dpbirthdate" type="text" class="form-control input-sm pull-right">
                      </div>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="txttin">TIN *</label>
                      <input type="text" id="txttin" class="form-control input-sm" required="required" data-error="TIN is required.">
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="txtcontactno">Contact No. *</label>
                      <input type="text" id="txtcontactno" class="form-control input-sm" required="required" data-error="Contact No. is required.">
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
                      <textarea id="txtaddress" class="form-control input-sm" placeholder="Address here!" rows="3" required="required" data-error="Address is required."></textarea>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="cboregion">Region *</label>
                      <select id="cboregion" class="form-control input-sm" required="required" data-error="Region is required.">
                        <option Value="">PLEASE SELECT</option>
                      </select>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="cboprovince">Province *</label>
                      <select id="cboprovince" class="form-control input-sm" required="required" data-error="Province is required.">
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
                      <select id="cbocity" class="form-control input-sm" required="required" data-error="City / Municipal is required.">
                        <option Value="">PLEASE SELECT</option>
                      </select>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="cbobrgy">Barangay *</label>
                      <select id="cbobrgy" class="form-control input-sm" required="required" data-error="Barangay is required.">
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
                      <input type="text" id="txtzipcode" class="form-control input-sm" required="required" data-error="Zip Code / Postal Code is required.">
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="cbocountry">Country *</label>
                      <select id="cbocountry" class="form-control input-sm" required="required" data-error="Country is required.">
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
            <button type="button" id="btncancelcust" class="btn btn-success"><i class="fa fa-ban"></i> Cancel</button>
            <button type="button" id="btnupdatecust" class="btn btn-success"><i class="fa fa-save"></i> Update Info.</button>
          </div>
        </div>  
      </div>
    </div>
    <!-- END MODAL MODIFY CUSTOMER INFO -->
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
                  <input type="text" id="txtcustomersearch" class="form-control input-sm clearable" placeholder="Press <Enter> key or click icon search button to search." autocomplete="off">
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
            <button type="button" id="btncustselect" data-toggle="tooltip" data-placement="top" title="Go" class="btn btn-success"><i class="fa-solid fa-clipboard-check"></i> Go</button>
          </div>
        </div>  
      </div>
    </div>
    <!-- END MODAL CUSTOMER LIST -->
    <!-- MODAL MODIFY VEHICLE INFO -->
    <div id="modal-modify-veh" aria-hidden="false" aria-labelledby="modal-modify" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box box-solid">
        <div class="box-body" style="max-width:100%;"> 
          <div class="vehicle-info">
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="txtvin">VIN *</label>
                      <div class="input-group input-group-sm">
                        <input type="text" id="txtvin" class="form-control input-sm" required="required" data-error="VIN is required.">
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
                        <input id="dpreldate" type="text" class="form-control input-sm pull-right" required="required" data-error="Released Date is required.">
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
                        <input id="dptechdate" type="text" class="form-control input-sm pull-right">
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
              </div>
            </div>
          </div>
        </div>
        <div class="box-footer with-border">
          <div class="pull-right">
            <button type="button" id="btncancelveh" class="btn btn-success"><i class="fa fa-ban"></i> Cancel</button>
            <button type="button" id="btnupdateveh" class="btn btn-success"><i class="fa fa-save"></i> Update Info.</button>
          </div>
        </div>  
      </div>
    </div>
    <!-- END MODAL MODIFY VEHICLE INFO -->
    <!-- MODAL VEHICLE LIST -->
    <div id="modal-vehiclelist" aria-hidden="false" aria-labelledby="modal-upload" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box">
        <!-- <div class="box-header with-border">
          <h2 class="box-title">Vehicle List</h2>
        </div> -->
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
        <div class="box-footer with-border">
          <div class="pull-right">
            <button type="button" id="btnvehselect" data-toggle="tooltip" data-placement="top" title="Go" class="btn btn-success"><i class="fa-solid fa-clipboard-check"></i> Go</button>
          </div>
        </div>  
      </div>
    </div>
    <!-- END MODAL VEHICLE LIST -->
    <!-- MODAL MODIFY INSURANCE CALCULATION -->
    <div id="modal-modify-calc" aria-hidden="false" aria-labelledby="modal-modify" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box box-solid">
        <div class="box-body" style="max-width:100%;">
          <div class="insurance-calc">
            <form>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="txtgrosspremium">Gross Premium *</label>
                    <input type="text" id="txtgrosspremium" class="form-control input-sm" value="0.00" required="required" data-error="Gross Premium is required.">
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="txtnetremittance">Net Remittance *</label>
                    <input type="text" id="txtnetremittance" class="form-control input-sm" value="0.00" required="required" data-error="Net Remittance is required.">
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="txtcommission">Commission *</label>
                    <input type="text" id="txtcommission" class="form-control input-sm" value="0.00" style="font-weight: bold; background: #F3F3F3;" required="required" data-error="Commission is required.">
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
              <table class="installment-section">
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
                  <!-- <tr>
                    <td data-label="" style="text-align: left;">
                      <label class="custom-checkbox">
                        <input type="checkbox" id="chknonvat"/>
                        <span class="checkbox-icon"></span>
                        <span class="checkbox-label">Non-VAT</span>
                      </label>
                    </td>
                  </tr> -->
                </tbody>
              </table>
            </form>
          </div>
        </div>
        <div class="box-footer with-border">
          <div class="pull-right">
            <button type="button" id="btncancelcalc" class="btn btn-success"><i class="fa fa-ban"></i> Cancel</button>
            <button type="button" id="btnupdatecalc" class="btn btn-success"><i class="fa fa-save"></i> Update Info.</button>
          </div>
        </div>  
      </div>
    </div>
    <!-- END MODAL MODIFY INSURANCE CALCULATION -->
    <!-- MODAL MODIFY INSURER INFO -->
    <div id="modal-modify-ins" aria-hidden="false" aria-labelledby="modal-modify" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box box-solid">
        <div class="box-body" style="max-width:100%;">
          <div class="insurer-info">
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="cboinstype">Insurance Type *</label>
                      <select id="cboinstype" class="form-control input-sm" required="required" data-error="Insurance Type is required.">
                        <option Value="">PLEASE SELECT</option>
                      </select>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="cboinsco">Insurance Company *</label>
                      <select id="cboinsco" class="form-control input-sm" required="required" data-error="Insurance Company is required.">
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
          <div class="pull-right">
            <button type="button" id="btncancelins" class="btn btn-success"><i class="fa fa-ban"></i> Cancel</button>
            <button type="button" id="btnupdateins" class="btn btn-success"><i class="fa fa-save"></i> Update Info.</button>
          </div>
        </div>  
      </div>
    </div>
    <!-- END MODAL MODIFY INSURER INFO -->
    <!-- MODAL MODIFY PAYMENT INFO -->
    <div id="modal-modify-pay" aria-hidden="false" aria-labelledby="modal-modify" role="dialog" class="iziModal isAttached hasScroll">
      <div class="box box-solid">
        <div class="box-body" style="max-width:100%;">
          <div class="payment-info">
            <div class="row">
              <div class="col-md-12">
                <div class="row pay-section">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="cbopaytype">Payment Type *</label>
                      <select id="cbopaytype" class="form-control input-sm" required data-error="Payment Type is required.">
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
                            <input type="text" id="txtccno" class="form-control input-sm" required data-error="Card No. is required.">
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="txtccholder">Holder Name *</label>
                            <input type="text" id="txtccholder" class="form-control input-sm" required data-error="Holder Name is required.">
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="txtccexpirydate">Expiry Date (MM/YY) *</label>
                            <input type="text" id="txtccexpirydate" class="form-control input-sm" required data-error="Expiry Date is required.">
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="txtccvv">CVV / CVC *</label>
                            <input type="text" id="txtccvv" class="form-control input-sm" required data-error="CVV / CVC is required.">
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
                            <input type="text" id="txtpdcno" class="form-control input-sm" required data-error="Check No. is required.">
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="txtpdcholdername">Account Holder Name *</label>
                            <input type="text" id="txtpdcholdername" class="form-control input-sm" required data-error="Account Holder Name is required.">
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="txtpdcbankname">Bank Name *</label>
                            <input type="text" id="txtpdcbankname" class="form-control input-sm" required data-error="Bank Name is required.">
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
                              <input id="dppdccheckdate" type="text" class="form-control input-sm pull-right"  required="required" data-error="Check Date is required.">
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
                        <select id="cboewallet" class="form-control input-sm" required data-error="E-Wallet Type is required.">
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
                      <input type="text" id="txtpayamount" class="form-control input-sm" required data-error="Amount is required.">
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
                  <th>Action</th>
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
            <label type="button" id="btncancelpay" class="btn btn-success"><i class="fa fa-ban"></i> Cancel</label>
            <label type="button" id="btnupdatepay" class="btn btn-success"><i class="fa fa-save"></i> Update Info.</label>
          </div>
        </div>  
      </div>
    </div>
    <!-- END MODAL MODIFY PAYMENT INFO -->
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


    window.LaravelRoutes = {
      csrfToken: "{{ csrf_token() }}",
      nbpendingcounts: @json(route('new_business.counts')),
      loadSelectedCustomer : @json(route('customer.get-by-no')),
      loadVehicle: @json(route('vehicle.search')),
      loadModifyPage: @json(route('getModifyView.data'))
    }

    window.SaveRoute = {
      saveFileUpload : @json(route('getModifyView.data'))
    }

    window.fetchData = {
      variableData : @json(route('getSession.variables')),
      getInsuranceNo : @json(route('transactions.get-by-insurance-no')),
      customerData: @json(route('customers.data')),
      vehicleInfo: @json(route('customercvehicleinfo.data')),
      getPaymentData: @json(route('payments.get-data')),
      getCustomerSpecificData : @json(route('getSpecificView.data'))
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

      searchVehicle: @json(route('vehicle.search')),
    }

    // Safely pass the Laravel session variable into JavaScript
    let insuranceno = @json(session('insuranceno', ''));
    console.log("Insurance No:", insuranceno);

    document.addEventListener("DOMContentLoaded", function() {
        // Function to adjust layout (columns visibility based on view)
        function adjustLayout() {
            let calcCols = document.querySelectorAll('.nvi-modify .insurance-calc .calc-col');
            let isMobile = window.innerWidth <= 768;

            calcCols.forEach(function(col) {
                if (isMobile) {
                    // Check if text content is empty and no inputs/checkboxes are inside
                    let hasText = col.textContent.trim().length > 0;
                    let hasInputs = col.querySelector('input, select, textarea, button') !== null;

                    if (!hasText && !hasInputs) {
                        col.style.display = 'none'; // Hide empty columns
                    } else {
                        col.style.display = 'block'; // Show filled columns
                    }
                } else {
                    // Show all columns on desktop view
                    col.style.display = '';
                }
            });
        }

        // Adjust layout on page load
        adjustLayout();

        // Adjust layout on window resize
        window.addEventListener('resize', adjustLayout);
    });
</script>

<script type="text/javascript" src="{{ asset("tmia-assets/js/laravel/new_business_modify_laravel.js") }}"></script>
@endpush

</x-layouts.main>   

