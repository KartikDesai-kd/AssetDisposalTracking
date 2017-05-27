<?php
// Environment Variables
include_once("config.php");
// Suppress PHP Warnings & Errors
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
// Global Functions..
// -----------------
// Array Flatten
function array_flatten($array) {
   $return = array();
   foreach ($array as $key => $value) {
     if (is_array($value)){ $return = array_merge($return, array_flatten($value));}
     else {$return[$key] = $value;}
   }
   return $return;
}
// End array_flatten

// MSSQL Escape String
function mssql_escape_string($data) {
    if ( !isset($data) or empty($data) ) return '';
    if ( is_numeric($data) ) return $data;

    $non_displayables = array(
        '/%0[0-8bcef]/',            // url encoded 00-08, 11, 12, 14, 15
        '/%1[0-9a-f]/',             // url encoded 16-31
        '/[\x00-\x08]/',            // 00-08
        '/\x0b/',                   // 11
        '/\x0c/',                   // 12
        '/[\x0e-\x1f]/'             // 14-31
    );
    foreach ( $non_displayables as $regex )
        $data = preg_replace( $regex, '', $data );
    $data = str_replace("'", "''", $data );
    return $data;
} // End mssql_escape_string

// UTF-8 Converter (For Special Characters)
function utf8_converter($array){
	array_walk_recursive($array, function(&$item, $key){
		if(!mb_detect_encoding($item, 'utf-8', true)){
				$item = utf8_encode($item);
		}
	});
	return $array;
} // End utf8_converter

// Object to Array
function objectToArray($d) {
  if (is_object($d)) {
    // Gets the properties of the given object with get_object_vars function...
    $d = get_object_vars($d);
  }
  // Return array, converted to object...
  if (is_array($d)) {
    return array_map(__FUNCTION__, $d);
  }
  else {
    // Return array
    return $d;
  }
} // End objectToArray

//##############################################################################
//##############################################################################
//##############################################################################
// Class JIRA provides a link to JIRA with some common functions
class JIRA {
  private $key,$asset,$url,$transitions,$queryResult;
  private $userpass;
  // Constructor
  public function __construct($k = NULL){
    $this->userpass = base64_encode("svcAcctBAT:j_WlGN]fKjde%?J:");
    !empty($k) ? $this->key=$k : $this->key=NULL;
    $env = new envConfig();
    $this->url = $env->URL;
  } // End constructor

  public function setKey($k){$this->key=$k;}
  public function setURL($k){$this->url=$k;}
  public function showAsset(){$this->setAsset();return $this->asset;}
  public function showTransitions(){return $this->transitions;}
  public function showKey(){return $this->key;}
  public function showURL(){return $this->url;}

  // Find Tickets
  public function findTickets($query){
    if(empty($this->url))
      return array("Error"=>"The URL must be set before you can find tickets.");

    $this->asset = $this->queryJira("/rest/api/2/search?jql=$query");
    return true;
  }
  // Adds Comment
  public function addComment($text){
    if(empty($this->key)||empty($this->url)||empty($this->userpass))
      return array("Error"=>"The key, url and userpass must all be configured first.");

    $q = array("body"=>$text);
    $q = json_encode($q);
    $res = $this->queryJira("/rest/api/2/issue/$this->key/comment",true,$q);
    $trans = $this->queryJira("/rest/api/2/issue/$this->key/transitions");
    $trans = json_decode($trans,true);
    foreach($trans['transitions'] as $t){
      if($t['name']==='Resume Work'){
        $ret = $t['id'];
        $q = json_encode(array("transition"=>array("id"=>$ret)));
        return $this->queryJira("/rest/api/2/issue/$this->key/transitions",true,$q);
      }
    }
    return $res;
  } // end addComment()

  // Cancel Ticket
  public function cancelTicket(){
    if(empty($this->key)||empty($this->url)||empty($this->userpass))
      return array("Error"=>"The key, url and userpass must all be configured first.");

    $trans = $this->queryJira("/rest/api/2/issue/$this->key/transitions");
    foreach($trans['transitions'] as $t){
      if($t['name']==='Cancelled')
        $ret = $t['id'];
    }
    $q = json_encode(array("transition"=>array("id"=>$ret)));
    return $this->queryJira("/rest/api/2/issue/$this->key/transitions",true,$q);
  } // End cancelTicket

