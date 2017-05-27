<?php session_start();  ?>
<?php
$FuncType="";
if(isset($_GET['Type']))
{
$FuncType=$_GET['Type'];
}
if(isset($_POST['Type']))
{
$FuncType=$_POST['Type'];
}
if($FuncType=="View")
{
	include('config.php');
  $query = new SQL();
$id=$_REQUEST['id'];
$sql="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] WHERE ID=$id";
$result = $query->query($sql);
//echo $sql;
//$array = mysql_fetch_row($result);

echo json_encode($result);
}
else if($FuncType=="DelSingle")
{
	//including the database connection file
include('config.php');
  $query = new SQL();

if($_POST['id'])
{
$id=$_POST['id'];
$delete = "DELETE FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] WHERE ID='$id'";

 $res = $query->query($delete);

 $query = new SQL();
           $select_table="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] WHERE ";
	       $select_table=$select_table.$_SESSION['query'];
	       echo $select_table;
	       $variable = $query->query($select_table);
	       $rows = count($variable);
	       $_SESSION['var']=$variable;
	       $_SESSION['no_rows']=$rows;
}
//redirecting to the display page (index.php in our case)
}
else if($FuncType=="DelMultiple")
{
	 include('config.php');
  $query = new SQL();
    if($_POST['checked_id']){

        $idArr = $_POST['checked_id'];
		 $arr=explode(",",$idArr);

        $N = count($arr);

    echo("You selected $N record(s): ");
    for($i=0; $i < $N; $i++)
    {

		    $sql="DELETE FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] WHERE ID=".$arr[$i];
			//echo $query;
            $res = $query->query($sql);
        }
       // $_SESSION['success_msg'] = 'Users have been deleted successfully.';

    }
	$query = new SQL();
           $select_table="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] WHERE ";
	       $select_table=$select_table.$_SESSION['query'];
	       echo $select_table;
	       $variable = $query->query($select_table);
	       $rows = count($variable);
	       $_SESSION['var']=$variable;
	       $_SESSION['no_rows']=$rows;
}
else if($FuncType=="editassets")
{
	//including the database connection file
include_once("config.php");
$query = new SQL();
if(isset($_POST['txt_Vendor']))
{
   $id=$_POST['txt_ID'];
   $Vendor = $_POST['txt_Vendor'];
   $datesubmitted = $_POST['txt_DateSubmitted'];
   $dt=date('Y-m-d', strtotime($datesubmitted));
   $statementofwork = $_POST['txt_StatementOfWork'];
   $workpallets = $_POST['txt_NumberOfPallets'];
   $pickuplocation = $_POST['txt_PickupLocation'];
   $localRIMcontact = $_POST['txt_LocalRIMContact'];
   $AssetType = $_POST['txt_AssetType'];
   $AssetID = $_POST['txt_AssetID'];
   $Manufacturer = $_POST['txt_Manufacturer'];
   $Model = $_POST['txt_Model'];
   $SerialNo = $_POST['txt_SerialNo'];
   $WO = $_POST['txt_WO'];
   $Description = $_POST['txt_Description'];
   $Weight = $_POST['txt_Weight'];
	$sql="UPDATE ".$env->ewasteDB.".[dbo].tbl_asset_tracking set Vendor='$Vendor',Date_Submitted='$dt',StatementOfWork='$statementofwork',NumberOfPallets=$workpallets,PickUpLocation='$pickuplocation',LocalRIMContact='$localRIMcontact',Asset_Type='$AssetType',Asset_ID='$AssetID',Manufacturer='$Manufacturer',Model='$Model',Serial_No='$SerialNo',Description='$Description',Weight='$Weight',LoadID='$WO' WHERE ID='$id'";
	//echo $sql;
	$result = $query->query($sql);

}
}
else if(isset($_POST['Indi_multipleupdate']))
{
 include('config.php');
  $query = new SQL();
 $id=$_POST['id'];

   $Vendor = $_POST['txt_Vendor'];
  // print_r($id);
	$datesubmitted = $_POST['txt_DateSubmitted'];

	$statementofwork = $_POST['txt_StatementOfWork'];
	$workpallets = $_POST['txt_NumberOfPallets'];
	$pickuplocation = $_POST['txt_PickupLocation'];
	$localRIMcontact = $_POST['txt_LocalRIMContact'];
	$AssetType = $_POST['txt_AssetType'];
	$AssetID = $_POST['txt_AssetID'];
    $Manufacturer = $_POST['txt_Manufacturer'];
	$Model = $_POST['txt_Model'];
    $SerialNo = $_POST['txt_SerialNo'];
	$WO=$_POST['txt_WO'];
	$Description = $_POST['txt_Description'];
    $Weight = $_POST['txt_Weight'];
	$N = count($id);
	for($i=0; $i < $N; $i++)
{
  $dt=date('Y-m-d', strtotime($datesubmitted[$i]));
  $sql="UPDATE ".$env->ewasteDB.".[dbo].tbl_asset_tracking set Vendor='$Vendor[$i]',Date_Submitted='$dt',StatementOfWork='$statementofwork[$i]',NumberOfPallets=$workpallets[$i],PickUpLocation='$pickuplocation[$i]',LocalRIMContact='$localRIMcontact[$i]',Asset_Type='$AssetType[$i]',Asset_ID='$AssetID[$i]',Manufacturer='$Manufacturer[$i]',Model='$Model[$i]',Serial_No='$SerialNo[$i]',Description='$Description[$i]',Weight='$Weight[$i]',LoadID='$WO[$i]' WHERE ID='$id[$i]'";
	//echo $sql;
	$result = $query->query($sql);
	header("location:overview.php");
}

}
else if(isset($_POST['Indi_multipleupdate_bulk']))
{
	include('config.php');
 $Arr=Array();
 $query = new SQL();
 $id=$_SESSION['ID'];
 $N = count($id);
 for($i=0; $i < 1; $i++)
 {
	$sql="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] where ID='$id[$i]'";
	$result = $query->query($sql);
	foreach($result as $row)
	    {
			if($result[0]["Vendor"]!=$_POST['txt_Vendor'])
			{

				array_push($Arr,"Vendor");
			}

			if($result[0]["Date_Submitted"]!=$_POST['txt_DateSubmitted'])
			{
				array_push($Arr,"DateSubmitted");
			}

			if($result[0]["StatementOfWork"]!=$_POST['txt_StatementOfWork'])
			{
				array_push($Arr,"SOW");
			}

			if($result[0]["NumberOfPallets"]!=$_POST['txt_NumberOfPallets'])
			{
				array_push($Arr,"Pallets");
			}

			if($result[0]["PickUpLocation"]!=$_POST['txt_PickupLocation'])
			{
				array_push($Arr,"Location");
			}

			if($result[0]["LocalRIMContact"]!=$_POST['txt_LocalRIMContact'])
			{
				array_push($Arr,"Contact");
			}

			if($result[0]["LoadID"]!=$_POST['txt_WO'])
			{
				array_push($Arr,"WO");
			}

		}
 }
 for($i=0; $i < $N; $i++)
      {
       $sql="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] where ID='$id[$i]'";
	   $result = $query->query($sql);
	     foreach($result as $row)
	    {
			$ID=$row["ID"];
			if(in_array("Vendor",$Arr))
			{
				$Vendor=$_POST['txt_Vendor'];
			}
			else
			{
				$Vendor=$row['Vendor'];
			}

			if(in_array("DateSubmitted",$Arr))
			{
				$datesubmitted = $_POST['txt_DateSubmitted'];
	            $dt=date('Y-m-d', strtotime($datesubmitted));
			}
			else
			{
				$datesubmitted = $row['Date_Submitted'];

			}

			if(in_array("SOW",$Arr))
			{
				$statementofwork = $_POST['txt_StatementOfWork'];

			}
			else
			{
				 $statementofwork = $row['StatementOfWork'];

			}

			if(in_array("Pallets",$Arr))
			{
				$workpallets = $_POST['txt_NumberOfPallets'];

			}
			else
			{
				 $workpallets = $row['NumberOfPallets'];

			}

			if(in_array("Location",$Arr))
			{
				$pickuplocation = $_POST['txt_PickupLocation'];

			}
			else
			{
				 $pickuplocation = $row['PickUpLocation'];

			}

			if(in_array("Contact",$Arr))
			{
				$localRIMcontact = $_POST['txt_LocalRIMContact'];

			}
			else
			{
				 $localRIMcontact = $row['LocalRIMContact'];
			}

			if(in_array("WO",$Arr))
			{
				$WO=$_POST['txt_WO'];
			}
			else
			{
				$WO = $row['LoadID'];
			}
			$sql="UPDATE ".$env->ewasteDB.".[dbo].tbl_asset_tracking set Vendor='$Vendor',Date_Submitted='$dt',StatementOfWork='$statementofwork',NumberOfPallets=$workpallets,PickUpLocation='$pickuplocation',LocalRIMContact='$localRIMcontact',LoadID='$WO' WHERE ID='$ID'";
	       // echo $sql;
	       $result = $query->query($sql);
		}
	  }

  header("Location:overview.php");

}
else if(isset($_POST['Search_MultiUpdate']))
{
	include('config.php');
  $query = new SQL();
 $id=$_POST['id'];

   $Vendor = $_POST['txt_Vendor'];
  // print_r($id);
	$datesubmitted = $_POST['txt_DateSubmitted'];

	$statementofwork = $_POST['txt_StatementOfWork'];
	$workpallets = $_POST['txt_NumberOfPallets'];
	$pickuplocation = $_POST['txt_PickupLocation'];
	$localRIMcontact = $_POST['txt_LocalRIMContact'];
	$AssetType = $_POST['txt_AssetType'];
	$AssetID = $_POST['txt_AssetID'];
    $Manufacturer = $_POST['txt_Manufacturer'];
	$Model = $_POST['txt_Model'];
    $SerialNo = $_POST['txt_SerialNo'];
	$WO=$_POST['txt_WO'];
	$Description = $_POST['txt_Description'];
    $Weight = $_POST['txt_Weight'];
	$N = count($id);
	for($i=0; $i < $N; $i++)
{
  $dt=date('Y-m-d', strtotime($datesubmitted[$i]));
  $sql="UPDATE ".$env->ewasteDB.".[dbo].tbl_asset_tracking set Vendor='$Vendor[$i]',Date_Submitted='$dt',StatementOfWork='$statementofwork[$i]',NumberOfPallets=$workpallets[$i],PickUpLocation='$pickuplocation[$i]',LocalRIMContact='$localRIMcontact[$i]',Asset_Type='$AssetType[$i]',Asset_ID='$AssetID[$i]',Manufacturer='$Manufacturer[$i]',Model='$Model[$i]',Serial_No='$SerialNo[$i]',Description='$Description[$i]',Weight='$Weight[$i]',LoadID='$WO[$i]' WHERE ID='$id[$i]'";
	//echo $sql;
	$result = $query->query($sql);
}

//header("Location:Search.php");
?>
<script>
window.history.go(-2);
</script>
<?php
}
else if($FuncType=='search')
{
	include('config.php');
    $msg="";
    $query = new SQL();
    $select_table="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] WHERE ";
	$select_table=$select_table.$_GET['query'];
	echo $select_table;
	$variable = $query->query($select_table);
	$rows = count($variable);
	$_SESSION['query']=$_GET['query'];
    $_SESSION['var']=$variable;

	$_SESSION['no_rows']=$rows;

	$s_Selection=$_GET['searchby'];
	$s_Vendor=$_GET['vendor'];
	$s_AssetType=$_GET['assettype'];
	$s_Manufacturer=$_GET['manufacturer'];
	$s_Model=$_GET['model'];
	$s_AssetID=$_GET['assetid'];
	$s_SerialNo=$_GET['serialno'];
	$s_WO=$_GET['wo'];

	if($s_Selection=="Vendor")
	{
		 $query_v = new SQL();
         $select_table_v="SELECT * FROM ".$env->ewasteDB.".[dbo].[VendorList] WHERE [Primary Vendor]= '".$s_Vendor."'";
	     echo $select_table_v;
	     $variable_v = $query->query($select_table_v);
		 $_SESSION['var_v']=$variable_v;
	}
	header("Location:Search.php?s_Vendor=".$s_Vendor."&s_AssetType=".$s_AssetType."&s_Manufacturer=".$s_Manufacturer
	."&s_Model=".$s_Model."&s_AssetID=".$s_AssetID
	."&s_SerialNo=".$s_SerialNo."&s_WO=".$s_WO."&var=".$variable."&selection=".$s_Selection);
?>
<script>
//history.back(-2);
</script>
<?php
}
else if($FuncType=='search_filter')
{
	include('config.php');
    $msg="";
    $query = new SQL();
	$s_WO=$_GET['wo'];
    $select_table="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] WHERE LoadID='".$s_WO."' and (Asset_Type='Unknown' or Manufacturer='Unknown' or Model='Unknown') ";
	echo $select_table;
	$variable = $query->query($select_table);
	$rows = count($variable);
	$_SESSION['query']=$select_table;
    $_SESSION['var']=$variable;

	$_SESSION['no_rows']=$rows;

	$s_Selection=$_GET['searchby'];
	$s_Vendor=$_GET['vendor'];
	$s_AssetType=$_GET['assettype'];
	$s_Manufacturer=$_GET['manufacturer'];
	$s_Model=$_GET['model'];
	$s_AssetID=$_GET['assetid'];
	$s_SerialNo=$_GET['serialno'];


	if($s_Selection=="Vendor")
	{
		 $query_v = new SQL();
         $select_table_v="SELECT * FROM ".$env->ewasteDB.".[dbo].[VendorList] WHERE [Primary Vendor]= '".$s_Vendor."'";
	     echo $select_table_v;
	     $variable_v = $query->query($select_table_v);
		 $_SESSION['var_v']=$variable_v;
	}
	header("Location:Search.php?s_Vendor=".$s_Vendor."&s_AssetType=".$s_AssetType."&s_Manufacturer=".$s_Manufacturer
	."&s_Model=".$s_Model."&s_AssetID=".$s_AssetID
	."&s_SerialNo=".$s_SerialNo."&s_WO=".$s_WO."&var=".$variable."&selection=".$s_Selection);
?>
<script>
//history.back(-2);
</script>
<?php
}
else if($FuncType=='Search_MultiUpdate_Bulk_adv_WO')
{
	include('config.php');
    $Arr=Array();
    $query = new SQL();
	echo $_GET['Vendor'];
	echo $_SESSION['var'][0]['ID'];
	//print_r($_SESSION['var']);
	//echo $_SESSION['no_rows'];
	$s_Selection=$_GET['searchby1'];
	$s_Vendor=$_GET['vendor1'];
	$s_AssetType=$_GET['assettype1'];
	$s_Manufacturer=$_GET['manufacturer1'];
	$s_Model=$_GET['model1'];
	$s_AssetID=$_GET['assetid1'];
	$s_SerialNo=$_GET['serialno1'];
	$s_WO=$_GET['wo1'];

	if($_SESSION['var'][0]["Vendor"]!=$_GET['Vendor'])
			{

				array_push($Arr,"Vendor");
			}

			if($_SESSION['var'][0]["Date_Submitted"]!=$_GET['Date_Submitted'])
			{
				array_push($Arr,"DateSubmitted");
			}

			if($_SESSION['var'][0]["StatementOfWork"]!=$_GET['sow'])
			{
				array_push($Arr,"SOW");
			}

			if($_SESSION['var'][0]["NumberOfPallets"]!=$_GET['pallets'])
			{
				array_push($Arr,"Pallets");
			}

			if($_SESSION['var'][0]["PickUpLocation"]!=$_GET['Plocation'])
			{
				array_push($Arr,"Location");
			}

			if($_SESSION['var'][0]["LocalRIMContact"]!=$_GET['contact'])
			{
				array_push($Arr,"Contact");
			}

			if($_SESSION['var'][0]["LoadID"]!=$_GET['wo'])
			{
				array_push($Arr,"WO");
			}
         for($i=0; $i < $_SESSION['no_rows']; $i++)
      {
		  	  $ID=$_SESSION['var'][$i]["ID"];
			  if(in_array("Vendor",$Arr))
			{
				$Vendor=$_GET['Vendor'];
			}
			else
			{
				$Vendor=$_SESSION['var'][$i]['Vendor'];
			}

			if(in_array("DateSubmitted",$Arr))
			{
				$datesubmitted = $_GET['Date_Submitted'];
	            $dt=date('Y-m-d', strtotime($datesubmitted));
			}
			else
			{
				$datesubmitted = $_SESSION['var'][$i]['Date_Submitted'];

			}

			if(in_array("SOW",$Arr))
			{
				$statementofwork = $_GET['sow'];

			}
			else
			{
				 $statementofwork = $_SESSION['var'][$i]['StatementOfWork'];

			}

			if(in_array("Pallets",$Arr))
			{
				$workpallets = $_GET['pallets'];

			}
			else
			{
				 $workpallets = $_SESSION['var'][$i]['NumberOfPallets'];

			}

			if(in_array("Location",$Arr))
			{
				$pickuplocation = $_GET['Plocation'];

			}
			else
			{
				 $pickuplocation = $_SESSION['var'][$i]['PickUpLocation'];

			}

			if(in_array("Contact",$Arr))
			{
				$localRIMcontact = $_GET['contact'];

			}
			else
			{
				 $localRIMcontact = $_SESSION['var'][$i]['LocalRIMContact'];
			}

			if(in_array("WO",$Arr))
			{
				$WO=$_GET['wo'];
			}
			else
			{
				$WO = $_SESSION['var'][$i]['LoadID'];
			}

			$sql="UPDATE ".$env->ewasteDB.".[dbo].tbl_asset_tracking set Vendor='$Vendor',Date_Submitted='$dt',StatementOfWork='$statementofwork',NumberOfPallets=$workpallets,PickUpLocation='$pickuplocation',LocalRIMContact='$localRIMcontact',LoadID='$WO' WHERE ID='$ID'";
	        // echo $sql;
	       $result = $query->query($sql);
		   $query = new SQL();
           $select_table="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] WHERE ";
	       $select_table=$select_table.$_SESSION['query'];
	      //  echo $select_table;
	       $variable = $query->query($select_table);
	       $rows = count($variable);
	       $_SESSION['var']=$variable;
	       $_SESSION['no_rows']=$rows;
 }

header("Location:Search.php?s_Vendor=".$s_Vendor."&s_AssetType=".$s_AssetType."&s_Manufacturer=".$s_Manufacturer
	."&s_Model=".$s_Model."&s_AssetID=".$s_AssetID
	."&s_SerialNo=".$s_SerialNo."&s_WO=".$s_WO."&var=".$variable."&selection=".$s_Selection);
 //header("Location:Search.php");
}
else if($FuncType=='Search_MultiUpdate_Bulk_adv_Vendor')
{
	include('config.php');
    $Arr=Array();
    $query = new SQL();
	//echo $_GET['Vendor'];
	//echo $_SESSION['var'][0]['ID'];
	//print_r($_SESSION['var']);
	//echo $_SESSION['no_rows'];
	$s_Selection=$_GET['searchby1'];
	$s_Vendor=$_GET['vendor1'];
	$s_AssetType=$_GET['assettype1'];
	$s_Manufacturer=$_GET['manufacturer1'];
	$s_Model=$_GET['model1'];
	$s_AssetID=$_GET['assetid1'];
	$s_SerialNo=$_GET['serialno1'];
	$s_WO=$_GET['wo1'];
	 $PrimaryVendor=$_GET['PrimaryVendor'];
  $SecondaryVendor=$_GET['SecondaryVendor'];
  $VendorLocation=$_GET['VendorLocation'];
  $ApprovalStatus=$_GET['ApprovalStatus'];
  $Resale=$_GET['Resale'];
  $Recycling=$_GET['Recycling'];
  $RecyclingType=$_GET['RecyclingType'];
  $DeviceDestruction=$_GET['DeviceDestruction'];
  $HDWiping=$_GET['HDWiping'];
  $VendorSecurity=$_GET['VendorSecurity'];
  $Environment=$_GET['Environment'];
  $Contract=$_GET['Contract'];
  $PickupProcess=$_GET['PickupProcess'];
  $Notes=$_GET['Notes'];
//  $s_Vendor=$_GET['s_Vendor'];

  $query = new SQL();
  $sql="UPDATE".$env->ewasteDB.".[dbo].VendorList set [Secondary Vendor _(would have contact with site)]='$SecondaryVendor',Location='$VendorLocation',[Approval Status]='$ApprovalStatus',
  Resale='$Resale',Recycling='$Recycling',[Type of recycling]='$RecyclingType',[Pre-Release and Device Destruction]='$DeviceDestruction',[Hard Drive Wiping]='$HDWiping',
  [Vendor Security Assessment]='$VendorSecurity',[Environment Assessment]='$Environment',[Contract in Place]='$Contract',[Pickup Process]='$PickupProcess',Notes='$Notes'
  where [Primary Vendor]='$PrimaryVendor'";

	echo $sql;
	       $result = $query->query($sql);

		/*    $query = new SQL();
           $select_table="SELECT * FROM ".$env->ewasteDB.".[dbo].[VendorList]";
	       $variable = $query->query($select_table); */

		    $query_v = new SQL();
         $select_table_v="SELECT * FROM ".$env->ewasteDB.".[dbo].[VendorList] WHERE [Primary Vendor]= '".$s_Vendor."'";
	     echo $select_table_v;
	     $variable_v = $query->query($select_table_v);
		 $_SESSION['var_v']=$variable_v;

		   $query = new SQL();
           $select_table="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] WHERE ";
	       $select_table=$select_table.$_SESSION['query'];
	       echo $select_table;
	       $variable = $query->query($select_table);
	       $rows = count($variable);
	       $_SESSION['var']=$variable;
	       $_SESSION['no_rows']=$rows;


header("Location:Search.php?s_Vendor=".$s_Vendor."&s_AssetType=".$s_AssetType."&s_Manufacturer=".$s_Manufacturer
	."&s_Model=".$s_Model."&s_AssetID=".$s_AssetID
	."&s_SerialNo=".$s_SerialNo."&s_WO=".$s_WO."&var=".$variable."&selection=".$s_Selection);
 //header("Location:Search.php");
}
else if($FuncType=='AddNewVendor')
{
  include('simpleConfig1.php');
  $query = new SQL();

  $PrimaryVendor=$_GET['PrimaryVendor'];
  $SecondaryVendor=$_GET['SecondaryVendor'];
  $VendorLocation=$_GET['VendorLocation'];
  $ApprovalStatus=$_GET['ApprovalStatus'];
  $Resale=$_GET['Resale'];
  $Recycling=$_GET['Recycling'];
  $RecyclingType=$_GET['RecyclingType'];
  $DeviceDestruction=$_GET['DeviceDestruction'];
  $HDWiping=$_GET['HDWiping'];
  $VendorSecurity=$_GET['VendorSecurity'];
  $Environment=$_GET['Environment'];
  $Contract=$_GET['Contract'];
  $PickupProcess=$_GET['PickupProcess'];
  $Notes=$_GET['Notes'];
  $s_Vendor=$_GET['s_Vendor'];
  $query = new SQL();
  $sql="Insert Into ".$env->ewasteDB.".[dbo].VendorList values('$PrimaryVendor','$SecondaryVendor','$VendorLocation','$ApprovalStatus','$Resale','$Recycling',
   '$RecyclingType','$DeviceDestruction','$HDWiping','$VendorSecurity','$Environment','$Contract','$PickupProcess','$Notes')";
  echo $sql;
  $result = $query->query($sql);

  header("Location:Search.php?selection=Vendor&s_Vendor=".$s_Vendor);
}
else if($FuncType=='AddNewVendor_Admin')
{
  include('simpleConfig1.php');
  $query = new SQL();

  $PrimaryVendor=$_GET['PrimaryVendor'];
  $SecondaryVendor=$_GET['SecondaryVendor'];
  $VendorLocation=$_GET['VendorLocation'];
  $ApprovalStatus=$_GET['ApprovalStatus'];
  $Resale=$_GET['Resale'];
  $Recycling=$_GET['Recycling'];
  $RecyclingType=$_GET['RecyclingType'];
  $DeviceDestruction=$_GET['DeviceDestruction'];
  $HDWiping=$_GET['HDWiping'];
  $VendorSecurity=$_GET['VendorSecurity'];
  $Environment=$_GET['Environment'];
  $Contract=$_GET['Contract'];
  $PickupProcess=$_GET['PickupProcess'];
  $Notes=$_GET['Notes'];

  $query = new SQL();
  $sql="Insert Into ".$env->ewasteDB.".[dbo].VendorList values('$PrimaryVendor','$SecondaryVendor','$VendorLocation','$ApprovalStatus','$Resale','$Recycling',
   '$RecyclingType','$DeviceDestruction','$HDWiping','$VendorSecurity','$Environment','$Contract','$PickupProcess','$Notes')";
  echo $sql;
  $result = $query->query($sql);

  header("Location:admin.php");
}
else if($FuncType=='Search_MultiUpdate_Bulk')
{
	include('config.php');
    $Arr=Array();
    $query = new SQL();
	$id=$_SESSION['ID'];
	//echo $id;
 $N = count($id);
 for($i=0; $i < 1; $i++)
 {
	$sql="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] where ID='$id[$i]'";
	$result = $query->query($sql);
	//print_r($_SESSION['var']);
	//echo $_SESSION['no_rows'];
	//$s_Selection=$_GET['searchby1'];

	if($result[0]["Vendor"]!=$_GET['Vendor'])
			{

				array_push($Arr,"Vendor");
			}

			if($result[0]["Date_Submitted"]!=$_GET['Date_Submitted'])
			{
				array_push($Arr,"DateSubmitted");
			}

			if($result[0]["StatementOfWork"]!=$_GET['sow'])
			{
				array_push($Arr,"SOW");
			}

			if($result[0]["NumberOfPallets"]!=$_GET['pallets'])
			{
				array_push($Arr,"Pallets");
			}

			if($result[0]["PickUpLocation"]!=$_GET['Plocation'])
			{
				array_push($Arr,"Location");
			}

			if($result[0]["LocalRIMContact"]!=$_GET['contact'])
			{
				array_push($Arr,"Contact");
			}

			if($result[0]["LoadID"]!=$_GET['wo'])
			{
				array_push($Arr,"WO");
			}
    }
        for($i=0; $i < $N; $i++)
      {
		  $sql="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] where ID='$id[$i]'";
	   $result = $query->query($sql);
	     foreach($result as $row)
	    {
		  	$ID=$row["ID"];
			  if(in_array("Vendor",$Arr))
			{
				$Vendor=$_GET['Vendor'];
			}
			else
			{
				$Vendor=$row['Vendor'];
			}

			if(in_array("DateSubmitted",$Arr))
			{
				$datesubmitted = $_GET['Date_Submitted'];
	            $dt=date('Y-m-d', strtotime($datesubmitted));
			}
			else
			{
				$datesubmitted = $row['Date_Submitted'];

			}

			if(in_array("SOW",$Arr))
			{
				$statementofwork = $_GET['sow'];

			}
			else
			{
				 $statementofwork = $row['StatementOfWork'];

			}

			if(in_array("Pallets",$Arr))
			{
				$workpallets = $_GET['pallets'];

			}
			else
			{
				 $workpallets = $row['NumberOfPallets'];

			}

			if(in_array("Location",$Arr))
			{
				$pickuplocation = $_GET['Plocation'];

			}
			else
			{
				 $pickuplocation = $row['PickUpLocation'];

			}

			if(in_array("Contact",$Arr))
			{
				$localRIMcontact = $_GET['contact'];

			}
			else
			{
				 $localRIMcontact = $row['LocalRIMContact'];
			}

			if(in_array("WO",$Arr))
			{
				$WO=$_GET['wo'];
			}
			else
			{
				$WO = $row['LoadID'];
			}

			$sql="UPDATE ".$env->ewasteDB.".[dbo].tbl_asset_tracking set Vendor='$Vendor',Date_Submitted='$dt',StatementOfWork='$statementofwork',NumberOfPallets=$workpallets,PickUpLocation='$pickuplocation',LocalRIMContact='$localRIMcontact',LoadID='$WO' WHERE ID='$ID'";
	        echo $sql;
	       $result = $query->query($sql);
		   $query = new SQL();
           $select_table="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] WHERE ";
	       $select_table=$select_table.$_SESSION['query'];
	       echo $select_table;
	       $variable = $query->query($select_table);
	       $rows = count($variable);
	       $_SESSION['var']=$variable;
	       $_SESSION['no_rows']=$rows;
		}
 }

header("Location:Search.php?var=".$variable);

}
else if($FuncType=="Add_MultipleAssets")
{
	Add_MultipleAssets();
}
if($FuncType=="FillLoadID")
{
	include('config.php');
  $query = new SQL();
$id=$_REQUEST['id'];
$sql="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] WHERE LoadID='$id'";
$result = $query->query($sql);
//echo $sql;
//$array = mysql_fetch_row($result);

echo json_encode($result);
}
else if($FuncType=="WO")
{
 require_once("config.php");
$query = new SQL();
//$db_handle = new DBController();
if(!empty($_POST["keyword"])) {
$sql ="SELECT DISTINCT LoadID FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] WHERE LoadID like '" . $_POST["keyword"] . "%' ORDER BY LoadID";

$result = $query->query($sql);
if(!empty($result)) {
?>
<ul style='padding-left:5px;' id="vendor-list">
<?php
foreach($result as $type) {
//	echo $type['LoadID'];
?>
<li class='typeahead' onClick="selectWO('<?php echo $type['LoadID']; ?>');"><?php echo $type['LoadID']; ?></li>
<?php } ?>
</ul>
<?php } }
}
else if($FuncType=="WO1")
{
 require_once("config.php");
$query = new SQL();
//$db_handle = new DBController();
if(!empty($_POST["keyword"])) {
$sql ="SELECT DISTINCT LoadID FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] WHERE LoadID like '" . $_POST["keyword"] . "%' ORDER BY LoadID";

$result = $query->query($sql);
if(!empty($result)) {
?>
<ul style='padding-left:5px;' id="vendor-list">
<?php
foreach($result as $type) {
//	echo $type['LoadID'];
?>
<li class='typeahead' onClick="selectWO1('<?php echo $type['LoadID']; ?>');"><?php echo $type['LoadID']; ?></li>
<?php } ?>
</ul>
<?php } }
}
else if($FuncType=="vendor")
{
	vendor();
}
else if($FuncType=="vendor1")
{
 require_once("config.php");
$query = new SQL();
//$db_handle = new DBController();
if(!empty($_POST["keyword"])) {
$sql ="SELECT DISTINCT [Primary Vendor] FROM ".$env->ewasteDB.".[dbo].[VendorList] WHERE [Primary Vendor] like '" . $_POST["keyword"] . "%' ORDER BY [Primary Vendor]";

$result = $query->query($sql);
if(!empty($result)) {
?>
<ul style='padding-left:5px;' id="vendor-list">
<?php
foreach($result as $type) {
?>
<li class='typeahead' onClick="selectVendor1('<?php echo $type["Primary Vendor"]; ?>');"><?php echo $type["Primary Vendor"]; ?></li>
<?php } ?>
</ul>
<?php } }
}
else if($FuncType=="vendor2")
{
 require_once("config.php");
$query = new SQL();
//$db_handle = new DBController();
if(!empty($_POST["keyword"])) {
$sql ="SELECT DISTINCT [Primary Vendor] FROM ".$env->ewasteDB.".[dbo].[VendorList] WHERE [Primary Vendor] like '" . $_POST["keyword"] . "%' ORDER BY [Primary Vendor]";

$result = $query->query($sql);
if(!empty($result)) {
?>
<ul style='padding-left:5px;' id="vendor-list">
<?php
foreach($result as $type) {
?>
<li class='typeahead' onClick="selectVendor2('<?php echo $type["Primary Vendor"]; ?>');"><?php echo $type["Primary Vendor"]; ?></li>
<?php } ?>
</ul>
<?php } }
}
else if($FuncType=="location")
{
	require_once("config.php");
$query = new SQL();
//$db_handle = new DBController();
if(!empty($_POST["keyword"])) {
$sql ="SELECT DISTINCT [Site Location] FROM ".$env->ewasteDB.".[dbo].[SiteList] WHERE [Site Location] like '" . $_POST["keyword"] . "%' ORDER BY [Site Location]";

$result = $query->query($sql);
if(!empty($result)) {
?>
<ul style='padding-left:5px;' id="location-list">
<?php
foreach($result as $type) {
?>
<li class="typeahead" onClick="selectLocation('<?php echo $type["Site Location"]; ?>');"><?php echo $type["Site Location"]; ?></li>
<?php } ?>
</ul>
<?php } }
}
else if($FuncType=="location1")
{
	require_once("config.php");
$query = new SQL();
//$db_handle = new DBController();
if(!empty($_POST["keyword"])) {
$sql ="SELECT DISTINCT [Site Location] FROM ".$env->ewasteDB.".[dbo].[SiteList] WHERE [Site Location] like '" . $_POST["keyword"] . "%' ORDER BY [Site Location]";

$result = $query->query($sql);
if(!empty($result)) {
?>
<ul style='padding-left:5px;' id="location-list">
<?php
foreach($result as $type) {
?>
<li class="typeahead" onClick="selectLocation1('<?php echo $type["Site Location"]; ?>');"><?php echo $type["Site Location"]; ?></li>
<?php } ?>
</ul>
<?php } }
}
else if($FuncType=="location2")
{
	require_once("config.php");
$query = new SQL();
//$db_handle = new DBController();
if(!empty($_POST["keyword"])) {
$sql ="SELECT DISTINCT [Site Location] FROM ".$env->ewasteDB.".[dbo].[SiteList] WHERE [Site Location] like '" . $_POST["keyword"] . "%' ORDER BY [Site Location]";

$result = $query->query($sql);
if(!empty($result)) {
?>
<ul style='padding-left:5px;' id="location-list">
<?php
foreach($result as $type) {
?>
<li class="typeahead" onClick="selectLocation2('<?php echo $type["Site Location"]; ?>');"><?php echo $type["Site Location"]; ?></li>
<?php } ?>
</ul>
<?php } }
}
else if($FuncType=="assettype")
{
	require_once("config.php");
$query = new SQL();
//$db_handle = new DBController();
if(!empty($_POST["keyword"])) {
$sql ="SELECT DISTINCT Asset_Type FROM ".$env->ewasteDB.".[dbo].[tbl_manufacturer] WHERE Asset_Type like '" . $_POST["keyword"] . "%' ORDER BY Asset_Type";

$result = $query->query($sql);
if(!empty($result)) {
?>
<ul style='padding-left:5px;' id="asset-list">
<?php
foreach($result as $type) {
?>
<li class="typeahead" onClick="selectAssetType('<?php echo $type["Asset_Type"]; ?>');"><?php echo $type["Asset_Type"]; ?></li>
<?php } ?>
</ul>
<?php } }
}
else if($FuncType=="assettype1")
{
	require_once("config.php");
$query = new SQL();
//$db_handle = new DBController();
if(!empty($_POST["keyword"])) {
$sql ="SELECT DISTINCT Asset_Type FROM ".$env->ewasteDB.".[dbo].[tbl_manufacturer] WHERE Asset_Type like '" . $_POST["keyword"] . "%' ORDER BY Asset_Type";

$result = $query->query($sql);
if(!empty($result)) {
?>
<ul style='padding-left:5px;' id="asset-list">
<?php
foreach($result as $type) {
?>
<li class="typeahead" onClick="selectAssetType1('<?php echo $type["Asset_Type"]; ?>');"><?php echo $type["Asset_Type"]; ?></li>
<?php } ?>
</ul>
<?php
 } }

}
else if($FuncType=="assettype2")
{
	require_once("config.php");
$query = new SQL();
//$db_handle = new DBController();
if(!empty($_POST["keyword"])) {
$sql ="SELECT DISTINCT Asset_Type FROM ".$env->ewasteDB.".[dbo].[tbl_manufacturer] WHERE Asset_Type like '" . $_POST["keyword"] . "%' ORDER BY Asset_Type";

$result = $query->query($sql);
if(!empty($result)) {
?>
<ul id="asset-list">
<?php
foreach($result as $type) {
?>
<li onClick="selectAssetType2('<?php echo $type["Asset_Type"]; ?>');"><?php echo $type["Asset_Type"]; ?></li>
<?php } ?>
</ul>
<?php } }
}
else if($FuncType=="manufacturer")
{
	require_once("config.php");
$query = new SQL();
//$db_handle = new DBController();
if(!empty($_POST["keyword"])) {
$sql ="SELECT DISTINCT Manufacturer FROM ".$env->ewasteDB.".[dbo].[tbl_manufacturer] WHERE Manufacturer like '" . $_POST["keyword"] . "%' ORDER BY Manufacturer";
$result = $query->query($sql);
if(!empty($result)) {
?>
<ul style='padding-left:5px;' id="Manufacturer-list">
<?php
foreach($result as $country) {
?>
<li class="typeahead" onClick="selectManufacturer('<?php echo $country["Manufacturer"]; ?>');"><?php echo $country["Manufacturer"]; ?></li>
<?php } ?>
</ul>
<?php } }
}
else if($FuncType=="manufacturer1")
{
	include('config.php');
  $query = new SQL();
//$db_handle = new DBController();
if(!empty($_POST["keyword"])) {
$sql ="SELECT DISTINCT Manufacturer FROM ".$env->ewasteDB.".[dbo].[tbl_manufacturer] WHERE Manufacturer like '" . $_POST["keyword"] . "%' ORDER BY Manufacturer";
$result = $query->query($sql);
if(!empty($result)) {
?>
<ul id="Manufacturer-list">
<?php
foreach($result as $country) {
?>
<li onClick="selectManufacturer1('<?php echo $country["Manufacturer"]; ?>');"><?php echo $country["Manufacturer"]; ?></li>
<?php } ?>
</ul>
<?php } }
}
else if($FuncType=="model")
{
	require_once("config.php");
$query = new SQL();
//$db_handle = new DBController();
if(!empty($_POST["keyword"])) {
$sql ="SELECT DISTINCT Model FROM ".$env->ewasteDB.".[dbo].[tbl_manufacturer] WHERE Model like '" . $_POST["keyword"] . "%' ORDER BY Model";

$result = $query->query($sql);
if(!empty($result)) {
?>
<ul  style='padding-left:5px;' id="Model-list">
<?php
foreach($result as $model) {
?>
<li class="typeahead" onClick="selectModel('<?php echo $model["Model"]; ?>');"><?php echo $model["Model"]; ?></li>
<?php } ?>
</ul>
<?php } }
}
else if($FuncType=="model1")
{
	include('config.php');
  $query = new SQL();
if(!empty($_POST["keyword"])) {
$sql ="SELECT DISTINCT Model FROM ".$env->ewasteDB.".[dbo].[tbl_manufacturer] WHERE Model like '" . $_POST["keyword"] . "%' ORDER BY Model";
$result = $query->query($sql);
if(!empty($result)) {
?>
<ul id="Model-list">
<?php
foreach($result as $model) {
?>
<li onClick="selectModel1('<?php echo $model["Model"]; ?>');"><?php echo $model["Model"]; ?></li>
<?php } ?>
</ul>
<?php } }
}
else
{
?>
<?php
if($FuncType == "vendor" || $FuncType == "vendor1" || $FuncType == "location" || $FuncType == "location1" || $FuncType == "assettype" || $FuncType == "assettype1"
 || $FuncType == "assettype2" || $FuncType == "manufacturer" || $FuncType == "manufacturer1" || $FuncType == "model" || $FuncType == "model1" || $FuncType=="View")
{

}
else
{
?>
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
	 <link rel="shortcut icon" href="favicon.ico" />
 <title>Asset Disposal Tracking Form</title>
 <!-- AJAX -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
 <!-- JQuery -->
 <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
 <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.js"></script>
 <!-- CSS (FA v4.5.0 & BS v3.3.6) -->
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/custom.css">
 <!-- <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css"> -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
 <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
 <!-- JavaScript & JQuery -->
 <script src='js/bootstrap.min.js'></script>
 <script src="js/highlightNav.js"></script>
 <script src="js/Asset_Tracking.js"></script>
 <!-- Data Tables -->
 <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css">
 <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
 <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
 <script type="text/javascript" charset="utf8" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
 <script type="text/javascript" charset="utf8" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
 <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.html5.min.js"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
 <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">

</head>
<!-- <body onload="loaddata();"> -->
<!-- Header -->
<!-- Navigation -->
<div id='navigation'>
	<nav class="navbar navbar-default">
		<div class="container-fluid" style='padding: 0 150px;'>
			<div class="navbar-header">
				<a class="navbar-brand" href="#">
					<img alt="BlackBerry" src="images/bb-full.png" style='width:145px;'>
				</a>
				<text class='header-text'>ASSET DISPOSAL TRACKING</text>
			</div>
			<ul class="nav navbar-nav navbar-right" style=''>
					<li><a href="index.php"><i class="fa fa-home fa-2x fa-fw"></i></a></li>
					<li><a href="Search.php"><i class="fa fa-search fa-2x fa-fw"></i></a></li>
					<li><a href="overview.php"><i class="fa fa-pie-chart fa-2x fa-fw"></i></a></li>
				</ul>
			</div>
		</nav>
	</div>

<!-- Page Content -->
<div class='container'>
<?php
}
if($FuncType=="Indi_EditMultiple")
{
	IndiAssets_EditMultiple();
	echo "</body>";
    echo "</html>";
}
else if($FuncType=="Indi_EditMultiple_bulk")
{
	IndiAssets_EditMultiple_Bulk();
	echo "</body>";
    echo "</html>";
}
else if($FuncType=="Search_EditMultiple_bulk")
{
	Search_EditMultiple_Bulk();
	echo "</body>";
    echo "</html>";
}
else if($FuncType=="Search_EditMultiple")
{
	 Search_EditMultiple();
	 echo "</body>";
    echo "</html>";
}
else if($FuncType=="Search_MultiView")
{
	 Search_MultiView();
	 echo "</body>";
    echo "</html>";
}
else if($FuncType=="Indi_MultiView")
{
	IndiAssets_MultiView();
	echo "</body>";
    echo "</html>";

}
else if($FuncType=="Indi_EditMultiView")
{
	IndiAssets_EditMultiView();
	echo "</body>";
    echo "</html>";
}
else if($FuncType=="Edit_MultiView")
{
	EditMultiView();
	echo "</body>";
    echo "</html>";
}
?>

<?php
}
?>
<?php
function IndiAssets_EditMultiple()
{
?>
 <!-- Instructions -->
    <div class='col-md-12'>
      <div class="alert alert-info" role="alert">
        <p style='font-size:2em; font-weight:800;'>INSTRUCTIONS: Hit update once you make your changes...</p>
        <!-- <p style='font-size:14px;'>Some text here to explain...</p> -->
      </div>
    </div>
  <form action="common.php" method="post" name="form1" class='form'>
   <?php
   //Database Connection
    include('config.php');
    $query = new SQL();
    if($_GET['chb']){
	  $ar=$_GET['chb'];
	  $idArr = explode(",",$ar);
      $N = count($idArr);
	  for($i=0; $i < $N; $i++)
      {
       $sql="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] where ID='$idArr[$i]'";
	   $result = $query->query($sql);
	   foreach($result as $row)
	   {
	    $id=$row['ID'];
	    $Vendor = $row['Vendor'];
	      //$dt=$row['Date_Submitted'];
	      //$datesubmitted = date_format($dt,"Y-m-d");
	    $datesubmitted = $row['Date_Submitted'];
	    $statementofwork = $row['StatementOfWork'];
	    $workpallets = $row['NumberOfPallets'];
	    $pickuplocation = $row['PickUpLocation'];
	    $localRIMcontact = $row['LocalRIMContact'];
	    $AssetType = $row['Asset_Type'];
	    $AssetID = $row['Asset_ID'];
        $Manufacturer = $row['Manufacturer'];
	    $Model = $row['Model'];
        $SerialNo = $row['Serial_No'];
		$WO = $row['LoadID'];
		$Description = $row['Description'];
        $Weight = $row['Weight'];
    ?>
  <!-- Left Column -->
  <div class='col-sm-6'>
   <div class='well' style="height:1000px;">
    <div class='form-group col-md-12'>
     <label for="txt_Vendor">Vendor:</label>
     <input class='form-control input-lg'  type="text" id="txt_Vendor" name="txt_Vendor[]" autocomplete="off" placeholder="Enter Vendor..." required value="<?php echo $Vendor;?>" />
     <span id="vendor" style="color:#FF0000;display:none;" title="Please Enter Vendor">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_DateSubmitted">Date Submitted:</label>
     <input class='form-control input-lg' type="date" id="datepicker" name='txt_DateSubmitted[]' required placeholder="YYYY-MM-DD" size="40" onclick="SetWhite(this.id);" value="<?php echo $datesubmitted;?>"/>
     <span id="datesubmitted" style="color:#FF0000;display:none;" title="Please Select Date">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_StatementOfWork">Statement of Work:</label>
     <input class='form-control input-lg' type="text" id="txt_StatementOfWork" name="txt_StatementOfWork[]" size="40" onkeyup="SetWhite(this.id);"  value="<?php echo $statementofwork;?>" />
     <span id="statementofwork" style="color:#FF0000;display:none;" title="Please Enter Work Statement">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_NumberOfPallets">Number of Pallets:</label>
     <input class='form-control input-lg' type="text" id="txt_NumberOfPallets" name="txt_NumberOfPallets[]" onkeyup="SetWhite(this.id);" size="40" value="<?php echo $workpallets;?>" />
     <span id="numberofpallets" style="color:#FF0000;display:none;" title="Please Enter Number Of Pallets">*</span>
    </div>
	<div class='form-group col-md-6'>
     <label for="txt_WO">Load ID (JIRA WO#):</label>
     <input type="text" class='form-control input-lg' id="txt_WO" name="txt_WO[]" size="40" value="<?php echo $WO;?>"  />
    </div>
    <div class='form-group col-md-12'>
     <label for="txt_PickupLocation">Pickup Location:</label>
     <input class='form-control input-lg' type="text" id="txt_PickupLocation" name="txt_PickupLocation[]" onkeyup="SetWhite(this.id);" size="40" value="<?php echo $pickuplocation;?>" />
     <span id="pickuplocation" style="color:#FF0000;display:none;" title="Please Enter Pickup Location">*</span>
    </div>
    <div class='form-group col-md-12'>
     <label for="txt_LocalRIMContact">Local BB Contact:</label>
     <textarea class='form-control input-lg' id="txt_LocalRIMContact" name="txt_LocalRIMContact[]" rows="2"  placeholder="Enter Local BlackBery Contact..." required><?php echo $localRIMcontact;?></textarea>
     <span id="localrimcontact" style="color:#FF0000;display:none;" title="Please Enter Contact Detail">*</span>
    </div>
    <div class='form-group col-md-12'>
     <label for="search-box">Asset Type:</label>
     <input type="text" class='form-control input-lg' onkeyup="ShowAssetType();" name="txt_AssetType[]" id="search-box" size="40" placeholder="Asset Type" autocomplete="off" value="<?php echo $AssetType; ?>" /><span id="assettype" style="color:#FF0000;display:none;" title="Please Select Asset Type">*</span>
     <div id="suggesstion-box"></div>
    </div>
    <div class='form-group col-md-6'>
     <label for="Manufactsearch-box">Manufacturer:</label>
     <input type="text" class='form-control input-lg' name="txt_Manufacturer[]" id="Manufactsearch-box" size="40" placeholder="Manufacturer" autocomplete="off" value="<?php echo $Manufacturer; ?>" /><span id="manufacturer" style="color:#FF0000;display:none;" title="Please Select Manufacturer">*</span>
     <div id="Manufact_suggesstion-box"></div>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_Model">Model:</label>
     <input type="text" class='form-control input-lg' name="txt_Model[]" id="txt_Model" placeholder="Model" size="40" autocomplete="off" value="<?php echo $Model; ?>" /><span id="model" style="color:#FF0000;display:none;" title="Please Select Model">*</span>
     <div id="Model_suggesstion-box"></div>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_AssetID">AssetID:</label>
     <input type="text" class='form-control input-lg' id="txt_AssetID" name="txt_AssetID[]" size="40" value="<?php echo $AssetID;?>"  />
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_SerialNo">Serial#:</label>
     <input type="text" id="txt_SerialNo" class='form-control input-lg' name="txt_SerialNo[]" size="40" value="<?php echo $SerialNo;?>" />

   </div>
   <div class='form-group col-md-12'>
       <label for="txt_Description1">Description (Optional):</label>
       <input type="text" class='form-control input-lg' id="txt_Description1" name="txt_Description[]" size="37" value="<?php echo $Description;?>" />
      </div>
   <div class='form-group col-md-12'>
       <label for="txt_Weight1"> Weight (LBS):</label>
       <input type="text" class='form-control input-lg' id="txt_Weight1" name="txt_Weight[]" size="37" value="<?php echo $Weight;?>" />
       <input type="hidden" name="id[]" value="<?php echo $id;?>" />
      </div>

  </div>
<?php
	  }
?>
</div>
<?php
	}
?>

 <?php
 }
?>
  <div class='col-sm-6'>
   <div class='well'>
   &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
   <a href="#" onclick="GOBack();"><u>Go Back</u></a>
   &nbsp; &nbsp;&nbsp; &nbsp;  &nbsp; &nbsp;&nbsp; &nbsp;  &nbsp; &nbsp;&nbsp; &nbsp;  &nbsp; &nbsp;
   <input type="submit" id="btnsubmit" class="btn btn-primary" name="Indi_multipleupdate"  value="Update" />
   &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
   </div>
  </div>
 </form>
 <?php
} //End of Indi_EditMultiple
function IndiAssets_EditMultiple_Bulk()
{
?>
	 <!-- Instructions -->
    <div class='col-md-12'>
      <div class="alert alert-info" role="alert">
				<p class='bolder' style='font-size:24px;'><i class='fa fa-edit fa-lg fa-fw'></i> <b class='bolder' style='font-size:22px;'>BULK EDIT:</b></p>
        <ul>
          <li class='big-font-bb'><p>The fields below are shared across the selected assets.</p></li>
          <li class='big-font-bb'><p>Edit the fields and save to update all of the assets with the new values.</p></li>
        </ul>
      </div>
    </div>
  <form action="common.php" method="post" name="form1" class='form'>
   <?php
   //Database Connection
    include('config.php');
    $query = new SQL();
    if($_GET['chb']){
	  $ar=$_GET['chb'];
	  $idArr = explode(",",$ar);
	  $_SESSION['ID']=$idArr;
			$N = count($idArr);
		$_SESSION['N']=$N;
      $N = count($idArr);
	  for($i=0; $i < 1; $i++)
      {
       $sql="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] where ID='$idArr[$i]'";
	   $result = $query->query($sql);
	   foreach($result as $row)
	   {
	    $id=$row['ID'];
	    $Vendor = $row['Vendor'];
	   //  $dt=$row['Date_Submitted'];
	     //$datesubmitted = date_format($dt,"Y-m-d");
	    $datesubmitted = $row['Date_Submitted'];
	    $statementofwork = $row['StatementOfWork'];
	    $workpallets = $row['NumberOfPallets'];
	    $pickuplocation = $row['PickUpLocation'];
	    $localRIMcontact = $row['LocalRIMContact'];
		$WO = $row['LoadID'];
    ?>
  <!-- Left Column -->
  <div class='col-sm-6'>
   <div class='well' style="height:500px;">
    <div class='form-group col-md-12'>
     <label for="txt_Vendor">Vendor:</label>
     <input class='form-control input-lg'  type="text" id="txt_Vendor" name="txt_Vendor" autocomplete="off" placeholder="Enter Vendor..." required value="<?php echo $Vendor;?>" />
	 <div id="VendorList"></div>
     <span id="vendor" style="color:#FF0000;display:none;" title="Please Enter Vendor">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_DateSubmitted">Date Submitted:</label>
     <input class='form-control input-lg' type="date" id="datepicker" name='txt_DateSubmitted' required placeholder="YYYY-MM-DD" size="40" onclick="SetWhite(this.id);" value="<?php echo $datesubmitted;?>"/>
     <span id="datesubmitted" style="color:#FF0000;display:none;" title="Please Select Date">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_StatementOfWork">Statement of Work:</label>
     <input class='form-control input-lg' type="text" id="txt_StatementOfWork" name="txt_StatementOfWork" size="40" onkeyup="SetWhite(this.id);"  value="<?php echo $statementofwork;?>" />
     <span id="statementofwork" style="color:#FF0000;display:none;" title="Please Enter Work Statement">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_NumberOfPallets">Number of Pallets:</label>
     <input class='form-control input-lg' type="text" id="txt_NumberOfPallets" name="txt_NumberOfPallets" onkeyup="SetWhite(this.id);" size="40" value="<?php echo $workpallets;?>" />
     <span id="numberofpallets" style="color:#FF0000;display:none;" title="Please Enter Number Of Pallets">*</span>
    </div>
	<div class='form-group col-md-6'>
     <label for="txt_WO">Load ID (JIRA WO#):</label>
     <input type="text" class='form-control input-lg' id="txt_WO" name="txt_WO" size="40" value="<?php echo $WO;?>"  />
    </div>
    <div class='form-group col-md-12'>
     <label for="txt_PickupLocation">Pickup Location:</label>
     <input class='form-control input-lg' type="text" id="txt_PickupLocation" name="txt_PickupLocation" autocomplete="off" onkeyup="SetWhite(this.id);" size="40" value="<?php echo $pickuplocation;?>" />
	 <div id="LocationList"></div>
     <span id="pickuplocation" style="color:#FF0000;display:none;" title="Please Enter Pickup Location">*</span>
    </div>
    <div class='form-group col-md-12'>
     <label for="txt_LocalRIMContact">Local BB Contact:</label>
     <textarea class='form-control input-lg' id="txt_LocalRIMContact" name="txt_LocalRIMContact" rows="2"  placeholder="Enter Local BlackBery Contact..." required><?php echo $localRIMcontact;?></textarea>
     <span id="localrimcontact" style="color:#FF0000;display:none;" title="Please Enter Contact Detail">*</span>
    </div>


  </div>
<?php
	  }
?>
</div>
<?php
	}
?>

 <?php
 }
?>
<div class='col-sm-6'>
 <div class='well row'>
	 <div class='col-sm-6'>
		<button class="btn btn-lg btn-primary btn-full" onclick="GOBack();">BACK</button>
	</div>
	<div class='col-sm-6'>
	<button type="button" id="btnsubmit" class="btn btn-success btn-lg btn-full" data-toggle="modal" data-target="#myModal11" name="Search_MultiUpdate_Bulk">UPDATE</button>
</div>
 </div>
</div>

 <div class='col-sm-6'>
    <?php
	  $query = new SQL();
     if($_GET['chb']){
	  $ar=$_GET['chb'];
	  $idArr = explode(",",$ar);
	   $sql="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] where ID='$idArr[0]'";
	  for($i=1; $i < count($idArr); $i++)
      {
       $sql=$sql." or ID='$idArr[$i]'";

      }

       $result = $query->query($sql);


	   ?>
	   <table id="tableid" class="display">
            <thead>
             <tr>

              <th><center>Vendor</center></th>
              <th><center>Statement Of Work</center></th>
			  <th><center>AssetType</center></th>
			  <th><center>Manufacturer</center></th>
			  <th><center>AssetID</center></th>
			  <th><center>Serial#</center></th>
			  <th><center>WO#</center></th>

             </tr>
            </thead>
	        <tbody>
             <?php
	          foreach($result as $row)
	         {
            ?>
           <tr>

            <td><center><?php echo $row['Vendor'];  ?></center></td>
			<td><center><?php echo $row['StatementOfWork'];  ?></center></td>
			<td><center><?php echo $row['Asset_Type'];  ?></center></td>
			<td><center><?php echo $row['Manufacturer'];  ?></center></td>
			<td><center><?php echo $row['Asset_ID'];  ?></center></td>
			<td><center><?php echo $row['Serial_No'];  ?></center></td>
			<td><center><?php echo $row['LoadID'];  ?></center></td>

          </tr>
        <?php
	       }

		 ?>
        </tbody>
       </table>
	   <?php
	 }
	?>
   </div>
 </form>
 <!-- Modal for bulk update -->
 <div class="modal fade" id="myModal11" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
 	<div class="modal-header row">
           <div class='col-xs-10 rm-padding'>
             <h3 class="modal-title">CONFIRM</h3>
           </div>
           <div class='col-xs-2 rm-padding'>
             <button type="button" onclick="div_hide();" data-dismiss="modal" class="close" aria-label="Close"><i class="fa fa-times fa-fw fa-2x"></i></button>
           </div>
         </div>
       <div class="modal-body">
             <!-- Success Message -->
               <div class="alert alert-success" role="alert">
                  <p style='font-size:22px; font-weight:800; text-align:center;'>You will update <font class="red-bb"><?php echo $_SESSION['N']; ?></font> asset records.</p>
               </div>


           </div>
       <div class="modal-footer">

         <button type="button" class="btn btn-warning btn-lg" onclick="updatedata_bulk(<?php echo $_GET['chb'];  ?>);">CONFIRM</button>

       </div>
     </div>
   </div>
 </div>
 <!-- End of modal -->
<?php
} //End of IndiAssets_EditMultiple_Bulk

function IndiAssets_MultiView()
{
?>
	<form action="editindividualexec.php" method="post" name="form1" class='form'>
   <?php
   //Database Connection
    include('config.php');
    $query = new SQL();
    if($_GET['chb']){
	  $ar=$_GET['chb'];
	  $idArr = explode(",",$ar);
	  $_SESSION["viewID"]=$idArr;
      $N = count($idArr);
	  for($i=0; $i < $N; $i++)
      {
       $sql="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] where ID='$idArr[$i]'";
	   $result = $query->query($sql);
	   foreach($result as $row)
	   {
	    $id=$row['ID'];
	    $Vendor = $row['Vendor'];
	     //$dt=$row['Date_Submitted'];
	     //$datesubmitted = date_format($dt,"Y-m-d");
	   $datesubmitted = $row['Date_Submitted'];
	    $statementofwork = $row['StatementOfWork'];
	    $workpallets = $row['NumberOfPallets'];
	    $pickuplocation = $row['PickUpLocation'];
	    $localRIMcontact = $row['LocalRIMContact'];
	    $AssetType = $row['Asset_Type'];
	    $AssetID = $row['Asset_ID'];
        $Manufacturer = $row['Manufacturer'];
	    $Model = $row['Model'];
        $SerialNo = $row['Serial_No'];
		$WO = $row['LoadID'];
		$Description = $row['Description'];
        $Weight = $row['Weight'];
    ?>
  <!-- Left Column -->
  <div class='col-sm-6'>
   <div class='well' style="height:900px">
    <div class='form-group col-md-12'>
     <label for="txt_Vendor">Vendor:</label>
     <input class='form-control input-lg'  type="text" id="txt_Vendor" name="txt_Vendor[]" readonly autocomplete="off" placeholder="Enter Vendor..." required value="<?php echo $Vendor;?>" />
     <span id="vendor" style="color:#FF0000;display:none;" title="Please Enter Vendor">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_DateSubmitted">Date Submitted:</label>
     <input class='form-control input-lg' type="date" id="datepicker" name='txt_DateSubmitted[]' readonly required placeholder="YYYY-MM-DD" size="40" onclick="SetWhite(this.id);" value="<?php echo $datesubmitted;?>"/>
     <span id="datesubmitted" style="color:#FF0000;display:none;" title="Please Select Date">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_StatementOfWork">Statement of Work:</label>
     <input class='form-control input-lg' type="text" id="txt_StatementOfWork" name="txt_StatementOfWork[]" readonly size="40" onkeyup="SetWhite(this.id);"  value="<?php echo $statementofwork;?>" />
     <span id="statementofwork" style="color:#FF0000;display:none;" title="Please Enter Work Statement">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_NumberOfPallets">Number of Pallets:</label>
     <input class='form-control input-lg' type="text" id="txt_NumberOfPallets" name="txt_NumberOfPallets[]" readonly onkeyup="SetWhite(this.id);" size="40" value="<?php echo $workpallets;?>" />
     <span id="numberofpallets" style="color:#FF0000;display:none;" title="Please Enter Number Of Pallets">*</span>
    </div>
	<div class='form-group col-md-6'>
     <label for="txt_WO">WO#:</label>
     <input type="text" class='form-control input-lg' id="txt_WO" name="txt_WO[]" size="40" readonly value="<?php echo $WO;?>"  />
    </div>
    <div class='form-group col-md-12'>
     <label for="txt_PickupLocation">Pickup Location:</label>
     <input class='form-control input-lg' type="text" id="txt_PickupLocation" name="txt_PickupLocation[]" readonly onkeyup="SetWhite(this.id);" size="40" value="<?php echo $pickuplocation;?>" />
     <span id="pickuplocation" style="color:#FF0000;display:none;" title="Please Enter Pickup Location">*</span>
    </div>
    <div class='form-group col-md-12'>
     <label for="txt_LocalRIMContact">Local BB Contact:</label>
	 <textarea class='form-control input-lg' id="txt_LocalRIMContact" name="txt_LocalRIMContact[]" rows="2" readonly  placeholder="Enter Local BlackBery Contact..." required><?php echo $localRIMcontact;?></textarea>
     <span id="localrimcontact" style="color:#FF0000;display:none;" title="Please Enter Contact Detail">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="search-box">Asset Type:</label>
     <input type="text" class='form-control input-lg' name="txt_AssetType[]" id="search-box" readonly size="40" placeholder="Asset Type" autocomplete="off" value="<?php echo $AssetType; ?>" /><span id="assettype" style="color:#FF0000;display:none;" title="Please Select Asset Type">*</span>
     <div id="suggesstion-box"></div>
    </div>
    <div class='form-group col-md-6'>
     <label for="Manufactsearch-box">Manufacturer:</label>
     <input type="text" class='form-control input-lg' name="txt_Manufacturer[]" id="Manufactsearch-box" readonly size="40" placeholder="Manufacturer" autocomplete="off" value="<?php echo $Manufacturer; ?>" /><span id="manufacturer" style="color:#FF0000;display:none;" title="Please Select Manufacturer">*</span>
     <div id="Manufact_suggesstion-box"></div>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_Model">Model:</label>
     <input type="text" class='form-control input-lg' name="txt_Model[]" id="txt_Model" placeholder="Model" readonly size="40" autocomplete="off" value="<?php echo $Model; ?>" /><span id="model" style="color:#FF0000;display:none;" title="Please Select Model">*</span>
     <div id="Model_suggesstion-box"></div>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_AssetID">AssetID:</label>
     <input type="text" class='form-control input-lg' id="txt_AssetID" name="txt_AssetID[]" size="40" readonly value="<?php echo $AssetID;?>"  />
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_SerialNo">Serial#:</label>
     <input type="text" id="txt_SerialNo" class='form-control input-lg' name="txt_SerialNo[]" readonly size="40" value="<?php echo $SerialNo;?>" />

   </div>
   <div class='form-group col-md-6'>
       <label for="txt_Weight1"> Weight (LBS):</label>
       <input type="text" class='form-control input-lg' id="txt_Weight1" name="txt_Weight[]" readonly size="37" onkeyup="SetWhite(this.id);" value="<?php echo $Weight;?>" /><span id="weight" style="color:#FF0000;display:none;" title="Please Enter Weight">*</span>
       <input type="hidden" name="id[]" value="<?php echo $id;?>" />
    </div>
   <div class='form-group col-md-12'>
       <label for="txt_Description1">Description (Optional):</label>
       <input type="text" class='form-control input-lg' id="txt_Description1" name="txt_Description[]" readonly rows="2" value="<?php echo $Description;?>" />
    </div>


  </div>
<?php
	  }
?>
</div>
<?php
	}
?>

 <?php
 }
?>
  <div class='col-sm-6'>

   &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
   <a href="#" onclick="goBack();" class='form-control input-lg'><u>Go Back</u></a>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
   <a href="common.php?Type=Indi_EditMultiView" class='form-control input-lg'><u>Change</u></a>
  </div>
 </form>
<?php
} //End of IndiAssets_MultiView

function IndiAssets_EditMultiView()
{
?>
	 <!-- Instructions -->
    <div class='col-md-12'>
      <div class="alert alert-info" role="alert">
        <p style='font-size:2em; font-weight:800;'>INSTRUCTIONS: Hit update once you make your changes...</p>
        <!-- <p style='font-size:14px;'>Some text here to explain...</p> -->
      </div>
    </div>
  <form action="common.php" method="post" name="form1" class='form'>
   <?php
   //Database Connection
    include('config.php');
    $query = new SQL();
    if($_SESSION["viewID"]){
	 // $ar=$_GET['chb'];
	  $idArr = $_SESSION["viewID"];
	 // $_SESSION["ID"]=$idArr;
      $N = count($idArr);
	  for($i=0; $i < $N; $i++)
      {
       $sql="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] where ID='$idArr[$i]'";
	   $result = $query->query($sql);
	   foreach($result as $row)
	   {
	    $id=$row['ID'];
	    $Vendor = $row['Vendor'];
	     //$dt=$row['Date_Submitted'];
	    // $datesubmitted = date_format($dt,"Y-m-d");
	    $datesubmitted = $row['Date_Submitted'];
	    $statementofwork = $row['StatementOfWork'];
	    $workpallets = $row['NumberOfPallets'];
	    $pickuplocation = $row['PickUpLocation'];
	    $localRIMcontact = $row['LocalRIMContact'];
	    $AssetType = $row['Asset_Type'];
	    $AssetID = $row['Asset_ID'];
        $Manufacturer = $row['Manufacturer'];
	    $Model = $row['Model'];
        $SerialNo = $row['Serial_No'];
		$WO = $row['LoadID'];
		$Description = $row['Description'];
        $Weight = $row['Weight'];
    ?>
  <!-- Left Column -->
  <div class='col-sm-6'>
   <div class='well' style="height:1000px;">
    <div class='form-group col-md-12'>
     <label for="txt_Vendor">Vendor:</label>
     <input class='form-control input-lg'  type="text" id="txt_Vendor" name="txt_Vendor[]" autocomplete="off" placeholder="Enter Vendor..." required value="<?php echo $Vendor;?>" />
     <span id="vendor" style="color:#FF0000;display:none;" title="Please Enter Vendor">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_DateSubmitted">Date Submitted:</label>
     <input class='form-control input-lg' type="date" id="datepicker" name='txt_DateSubmitted[]' required placeholder="YYYY-MM-DD" size="40" onclick="SetWhite(this.id);" value="<?php echo $datesubmitted;?>"/>
     <span id="datesubmitted" style="color:#FF0000;display:none;" title="Please Select Date">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_StatementOfWork">Statement of Work:</label>
     <input class='form-control input-lg' type="text" id="txt_StatementOfWork" name="txt_StatementOfWork[]" size="40" onkeyup="SetWhite(this.id);"  value="<?php echo $statementofwork;?>" />
     <span id="statementofwork" style="color:#FF0000;display:none;" title="Please Enter Work Statement">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_NumberOfPallets">Number of Pallets:</label>
     <input class='form-control input-lg' type="text" id="txt_NumberOfPallets" name="txt_NumberOfPallets[]" onkeyup="SetWhite(this.id);" size="40" value="<?php echo $workpallets;?>" />
     <span id="numberofpallets" style="color:#FF0000;display:none;" title="Please Enter Number Of Pallets">*</span>
    </div>
	<div class='form-group col-md-6'>
     <label for="txt_WO">Load ID (JIRA WO#):</label>
     <input type="text" class='form-control input-lg' id="txt_WO" name="txt_WO[]" size="40" value="<?php echo $WO;?>"  />
    </div>
    <div class='form-group col-md-12'>
     <label for="txt_PickupLocation">Pickup Location:</label>
     <input class='form-control input-lg' type="text" id="txt_PickupLocation" name="txt_PickupLocation[]" onkeyup="SetWhite(this.id);" size="40" value="<?php echo $pickuplocation;?>" />
     <span id="pickuplocation" style="color:#FF0000;display:none;" title="Please Enter Pickup Location">*</span>
    </div>
    <div class='form-group col-md-12'>
     <label for="txt_LocalRIMContact">Local BB Contact:</label>
     <textarea class='form-control input-lg' id="txt_LocalRIMContact" name="txt_LocalRIMContact[]" rows="2"  placeholder="Enter Local BlackBery Contact..." required><?php echo $localRIMcontact;?></textarea>
     <span id="localrimcontact" style="color:#FF0000;display:none;" title="Please Enter Contact Detail">*</span>
    </div>
    <div class='form-group col-md-12'>
     <label for="search-box">Asset Type:</label>
     <input type="text" class='form-control input-lg' onkeyup="ShowAssetType();" name="txt_AssetType[]" id="search-box" size="40" placeholder="Asset Type" autocomplete="off" value="<?php echo $AssetType; ?>" /><span id="assettype" style="color:#FF0000;display:none;" title="Please Select Asset Type">*</span>
     <div id="suggesstion-box"></div>
    </div>
    <div class='form-group col-md-6'>
     <label for="Manufactsearch-box">Manufacturer:</label>
     <input type="text" class='form-control input-lg' name="txt_Manufacturer[]" id="Manufactsearch-box" size="40" placeholder="Manufacturer" autocomplete="off" value="<?php echo $Manufacturer; ?>" /><span id="manufacturer" style="color:#FF0000;display:none;" title="Please Select Manufacturer">*</span>
     <div id="Manufact_suggesstion-box"></div>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_Model">Model:</label>
     <input type="text" class='form-control input-lg' name="txt_Model[]" id="txt_Model" placeholder="Model" size="40" autocomplete="off" value="<?php echo $Model; ?>" /><span id="model" style="color:#FF0000;display:none;" title="Please Select Model">*</span>
     <div id="Model_suggesstion-box"></div>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_AssetID">AssetID:</label>
     <input type="text" class='form-control input-lg' id="txt_AssetID" name="txt_AssetID[]" size="40" value="<?php echo $AssetID;?>"  />
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_SerialNo">Serial#:</label>
     <input type="text" id="txt_SerialNo" class='form-control input-lg' name="txt_SerialNo[]" size="40" value="<?php echo $SerialNo;?>" />

   </div>
   <div class='form-group col-md-12'>
       <label for="txt_Description1">Description (Optional):</label>
       <input type="text" class='form-control input-lg' id="txt_Description1" name="txt_Description[]" size="37" value="<?php echo $Description;?>" />
      </div>
   <div class='form-group col-md-12'>
       <label for="txt_Weight1"> Weight (LBS):</label>
       <input type="text" class='form-control input-lg' id="txt_Weight1" name="txt_Weight[]" size="37" value="<?php echo $Weight;?>" />
       <input type="hidden" name="id[]" value="<?php echo $id;?>" />
      </div>

  </div>
<?php
	  }
?>
</div>
<?php
	}
?>

 <?php
 }
?>
  <div class='col-sm-6'>
   <div class='well'>
   &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
   <a href="overview.php"><u>Go Back</u></a>
   &nbsp; &nbsp;&nbsp; &nbsp;  &nbsp; &nbsp;&nbsp; &nbsp;  &nbsp; &nbsp;&nbsp; &nbsp;  &nbsp; &nbsp;
   <input type="submit" id="btnsubmit" class="btn btn-primary" name="Indi_multipleupdate"  value="Update" />
   &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
   </div>
  </div>
 </form>
<?php
}  //End of IndiAssets_EditMultiView

function Search_EditMultiple()
{
?>
	<!-- Instructions -->
    <div class='col-md-12'>
      <div class="alert alert-info" role="alert">
        <p style='font-size:2em; font-weight:800;'>INSTRUCTIONS: Hit update once you make your changes...</p>
        <!-- <p style='font-size:14px;'>Some text here to explain...</p> -->
      </div>
    </div>
  <form action="common.php" method="post" name="form1" class='form'>
   <?php
   //Database Connection
    include('config.php');
    $query = new SQL();
    if($_GET['chb']){
	  $ar=$_GET['chb'];
	  $idArr = explode(",",$ar);
      $N = count($idArr);
	  for($i=0; $i < $N; $i++)
      {
       $sql="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] where ID='$idArr[$i]'";
	   $result = $query->query($sql);
	   foreach($result as $row)
	   {
	    $id=$row['ID'];
	    $Vendor = $row['Vendor'];
	      //$dt=$row['Date_Submitted'];
	      //$datesubmitted = date_format($dt,"Y-m-d");
	    $datesubmitted = $row['Date_Submitted'];
	    $statementofwork = $row['StatementOfWork'];
	    $workpallets = $row['NumberOfPallets'];
	    $pickuplocation = $row['PickUpLocation'];
	    $localRIMcontact = $row['LocalRIMContact'];
	    $AssetType = $row['Asset_Type'];
	    $AssetID = $row['Asset_ID'];
        $Manufacturer = $row['Manufacturer'];
	    $Model = $row['Model'];
        $SerialNo = $row['Serial_No'];
		$WO = $row['LoadID'];
		$Description = $row['Description'];
        $Weight = $row['Weight'];
    ?>
  <!-- Left Column -->
  <div class='col-sm-6'>
   <div class='well' style="height:1000px;">
    <div class='form-group col-md-12'>
     <label for="txt_Vendor">Vendor:</label>
     <input class='form-control input-lg'  type="text" id="txt_Vendor" name="txt_Vendor[]" autocomplete="off" placeholder="Enter Vendor..." required value="<?php echo $Vendor;?>" />
     <span id="vendor" style="color:#FF0000;display:none;" title="Please Enter Vendor">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_DateSubmitted">Date Submitted:</label>
     <input class='form-control input-lg' type="date" id="datepicker" name='txt_DateSubmitted[]' required placeholder="YYYY-MM-DD" size="40" onclick="SetWhite(this.id);" value="<?php echo $datesubmitted;?>"/>
     <span id="datesubmitted" style="color:#FF0000;display:none;" title="Please Select Date">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_StatementOfWork">Statement of Work:</label>
     <input class='form-control input-lg' type="text" id="txt_StatementOfWork" name="txt_StatementOfWork[]" size="40" onkeyup="SetWhite(this.id);"  value="<?php echo $statementofwork;?>" />
     <span id="statementofwork" style="color:#FF0000;display:none;" title="Please Enter Work Statement">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_NumberOfPallets">Number of Pallets:</label>
     <input class='form-control input-lg' type="text" id="txt_NumberOfPallets" name="txt_NumberOfPallets[]" onkeyup="SetWhite(this.id);" size="40" value="<?php echo $workpallets;?>" />
     <span id="numberofpallets" style="color:#FF0000;display:none;" title="Please Enter Number Of Pallets">*</span>
    </div>
	<div class='form-group col-md-6'>
     <label for="txt_WO">Load ID (JIRA WO#):</label>
     <input type="text" class='form-control input-lg' id="txt_WO" name="txt_WO[]" size="40" value="<?php echo $WO;?>"  />
    </div>
    <div class='form-group col-md-12'>
     <label for="txt_PickupLocation">Pickup Location:</label>
     <input class='form-control input-lg' type="text" id="txt_PickupLocation" name="txt_PickupLocation[]" onkeyup="SetWhite(this.id);" size="40" value="<?php echo $pickuplocation;?>" />
     <span id="pickuplocation" style="color:#FF0000;display:none;" title="Please Enter Pickup Location">*</span>
    </div>
    <div class='form-group col-md-12'>
     <label for="txt_LocalRIMContact">Local BB Contact:</label>
     <textarea class='form-control input-lg' id="txt_LocalRIMContact" name="txt_LocalRIMContact[]" rows="2"  placeholder="Enter Local BlackBery Contact..." required><?php echo $localRIMcontact;?></textarea>
     <span id="localrimcontact" style="color:#FF0000;display:none;" title="Please Enter Contact Detail">*</span>
    </div>
    <div class='form-group col-md-12'>
     <label for="search-box">Asset Type:</label>
     <input type="text" class='form-control input-lg' onkeyup="ShowAssetType();" name="txt_AssetType[]" id="search-box" size="40" placeholder="Asset Type" autocomplete="off" value="<?php echo $AssetType; ?>" /><span id="assettype" style="color:#FF0000;display:none;" title="Please Select Asset Type">*</span>
     <div id="suggesstion-box"></div>
    </div>
    <div class='form-group col-md-6'>
     <label for="Manufactsearch-box">Manufacturer:</label>
     <input type="text" class='form-control input-lg' name="txt_Manufacturer[]" id="Manufactsearch-box" size="40" placeholder="Manufacturer" autocomplete="off" value="<?php echo $Manufacturer; ?>" /><span id="manufacturer" style="color:#FF0000;display:none;" title="Please Select Manufacturer">*</span>
     <div id="Manufact_suggesstion-box"></div>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_Model">Model:</label>
     <input type="text" class='form-control input-lg' name="txt_Model[]" id="txt_Model" placeholder="Model" size="40" autocomplete="off" value="<?php echo $Model; ?>" /><span id="model" style="color:#FF0000;display:none;" title="Please Select Model">*</span>
     <div id="Model_suggesstion-box"></div>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_AssetID">AssetID:</label>
     <input type="text" class='form-control input-lg' id="txt_AssetID" name="txt_AssetID[]" size="40" value="<?php echo $AssetID;?>"  />
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_SerialNo">Serial#:</label>
     <input type="text" id="txt_SerialNo" class='form-control input-lg' name="txt_SerialNo[]" size="40" value="<?php echo $SerialNo;?>" />

   </div>
   <div class='form-group col-md-12'>
       <label for="txt_Description1">Description (Optional):</label>
       <input type="text" class='form-control input-lg' id="txt_Description1" name="txt_Description[]" size="37" value="<?php echo $Description;?>" />
      </div>
   <div class='form-group col-md-12'>
       <label for="txt_Weight1"> Weight (LBS):</label>
       <input type="text" class='form-control input-lg' id="txt_Weight1" name="txt_Weight[]" size="37" value="<?php echo $Weight;?>" />
       <input type="hidden" name="id[]" value="<?php echo $id;?>" />
      </div>

  </div>
<?php
	  }
?>
</div>
<?php
	}
?>

 <?php
 }
?>
  <div class='col-sm-6'>
   <div class='well'>
   &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
   <a href="#" onclick="GOBack();"><u>Go Back</u></a>
   &nbsp; &nbsp;&nbsp; &nbsp;  &nbsp; &nbsp;&nbsp; &nbsp;  &nbsp; &nbsp;&nbsp; &nbsp;  &nbsp; &nbsp;
   <input type="submit" id="btnsubmit" class="btn btn-primary" name="Search_MultiUpdate"  value="Update" />
   &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
   </div>
  </div>
 </form>
<?php
}  //end of Search_EditMultiple

function Search_EditMultiple_Bulk()
{
?>
	 <!-- Instructions -->

	<div id='instructions' class='col-md-12'>
      <div class="alert alert-info" role="alert">
      <div id="startHelp">
        <p class='bolder' style='font-size:24px;'><i class='fa fa-edit fa-lg fa-fw'></i> <b class='bolder' style='font-size:22px;'>BULK EDIT:</b></p>
        <ul>
          <li class='big-font-bb'><p>The fields below are shared across the selected assets.</p></li>
          <li class='big-font-bb'><p>Edit the fields and save to update all of the assets with the new values.</p></li>
        </ul>
      </div>
    </div>
    </div>
  <form name="form1" class='form'>
   <?php
   //Database Connection
    include('config.php');
    $query = new SQL();
    if($_GET['chb']){
	  $ar=$_GET['chb'];
	  $idArr = explode(",",$ar);
	  $_SESSION['ID']=$idArr;
      $N = count($idArr);
	  $_SESSION['N']=$N;
	  for($i=0; $i < 1; $i++)
      {
       $sql="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] where ID='$idArr[$i]'";
	   $result = $query->query($sql);
	   foreach($result as $row)
	   {
	    $id=$row['ID'];
	    $Vendor = $row['Vendor'];
	     // $dt=$row['Date_Submitted'];
	      //$datesubmitted = date_format($dt,"Y-m-d");
	    $datesubmitted = $row['Date_Submitted'];
	    $statementofwork = $row['StatementOfWork'];
	    $workpallets = $row['NumberOfPallets'];
	    $pickuplocation = $row['PickUpLocation'];
	    $localRIMcontact = $row['LocalRIMContact'];
		$WO = $row['LoadID'];
    ?>
  <!-- Left Column -->
  <div class='col-sm-6'>
   <div class='well' style="height:500px;">
    <div class='form-group col-md-12'>
     <label for="txt_Vendor">Vendor:</label>
     <input class='form-control input-lg'  type="text" id="txt_Vendor" name="txt_Vendor" autocomplete="off" placeholder="Enter Vendor..." required value="<?php echo $Vendor;?>" />
	 <div id="VendorList"></div>
     <span id="vendor" style="color:#FF0000;display:none;" title="Please Enter Vendor">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_DateSubmitted">Date Submitted:</label>
     <input class='form-control input-lg' type="date" id="datepicker" name='txt_DateSubmitted' required placeholder="YYYY-MM-DD" size="40" onclick="SetWhite(this.id);" value="<?php echo $datesubmitted;?>"/>
     <span id="datesubmitted" style="color:#FF0000;display:none;" title="Please Select Date">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_StatementOfWork">Statement of Work:</label>
     <input class='form-control input-lg' type="text" id="txt_StatementOfWork" name="txt_StatementOfWork" size="40" onkeyup="SetWhite(this.id);"  value="<?php echo $statementofwork;?>" />
     <span id="statementofwork" style="color:#FF0000;display:none;" title="Please Enter Work Statement">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_NumberOfPallets">Number of Pallets:</label>
     <input class='form-control input-lg' type="text" id="txt_NumberOfPallets" name="txt_NumberOfPallets" onkeyup="SetWhite(this.id);" size="40" value="<?php echo $workpallets;?>" />
     <span id="numberofpallets" style="color:#FF0000;display:none;" title="Please Enter Number Of Pallets">*</span>
    </div>
	<div class='form-group col-md-6'>
     <label for="txt_WO">Load ID (JIRA WO#):</label>
     <input type="text" class='form-control input-lg' id="txt_WO" name="txt_WO" size="40" value="<?php echo $WO;?>"  />
    </div>
    <div class='form-group col-md-12'>
     <label for="txt_PickupLocation">Pickup Location:</label>
     <input class='form-control input-lg' type="text" id="txt_PickupLocation" name="txt_PickupLocation" autocomplete="off" onkeyup="SetWhite(this.id);" size="40" value="<?php echo $pickuplocation;?>" />
	 <div id="LocationList"></div>
     <span id="pickuplocation" style="color:#FF0000;display:none;" title="Please Enter Pickup Location">*</span>
    </div>
    <div class='form-group col-md-12'>
     <label for="txt_LocalRIMContact">Local BB Contact:</label>
     <textarea class='form-control input-lg' id="txt_LocalRIMContact" name="txt_LocalRIMContact" rows="2"  placeholder="Enter Local BlackBery Contact..." required><?php echo $localRIMcontact;?></textarea>
     <span id="localrimcontact" style="color:#FF0000;display:none;" title="Please Enter Contact Detail">*</span>
    </div>


  </div>
<?php
	  }
?>
</div>
<?php
	}
?>

 <?php
 }
?>
  <div class='col-sm-6'>
   <div class='well row'>
		 <div class='col-sm-6'>
	 	 	<button class="btn btn-lg btn-primary btn-full" onclick="GOBack();">BACK</button>
		</div>
		<div class='col-sm-6'>
   	<button type="button" id="btnsubmit" class="btn btn-success btn-lg btn-full" data-toggle="modal" data-target="#myModal11" name="Search_MultiUpdate_Bulk">UPDATE</button>
	</div>
   </div>
  </div>
   <div class='col-sm-6'>
    <?php
	  $query = new SQL();
     if($_GET['chb']){
	  $ar=$_GET['chb'];
	  $idArr = explode(",",$ar);
	   $sql="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] where ID='$idArr[0]'";
	  for($i=1; $i < count($idArr); $i++)
      {
       $sql=$sql." or ID='$idArr[$i]'";

      }

       $result = $query->query($sql);


	   ?>
	   <table id="tableid" class="display">
            <thead>
             <tr>

              <th><center>Vendor</center></th>
              <th><center>Statement Of Work</center></th>
			  <th><center>AssetType</center></th>
			  <th><center>Manufacturer</center></th>
			  <th><center>AssetID</center></th>
			  <th><center>Serial#</center></th>
			  <th><center>WO#</center></th>

             </tr>
            </thead>
	        <tbody>
             <?php
	          foreach($result as $row)
	         {
            ?>
           <tr>

            <td><center><?php echo $row['Vendor'];  ?></center></td>
			<td><center><?php echo $row['StatementOfWork'];  ?></center></td>
			<td><center><?php echo $row['Asset_Type'];  ?></center></td>
			<td><center><?php echo $row['Manufacturer'];  ?></center></td>
			<td><center><?php echo $row['Asset_ID'];  ?></center></td>
			<td><center><?php echo $row['Serial_No'];  ?></center></td>
			<td><center><?php echo $row['LoadID'];  ?></center></td>

          </tr>
        <?php
	       }

		 ?>
        </tbody>
       </table>
	   <?php
	 }
	?>
   </div>
 </form>

<!-- Modal for bulk update -->
<div class="modal fade" id="myModal11" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
	<div class="modal-header row">
          <div class='col-xs-10 rm-padding'>
            <h3 class="modal-title">CONFIRM</h3>
          </div>
          <div class='col-xs-2 rm-padding'>
            <button type="button" onclick="div_hide();" data-dismiss="modal" class="close" aria-label="Close"><i class="fa fa-times fa-fw fa-2x"></i></button>
          </div>
        </div>
      <div class="modal-body">
            <!-- Success Message -->
              <div class="alert alert-success" role="alert">
                 <p style='font-size:22px; font-weight:800; text-align:center;'>You will update <font class="red-bb"><?php echo $_SESSION['N']; ?></font> asset records.</p>
              </div>


          </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-warning btn-lg" onclick="updatedata_bulk(<?php echo $_GET['chb'];  ?>);">CONFIRM</button>

      </div>
    </div>
  </div>
</div>
<!-- End of modal -->

<?php
}  //Search_EditMultiple_Bulk

function Search_MultiView()
{
?>
	<form action="editindividualexec.php" method="post" name="form1" class='form'>
   <?php
   //Database Connection
    include('config.php');
    $query = new SQL();
    if($_GET['chb']){
	  $ar=$_GET['chb'];
	  $idArr = explode(",",$ar);
	  $_SESSION["viewID"]=$idArr;
      $N = count($idArr);
	  for($i=0; $i < $N; $i++)
      {
       $sql="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] where ID='$idArr[$i]'";
	   $result = $query->query($sql);
	   foreach($result as $row)
	   {
	    $id=$row['ID'];
	    $Vendor = $row['Vendor'];
	    // $dt=$row['Date_Submitted'];
	     //$datesubmitted = date_format($dt,"Y-m-d");
	   $datesubmitted = $row['Date_Submitted'];
	    $statementofwork = $row['StatementOfWork'];
	    $workpallets = $row['NumberOfPallets'];
	    $pickuplocation = $row['PickUpLocation'];
	    $localRIMcontact = $row['LocalRIMContact'];
	    $AssetType = $row['Asset_Type'];
	    $AssetID = $row['Asset_ID'];
        $Manufacturer = $row['Manufacturer'];
	    $Model = $row['Model'];
        $SerialNo = $row['Serial_No'];
		$WO = $row['LoadID'];
		$Description = $row['Description'];
        $Weight = $row['Weight'];
    ?>
  <!-- Left Column -->
  <div class='col-sm-6'>
   <div class='well' style="height:900px">
    <div class='form-group col-md-12'>
     <label for="txt_Vendor">Vendor:</label>
     <input class='form-control input-lg'  type="text" id="txt_Vendor" name="txt_Vendor[]" readonly autocomplete="off" placeholder="Enter Vendor..." required value="<?php echo $Vendor;?>" />
     <span id="vendor" style="color:#FF0000;display:none;" title="Please Enter Vendor">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_DateSubmitted">Date Submitted:</label>
     <input class='form-control input-lg' type="date" id="datepicker" name='txt_DateSubmitted[]' readonly required placeholder="YYYY-MM-DD" size="40" onclick="SetWhite(this.id);" value="<?php echo $datesubmitted;?>"/>
     <span id="datesubmitted" style="color:#FF0000;display:none;" title="Please Select Date">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_StatementOfWork">Statement of Work:</label>
     <input class='form-control input-lg' type="text" id="txt_StatementOfWork" name="txt_StatementOfWork[]" readonly size="40" onkeyup="SetWhite(this.id);"  value="<?php echo $statementofwork;?>" />
     <span id="statementofwork" style="color:#FF0000;display:none;" title="Please Enter Work Statement">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_NumberOfPallets">Number of Pallets:</label>
     <input class='form-control input-lg' type="text" id="txt_NumberOfPallets" name="txt_NumberOfPallets[]" readonly onkeyup="SetWhite(this.id);" size="40" value="<?php echo $workpallets;?>" />
     <span id="numberofpallets" style="color:#FF0000;display:none;" title="Please Enter Number Of Pallets">*</span>
    </div>
	<div class='form-group col-md-6'>
     <label for="txt_WO">WO#:</label>
     <input type="text" class='form-control input-lg' id="txt_WO" name="txt_WO[]" size="40" readonly value="<?php echo $WO;?>"  />
    </div>
    <div class='form-group col-md-12'>
     <label for="txt_PickupLocation">Pickup Location:</label>
     <input class='form-control input-lg' type="text" id="txt_PickupLocation" name="txt_PickupLocation[]" readonly onkeyup="SetWhite(this.id);" size="40" value="<?php echo $pickuplocation;?>" />
     <span id="pickuplocation" style="color:#FF0000;display:none;" title="Please Enter Pickup Location">*</span>
    </div>
    <div class='form-group col-md-12'>
     <label for="txt_LocalRIMContact">Local BB Contact:</label>
	 <textarea class='form-control input-lg' id="txt_LocalRIMContact" name="txt_LocalRIMContact[]" rows="2" readonly  placeholder="Enter Local BlackBery Contact..." required><?php echo $localRIMcontact;?></textarea>
     <span id="localrimcontact" style="color:#FF0000;display:none;" title="Please Enter Contact Detail">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="search-box">Asset Type:</label>
     <input type="text" class='form-control input-lg' name="txt_AssetType[]" id="search-box" readonly size="40" placeholder="Asset Type" autocomplete="off" value="<?php echo $AssetType; ?>" /><span id="assettype" style="color:#FF0000;display:none;" title="Please Select Asset Type">*</span>
     <div id="suggesstion-box"></div>
    </div>
    <div class='form-group col-md-6'>
     <label for="Manufactsearch-box">Manufacturer:</label>
     <input type="text" class='form-control input-lg' name="txt_Manufacturer[]" id="Manufactsearch-box" readonly size="40" placeholder="Manufacturer" autocomplete="off" value="<?php echo $Manufacturer; ?>" /><span id="manufacturer" style="color:#FF0000;display:none;" title="Please Select Manufacturer">*</span>
     <div id="Manufact_suggesstion-box"></div>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_Model">Model:</label>
     <input type="text" class='form-control input-lg' name="txt_Model[]" id="txt_Model" placeholder="Model" readonly size="40" autocomplete="off" value="<?php echo $Model; ?>" /><span id="model" style="color:#FF0000;display:none;" title="Please Select Model">*</span>
     <div id="Model_suggesstion-box"></div>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_AssetID">AssetID:</label>
     <input type="text" class='form-control input-lg' id="txt_AssetID" name="txt_AssetID[]" size="40" readonly value="<?php echo $AssetID;?>"  />
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_SerialNo">Serial#:</label>
     <input type="text" id="txt_SerialNo" class='form-control input-lg' name="txt_SerialNo[]" readonly size="40" value="<?php echo $SerialNo;?>" />

   </div>
   <div class='form-group col-md-6'>
       <label for="txt_Weight1"> Weight (LBS):</label>
       <input type="text" class='form-control input-lg' id="txt_Weight1" name="txt_Weight[]" readonly size="37" onkeyup="SetWhite(this.id);" value="<?php echo $Weight;?>" /><span id="weight" style="color:#FF0000;display:none;" title="Please Enter Weight">*</span>
       <input type="hidden" name="id[]" value="<?php echo $id;?>" />
    </div>
   <div class='form-group col-md-12'>
       <label for="txt_Description1">Description (Optional):</label>
       <input type="text" class='form-control input-lg' id="txt_Description1" name="txt_Description[]" readonly rows="2" value="<?php echo $Description;?>" />
    </div>


  </div>
<?php
	  }
?>
</div>
<?php
	}
?>

 <?php
 }
?>
  <div class='col-sm-6'>

   &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
   <a href="#" class='form-control input-lg' onclick="goBack();"><u>Go Back</u></a>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
   <a href="common.php?Type=Edit_MultiView" class='form-control input-lg'><u>Change</u></a>
  </div>
 </form>
<?php
}  // End of Search_MultiView

function EditMultiView()
{
?>
	 <!-- Instructions -->
    <div class='col-md-12'>
      <div class="alert alert-info" role="alert">
        <p style='font-size:2em; font-weight:800;'>INSTRUCTIONS: Hit update once you make your changes...</p>
        <!-- <p style='font-size:14px;'>Some text here to explain...</p> -->
      </div>
    </div>
  <form action="common.php" method="post" name="form1" class='form'>
   <?php
   //Database Connection
    include('config.php');
    $query = new SQL();
    if($_SESSION["viewID"]){
	 // $ar=$_GET['chb'];
	  $idArr = $_SESSION["viewID"];
	 // $_SESSION["ID"]=$idArr;
      $N = count($idArr);
	  for($i=0; $i < $N; $i++)
      {
       $sql="SELECT * FROM ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] where ID='$idArr[$i]'";
	   $result = $query->query($sql);
	   foreach($result as $row)
	   {
	    $id=$row['ID'];
	    $Vendor = $row['Vendor'];
	    // $dt=$row['Date_Submitted'];
	    // $datesubmitted = date_format($dt,"Y-m-d");
	    $datesubmitted = $row['Date_Submitted'];
	    $statementofwork = $row['StatementOfWork'];
	    $workpallets = $row['NumberOfPallets'];
	    $pickuplocation = $row['PickUpLocation'];
	    $localRIMcontact = $row['LocalRIMContact'];
	    $AssetType = $row['Asset_Type'];
	    $AssetID = $row['Asset_ID'];
        $Manufacturer = $row['Manufacturer'];
	    $Model = $row['Model'];
        $SerialNo = $row['Serial_No'];
		$WO = $row['LoadID'];
		$Description = $row['Description'];
        $Weight = $row['Weight'];
    ?>
  <!-- Left Column -->
  <div class='col-sm-6'>
   <div class='well' style="height:1000px;">
    <div class='form-group col-md-12'>
     <label for="txt_Vendor">Vendor:</label>
     <input class='form-control input-lg'  type="text" id="txt_Vendor" name="txt_Vendor[]" autocomplete="off" placeholder="Enter Vendor..." required value="<?php echo $Vendor;?>" />
     <span id="vendor" style="color:#FF0000;display:none;" title="Please Enter Vendor">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_DateSubmitted">Date Submitted:</label>
     <input class='form-control input-lg' type="date" id="datepicker" name='txt_DateSubmitted[]' required placeholder="YYYY-MM-DD" size="40" onclick="SetWhite(this.id);" value="<?php echo $datesubmitted;?>"/>
     <span id="datesubmitted" style="color:#FF0000;display:none;" title="Please Select Date">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_StatementOfWork">Statement of Work:</label>
     <input class='form-control input-lg' type="text" id="txt_StatementOfWork" name="txt_StatementOfWork[]" size="40" onkeyup="SetWhite(this.id);"  value="<?php echo $statementofwork;?>" />
     <span id="statementofwork" style="color:#FF0000;display:none;" title="Please Enter Work Statement">*</span>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_NumberOfPallets">Number of Pallets:</label>
     <input class='form-control input-lg' type="text" id="txt_NumberOfPallets" name="txt_NumberOfPallets[]" onkeyup="SetWhite(this.id);" size="40" value="<?php echo $workpallets;?>" />
     <span id="numberofpallets" style="color:#FF0000;display:none;" title="Please Enter Number Of Pallets">*</span>
    </div>
	<div class='form-group col-md-6'>
     <label for="txt_WO">Load ID (JIRA WO#):</label>
     <input type="text" class='form-control input-lg' id="txt_WO" name="txt_WO[]" size="40" value="<?php echo $WO;?>"  />
    </div>
    <div class='form-group col-md-12'>
     <label for="txt_PickupLocation">Pickup Location:</label>
     <input class='form-control input-lg' type="text" id="txt_PickupLocation" name="txt_PickupLocation[]" onkeyup="SetWhite(this.id);" size="40" value="<?php echo $pickuplocation;?>" />
     <span id="pickuplocation" style="color:#FF0000;display:none;" title="Please Enter Pickup Location">*</span>
    </div>
    <div class='form-group col-md-12'>
     <label for="txt_LocalRIMContact">Local BB Contact:</label>
     <textarea class='form-control input-lg' id="txt_LocalRIMContact" name="txt_LocalRIMContact[]" rows="2"  placeholder="Enter Local BlackBery Contact..." required><?php echo $localRIMcontact;?></textarea>
     <span id="localrimcontact" style="color:#FF0000;display:none;" title="Please Enter Contact Detail">*</span>
    </div>
    <div class='form-group col-md-12'>
     <label for="search-box">Asset Type:</label>
     <input type="text" class='form-control input-lg' onkeyup="ShowAssetType();" name="txt_AssetType[]" id="search-box" size="40" placeholder="Asset Type" autocomplete="off" value="<?php echo $AssetType; ?>" /><span id="assettype" style="color:#FF0000;display:none;" title="Please Select Asset Type">*</span>
     <div id="suggesstion-box"></div>
    </div>
    <div class='form-group col-md-6'>
     <label for="Manufactsearch-box">Manufacturer:</label>
     <input type="text" class='form-control input-lg' name="txt_Manufacturer[]" id="Manufactsearch-box" size="40" placeholder="Manufacturer" autocomplete="off" value="<?php echo $Manufacturer; ?>" /><span id="manufacturer" style="color:#FF0000;display:none;" title="Please Select Manufacturer">*</span>
     <div id="Manufact_suggesstion-box"></div>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_Model">Model:</label>
     <input type="text" class='form-control input-lg' name="txt_Model[]" id="txt_Model" placeholder="Model" size="40" autocomplete="off" value="<?php echo $Model; ?>" /><span id="model" style="color:#FF0000;display:none;" title="Please Select Model">*</span>
     <div id="Model_suggesstion-box"></div>
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_AssetID">AssetID:</label>
     <input type="text" class='form-control input-lg' id="txt_AssetID" name="txt_AssetID[]" size="40" value="<?php echo $AssetID;?>"  />
    </div>
    <div class='form-group col-md-6'>
     <label for="txt_SerialNo">Serial#:</label>
     <input type="text" id="txt_SerialNo" class='form-control input-lg' name="txt_SerialNo[]" size="40" value="<?php echo $SerialNo;?>" />

   </div>
   <div class='form-group col-md-12'>
       <label for="txt_Description1">Description (Optional):</label>
       <input type="text" class='form-control input-lg' id="txt_Description1" name="txt_Description[]" size="37" value="<?php echo $Description;?>" />
      </div>
   <div class='form-group col-md-12'>
       <label for="txt_Weight1"> Weight (LBS):</label>
       <input type="text" class='form-control input-lg' id="txt_Weight1" name="txt_Weight[]" size="37" value="<?php echo $Weight;?>" />
       <input type="hidden" name="id[]" value="<?php echo $id;?>" />
      </div>

  </div>
<?php
	  }
?>
</div>
<?php
	}
?>

 <?php
 }
?>
  <div class='col-sm-6'>
   <div class='well'>
   &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
   <a href="Search.php"><u>Go Back</u></a>
   &nbsp; &nbsp;&nbsp; &nbsp;  &nbsp; &nbsp;&nbsp; &nbsp;  &nbsp; &nbsp;&nbsp; &nbsp;  &nbsp; &nbsp;
   <input type="submit" id="btnsubmit" class="btn btn-primary" name="Search_MultiUpdate"  value="Update" />
   &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
   </div>
  </div>
 </form>
<?php
}  //End of EditMultiView

function Add_MultipleAssets()
{
	include_once("config.php");
$query = new SQL();
if(isset($_POST['val']))
{
  $data = json_decode($_POST["val"],true);
// echo $data[0]['a_Vendor'];
 for($i=0;$i<count($data);$i++)
 {
    $Vendor = $data[$i]['a_Vendor'];
	$dt = $data[$i]['a_DateSubmitted'];
	//$dt=date('Y-m-d', strtotime($datesubmitted));
	$statementofwork = $data[$i]['a_StatementOfWork'];
	$workpallets = $data[$i]['a_NumberOfPallets'];
	$pickuplocation = $data[$i]['a_PickUpLocation'];
	$localRIMcontact = $data[$i]['a_LocalRIMContact'];
	$AssetType = $data[$i]['Asset Type'];
	$WO = $data[$i]['a_WO'];
	if($data[$i]['Asset ID']=="")
	{
		$AssetID = "N/A";
	}
	else
	{
		$AssetID = $data[$i]['Asset ID'];
	}

	if($data[$i]['a_Manufacturer']=="")
	{
		$Manufacturer = "N/A";
	}
	else
	{
		$Manufacturer = $data[$i]['a_Manufacturer'];
	}

	if($data[$i]['a_Model']=="")
	{
		$Model = "N/A";
	}
	else
	{
		$Model = $data[$i]['a_Model'];
	}

	if($data[$i]['a_SerialNo']=="")
	{
		$SerialNo = "N/A";
	}
	else
	{
		$SerialNo = $data[$i]['a_SerialNo'];
	}

	if($data[$i]['a_Description']=="")
	{
		$Description = "N/A";
	}
	else
	{
		$Description=$data[$i]['a_Description'];
	}

	if($data[$i]['a_Weight']=="")
	{
		$Weight = "N/A";
	}
	else
	{
		$Weight=$data[$i]['a_Weight'];
	}

	 $sql = "INSERT INTO ".$env->ewasteDB.".[dbo].[tbl_asset_tracking](Vendor,Date_Submitted,StatementOfWork,NumberOfPallets,PickUpLocation,LocalRIMContact,Asset_Type,Asset_ID,Manufacturer,Model,Serial_No,Description,Weight,LoadID) VALUES('$Vendor','$dt','$statementofwork','$workpallets','$pickuplocation','$localRIMcontact','$AssetType','$AssetID','$Manufacturer','$Model','$SerialNo','$Description','$Weight','$WO')";

			 $result= $query->query($sql);


 }
}

}  //End of Add_MultipleAssets

function vendor()
{
	require_once("config.php");
$query = new SQL();
//$db_handle = new DBController();
if(!empty($_POST["keyword"])) {
$sql ="SELECT DISTINCT [Primary Vendor] FROM ".$env->ewasteDB.".[dbo].[VendorList] WHERE [Primary Vendor] like '" . $_POST["keyword"] . "%' ORDER BY [Primary Vendor]";

$result = $query->query($sql);
if(!empty($result)) {
?>
<ul style='padding-left:5px;' id="vendor-list">
<?php
foreach($result as $type) {
?>
<li class='typeahead' onClick="selectVendor('<?php echo $type["Primary Vendor"]; ?>');"><?php echo $type["Primary Vendor"]; ?></li>
<?php } ?>
</ul>
<?php } }
}
?>
