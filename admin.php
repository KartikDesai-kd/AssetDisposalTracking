<html>
  <head>
    <?php include('templates/head.html'); ?>
  </head>
<body>
 <?php
     // DB Connection
     include('config.php');
     $query = new SQL();
     // Navbar
     include('templates/navbar.html');
   ?>
  <!-- Page Content -->
  <div class='container'>
	<!-- Instructions -->
    <div class='col-md-12'>
      <div class="alert alert-info" role="alert">
        <h3>INSTRUCTIONS</h3>
        <p>Find all the disposed Assets here....</p>
      </div>
    </div>
    <!-- Well -->
    <div class='row'>
      <div class='col-md-12 spacer-t'>
        <div class='well well-lg col-md-12'>
	         <div>
	           <button class='btn btn-primary btn-lg' onclick="" data-toggle="modal" data-target="#myModal_Vendor"  aria-hidden="true">ADD VENDOR</button>
           </div>
        </div>
      </div>
	   </div>
	<!-- Add Vendor Modal -->
  <div class="modal fade" id="myModal_Vendor" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header row">
          <div class='col-xs-10 rm-padding'>
            <h3 class="modal-title">Add New Vendor:</h3>
          </div>
          <div class='col-xs-2 rm-padding'>
            <button type="button" data-dismiss="modal" class="close" aria-label="Close"><i class="fa fa-times fa-fw fa-2x"></i></button>
          </div>
        </div>
      <div class="modal-body spacer-b">
        <!-- Instructions -->
        <div class='form-group col-xs-6'>
          <label for="txt_PrimaryVendor">Primary Vendor:</label>
          <input type="text" class='form-control input-lg' name="txt_PrimaryVendor" id="txt_PrimaryVendor"  placeholder="Primary Vendor" autocomplete="off" value="" />
        </div>
      	<div class='form-group col-xs-6'>
          <label for="search-box1">Secondary Vendor:</label>
          <input type="text" class='form-control input-lg' name="txt_SecondaryVendor" id="txt_SecondaryVendor"  placeholder="Secondary Vendor" autocomplete="off" value="" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Location:</label>
          <input type="text" class='form-control input-lg' name="txt_Location" id="txt_Location"  placeholder="Location" autocomplete="off" value="" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Approval Status:</label>
          <input type="text" class='form-control input-lg' name="txt_ApprovalStatus" id="txt_ApprovalStatus"  placeholder="Approval Status" autocomplete="off" value="" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Resale:</label>
          <input type="text" class='form-control input-lg' name="txt_Resale" id="txt_Resale"  placeholder="Resale" autocomplete="off" value="" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Recycling:</label>
          <input type="text" class='form-control input-lg' name="txt_Recycling" id="txt_Recycling"  placeholder="Recycling" autocomplete="off" value="" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Type of Recycling:</label>
          <input type="text" class='form-control input-lg' name="txt_RecyclingType" id="txt_RecyclingType"  placeholder="Type of Recycling" autocomplete="off" value="" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Pre-Release and Device Destruction:</label>
          <input type="text" class='form-control input-lg' name="txt_DeviceDestruction" id="txt_DeviceDestruction"  placeholder="Pre-Release and Device Destruction" autocomplete="off" value="" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Hard Drive wiping:</label>
          <input type="text" class='form-control input-lg' name="txt_HDWiping" id="txt_HDWiping"  placeholder="Hard Drive Wiping" autocomplete="off" value="" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Vendor Security Assessment:</label>
          <input type="text" class='form-control input-lg' name="txt_VendorSecurity" id="txt_VendorSecurity"  placeholder="Vendor Security Assessment" autocomplete="off" value="" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Environment Assessment:</label>
          <input type="text" class='form-control input-lg' name="txt_Environment" id="txt_Environment"  placeholder="Environment Assessment" autocomplete="off" value="" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Contract in Place:</label>
          <input type="text" class='form-control input-lg' name="txt_Contract" id="txt_Contract"  placeholder="Contract in Place" autocomplete="off" value="" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Pickup Process:</label>
          <input type="text" class='form-control input-lg' name="txt_PickupProcess" id="txt_PickupProcess"  placeholder="Pickup Process" autocomplete="off" value="" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Notes:</label>
          <input type="text" class='form-control input-lg' name="txt_Notes" id="txt_Notes"  placeholder="Notes" autocomplete="off" value="" />
        </div>

    </div>
    <div class="modal-footer">
      <div class='col-md-12'>
        <button id='update' data-toggle="modal" data-target="#myModal2_Vendor" class="pull-right btn btn-lg btn-success" type="button">Add</button>
      </div>
    </div>

      </div>
    </div>
  </div>
  <!-- Success Modal -->
   <div class="modal fade" id="myModal2_Vendor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
	  <div class="modal-header row">
          <div class='col-xs-10 rm-padding'>
            <h3 class="modal-title" id="myModalLabel"><i class="fa fa-exclamation-circle fa-lg"></i>Vendor info:</h3>
          </div>
          <div class='col-xs-2 rm-padding'>
            <button type="button" data-dismiss="modal" class="close" aria-label="Close"><i class="fa fa-times fa-fw fa-2x"></i></button>
          </div>
        </div>
        <div class="modal-body">
          <!-- Success Message -->
          <div  class='col md 12'>
            <div class="alert alert-warning" role="alert">
               <p style='font-size:2em; font-weight:800;'>New Vendor Added <font id='ticket'></font> </p>
            </div>
          </div>

        </div>
         <div class="modal-footer">
      <div class='col-md-12'>
        <button id='update' onclick="AddNewVendor_Admin();" class="pull-right btn btn-lg btn-success" type="button">OK</button>
      </div>
    </div>
      </div>
    </div>
  </div>

</div>
</body>
</html>
