<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<?php
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

?>
</body>
</html>
