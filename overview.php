<html>
<head>
  <?php include('templates/head.html'); ?>
</head>
<body >
   <?php
     error_reporting(0);
     // DB Connection
     include('config.php');
     $query = new SQL();
     // Navbar
     include('templates/navbar.html');
   ?>
  <!-- Page Content -->
  <div class='container' >
	<!-- Instructions -->
    <div class='col-md-12 spacer-b'>
      <div class="alert alert-info" role="alert">
        <p style='font-size:2em; font-weight:800;'>INSTRUCTIONS: Find all the disposed Assets here....</p>
        <!-- <p style='font-size:14px;'>Some text here to explain...</p> -->
      </div>
    </div>
<?php
$query = new SQL();
$query_pag_data = "select * from ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] order by ID DESC";
$result_pag_data = $query->query($query_pag_data);

$query_pag = "select * from ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] order by ID DESC";
$result_pag = $query->query($query_pag);
$c=count($result_pag);
?>
<!--Right Column-->
<div class='form-group col-md-12'>
 <form id='frm' name='frm' action="edit_Multiple.php" method="post">
  <table id="tableid" class="display">

    <thead>
        <tr>
		    <th></th>
            <th>Vendor</th>
			<th>AssetType</th>
			<th>Manufacturer</th>
			<th>Model</th>
			<th>AssetID</th>
			<th>Serial#</th>
			<th>Wo#</th>
			<th>Weight</th>
			<th>Description</th>
			<th>Action</th>
        </tr>
	</thead>
	<tbody>
	<?php
       foreach($result_pag_data as $row) {
	   $id1=$row['ID'];
    ?>
        <tr>
            <td><input type="checkbox"  name="chb[]" value="<?php echo $id1; ?>" onclick="set_display();" /></td>
            <td><center><?php echo $row['Vendor'];  ?></center></td>
			<td><center><?php echo $row['Asset_Type'];  ?></center></td>
			<td><center><?php echo $row['Manufacturer'];  ?></center></td>
			<td><center><?php echo $row['Model'];  ?></center></td>
			<td><center><?php echo $row['Asset_ID'];  ?></center></td>
			<td><center><?php echo $row['Serial_No'];  ?></center></td>
			<td><center><?php echo $row['LoadID'];  ?></center></td>
			<td><center><?php echo $row['Weight'];  ?></center></td>
			<td><center><?php echo $row['Description'];  ?></center></td>
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
        <a href="#"><i class="fa fa-pencil-square fa-lg fa-2x" onclick="rpt_senddata_bulk();" id="submit_mult_bulk" style="display:none;"  alt="Bulk Update" title="Bulk Update" ></i></a>

 </div>
</form>
</div>
<!-- View selected record -->
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


  </div>
</body>
</html>