  // Re-open Ticket
  public function reopenTicket(){
    if(empty($this->key)||empty($this->url)||empty($this->userpass))
      return array("Error"=>"The key, url and userpass must all be configured first.");

    $trans = $this->queryJira("/rest/api/2/issue/$this->key/transitions");
    $trans = json_decode($trans,true);
    foreach($trans['transitions'] as $t){
      if($t['name']==='Reopen')
        $ret = $t['id'];
    }
    $q = json_encode(array("transition"=>array("id"=>$ret)));
    return $this->queryJira("/rest/api/2/issue/$this->key/transitions",true,$q);
  } // End reopenTicket

  // Close Ticket
  public function closeTicket(){
    if(empty($this->key)||empty($this->url)||empty($this->userpass))
      return array("Error"=>"The key, url and userpass must all be configured first.");

    $trans = $this->queryJira("/rest/api/2/issue/$this->key/transitions");
    $trans = json_decode($trans,true);
    $skip = true;
    $chArray = array("Selected","Start Work","Done","Complete","Resume Work");
    foreach($trans['transitions'] as $t){
      if($t['name']==='Selected' || $t['name']==='Start Work' || $t['name']==='Done' || $t['name']==='Complete'|| $t['name']==='Resume Work')
        $ret = $t['id'];
      if($t['name']==='Complete' || $t['name']==='Done'){
        $skip = false;
      }
    }
    if($skip){
      $q = json_encode(array("transition"=>array("id"=>$ret)));
      $res = $this->queryJira("/rest/api/2/issue/$this->key/transitions",true,$q);
      $res = json_decode($res,true);
      // return $this->queryJira("/rest/api/2/issue/$this->key/editmeta",true,$q);
      if($res['errorMessages'][0]==="OpCats is required. But it is not present on screen."){
        $q = json_encode(array("fields"=>array("customfield_14431"=>array("value"=>"Other","child"=>array("value"=>"User Resolved")))));
        $this->queryJira("/rest/api/2/issue/$this->key",true,$q,true);
      }//end of if setting missing opcats
    } else {
      $q = json_encode(array("fields"=>array("resolution"=>array("name"=>"Completed")),"transition"=>array("id"=>$ret)));
      return $this->queryJira("/rest/api/2/issue/$this->key/transitions?expand=transitions.fields",true,$q,false);
    }

    if(sizeof($trans['transitions'])==1 && $trans['transitions'][0]['name']===Cancelled)
      return json_encode(array("Success"=>"Issue has been closed"));

    return $this->closeTicket();
  } // End closeTicket

  // Create Ticket
  public function createTicket($summary,$description,$L1=null,$L2=null,$key="WO",$type){
    if($type == "")
      $type = "Bug";
    $env = new envConfig();
    $json = array(
      "fields"=>array(
        "project"=>array(
          "key"=>$key
        ),
        "summary"=>$summary,
        "description"=>$description
      )
    );
    if(!is_null($L1) && !is_null($L2))
      $json["fields"]["customfield_14135"] = array("value"=>$L1, "child"=>array("value"=>$L2));
    if($key == "ITPLAN") {
      $user = $_SERVER['REMOTE_USER'];
      $user = explode("\\",$user);
      $user = $user[1];
      $json["fields"]["reporter"]["name"] = $user;
      $json["fields"]["labels"] = array("BAT","desktop_services");
      $json["fields"]["issuetype"]["name"] = $type;
    }
    else {
      $json["fields"]["customfield_10960"]["value"] = "Low";
      $json["fields"]["reporter"]["name"] = $env->UID;
      $json["fields"]["issuetype"]["name"] = "Request";
    }
    return $this->queryJira("/rest/api/2/issue/", true,json_encode($json), false);
  } // End createTicket()

  // Set Asset - loads all the basic ticket details
  private function setAsset(){
    if(empty($this->key)||empty($this->url)||empty($this->userpass))
      return false;

    $this->asset = $this->queryJira("/rest/api/2/issue/$this->key");
  } // End of setAsset()

