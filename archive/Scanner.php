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
#txt_AssetID{padding: 10px;border: #F0F0F0 1px solid;}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$("#txt_AssetID").blur(function(){
	var ID=document.getElementById("txt_AssetID").value;
	
	$.ajax({
		type: "POST",
		url: "Check_ID.php",
		data:'ID='+ID,
		success: function(data){
		  //    alert (data);
			  var default_data=JSON.parse(data);
			  var count=default_data["count"];
			 
			  if(count>0)
			  {
			    alert("AssetID You entered already exist. Update the existing one or add a new AssetID");
				document.getElementById("txt_AssetID").value="";
			  }
			  else
			  {
			    document.getElementById("txt_AssetID").value=ID;
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
   <input type="text" class='form-control input-lg' id="txt_AssetID" name="txt_AssetID" onkeypress="return noenter()" onMouseOver="this.focus();" size="40" onClick="SetWhite(this.id);" placeholder="Please Enter Asset ID" autocomplete="off" value="" autofocus />	
   
	</form>
	</div>
</body>

</html>