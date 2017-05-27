<?php session_start(); ?>
<html>
<head>
  <?php include('templates/head.html'); ?>
</head>
 <body onload="loaddata();">
   <?php
     // DB Connection
     include('config.php');
     $query = new SQL();
     // Navbar
     include('templates/navbar.html');
   ?>

<!-- Page Content -->
<div class='container'>

	<form name="myform1" id="myform1" action="Search.php" method="post" style="font-size:18px;" class='form'>
	<div class='col-sm-8 well'>
	<!-- Fields To Search Record -->
      <div id="well">
         <div class='form-group col-md-9'>
           <label for="search-box1">Search Criteria:</label>
           <select id="searchby" name="searchby" class='form-control input-lg' onchange="ShowSelection();">
    		    <option <?php if(isset($_GET['selection']) && $_GET['selection']=='-SELECT-') echo 'selected'; ?>>-SELECT-</option>
    		    <option <?php if(isset($_GET['selection']) && $_GET['selection']=='Vendor') echo 'selected'; ?>>Vendor</option>
    		    <option <?php if(isset($_GET['selection']) && $_GET['selection']=='Asset Type') echo 'selected'; ?>>Asset Type</option>
    		    <option <?php if(isset($_GET['selection']) && $_GET['selection']=='Manufacturer') echo 'selected'; ?>>Manufacturer</option>
    		    <option <?php if(isset($_GET['selection']) && $_GET['selection']=='Model') echo 'selected'; ?>>Model</option>
    		    <option <?php if(isset($_GET['selection']) && $_GET['selection']=='Asset ID') echo 'selected'; ?>>Asset ID</option>
    		    <option <?php if(isset($_GET['selection']) && $_GET['selection']=='Serial') echo 'selected'; ?>>Serial#</option>
    		    <option <?php if(isset($_GET['selection']) && $_GET['selection']=='WO') echo 'selected'; ?>>WO#</option>
    		   </select>
         </div>
      <!-- Drop Down Menu -->
		 <div id="dynamic" style="">
		    <div id="Vendor" style="display:none;">
			  <div class='form-group col-md-9'>
               <label for="search-box1">Vendor:</label>
               <input type="text" class='form-control input-lg'  name="txt_Vendor" id="txt_Vendor" size="40" placeholder="Enter Vendor" autocomplete="off" value="<?php if(isset($_GET['s_Vendor'])) echo $_GET['s_Vendor']; ?>" />
	           <div id="VendorList"></div>
              </div>
			</div>
			<div id="AssetType">
			  <div class='form-group col-md-9'>
               <label for="search-box1">Asset Type:</label>
               <input type="text" class='form-control input-lg' name="txt_AssetType" id="search-box" placeholder="Enter Asset Type" autocomplete="off" value="<?php if(isset($_GET['s_AssetType'])) echo $_GET['s_AssetType']; ?>" />
               <div id="suggesstion-box"></div>
              </div>
			</div>
			<div id="Manufacturer">
			  <div class='form-group col-md-9'>
               <label for="Manufactsearch-box1">Manufacturer:</label>
               <input type="text" class='form-control input-lg' name="txt_Manufacturer" id="Manufactsearch-box" placeholder="Enter Manufacturer" autocomplete="off"  value="<?php if(isset($_GET['s_Manufacturer'])) echo $_GET['s_Manufacturer']; ?>" />
               <div id="Manufact_suggesstion-box"></div>
              </div>
			</div>
			<div id="Model">
			  <div class='form-group col-md-9'>
               <label for="txt_Model1">Model:</label>
               <input type="text" class='form-control input-lg' name="txt_Model" id="txt_Model" placeholder="Enter Model" autocomplete="off" value="<?php if(isset($_GET['s_Model'])) echo $_GET['s_Model']; ?>" />
               <div id="Model_suggesstion-box"></div>
              </div>
			</div>
			<div id="AssetID">
			  <div class='form-group col-md-9'>
               <label for="txt_AssetID1">AssetID:</label>
               <input type="text" id="txt_AssetID" class='form-control input-lg' name="txt_AssetID" placeholder="Enter AssetID" autocomplete="off" value="<?php if(isset($_GET['s_AssetID'])) echo $_GET['s_AssetID']; ?>"  />
              </div>
			</div>
			<div id="SerialNo">
			  <div class='form-group col-md-9'>
               <label for="txt_SerialNo1">Serial Number:</label>
               <input type="text" id="txt_SerialNo" name="txt_SerialNo" class='form-control input-lg' placeholder="Enter SerialNo" autocomplete="off" value="<?php if(isset($_GET['s_SerialNo'])) echo $_GET['s_SerialNo']; ?>"  />
              </div>
			</div>
			<div id="WO">
			  <div class='form-group col-md-9'>
         <label for="txt_WO"> Load ID (WO #):</label>
         <input type="text" class='form-control input-lg' id="txt_WO" name="txt_WO" placeholder="Enter LoadID" autocomplete="off" value="<?php if(isset($_GET['s_WO'])) echo $_GET['s_WO']; ?>" />
		 <div id="WOList"></div>
        </div>
			</div>
		 </div>
     <div id="btn_search" class='col-md-12'>
       <button type="button" name="search" id="search" onclick="Search_CreateTable();" class="btn btn-primary btn-lg" style='font-weight:800;'>SEARCH</button>
        <button type="button" name="filter" id="filter" onclick="Search_CreateTable_Filter();" style="display:none;" class="btn btn-warning btn-lg" style='font-weight:800;'>FILTER</button>
     </div>

  </div>
	</div>
  <!-- Instructions -->
  <div id='instructions' class='col-md-4' style="float:right;">
    <div class="alert alert-info" role="alert">
      <div id="startHelp">
        <p class='bolder bigger-font-bb'><i class='fa fa-search fa-lg fa-fw'></i> SEARCH:</p>
        <ul>
          <li class='big-font-bb'><p>Select a criteria to search on from the drop down.</p></li>
          <li class='big-font-bb'><p>Vendor and Load ID fields will return additional information to allow for bulk updates.</p></li>
          <li class='big-font-bb'><p>All individual assets will be shown for the search criteria selected.</p></li>
        </ul>
      </div>
    </div>
    <!-- Bulk Update Title -->
	<?php
  if($_SESSION['no_rows']>0 && isset($_GET['selection'])&& ($_GET['selection']=="Vendor" || $_GET['selection']=="WO"))
{
	?>
    <div id='searchTitle' class='spacer-t'>
	<?php
	 if($_GET['selection']=="Vendor")
	 {
	?>
      <h3 id='searchVendor' class='text-muted'>EDIT VENDOR INFO: <i class='fa fa-fw fa-lg fa-question-circle blue-bb' aria-hidden="true" style='cursor:pointer;' onclick="infoModal('vendor');" data-toggle="modal" data-target="#myModal3_WOVendor" ></i></h3><hr>
	  <?php
	 }
	  elseif($_GET['selection']=="WO")
	  {
	  ?>
      <h3 id='searchLoadID' class='text-muted'>EDIT LOAD ID: <i class='fa fa-fw fa-lg fa-question-circle blue-bb' aria-hidden="true" style='cursor:pointer;' onclick="infoModal('loadID');" data-toggle="modal" data-target="#myModal3_WOVendor" ></i></h3><hr>
	  <?php } ?>
    </div>
<?php
}
?>
  </div>
  <!-- End of Instruction Pannel -->

	</form>

<!-- Datatable -->
<div class='form-group col-md-8'>
	<?php
	  if(isset($_SESSION['var']) && isset($_GET['selection']) && isset($_SESSION['var'][0]) )
	 {

	?>

     <?php
		 if($_SESSION['no_rows']==0)
        {
          echo "<div class='alert alert-danger'>";
          echo  "<i class='fa fa-exclamation-circle fa-fw' style='font-size:22px;'></i><text class='bigger-font-bb'><b class='bolder' style='font-size:18px;'> ERROR:</b> No Record(s) Found.</text>";
          echo "</div>";
        }
         if($_SESSION['no_rows']>0)
	    {
	?>
          <form id='frm' name='frm' action="edit_Multiple.php" method="post">
           <table id="tableid" class="display">
            <thead>
             <tr>
		      <th></th>
              <th><center>Vendor</center></th>
              <th><center>Statement Of Work</center></th>
			  <th><center>AssetType</center></th>
			  <th><center>Manufacturer</center></th>
			  <th><center>AssetID</center></th>
			  <th><center>Serial#</center></th>
			  <th><center>WO#</center></th>
			  <th><center>Action</center></th>
             </tr>
            </thead>
	        <tbody>
             <?php
			  $variable=$_SESSION['var'];

	          foreach($variable as $row)
	         {
			   $id1=$row['ID'];
            ?>
           <tr>
		    <td align="center" style="width:1px;"><input type="checkbox"  name="chb[]" value="<?php echo $id1; ?>" onclick="set_display();" /></td>
            <td><center><?php echo $row['Vendor'];  ?></center></td>
			<td><center><?php echo $row['StatementOfWork'];  ?></center></td>
			<td><center><?php echo $row['Asset_Type'];  ?></center></td>
			<td><center><?php echo $row['Manufacturer'];  ?></center></td>
			<td><center><?php echo $row['Asset_ID'];  ?></center></td>
			<td><center><?php echo $row['Serial_No'];  ?></center></td>
			<td><center><?php echo $row['LoadID'];  ?></center></td>
			<?php
			 if($row['Manufacturer']=="")
			 {
			?>
			 <td><center><a href="#"><i class="fa fa-trash fa-lg" id='delete' name='delete' onclick='del_single_confirm(<?php echo $row['ID']; ?>);' title='Delete'></i></a>|<a href="#?id=<?php echo $row['ID']; ?>"><i class="fa fa-info fa-lg" id="<?php echo $row['ID']; ?> " data-toggle="modal" data-target="#myModal" onclick='div_show(this.id);' name='view' title='View'></i></a></center></td>
			<?php
			 }
			 else
		     {
			?>
			  <td><center><a href="#"><i class="fa fa-trash fa-lg" id='delete' name='delete' onclick='del_single_confirm(<?php echo $row['ID']; ?>);' title='Delete'></i></a> | <a href="#?id=<?php echo $row['ID']; ?>"><i class="fa fa-info fa-lg" id="<?php echo $row['ID']; ?> " data-toggle="modal" data-target="#myModal" onclick='div_show(this.id);' name='view' title='View'></i></a></center></td>
			 <?php
			 }
			 ?>
          </tr>
        <?php
	       }

		 ?>
        </tbody>
       </table>
      <div>
        <a href="#"><i class="fa fa-trash fa-lg fa-2x" id='del' name='del' style="display:none;" onclick='del_multiple_Confirm();' title='Delete'></i></a>

  	      &nbsp;&nbsp;
        <a href="#"><i class="fa fa-pencil-square fa-lg fa-2x" onclick="senddata_bulk();" id="submit_mult_bulk" style="display:none;"  alt="Bulk Update" title="Bulk Update" ></i></a>

      </div>
		</form>

    <?php

	 }}
		?>

      </div>
<!-- End of DataTable -->

<!-- Bulk Update -->
<!-- bulk update with Vendor -->
<?php
  if($_SESSION['no_rows']>0 && isset($_GET['selection'])&& ($_GET['selection']=="Vendor") && isset($_SESSION['var_v']))
{
	if($_GET['selection']=="Vendor")
	{
		$_SESSION['t']="Vendor";

	}
	//print_r($_SESSION['var_v']);
?>
<div class='form-group col-md-4'>
	 <form action="common.php" method="post" name="form4" class='form'>
	  <div id='search_update' class='well' style="float:right;">
    <div class='form-group col-xs-12'>
          <label for="txt_PrimaryVendor">Primary Vendor:</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		   <a href="#"><i title="Add New Vendor" class="fa fa-plus-circle fa-2x" data-toggle="modal" data-target="#myModal_Vendor"  aria-hidden="true"></i></a>
          <input type="text" class='form-control input-lg' name="s_txt_PrimaryVendor" readonly id="s_txt_PrimaryVendor"  placeholder="Primary Vendor" autocomplete="off" value="<?php echo $variable[0]["Vendor"];?>" />
        </div>
      	<div class='form-group col-xs-12'>
          <label for="search-box1">Secondary Vendor:</label>
          <input type="text" class='form-control input-lg' name="s_txt_SecondaryVendor" readonly id="s_txt_SecondaryVendor"  placeholder="Secondary Vendor" autocomplete="off" value="<?php echo $_SESSION['var_v'][0] ['Secondary Vendor _(would have contact with site)'];  ?>" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Location:</label>
          <input type="text" class='form-control input-lg' name="s_txt_Location" readonly id="s_txt_Location"  placeholder="Location" autocomplete="off" value="<?php echo $_SESSION['var_v'][0]["Location"];?>" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Approval Status:</label>
          <input type="text" class='form-control input-lg' name="s_txt_ApprovalStatus" readonly id="s_txt_ApprovalStatus"  placeholder="Approval Status" autocomplete="off" value="<?php echo $_SESSION['var_v'][0]["Approval Status"];?>" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Resale:</label>
          <input type="text" class='form-control input-lg' name="s_txt_Resale" id="s_txt_Resale" readonly  placeholder="Resale" autocomplete="off" value="<?php echo $_SESSION['var_v'][0]["Resale"]; ?>" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Recycling:</label>
          <input type="text" class='form-control input-lg' name="s_txt_Recycling" id="s_txt_Recycling" readonly  placeholder="Recycling" autocomplete="off" value="<?php echo $_SESSION['var_v'][0]["Recycling"];?>" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Type of Recycling:</label>
          <input type="text" class='form-control input-lg' name="s_txt_RecyclingType" id="s_txt_RecyclingType" readonly  placeholder="Type of Recycling" autocomplete="off" value="<?php echo $_SESSION['var_v'][0]["Type of recycling"];?>" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Pre-Release and Device Destruction:</label>
          <input type="text" class='form-control input-lg' name="s_txt_DeviceDestruction" id="s_txt_DeviceDestruction" readonly  placeholder="Pre-Release and Device Destruction" autocomplete="off" value="<?php echo $_SESSION['var_v'][0]["Pre-Release and Device Destruction"];?>" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Hard Drive wiping:</label>
          <input type="text" class='form-control input-lg' name="s_txt_HDWiping" id="s_txt_HDWiping" readonly  placeholder="Hard Drive Wiping" autocomplete="off" value="<?php echo $_SESSION['var_v'][0]["Hard Drive Wiping"];?>" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Vendor Security Assessment:</label>
          <input type="text" class='form-control input-lg' name="s_txt_VendorSecurity" id="s_txt_VendorSecurity" readonly  placeholder="Vendor Security Assessment" autocomplete="off" value="<?php echo $_SESSION['var_v'][0]["Vendor Security Assessment"];?>" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Environment Assessment:</label>
          <input type="text" class='form-control input-lg' name="s_txt_Environment" id="s_txt_Environment" readonly  placeholder="Environment Assessment" autocomplete="off" value="<?php echo $_SESSION['var_v'][0]["Environment Assessment"];?>" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Contract in Place:</label>
          <input type="text" class='form-control input-lg' name="s_txt_Contract" id="s_txt_Contract" readonly  placeholder="Contract in Place" autocomplete="off" value="<?php echo $_SESSION['var_v'][0]["Contract in Place"];?>" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Pickup Process:</label>
          <input type="text" class='form-control input-lg' name="s_txt_PickupProcess" id="s_txt_PickupProcess" readonly  placeholder="Pickup Process" autocomplete="off" value="<?php echo $_SESSION['var_v'][0]["Pickup Process"];?>" />
        </div>
		<div class='form-group col-xs-6'>
          <label for="search-box1">Notes:</label>
          <input type="text" class='form-control input-lg' name="s_txt_Notes" id="s_txt_Notes" readonly  placeholder="Notes" autocomplete="off" value="<?php echo $_SESSION['var_v'][0]["Notes"];?>" />
        </div>
	<div class='form-group col-md-12'>
        <input type="button" id="btnedit_vendor" name="Search_MultiEdit_Bulk_adv" onclick="ReadonlyFalse_Vendor();" class='btn btn-success btn-lg btn-full' value="EDIT" />
    </div>
    <div class='form-group col-md-12'>
        <input type="button" id="btnsubmit_vendor" style="display:none;" data-toggle="modal" data-target="#myModal1" name="Search_MultiUpdate_Bulk_adv" class='btn btn-success btn-lg btn-full' value="BULK UPDATE" />
    </div>
  </div>
</form>
</div>
<?php
	 }
?>

<!-- bulk update with WO# -->
<?php
  if($_SESSION['no_rows']>0 && isset($_GET['selection'])&& ($_GET['selection']=="WO"))
{
?>
<div class='form-group col-md-4'>
	 <form action="common.php" method="post" name="form4" class='form'>
	  <div id='search_update' class='well' style="float:right;">

    <div class='form-group col-md-12'>
     <label for="txt_Vendor">Vendor:</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <input class='form-control input-lg'  type="text" id="s_txt_Vendor" name="txt_Vendor" readonly autocomplete="off" placeholder="Enter Vendor..." required value="<?php echo $variable[0]["Vendor"];?>" />

	 <div id="s_VendorList"></div>
     <span id="vendor" style="color:#FF0000;display:none;" title="Please Enter Vendor">*</span>
    </div>

    <div class='form-group col-md-6'>
     <label for="txt_DateSubmitted">Date Submitted:</label>
	 <?php
	      $dt=$variable[0]["Date_Submitted"];
        // echo $dt;
	     //  $datesubmitted = date_format($dt,"Y-m-d");
	 ?>
     <input class='form-control input-lg' type="date" id="s_datepicker" name='txt_DateSubmitted' required placeholder="YYYY-MM-DD" size="40" readonly onclick="SetWhite(this.id);" value="<?php echo $dt; ?>"/>
     <span id="datesubmitted" style="color:#FF0000;display:none;" title="Please Select Date">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_StatementOfWork">Statement of Work:</label>
     <input class='form-control input-lg' type="text" id="s_txt_StatementOfWork" name="txt_StatementOfWork" size="40" readonly onkeyup="SetWhite(this.id);"  value="<?php echo $variable[0]["StatementOfWork"];?>" />
     <span id="statementofwork" style="color:#FF0000;display:none;" title="Please Enter Work Statement">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_NumberOfPallets">Number of Pallets:</label>
     <input class='form-control input-lg' type="text" id="s_txt_NumberOfPallets" name="txt_NumberOfPallets" onkeyup="SetWhite(this.id);" readonly size="40" value="<?php echo $variable[0]["NumberOfPallets"];?>" />
     <span id="numberofpallets" style="color:#FF0000;display:none;" title="Please Enter Number Of Pallets">*</span>
    </div>
	<div class='form-group col-md-6'>
     <label for="txt_WO">Load ID (JIRA WO#):</label>
     <input type="text" class='form-control input-lg' id="s_txt_WO" name="txt_WO" size="40" readonly value="<?php echo $variable[0]["LoadID"];?>"  />
    </div>
    <div class='form-group col-md-12'>
     <label for="txt_PickupLocation">Pickup Location:</label>
     <input class='form-control input-lg' type="text" id="s_txt_PickupLocation" readonly name="txt_PickupLocation" autocomplete="off" onkeyup="SetWhite(this.id);" size="40" value="<?php echo $variable[0]["PickUpLocation"];?>" />
	 <div id="s_LocationList"></div>
     <span id="pickuplocation" style="color:#FF0000;display:none;" title="Please Enter Pickup Location">*</span>
    </div>
    <div class='form-group col-md-12'>
     <label for="txt_LocalRIMContact">Local BB Contact:</label>
     <textarea class='form-control input-lg' id="s_txt_LocalRIMContact" name="txt_LocalRIMContact" rows="2" readonly  placeholder="Enter Local BlackBery Contact..." required><?php echo $variable[0]["LocalRIMContact"];?></textarea>
     <span id="localrimcontact" style="color:#FF0000;display:none;" title="Please Enter Contact Detail">*</span>
    </div>
	<div class='form-group col-md-12'>
        <input type="button" id="btnedit" name="Search_MultiEdit_Bulk_adv" onclick="ReadonlyFalse();" class='btn btn-success btn-lg btn-full' value="EDIT" />
    </div>
    <div class='form-group col-md-12'>
        <input type="button" id="btnsubmit" style="display:none;" data-toggle="modal" data-target="#myModal1" name="Search_MultiUpdate_Bulk_adv" class='btn btn-success btn-lg btn-full' value="BULK UPDATE" />
    </div>
  </div>
</form>
</div>
<?php
	 }
?>

	<!-- Modal for bulk update -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
	<div class="modal-header row">
          <div class='col-xs-10 rm-padding'>
            <h3 class="modal-title" id="myModalLabel">  <i class="fa fa-exclamation-triangle fa-lg"></i>Warning</h3>
          </div>
          <div class='col-xs-2 rm-padding'>
            <button type="button" onclick="div_hide();" data-dismiss="modal" class="close" aria-label="Close"><i class="fa fa-times fa-fw fa-2x"></i></button>
          </div>
        </div>
	    <?php
  if($_SESSION['no_rows']>0 && isset($_GET['selection'])&& ($_GET['selection']=="WO"))
{
?>
      <div class="modal-body">
            <!-- Success Message -->

              <div class="alert alert-warning" role="alert">
                 <p style='font-size:2em; font-weight:800;'>You will update <?php echo $_SESSION['no_rows']; ?> records. <font id='ticket'></font> </p>
              </div>


          </div>
<?php }
else if($_SESSION['no_rows']>0 && isset($_GET['selection'])&& ($_GET['selection']=="Vendor"))
{
?>
 <div class="modal-body">
            <!-- Success Message -->

              <div class="alert alert-success" role="alert">
                 <p style='font-size:2em; font-weight:800;'>You will update 1 record. <font id='ticket'></font> </p>
              </div>


          </div>
<?php
}
?>
      <div class="modal-footer">
	  <?php
	   if(isset($_GET['selection']) && $_GET['selection']=="Vendor")
	   {
	  ?>
        <button type="button" class="btn btn-primary" onclick="senddata_bulk_adv_Vendor();">Update</button>
	  <?php
	   }
       else
       {
      ?>
        <button type="button" class="btn btn-primary" onclick="senddata_bulk_adv_WO();">Update</button>
       <?php

	    }
       ?>
      </div>
    </div>
  </div>
</div>
<!-- End of modal -->

	 <!-- View selected record  modal-->
	 <div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog modal-lg"">

      <!-- Modal content-->
      <div class="modal-content">
		<div class="modal-header row">
          <div class='col-xs-10 rm-padding'>
            <h3 class="modal-title">VIEW RECORD:</h3>
          </div>
          <div class='col-xs-2 rm-padding'>
            <button type="button" onclick="div_hide();" data-dismiss="modal" class="close" aria-label="Close"><i class="fa fa-times fa-fw fa-2x"></i></button>
          </div>
        </div>
        <div class="modal-body">
    <div class='col-xs-6'>
      <label for="txt_Vendor1">Vendor:</label>
      <input class='form-control input-lg'  type="text" id="txt_Vendor1" name="txt_Vendor" autocomplete="off" readonly  placeholder="Enter Vendor..." required value="" />
	  <div id="VendorList1"></div>
      <span id="vendor" style="color:#FF0000;display:none;" title="Please Enter Vendor">*</span>
    </div>
	 <div class='col-xs-6'>
      <label for="search-box1">Asset Type:</label>
      <input type="text" class='form-control input-lg' name="txt_AssetType" id="search-box1" readonly placeholder="Asset Type" autocomplete="off" value="" /><span id="assettype" style="color:#FF0000;display:none;" title="Please Select Asset Type">*</span>
      <div id="suggesstion-box1"></div>
    </div>
    <div class='col-xs-6'>
      <label for="datepicker1">Date Submitted:</label>
      <input class='form-control input-lg' type="date" id="datepicker1" name='txt_DateSubmitted' required placeholder="YYYY-MM-DD" readonly value=""/>
      <span id="datesubmitted" style="color:#FF0000;display:none;" title="Please Select Date">*</span>
    </div>
	<div class='col-xs-6'>
      <label for="Manufactsearch-box1">Manufacturer:</label>
      <input type="text" class='form-control input-lg' name="txt_Manufacturer" id="Manufactsearch-box1" readonly placeholder="Manufacturer" autocomplete="off" value="" /><span id="manufacturer" style="color:#FF0000;display:none;" title="Please Select Manufacturer">*</span>
      <div id="Manufact_suggesstion-box1"></div>
    </div>
    <div class='col-xs-6'>
      <label for="txt_StatementOfWork1">Statement of Work:</label>
      <input class='form-control input-lg' type="text" id="txt_StatementOfWork1" name="txt_StatementOfWork" size="40" readonly  value="" />
      <span id="statementofwork" style="color:#FF0000;display:none;" title="Please Enter Work Statement">*</span>
    </div>
	<div class='col-xs-6'>
      <label for="txt_Model1">Model:</label>
      <input type="text" class='form-control input-lg' name="txt_Model" id="txt_Model1" placeholder="Model" readonly autocomplete="off" value="" /><span id="model" style="color:#FF0000;display:none;" title="Please Select Model">*</span>
      <div id="Model_suggesstion-box1"></div>
    </div>
    <div class='col-xs-6'>
      <label for="txt_NumberOfPallets1">Number of Pallets:</label>
      <input class='form-control input-lg' type="text" id="txt_NumberOfPallets1" name="txt_NumberOfPallets" readonly value="" />
      <span id="numberofpallets" style="color:#FF0000;display:none;" title="Please Enter Number Of Pallets">*</span>
    </div>
	<div class='col-xs-6'>
      <label for="txt_AssetID1">AssetID:</label>
      <input type="text" id="txt_AssetID1" class='form-control input-lg' name="txt_AssetID" readonly  autocomplete="off" value="" />
    </div>
    <div class='col-xs-6'>
      <label for="txt_PickupLocation1">Pickup Location:</label>
      <input class='form-control input-lg' type="text" id="txt_PickupLocation1" name="txt_PickupLocation" readonly value="" />
	  <div id="LocationList1"></div>
      <span id="pickuplocation" style="color:#FF0000;display:none;" title="Please Enter Pickup Location">*</span>
    </div>
	<div class='col-xs-6'>
      <label for="txt_SerialNo1">Serial#:</label>
      <input type="text" id="txt_SerialNo1" name="txt_SerialNo" class='form-control input-lg' readonly autocomplete="off" value=""  />
    </div>
    <div class='col-xs-6'>
      <label for="txt_LocalRIMContact1">Local BB Contact:</label>
      <textarea class='form-control input-lg' id="txt_LocalRIMContact1" name="txt_LocalRIMContact" rows="4" readonly></textarea>
      <span id="localrimcontact" style="color:#FF0000;display:none;" title="Please Enter Contact Detail">*</span>
	  <br>
    </div>
	 <div class='col-xs-6'>
	  <label for="txt_WO1">WO#:</label>
      <input type="text" id="txt_WO1" name="txt_WO" class='form-control input-lg' readonly autocomplete="off" value=""  />
    </div>
	<div class='col-xs-6'>
      <label for="txt_Description1">Description (Optional):</label>
      <input type="text" class='form-control input-lg' id="txt_Description1" name="txt_Description" readonly size="40" value="" />
     </div>

     <div class='col-xs-6'>
      <label for="txt_Weight1"> Weight (LBS):</label>
      <input type="text" class='form-control input-lg' id="txt_Weight1" name="txt_Weight" readonly data-toggle="tooltip8"  value="" />
	  <input type="hidden" class='form-control input-lg' id="ID1" name="ID1" readonly data-toggle="tooltip8"  value="" />
     </div>
   </div>
   <br>
   <div class="modal-footer">
     <button class="btn btn-lg btn-primary" id="change" onclick="div_change();">EDIT</button>
     <button class="btn btn-lg btn-success pull-right" id="update" onclick="div_update();" style="display:none;">SAVE</button>
   </div>
 </div>

    </div>
  </div>
   <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
	        <div class="modal-header row">
          <div class='col-xs-10 rm-padding'>
            <h3 class="modal-title"><i class='fa fa-trash-o fa-fw' style='margin-right:10px;'></i> DELETE RECORD</h3>
          </div>
          <div class='col-xs-2 rm-padding'>
            <button type="button" data-dismiss="modal" class="close" aria-label="Close"><i class="fa fa-times fa-fw fa-2x"></i></button>
          </div>
        </div>

          <div class="modal-body">
            <!-- Success Message -->
            <div id="del_confirm" class='col md 12'>
              <div class="alert alert-danger" role="alert">
                 <h3 class='text-center'>Delete this single asset record?</h3>
              </div>
            </div>
          </div>
          <div class="modal-footer">
		          <button type="button" class="btn btn-warning btn-lg" onclick="del_single();" data-dismiss="modal">CONFIRM</button>
          </div>
        </div>
      </div>
    </div>

	 <div class="modal fade" id="MultipleDelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
		<div class="modal-header row">
          <div class='col-xs-10 rm-padding'>
          <h3 class="modal-title"><i class='fa fa-trash-o fa-fw' style='margin-right:10px;'></i> DELETE RECORD(s)</h3>
          </div>
          <div class='col-xs-2 rm-padding'>
            <button type="button" data-dismiss="modal" class="close" aria-label="Close"><i class="fa fa-times fa-fw fa-2x"></i></button>
          </div>
        </div>

        <div class="modal-body">
          <!-- Success Message -->
          <div id="Multidel_confirm" class='col md 12'>
            <div class="alert alert-danger" role="alert">
               <h3 class='text-center'>Delete this single asset record(s)?</h3>
            </div>
          </div>
        </div>
          <div class="modal-footer">
		      <button type="button" class="btn btn-warning btn-lg" onclick="del_multiple();" data-dismiss="modal">CONFIRM</button>
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
        <button id='update' onclick="AddNewVendor();" class="pull-right btn btn-lg btn-success" type="button">OK</button>
      </div>
    </div>
      </div>
    </div>
  </div>

   <!-- Search instruction Modal -->
   <div class="modal fade" id="myModal3_WOVendor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
	  <div class="modal-header row">
          <div class='col-xs-10 rm-padding'>
            <h3 class="modal-title" id="myModalLabel"><i class="fa fa-exclamation-circle fa-lg"></i> Info:</h3>
          </div>
          <div class='col-xs-2 rm-padding'>
            <button type="button" data-dismiss="modal" class="close" aria-label="Close"><i class="fa fa-times fa-fw fa-2x"></i></button>
          </div>
        </div>
        <div class="modal-body">
          <!-- Success Message -->
          <div  class='col md 12'>
            <div class="alert alert-warning" role="alert">
              <p class='bigger-font-bb red-bb bolder'>PLEASE READ</p><hr>
              <p>Search Instructions: <font id='search_inst'></font> </p>
            </div>
          </div>

        </div>
         <div class="modal-footer">
      <div class='col-md-12'>
        <!-- <button id='inst' data-dismiss="modal"  class="pull-right btn btn-lg btn-success" type="button">OK</button> -->
      </div>
    </div>
      </div>
    </div>
  </div>
  </div>
 </body>
</html>
