<?php
include('config.php');
  $query = new SQL();
if($_POST['ID'])
{
  $sql="select * from ".$env->ewasteDB.".[dbo].[tbl_asset_tracking] where Manufacturer!='' and (Asset_ID LIKE '".$_POST['ID']."'"." or Serial_No LIKE '".$_POST['ID']."'".")";
  //echo $sql;
  $result=$query->query($sql);
  $count=count($result);
  $array["count"]=$count;
  echo json_encode($array);
}
?>