  // Search JIRA
  public function searchJira($criteria){
    $criteria = "/rest/api/2/search?" . $criteria;
    $ret = $this->queryJira($criteria);
    return $ret;
  }

  // Query JIRA - Performas a query against JIRA, for post or pull
  private function queryJira($criteria,$post=false,$q=NULL,$put=false){

    $search = $this->url . $criteria;
    $headers = array(
      "Content-Type: application/json",
      "Authorization: Basic " . $this->userpass
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $search);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    if($put)
      curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"PUT");
    if($post){
      curl_setopt($ch,CURLOPT_POSTFIELDSIZE,strlen($q));
      curl_setopt($ch,CURLOPT_POSTFIELDS,$q);
    }
    curl_setopt($ch, CURLOPT_SSLVERSION, 3);
    $my_var = curl_exec($ch);
    $this->queryResult = curl_getinfo($ch);
    return $my_var;
  }//end of pullJira

  // Help
  public function showHelp(){
    return array(
      "__contruct"=>"Default creation constructor. Optionally can take a Jira KEY and a Jira URL.",
      "setKey"=>"Set a Jira Key variable.",
      "setURL"=>"Set a Jira URL variable.",
      "showAsset"=>"Return the stored asset(s).",
      "showTransitions"=>"Return the available transitions on the asset.",
      "showKey"=>"Show the key that is currently set.",
      "showURL"=>"Show the URL that is currently set.",
      "findTickets"=>"Requires a JQL query to be provided. Stores the results in the assets.",
      "addComment"=>"Key must be set. Requires a comment to be provided. Adds the comment to the ticket.",
      "cancelTicket"=>"Key must be set. Cancels the ticket.",
      "reopenTicket"=>"Key must be set. Reopens the ticket.",
      "closeTicket"=>"Key must be set. Closes the ticket."
    );
  }

} // End of JIRA Class

//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//class eID provides a link to EmpowerID with functions to get and set entitlement


//class Email provides standardized acess to emailing. Exposes the templates
//available to use (hosted within Confluence).
class Email {
  private $recipient=null, $templateID=null, $iTopKey=null;
  private $params = null;
  private $asset = null;
  private $template = null;
  private $disclaimer = null;
  private $subject = null;

  public function __construct($obj){
    $this->setParams($obj);
  }//end of constructor

  public function setParams($obj){
    foreach($obj as $k=>$v){
      if($k==="recipient" || $k==="templateID" || $k==="iTopKey" || $k==="disclaimer")
        $this->$k = $v;
      else
        $this->params[$k] = $v;

      if(!empty($this->iTopKey))
        $this->queryAsset();
      }//end of foreach
  }//end of setParams

  public function setAsset($a){$this->asset = $a;}

  public function queryAsset(){
    $env = new envConfig();
    $iTop = new iTop();
    $iTop->setURL($env->iTopURL);
    $iTop->query(array(
      "class"=>"PC",
      "key"=>"SELECT PC WHERE id=" . $this->iTopKey
    ));
    $asset = $iTop->printAsset();
    $asset = json_decode($asset,2);
    if(is_array($asset)){
      foreach($asset['objects'] as $r)
        $final = array_flatten($r);
    }
    $this->asset = $final;
  }

