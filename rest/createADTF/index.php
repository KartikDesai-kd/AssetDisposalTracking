<?php
  error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
  include($_SERVER['DOCUMENT_ROOT'] . '\\adtf\\config.php');
  // Params
  $type = (isset($_POST['type']) ? $_POST['type'] : $params['type']);
  $user = (isset($_POST['user']) ? $_POST['user'] : $params['user']);
  $data = json_decode($_POST['val'], true);
  $count = 0;

  $sql = new SQL();

  foreach($data as $t){
      // Setup Variables
      $Vendor = $t['a_Vendor'];
      // $dt = $t['a_DateSubmitted'];
      // $dt = new Date("Y-m-d");
      $statementofwork = $t['a_StatementOfWork'];
      $workpallets = $t['a_NumberOfPallets'];
      $pickuplocation = $t['a_PickUpLocation'];
      $localRIMcontact = $t['a_LocalRIMContact'];
      $AssetType = $t['Asset Type'];
      $WO = $t['a_WO'];
      $t['Asset ID'] == "" ? $AssetID = "N/A" : $AssetID = $t['Asset ID'];
      $t['a_Manufacturer'] == "" ? $Manufacturer = "N/A" : $Manufacturer = $t['a_Manufacturer'];
      $t['a_Model'] == "" ? $Model = "N/A" : $Model = $t['a_Model'];
      $t['a_SerialNo'] == "" ? $SerialNo = "N/A" : $SerialNo = $t['a_SerialNo'];
      $t['a_Description'] == "" ? $Description = "N/A" : $Description = $t['a_Description'];
      $t['a_Weight'] == "" ? $Weight = "N/A" : $Weight = $t['a_Weight'];
      // JIRA
      $jira = new JIRA();
      $date = date("Y-m-d");
      $sum = "ADTF >> " . $pickuplocation . " >> "  . $date;
      $desc = "Vendor: $Vendor \n\n SOW: $statementofwork\n\n Pallets: $workpallets \n\n Pickup Location: $pickuplocation\n\n Contact: $localRIMcontact \n\n ";
      if($count == 0) {
        $count ++;
        // If Ticket Provided...
        if(!$WO) {
          $ticket = $jira->createTicket($sum, $desc, "End User Services", "HW Asset Management");
          $ticket = json_decode($ticket, true);
          $ticket = $ticket["key"];
          $jira->setKey($ticket);
          // Add Direct ADTF Link
          $url = "http://tlws003ykf/adtf/Search.php"
          // $url = "http://tlws003ykf/adtf/Search.php?s_Vendor=&s_AssetType=&s_Manufacturer=&s_Model=&s_AssetID=&s_SerialNo=&s_WO=". $ticket . "&var=Array&selection=WO#";
          $link = "Direct ADTF Link \n\n " . $url;
          $jira->addComment($link);
        } else { // Otherwise Create New
          $jira->setKey($WO);
          $ticket = $WO;
          $jira->addComment($desc);
          // $url = "http://tlws003ykf/adtf/Search.php?s_Vendor=&s_AssetType=&s_Manufacturer=&s_Model=&s_AssetID=&s_SerialNo=&s_WO=". $ticket . "&var=Array&selection=WO#";
          $url = "http://tlws003ykf/adtf/Search.php"
          $link = "Direct ADTF Link \n\n " . $url;
          $jira->addComment($link);
        }
      }
      // Insert
      $query = "INSERT INTO ".$env->ewasteDB.".[dbo].[tbl_asset_tracking](Vendor,Date_Submitted,StatementOfWork,NumberOfPallets,PickUpLocation,LocalRIMContact,Asset_Type,Asset_ID,Manufacturer,Model,Serial_No,Description,Weight,LoadID) VALUES('$Vendor','$date','$statementofwork','$workpallets','$pickuplocation','$localRIMcontact','$AssetType','$AssetID','$Manufacturer','$Model','$SerialNo','$Description','$Weight','$ticket')";
      $result = $sql->query($query);
  } // end foreach

  // Get User Info
  $ad = new ADLink($user);
  $temp = $ad->showDetails();
  $name = $temp['displayname'];
  $mail = $temp['mail'];

  // Email
  $email = new Email();
  $email->setParams(array(
    "recipient"=>$mail . ";blackberryassettracker@blackberry.com",
      "templateID"=>"706521249",
      "json_data"=>array(
        "JIRATicket"=>$ticket,
        "ADTFLink"=>$url,
        "User"=>$name,
      )
    )
  );
  $email->send();
  // Result
  $final = array($ticket,$url);
  echo json_encode($final);
?>
