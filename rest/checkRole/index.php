<?php
  $user = $_SERVER['REMOTE_USER'];
  $user = explode("\\",$user);
  $user = $user[1];
  // $user = 'kdesai';
  if ($user == 'bdusome' || $user == 'jcarlin' ||  $user == 'kadesai') {
    echo json_encode(array("Role"=>"Admin","User"=>$user));
  } else {
    echo json_encode(array("Role"=>"User","User"=>$user));
  }
 ?>