  public function pullTemplate(){
    if(empty($this->templateID))
      return array("Error"=>"templateID must be configured first. Use setParams(arr) to configure.");

    $env = new envConfig();
    $iTop = new iTop();
    $iTop->setURL($env->iTopURL);

    $sql = new SQL();
    $query = "SELECT * FROM " . $env->metaDB . ".dbo.emailTemplates WHERE template = '" . $this->templateID . "' ";
    $res = $sql->query($query);
    $this->subject = $res[0]['subject'];
    $server_output = $res[0]['payload'];


    if(!$server_output){
      return array(
        "Error"=>"Could not get wiki template.",
        "Call Error"=>curl_error($ch),
        "Call Info"=>curl_errno($ch),
        "Call Results"=>$results
      );
    }

    //##############################################
    //Replace the default iTop data in the template
    if(empty($this->asset))
      $this->queryAsset();

    foreach($this->asset as $k=>$v) {
      $server_output = str_replace("[$k]",$v, $server_output);
      $this->subject = str_replace("[$k]",$v, $this->subject);
    }
    //##############################################
    //##############################################
    //Replace the json_data provided in the template
    if(!empty($this->params['json_data'])){
      foreach($this->params['json_data'] as $k=>$v){
        if(substr($k,0,5)=="html_"){
          $temp = ($v);
          $temp = str_replace(" ", "+", $temp);
          $temp = base64_decode($temp);
          $tKey = str_replace("html_","",$k);
          $server_output = str_replace('[' . $tKey . ']', $temp, $server_output);
          $this->subject = str_replace('[' . $tKey . ']', $temp, $this->subject);
        }
        else {
          $server_output = str_replace("[$k]",$v, $server_output);
          $this->subject = str_replace("[$k]",$v, $this->subject);
        }
      }

      $button = '<a href="http://' . $_SERVER['HTTP_HOST'] . '/#/Acknowledge:' . $this->params['json_data']["key"] . '">I ACKNOWLEDGE</a>';
      $server_output = str_replace("[ACKBTN]", $button, $server_output);
    }
    //##############################################
    //##############################################
    //Replace the Contact iTop data in the template
    $contacts = $iTop->getContact($this->asset['contact_id']);
    if($contacts['code']==1){
      foreach($contacts['result'] as $k=>$v) {
        $server_output = str_replace("[$k]",$v,$server_output);
        $this->subject = str_replace("[$k]",$v, $this->subject);
      }
    }

    $this->template = $server_output;

    return $this->template;
  }//end of pullTemplate

