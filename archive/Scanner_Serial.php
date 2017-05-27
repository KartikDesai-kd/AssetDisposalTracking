<!DOCTYPE html>



<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
  
<!-- CSS (FA v4.5.0 & BS v3.3.6) -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/Individual_Assets.css">
<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
  
<!-- JavaScript & JQuery -->
<script src='js/bootstrap.min.js'></script>
<script src="js/highlightNav.js"></script>
<style>
#txt_SerialNo{padding: 10px;border: #F0F0F0 1px solid;}
</style>

<script type="text/javascript">
$(document).ready(function(){
	$("#txt_SerialNo").blur(function(){
	var ID=document.getElementById("txt_SerialNo").value;
	
	$.ajax({
		type: "POST",
		url: "Check_ID.php",
		data:'ID='+ID,
		success: function(data){
		 
			  var default_data=JSON.parse(data);
			  var count=default_data["count"];
			 
			  if(count>0)
			  {
			    alert("Serial#  You entered already exist. Update the existing one or add a new Serial#");
				document.getElementById("txt_SerialNo").value="";
			  }
			  else
			  {
			    document.getElementById("txt_SerialNo").value=ID;
			  }
		}
		});  
	});
});
</script>
	<script type="text/javascript">
	
	$(function){
$('#scanner').submit(function(event){
event.preventDefault();
$(this).submit();
	});
});

function SetWhite(id)
{
  document.getElementById(id).style.background="white";
}
	</script>
	<script type="text/javascript">
function noenter() {
  return !(window.event && window.event.keyCode == 13); }
</script>
<head>
<body>
	<div class='form-group'>
	<form action="" id="scanner" method="post">
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="text" id="txt_SerialNo" class='form-control input-lg' name="txt_SerialNo" onkeypress="return noenter()" onMouseOver="this.focus();" size="40" onClick="SetWhite(this.id);" placeholder="Please enter Serial No" autocomplete="off" value=""  />	
	
	</form>
	</div>
</body>

</html>