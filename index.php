<html>
  <head>
    <?php include('templates/head.html'); ?>
  </head>
  <body onload="Index_Reset();">
    <?php
      // DB Connection
      include('config.php');
      $query = new SQL();
      // Navbar
      include('templates/navbar.html');
    ?>
<!-- Page Content -->
<div class='container' >
  <!-- Saved Info Bar -->
  <div  class='row' >
    <div class='col-md-8'>
      <!-- ADTF Info -->
      <div id="adtfInfo">
	   <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#" onClick="NewLoadID();"><b>New Load ID</b></a></li>
          <li><a data-toggle="tab" href="#" onClick="ExistingLoadID();"><b>Existing Load ID</b></a></li>

        </ul>
        <form id="frmInfo">
          <div class='well well-sm' id="manual">
            <div class='row'>
              <!-- Vendor -->
              <div class='form-group col-md-12'>
                <label class='required' for="txt_Vendor1">Vendor:</label>
                <input class='form-control input-lg'  type="text" id="txt_Vendor" name="txt_Vendor" autocomplete="off" placeholder="Select Vendor..." required/>
                <div id="VendorList"></div>
              </div>
              <!-- Date -->
              <div class='form-group col-md-6'>
                <label class='required' for="txt_DateSubmitted">Date Submitted:</label>
                <input class='form-control input-lg' type="date" id="datepicker1" name='txt_DateSubmitted' required/>
              </div>
              <!-- SOW -->
              <div class='form-group col-md-6'>
                <label for="txt_StatementOfWork">Statement of Work:</label>
                <input class='form-control input-lg' type="text" id="txt_StatementOfWork1" name="txt_StatementOfWork" autocomplete="off" placeholder="Enter Statement of Work..." />
              </div>
              <!-- Pallets -->
              <div class='form-group col-md-6'>
                <label class='required' for="txt_NumberOfPallets">Number of Pallets:</label>
                <input class='form-control input-lg' type="number" id="txt_NumberOfPallets1" name="txt_NumberOfPallets" autocomplete="off"  placeholder="Number of Pallets..."  />
              </div>
              <!-- Load ID -->
              <div class='form-group col-md-6' id="div_WO">
                <label for="txt_WO1">Load ID ( JIRA WO # ): <i class='fa fa-fw fa-lg fa-question-circle blue-bb' aria-hidden="true" style='cursor:pointer;' onclick="infoModal('loadID');" data-toggle="modal" data-target="#myModal3_WOVendor"></i></label>
                <input type="text" id="txt_WO1" name="txt_WO" class='form-control input-lg' placeholder="JIRA WO #" autocomplete="off"  />
				<div id="WOList"></div>
              </div>
              <!-- Pickup -->
              <div class='form-group col-md-12'>
                <label class='required' for="txt_PickupLocation">Pickup Location:</label>
                <input class='form-control input-lg' type="text" id="txt_PickupLocation" name="txt_PickupLocation" autocomplete="off"  placeholder="Enter Pickup Location..."  required />
                <div id="LocationList"></div>
              </div>
              <!-- Contact -->
              <div class='form-group col-md-12'>
                <label class='required' for="txt_LocalRIMContact">Local BB Contact:</label>
                <textarea class='form-control input-lg' id="txt_LocalRIMContact1" name="txt_LocalRIMContact" rows="2"  placeholder="Enter Local BlackBery Contact..." required></textarea>
              </div>
              <!-- Start Button -->
              <div class='form-group col-md-12 text-right'>
                <!-- <button type='submit' name="submit" onclick='start();' class='btn btn-success btn-lg' style='width:100%; height:60px; font-weight:800;'>START</button> -->
                <button type='submit' class='btn btn-success btn-lg' style='width:100%; height:60px; font-weight:800;'>START</button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- end adtfInfo -->
      <div id='savedInfo' class='col-md-12 well' style='display:none;'>
      <div>
        <h3 class='text-medium'>LOAD INFO:</h3>
        <hr>
        <div class='col-md-12'>
          <p class='bigger-font-bb text-medium bolder'>Vendor: <br><text class='text-muted' id="vendorInfo"></text></p>
        </div>
		      <!-- Date -->
          <div class='col-md-4'>
                <p class='bigger-font-bb text-medium bolder'>Date Submitted: <br><text class='text-muted'id="datesubmittedInfo"></text></p>
          </div>
            <!-- SOW -->
            <div class='col-md-4'>
                  <p class='bigger-font-bb text-medium bolder'>SOW: <br><text class=' text-muted'id="sow"></text></p>
            </div>
            <br>
		       <!-- Pallets -->
           <div class='col-md-4'>
                 <p class='bigger-font-bb text-medium bolder'># Pallets: <br><text class=' text-muted 'id="nop"></text></p>
           </div>
            <!-- Load ID -->
            <div class='col-md-4'>
                  <p class='bigger-font-bb text-medium bolder'>Load ID (WO #): <br><text class=' text-muted' id="wo"></text></p>
            </div>
            <!-- Pickup -->
            <div class='col-md-4'>
                  <p class='bigger-font-bb text-medium bolder'>Pickup Location:<br><text class=' text-muted' id="pickup"></text></p>
            </div>
            <!-- Contact -->
            <div class='col-md-4'>
                  <p class='bigger-font-bb text-medium bolder'>Local BB Contact: <br><text class=' text-muted' id="contact"></text></p>
            </div>
          </div>
        </div>
        </div>
    <!-- Top Right Section -->
    <div id='ADTFstatus' class='col-md-4'>
      <!-- Commit ADTF -->
      <div class='col-md-12 row spacer-b'>
        <button id="datatable" class='btn btn-lg btn-primary' data-toggle="modal" data-target="#myModal1" style='width:100%; font-weight:800;'>GENERATE ADTF</button>
      </div>
      <div id='instructions' class='col-md-12'>
        <div class="alert alert-info" role="alert">
          <div id="startHelp">
            <p class='bolder bigger-font-bb'><i class='fa fa-bullhorn fa-lg fa-fw'></i> GETTING STARTED:</p>
            <ul>
              <li class='big-font-bb'>Fill out the form on the left, ensuring to fill in all of the required ( <font class='red-bb bolder' style='font-size:1.3em; vertical-align:text-top;'>*</font> ) fields.</li>
              <li class='big-font-bb'><p>For more information on ADTF Load ID #s - click the here.<i class='fa fa-fw fa-lg fa-question-circle blue-bb' aria-hidden="true" style='cursor:pointer;' onclick="infoModal('loadID');" data-toggle="modal" data-target="#myModal3_WOVendor"></i></p></li>
              <li class='big-font-bb'><p>Click the <b class='bolder'>START</b> button to begin.</p></li>
            </ul>
          </div>
          <div id="scanHelp" hidden>
            <p class='bolder bigger-font-bb'><i class='fa fa-barcode fa-lg fa-fw'></i> SCANNING ASSETS:</p>
            <ul>
              <li class='big-font-bb'>Enter serial number or asset ID and hit the search button to add assets.</li>
              <li class='big-font-bb'>If a valid record is found in the CMDB, additional information will be populated for you.</li>
              <li class='big-font-bb'>If using a scanner, set the suffix to tab to automatically search after scanning.</li>
            </ul>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Columns -->
  <div class='row'>
    <div class='col-md-12'>
    <!-- Left Column -->
    <div class='col-md-8' id="search" class='' style='display:none;'>
      <!-- Asset Search -->
      <form>
        <!-- Tabs -->
        <div class='col-md-10 well'>
    	   <div >
            <ul class="nav nav-tabs nav-justified bolder spacer-t-sm" style='font-size: 1.3em;'>
             <li id="indi">
                <a href="#" onClick="ShowIndividual();"><i class='fa fa-cube fa-fw fa-lg'></i> Individual Assets</a>
              </li>
             <li id="blk">
               <a href="#" onClick="ShowBulk();"><i class='fa fa-cubes fa-fw fa-lg'></i> Bulk Assets</a>
              </li>
           </ul>
             <!-- Search Box -->
            <div id='indvAssets' class='col-md-12 spacer-b' style='margin-top:20px;'>
              <form name="frm_search" id="frm_search" class='form'>
                <!-- Search -->
                <div class='col-md-10'>
                  <input
                    type="text"
                    style="height:60px; font-size:2em;"
                    placeholder="Enter Asset ID / Serial"
                    class='form-control input-lg'
                    name="txt_ID" id="txt_ID"
      	            onkeyup="DisableADTF();"
                    autocomplete="off"
                    autofocus
                  />
                </div>
                <div class='col-md-2'>
                  <button type="button" name="search_data" class="btn btn-lg btn-primary" onclick="search_ID();" style='height:60px; min-width:0px;'><i class="fa fa-search" style='font-size:38px; margin-right:0px;'></i></button>
          		  </div>
                <!-- Hidden Data Fields -->
          		  <div id="ind" style="display:none;">
            		  <div class='form-group'>
                    <input type="hidden" class='form-control input-lg' name="txt_AssetType" id="search-box" size="40" placeholder="Asset Type" autocomplete="off" value="" />
                  </div>
                  <div class='form-group'>
                    <input type="hidden" class='form-control input-lg' name="txt_Manufacturer" id="Manufactsearch-box1" size="40" placeholder="Manufacturer" autocomplete="off" value="" />
                  </div>
                  <div class='form-group'>
                    <input type="hidden" class='form-control input-lg' name="txt_Model" id="txt_Model1" placeholder="Model" size="40" autocomplete="off" value="" />
                  </div>
                  <div class='form-group'>
                    <input type="hidden" id="txt_AssetID1" class='form-control input-lg' name="txt_AssetID" onMouseOver="this.focus();" size="40" autocomplete="off" value="" autofocus />
                  </div>
                  <div class='form-group'>
                    <input type="hidden" id="txt_SerialNo1" name="txt_SerialNo" class='form-control input-lg' onMouseOver="this.focus();" size="40" autocomplete="off" value=""  />
                  </div>
          	    </div>
              </form>
            </div>
            <!-- Bulk Assets Tab -->
            <div id='bulkAssets'>
             <div class='spacer-t col-md-12'>
               <div class='form-group'>
                  <label for="search-box">Asset Type:</label>
                  <select id="search-box1" class='form-control input-lg'>
                	  <option <?php if($AssetType=='Cables') echo 'selected'; ?>>Cables</option>
                	  <option <?php if($AssetType=='Keyboards') echo 'selected'; ?>>Keyboards</option>
                	  <option <?php if($AssetType=='Mice') echo 'selected'; ?>>Mice</option>
                	  <option <?php if($AssetType=='Others') echo 'selected'; ?>>Others</option>
                 </select>
               </div>
               <div class='form-group'>
                 <label for="txt_Description">Description:</label>
                 <input type="text" class='form-control input-lg' autocomplete="off" id="txt_Description" name="txt_Description" size="37" value="" />
               </div>
               <div class='form-group'>
                 <label for="txt_Weight" class='required'> Weight(LBS)(Optional):</label>
                 <input type="text" class='form-control input-lg' id="txt_Weight" autocomplete="off" name="txt_Weight" size="37"  value="" />
               </div>
               <div class='form-group spacer-t-sm'>
                 <input type="button" name="bulksubmit" id="bulksubmit" class="btn btn-primary btn-lg" style='height:60px; width:100%;' value="SUBMIT" onClick="Index_Add_Data_Bulk();" />
               </div>
             </div>
           </div>
         </div>
      </div>
      <!-- Loader -->
      <div class='col-md-2'>
        <h3 class='text-muted text-center'>SCANS:</h3><hr>
        <div id="loader">
          <div id="loading" class='col-md-12 text-center text-muted rm-padding'>
            <span class="fa-stack fa-5x" style=''>
              <i class="fa fa-refresh fa-spin fa-stack-5x" style='font-size:90px;'></i>
              <strong class="fa-stack-1x fa-stack-text" style='font-size: 22px;'><div id='cnt' style='margin-top:-26px;' class='blue-bb'></div></strong>
            </span>
          </div>
        </div>
      </div>
    </div>
     <!-- Right Column -->
     <div class='col-md-4'>
       <!-- Error -->
      <div class='col-md-12' id='errorMsg' style='display:none;'>
        <div class="alert alert-danger">
          <h4><i class='fa fa-exclamation-circle fa-fw'></i>ERROR: </h4>
          <p>No CMDB record found. Click below to fill in the information manually:</p>
          <div class='spacer-t-sm' id="msg" style='min-height:83px;'></div>
        </div>
      </div>
     </div>
   </div>
  </div>
  <!-- End of columns -->
  <!-- Results -->
   <div class='col-md-12 spacer-t'>
     <p id='table3'></p>
   </div>
   <div class='col-md-12'>
     <table id='table2'></table>
   </div>
 </form>

  <!-- ADTF Confirmation Modal -->
  <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
	       <div class="modal-header row">
          <div class='col-xs-10 rm-padding'>
            <h2 class="modal-title" id="myModalLabel">  <i class="fa fa-exclamation-triangle fa-fw"></i> ATTENTION</h2>
          </div>
          <div class='col-xs-2 rm-padding'>
            <button type="button" data-dismiss="modal" class="close" aria-label="Close"><i class="fa fa-times fa-fw fa-2x"></i></button>
          </div>
        </div>
        <div class="modal-body">
          <!-- Confirm -->
          <div id='confirmADTF' class='col-md-12'>
            <div class="alert alert-warning" role="alert">
              <h3 class='red-bb'>PLEASE READ</h3><hr>
              <p>You are about to submit your Asset Disposal Request. You will recieve a <font class='bolder'>Load ID #</font> to reference and your request will be submitted, but the current session of scanned assets will be reset.</p>
            </div>
          </div>
          <!-- Loading -->
          <div id="loadingADTF" class='col-md-12 text-center text-muted rm-padding' style="display:none;">
            <i class="fa fa-refresh fa-spin fa-5x spacer-t"></i>
          </div>
          <!-- Success -->
          <div id='successADTF' class='col-md-12' style='display:none;'>
            <div class="alert alert-success" role="alert">
              <p class='bigger-font-bb bolder'>ADTF LOAD ID #: <font id='ticket'></font></p><hr>
              <p>Please use this ID # to reference your ADTF submission, you can use it to add or modify this ADTF request later.</p>
            </div>
          </div>
        </div>
        <!-- Buttons -->
        <div class="modal-footer">
          <button id='confirmADTF_btn' type="button" class="btn btn-warning btn-lg" onclick="Index_AddData();">CONFIRM</button>
          <button id='successADTF_btn' type="button" class="btn btn-success btn-lg" onclick="openLink('myModal1');" style='display:none;'>VIEW</button>
        </div>
      </div>
    </div>
  </div>
  <!-- ADTF Vendor Confirmation -->
  <div class="modal fade" id="Vendor_myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
	  <div class="modal-header row">
          <div class='col-xs-10 rm-padding'>
            <h3 class="modal-title" id="myModalLabel"><i class="fa fa-exclamation-triangle fa-lg fa-fw"></i> WARNING</h3>
          </div>
          <div class='col-xs-2 rm-padding'>
            <button type="button" data-dismiss="modal" class="close" aria-label="Close"><i class="fa fa-times fa-fw fa-2x"></i></button>
          </div>
        </div>
        <div class="modal-body">
          <!-- Success Message -->
          <div class='col md 12'>
            <div class="alert alert-warning" role="alert">
              <p style='font-size:20px;' class='bolder'>INVALID VENDOR:</p><hr>
              <ul>
                <li><p>Start typing a vendor name then select it from the list that appears.</p></li>
                <li><p>If the vendor you need does not exist, please contact:<br> <a class='bolder' href="mailto:ITAM@blackberry.com">Technology Asset Management</a></p></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-lg btn-full" data-dismiss="modal" >OK</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Selected Record Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header row">
          <div class='col-xs-10 rm-padding'>
            <h3 class="modal-title">EDIT RECORD:</h3>
          </div>
          <div class='col-xs-2 rm-padding'>
            <button type="button" onclick="err_div_hide();" data-dismiss="modal" class="close" aria-label="Close"><i class="fa fa-times fa-fw fa-2x"></i></button>
          </div>
        </div>
      <div class="modal-body spacer-b">
        <!-- Instructions -->
        <div class='col-md-12 spacer-t-sm spacer-b'>
          <div class="alert alert-info" role="alert">
            <p class='bolder bigger-font-bb'>INSTRUCTIONS:</p><hr>
            <ul>
              <li><p>Click <font class='bolder'>'EDIT'</font> to change the values and <font class='bolder'>'SAVE'</font> to save.</p></li>
              <li><p class='red-bb'>Model and Serial Number are <font class='bolder'>REQUIRED</font> fields.</p></li>
            </ul>
          </div>
        </div>
        <div class='form-group col-xs-6'>
          <label for="search-box1">Asset Type:</label>
          <input type="text" class='form-control input-lg' name="txt_AssetType" id="search-box2" readonly placeholder="Asset Type" autocomplete="off" value="" />
          <div id="suggesstion-box2"></div>
        </div>
      	<div class='form-group col-xs-6'>
          <label for="Manufactsearch-box1">Manufacturer:</label>
          <input type="text" class='form-control input-lg' name="txt_Manufacturer" id="Manufactsearch-box" readonly placeholder="Manufacturer" autocomplete="off" value="" />
          <div id="Manufact_suggesstion-box"></div>
        </div>
      	<div class='form-group col-xs-6'>
          <label for="txt_Model1" class='required'>Model:</label>
          <input type="text" class='form-control input-lg' name="txt_Model" id="txt_Model" onkeyup="Check_Model();" placeholder="Model" readonly autocomplete="off" value=""/>
          <div id="Model_suggesstion-box"></div>
        </div>
      	<div class='form-group col-xs-6'>
          <label for="txt_AssetID1">AssetID:</label>
          <input type="text" id="txt_AssetID" class='form-control input-lg' name="txt_AssetID" readonly  autocomplete="off" value="" />
        </div>
      	<div class='form-group col-xs-6'>
          <label for="txt_SerialNo1" class='required'>Serial#:</label>
          <input type="text" id="txt_SerialNo" name="txt_SerialNo" class='form-control input-lg' readonly autocomplete="off" value=""  />
        </div>
    </div>
    <div class="modal-footer">
      <div class='col-md-12'>
        <button id='change' onclick="index_div_change();" class="btn btn-lg btn-primary pull-right" type="button">EDIT</button>
        <button id='update' onclick="index_div_update();" class="pull-right btn btn-lg btn-success" type="button" style='display:none;'>SAVE</button>
      </div>
    </div>
      </div>
    </div>
  </div>
  <!-- Tooltip Modal -->
   <div class="modal fade" id="myModal3_WOVendor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
	       <div class="modal-header row">
          <div class='col-xs-10 rm-padding'>
            <h3 class="modal-title" id="myModalLabel"><i class="fa fa-question-circle fa-lg fa-fw"></i><font id='search_inst_header'></font></h3>
          </div>
          <div class='col-xs-2 rm-padding'>
            <button type="button" data-dismiss="modal" class="close" aria-label="Close"><i class="fa fa-times fa-fw fa-2x"></i></button>
          </div>
        </div>
        <div class="modal-body">
          <!-- Success Message -->
          <div  class='col md 12'>
            <div class="alert alert-info" role="alert">
              <p class='bigger-font-bb bolder'><font id='search_inst_title'></font></p><hr>
              <p><font id='search_inst_body'></font></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