  public function send(){
    if(empty($this->templateID) || empty($this->recipient))
      return array("Error"=>"templateID and recipient must both be set. use setParams() to configure.");

    if(empty($this->template))
      $this->pullTemplate();

    $subject = $this->subject;
    $body = $this->template;

    if(isset($this->disclaimer))
      $body .= "<p><hr/><em>" . $this->disclaimer . "</em></p>";
    else {
      $this->disclaimer = '<hr/><em><span style="color: rgb(51,102,255);">This is an automated message sent on behalf of IT. <strong>Please do not reply to this email address as this mailbox is not monitored.</strong> For questions and support, visit</span> <a class="external-link" href="http://go/pcsupport" rel="nofollow">go/pcsupport</a>.</em>';
      $body .= "<p>" . $this->disclaimer . "</p>";
    }


    $from = "BAT@BlackBerry.com";

    $headers = "From: $from\r\n";
    $headers .= "Reply-To: donotreply@blackberry.com\r\n";
    $headers .= "Return-Path: $from\r\n";
    $headers .= "Bcc: BAT@Blackberry.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $css = '
    <head>
      <style>
      .red {color:#FF0000;}
      .green {color:#548235;}
      .btn-ack {
        background-color: #007BC0;
        width: 185px;
        padding: 10px;
        color: white;
        font-weight: 800;
        border-radius: 4px;
        text-align: center;
      }
      .btn-ack a {
        text-decoration: none;
        color: white;
      }
      h1, h2, h3, p, i, b, em, table, td, th, tr {
        font-family: Calibri;
      }
      th, td {
        padding:.5em 1em;
      }
      th {
        background-color: #e0e0e0;
      }
      </style>
    </head>
    ';
    $body = $css . $body;
    // Prod Server List
    $prod = array("bat", "bat.rim.net", "bot", "bot.rim.net");
    // if QA...
    if(!in_array($_SERVER['SERVER_NAME'], $prod)){
      $temp = explode("\\",$_SERVER['REMOTE_USER']);
      $ad = new ADLink($temp[1]);
      $temp = $ad->showDetails();
      $to = $temp['mail'];
    }
    // if Prod...
    else {
      $to = $this->recipient;

      // Build Email Shim...
      $emailShim = array(
        "jschen@blackberry.com",
        "hsli@blackberry.com",
        "schennakeshu@blackberry.com",
        "rlouks@blackberry.com",
        "nwhiteivy@blackberry.com",
        "szipperstein@blackberry",
        "cwiese@blackberry.com",
        "bho@blackberry.com",
        "jmackey@blackberry.com",
        "mbeard@blackberry.com",
        "jyersh@blackberry.com"
      );
      if (in_array($to, $emailShim))
      $to = "vchick@blackberry.com";
    }

    if(mail($to, $subject, $body, $headers))
      $res = array("code"=>0,"message"=>"Message sent successfully.");
    else
      $res = array("code"=>1,"message"=>"Message failed to send.");

    $log = new Logging();
    ($log->execute(array(
      "Call"=>"Send Email",
      "Result_Code"=>"0",
      "Source"=>"Template: " . $this->templateID . "; recipient: " . $this->recipient,
      "Result"=>$res['message']
    )));
    return $res;
  }//end of send

  public function printAsset(){
    return $this->asset;
  }

  public function showDetails(){
    echo "Recipient: " . $this->recipient . "<br/>";
    echo $this->templateID . "<br/>";
    echo $this->iTopKey . "<br/>";
  }

}//end of Email


//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//class iTop provides standardized access to iTop.
class iTop {
  public function __construct($key=null,$user=null) {
    if(!empty($key)) $this->key = $key;
    if(!empty($key)) $this->user = $user;

    $env = new envConfig();
    $this->iTopWriter = array('User'=>$env->iTopUID,'Password'=>$env->iTopPWD);
  }

  private $asset,$key,$user;
  private $URL =  NULL; // iTop URL
  private $iTopWriter = NULL; // iTop Credentials
  private $json = array(
    "operation"=>"core/get",
    "comment"=>" (BAT Portal 2.0)",
    // "class"=>"PC",
    "simulate"=>"false");

  public function getKey($asset){
    $temp = array(
      "class"=>"PC",
      "key"=>"SELECT PC WHERE asset_number = '$asset'"
    );
    $this->query($temp);
    $t = json_decode($this->asset, true);
    foreach($t['objects'] as $f){
      $this->key = $f['key'];
    }
    return true;
  }

  public function getAsset($asset){
    $temp = array(
      "class"=>"PC",
      "key"=>"SELECT PC WHERE id = '$asset'"
    );
    $this->query($temp);
    $t = json_decode($this->asset, true);
    foreach($t['objects'] as $f){
      $this->key = $f['key'];
    }
    return true;
  }

  public function setURL($a){
    $this->URL = (empty($a) ? false : $a);
  }

  public function getContact($id = null, $search=null){
    if(empty($id))
      return array("Error"=>"You must pass a Contact ID to search against.");

    if(empty($search)){
      $this->json = array(
        "operation"=>"core/get",
  			"class"=>"Contact",
  			"key"=>$id,
  			"simulate"=>"false",
  			"output_fields"=>"name,status, org_id, org_name, email,phone, notify, function, building_id_bb, employment_status_bb, cost_center_bb, cost_center_manager_bb, samaccountname_bb, friendlyname, org_id_friendlyname"
      );
    } else {
      $this->json = array(
        "operation"=>"core/get",
  			"class"=>"Contact",
  			"key"=>"SELECT Contact WHERE samaccountname_bb='$id'",
  			"simulate"=>"false",
  			"output_fields"=>"name,status, org_id, org_name, email, phone, notify, function, building_id_bb, employment_status_bb, cost_center_bb, cost_center_manager_bb, samaccountname_bb, friendlyname, org_id_friendlyname"
      );
    }

    $result = $this->execute();
    if(is_array($result))
      return array("code"=>0,"result"=>$result);

    $result = json_decode($result,1);
    $result = array_flatten($result);
    foreach($result as $k=>$v)
      $final["user_" . $k]=$v;
    return array("code"=>1,"result"=>$final);
  }

  public function query($cmd){
    if(!is_array($cmd))
      return array("Error"=>"Query command must be an array with class and key defined.");

    //Checks to see if a location is being set and if so it pulls the pc data and see's if it's on legal hold to redirect it.
    if(isset($cmd['fields']['location_id'])) {
      $temp = new iTop();
      $env = new envConfig();
      $temp->setURL($env->iTopURL);
      $temp->query(array(
        "operation"=>"core/get",
        "class"=>"PC",
        "key"=>"SELECT PC WHERE id=" . $cmd['key'],
        "output_fields"=>"location_name"
      ));
      $t = json_decode($temp->printAsset(),true);
      foreach($t['objects'] as $c){
        if($c['fields']['location_name']=="Legal Hold"){
          $locs = new iTop();
          $locs->setURL($env->iTopURL);
          $sql = "SELECT Location WHERE id=" . $cmd['fields']['location_id'];
          $locs->query(array(
            "operation"=>"core/get",
            "class"=>"Location",
            "key"=>$sql,
            "output_fields"=>"friendlyname"
          ));
          $dec = json_decode($locs->printAsset(),true);
          $hold = array();
          foreach($dec['objects'] as $loc)
            $hold[] = $loc;
          foreach($hold as $h){
            if($h['key'] == $cmd['fields']['location_id']){
              $catch = $h['fields']['friendlyname'];
              $catch = "LH" . ltrim($catch,"WH");
              $locs->query(array(
                "operation"=>"core/get",
                "class"=>"Location",
                "key"=>"SELECT Location WHERE friendlyname='$catch'",
                "output_fields"=>"friendlyname"
              ));
              $dec = json_decode($locs->printAsset(),true);
              foreach($dec['objects'] as $d)
                $cmd['fields']['location_id'] = $d['key'];
            }//end of if finding the matching location
          }//end of foreach to run the locations
        }//end of if running if Legal Hold
      }//end of foreach of the pulled PC
    }//end of if looking to intercept and redirect a legal hold machine

    foreach($cmd as $k=>$v)
      $this->json["$k"]=$v;

    $this->asset = $this->execute();
    return $this->asset;
  }

  private function execute() {
    $t = $this->URL . urlencode(json_encode($this->json));
    $ch = curl_init($t);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_USERPWD, $this->iTopWriter['User'] . ":" . $this->iTopWriter['Password']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSLVERSION, 3);
    curl_setopt($ch, CURLOPT_STDERR, $verbose = fopen('php://temp', 'rw+'));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json')
    );
   $result = curl_exec($ch);
   $results = curl_getinfo($ch);

   $log = new Logging();
   if(!$result){
     $log->execute(array(
       "Call"=>"iTop Query",
       "Result_Code"=>"0",
       "Source"=>json_encode($this->json),
       "Result"=>json_encode($results)
     ));
     return array(
       "Error"=>"Could not get iTop data.",
       "Call Error"=>curl_error($ch),
       "Call Info"=>curl_errno($ch),
       "Call Results"=>$results
     );
   }
   $log->execute(array(
     "Call"=>"iTop Query",
     "Result_Code"=>"1",
     "Source"=>json_encode($this->json),
     "Result"=>json_encode($result)
   ));
   return $result;
  } // End of execute()

