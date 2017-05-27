<?php
  include($_SERVER['DOCUMENT_ROOT'] . '\\adtf\\config.php');
  $arr=array();
  $id=$_REQUEST['id'];

  $final = search($id);
  // Get Asset Fields
	if(isset($final)){
  	foreach($final as $key=>$value) {
      $AssetType1= $value['class'];
      foreach($value as $key1=>$value1) {
	      $AssetID1= $value['fields']["asset_number"];
        $Manufacturer1=$value['fields']['brand_id_friendlyname'];
        $Model1=$value['fields']['model_name'];
	      $SerialNo1=$value['fields']['serialnumber'];
	     }
    }
	}
  // Result
  $final=array("Asset_Type"=>$AssetType1,"Asset_ID"=>$AssetID1,"Manufacturer"=>$Manufacturer1,"Model"=>$Model1,"Serial_No"=>$SerialNo1);
  echo json_encode($final);
?>
<?php
  function search($id){
    $sql = new SQL();
    $env = new envConfig();
    $iTop = new iTop();
    $iTop->setURL($env->iTopURL);

    // Build Class List
    $query="SELECT Class FROM ".$env->ewasteDB.".[dbo].[CMDB_Classes]";
    $Type_result = $sql->query($query);
    // Search each class...
    foreach($Type_result as $t) {
      foreach($t as $k=>$v){
        $query = array(
          "class"=>$v,
          "key"=>"SELECT $v WHERE serialnumber='$id' OR asset_number='$id'",
          "output_fields"=>"asset_number,status,serialnumber,cost_center_bb,last_scan_date_bb,model_name,
          end_of_warranty,received_date_bb,brand_id_friendlyname,po_bb, location_name"
        );
        $result = $iTop->query($query);
        $final = json_decode($result, true);
        // Break if an asset is found
        if($final['message'] != "Found: 0"){
          $asset = $final['objects'];
          return $asset;
        }
    	}
    }
  }

?>