  public function printAsset(){
    return $this->asset;
  }

  public function printKey(){
    return $this->key;
  }
} // End of iTop class

//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
// class mSQL provides standardized access to mysql_info
class mSQL {
  private $conn;
  public function __construct(){
    $env=new envConfig();
    $connection = "mysql:host=" . $env->msqlServer . ";dbname=" . $env->mDB;
    // $connection = "mysql:host=10.68.33.251;port=3306;dbname=" . $env->mDB;
    // echo $connection;
    $this->conn = new PDO($connection, $env->msqlUID,$env->msqlPWD);
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  public function query($sql){
    // echo $sql . "\n\n";
    try {
      $result = $this->conn->query($sql);
      $final = $result->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e){
      $final = array($sql,$e->getMessage());
    }

     return $final;
  }

  public function insert($sql){
    try{
      $result = $this->conn->prepare($sql);
      $finish = $result->execute();
      $finish = $this->conn->lastInsertID();
    } catch(PDOException $e){
      $finish = $e->getMessage();
    }

    return $finish;
  }
}

//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//class SQL provides standardized access to MSSQL
class SQL {
  private $server, $connectionInfo, $db;
  private $conn;

  public function __construct($db = null){
    $env = new envConfig;
    $this->server = $env->TLSQLServer;
    $this->connectionInfo = $env->TLSQLconnectionInfo;

    if(!empty($db))
      $this->db = $db;

    $this->conn = sqlsrv_connect($this->server, $this->connectionInfo);
    if($this->conn === false)
      return array("Error"=>sqlsrv_errors());
    else
      return true;
  }//end of constructor

  public function query($sql){
    $stmt = sqlsrv_query($this->conn, $sql);

    if($stmt===false){
      return array("Error"=>sqlsrv_errors(), "SQL"=>$sql);
    }

    $results = array();
    while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
      $results[] = $row;

    return $results;
  }

  public function insert($sql,$params){
    if(!isset($sql) || !is_array($params)){
      return array("Error"=>"An insert statement and an array of parameters must be passed.");
    }
    $stmt = sqlsrv_prepare($this->conn, $sql, $params);

    // $stmt = sqlsrv_query($this->conn, $sql, $params);
    echo "\n$stmt\n";
    if(!$stmt){
      return array("Error"=>sqlsrv_errors(), "SQL"=>$sql);
    }

    if(sqlsrv_execute($stmt)===false){
      return array("Error"=>sqlsrv_errors(),"SQL"=>$sql);
    }
    return array("Success"=>"Successfully inserted.");
  } // end of insert

  public function CDSimCreate($Closet_ID,$SIM,$MobileNumber,$Carrier,$Status,$Contact,$EmpPaid,$Voice,$Data,$LastUpdatedBy,$WO,$Usage){
    $env = new envConfig;

  	$sql = "
  	USE " .$env->CarrierDB . "

  	INSERT INTO " . $env->CarrierDB . ".[dbo].[Sims]
  			   ([ID]			   ,[Closet_ID]			   ,[SIM]		   ,[MobileNumber]			   ,[Carrier]			   ,[Status]			   ,[Contact]			   ,[EmpPaid]			   ,[Voice]			   ,[Data]			   ,[LastUpdatedBy]			   ,[LastUpdatedDate]			   ,[CreatedDate],[WO],[Usage])
  		 VALUES			   (NEWID()			   ,?			   ,?			   ,?			   ,?			   ,?			   ,?			   ,?			   ,?			   ,?			   ,?			   ,GETDATE()			   ,GETDATE(),?,?)	";

    sqlsrv_configure("WarningsReturnAsErrors", 0);
  	$stmt = sqlsrv_prepare($this->conn,$sql,array(&$Closet_ID,&$SIM,&$MobileNumber,&$Carrier,&$Status,&$Contact,&$EmpPaid,&$Voice,&$Data,&$LastUpdatedBy,&$WO,&$Usage));

  	if( !$stmt ) {
  		echo json_encode(sqlsrv_errors());
  		return FALSE;
  	}

  	if( sqlsrv_execute( $stmt ) === false ) {
  		echo json_encode(sqlsrv_errors());
  		return FALSE;
  	}

  	$sql = "SELECT * FROM " . $env->CarrierDB . ".[dbo].[Sims] WHERE SIM = '" . $SIM . "'";

  	$stmt = sqlsrv_query( $this->conn, $sql);
  	if( $stmt === false )
  	{
  	   echo "Error in executing query.</br>";
  	   die( print_r( sqlsrv_errors(), true));
  	}

  	$results = array();
  	while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  		$results[] = $row;
  	} //Ends While

  	if(sizeof($results)>0)
  		return $results;
  	else
  		return FALSE;
  }

  public function sql_escape_string($data) {
    if ( !isset($data) or empty($data) ) return '';
    if ( is_numeric($data) ) return $data;

    $non_displayables = array(
        '/%0[0-8bcef]/',            // url encoded 00-08, 11, 12, 14, 15
        '/%1[0-9a-f]/',             // url encoded 16-31
        '/[\x00-\x08]/',            // 00-08
        '/\x0b/',                   // 11
        '/\x0c/',                   // 12
        '/[\x0e-\x1f]/'             // 14-31
    );
    foreach ( $non_displayables as $regex )
        $data = preg_replace( $regex, '', $data );
    $data = str_replace("'", "''", $data );
    return $data;
	}//end of mssql_escape_string
}


//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//class Logging provides the standardized logging for BAT
class Logging {

  public function execute($vals = null){
    if(!is_array($vals) || empty($vals))
      return array("Error"=>"You must pass an array of values that include Call, the Result_Code, the Source, and the Result.");

    $sql = new SQL();
    $env = new envConfig();
    $ins = "USE " . $env->LoggingDB . " INSERT INTO " . $env->LoggingDB . ".[dbo].[function_calls]
      ([FunctionID],[WorkflowID],[StartDateTime],[FinishDateTime],[UserName],[Function],[FunctionVersion],[ExitCode],[Source],[Result])
      VALUES (NEWID(), NEWID(), GETDATE(), GETDATE(),'" . addslashes($_SERVER['REMOTE_USER']) . "',
      '" . $vals['Call'] . "','2.0', '" . $vals['Result_Code'] . "', '" . $vals['Source'] . "', '" . $vals['Result'] . "')";

    // echo $ins . "\n";
    $res = $sql->query($ins);

    return $res;
  }

  public function sql_escape_string($data) {
    if ( !isset($data) or empty($data) ) return '';
    if ( is_numeric($data) ) return $data;

    $non_displayables = array(
        '/%0[0-8bcef]/',            // url encoded 00-08, 11, 12, 14, 15
        '/%1[0-9a-f]/',             // url encoded 16-31
        '/[\x00-\x08]/',            // 00-08
        '/\x0b/',                   // 11
        '/\x0c/',                   // 12
        '/[\x0e-\x1f]/'             // 14-31
    );
    foreach ( $non_displayables as $regex )
        $data = preg_replace( $regex, '', $data );
    $data = str_replace("'", "''", $data );
    return $data;
	}//end of mssql_escape_string
}//end of logging

//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//class carrierPerm returns the carrier permissions for a user
//Can be extended for further carrier work

class Notes {

  private $env, $conn, $results;
  public function __construct(){

    $this->env = new envConfig();
    $conn = sqlsrv_connect($this->env->TLSQLServer, $this->env->TLSQLconnectionInfo);
    if( $conn === false )	{
       echo "Unable to connect.</br>";
       die( print_r( sqlsrv_errors(), true));
    }
    $this->conn = $conn;
  }
  public function query($criteria=null, $columns=null){
    if(empty($criteria) || empty($columns))
      return array("Error"=>"You must provide criteria and columns.");
    $sql = $columns . " FROM " . $this->env->metaDB . ".[dbo].[AssetComments] " . $criteria;
    $stmt = sqlsrv_query($this->conn, $sql);
    if( $stmt === false ) {
       echo "Error in executing query. \n";
       echo $sql . "\n";
       return array(sqlsrv_errors());
    }
    $results = array();
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      $results[] = $row;
    } //Ends While
    $this->results = $results;
  } // End query
  public function insert($s=null){
    if(empty($s))
      return array("Error"=>"You must provide an insert statement.");
    $sql = "USE " . $this->env->metaDB . " INSERT INTO " . $this->env->metaDB . ".[dbo].[AssetComments] (" . $s . ")";
    $stmt = sqlsrv_query($this->conn, $sql);
    if( $stmt === false ) {
       echo "Error in executing query. \n";
       echo $sql . "\n";
       return array(sqlsrv_errors());
    }
    return array("Success"=>"Note Saved.");
  } // End insert

  public function getResults(){
    return $this->results;
  } // End getResults
}

class itopMap {

  public function map($t){
    if($t=="MobilePhone"){
      return array(
        "data"=>array(
          "imei"=>"imei",
          "bsn"=>"tag_number_bb",
          "prd"=>"name",
          "location"=>"location_id",
          "status"=>"status",
          "warranty"=>"end_of_warranty",
          "brand"=>"po_bb",
          "receiveddate"=>"received_date_bb",
          "model"=>"sow_bb"
        ),
        "renames"=>array(
          "imei"=>"IMEI",
          "tag_number_bb"=>"BSN",
          "name"=>"PRD",
          "location_name"=>"Location",
          "status"=>"Status",
          "end_of_warranty"=>"Warranty",
          "po_bb"=>"Brand",
          "received_date_bb"=>"Received Date",
          "sow_bb"=>"Model",
          "asset_number"=>"Asset ID"
        ),
        "org_id"=>"2",
        "uniqueFields"=>array("imei","tag_number_bb","name")
      );
    }
  }

}


?>
