// Global Variables
var url = "";
var ID_Asset;
var sessionUser = "";
// Admin Check
function checkRole(){
   $.ajax({
    type: "POST",
    url: "rest/checkRole/",
    success: function (data) {
      var default_data = eval('(' + data + ')');
      data = JSON.parse(data);
      sessionUser = data.User;
      console.log(sessionUser);
      if(data.Role == "Admin")
        $("#adminNav").show();
    } // end success
  });
}
// Add new Vendor, Functionality for Admin
function AddNewVendor_Admin()
{

	var type="AddNewVendor_Admin";
	var PrimaryVendor=document.getElementById("txt_PrimaryVendor").value;
	var SecondaryVendor=document.getElementById("txt_SecondaryVendor").value;
	var VendorLocation=document.getElementById("txt_Location").value;
	var ApprovalStatus=document.getElementById("txt_ApprovalStatus").value;
	var Resale=document.getElementById("txt_Resale").value;
	var Recycling=document.getElementById("txt_Recycling").value;
	var RecyclingType=document.getElementById("txt_RecyclingType").value;
	var DeviceDestruction=document.getElementById("txt_DeviceDestruction").value;
	var HDWiping=document.getElementById("txt_HDWiping").value;
	var VendorSecurity=document.getElementById("txt_VendorSecurity").value;
	var Environment=document.getElementById("txt_Environment").value;
	var Contract=document.getElementById("txt_Contract").value;
	var PickupProcess=document.getElementById("txt_PickupProcess").value;
	var Notes=document.getElementById("txt_Notes").value;

	window.location="common.php?Type="+type+"&PrimaryVendor="+PrimaryVendor+"&SecondaryVendor="+SecondaryVendor+"&VendorLocation="+VendorLocation+"&ApprovalStatus="+ApprovalStatus
	     +"&Resale="+Resale+"&Recycling="+Recycling+"&RecyclingType="+RecyclingType+"&DeviceDestruction="+DeviceDestruction+"&HDWiping="+HDWiping+"&VendorSecurity="+VendorSecurity
		 +"&Environment="+Environment+"&Contract="+Contract+"&PickupProcess="+PickupProcess+"&Notes="+Notes;
}

// Reset Everything
function Index_Reset() {
  document.getElementById("txt_Vendor").value=="";
  document.getElementById("datepicker1").value=="";
  document.getElementById("txt_StatementOfWork1").value=="";
  document.getElementById("txt_NumberOfPallets1").value=="";
  document.getElementById("txt_PickupLocation").value=="";
  document.getElementById("txt_LocalRIMContact1").value=="";
  document.getElementById("txt_ID").value=="";
  document.getElementById("indi").classList.add("active");
  document.getElementById("bulkAssets").style.display="none";
  document.getElementById("datatable").disabled=true;
  document.getElementById("div_WO").style.display="none";
  // document.getElementById("manual").style.display="inline";
}

function NewLoadID()
{
	document.getElementById("txt_WO1").value="";
	document.getElementById("div_WO").style.display="none";
	document.getElementById("txt_Vendor").value="";
  document.getElementById("datepicker1").value="";
  document.getElementById("txt_StatementOfWork1").value="";
  document.getElementById("txt_NumberOfPallets1").value="";
  document.getElementById("txt_PickupLocation").value="";
  document.getElementById("txt_LocalRIMContact1").value="";

	document.getElementById("txt_Vendor").readOnly=false;
  document.getElementById("datepicker1").readOnly=false;
  document.getElementById("txt_StatementOfWork1").readOnly=false;
  document.getElementById("txt_NumberOfPallets1").readOnly=false;
  document.getElementById("txt_PickupLocation").readOnly=false;
  document.getElementById("txt_LocalRIMContact1").readOnly=false;
}
function ExistingLoadID()
{

	document.getElementById("div_WO").style.display="block";

	document.getElementById("txt_Vendor").value="";
    document.getElementById("datepicker1").value="";
    document.getElementById("txt_StatementOfWork1").value="";
    document.getElementById("txt_NumberOfPallets1").value="";
    document.getElementById("txt_PickupLocation").value="";
    document.getElementById("txt_LocalRIMContact1").value="";

	document.getElementById("txt_Vendor").readOnly=true;
    document.getElementById("datepicker1").readOnly=true;
    document.getElementById("txt_StatementOfWork1").readOnly=true;
    document.getElementById("txt_NumberOfPallets1").readOnly=true;
    document.getElementById("txt_PickupLocation").readOnly=true;
    document.getElementById("txt_LocalRIMContact1").readOnly=true;
}
function FillFromLoadID()
{

	var type1="FillLoadID";
	var id=document.getElementById("txt_WO1").value;
	     $.ajax({
            type: "POST",
            url: "common.php",
            data: "id="+id+"&Type="+type1,
            success: function (data) {
			 // alert(data);
               var default_data = eval('(' + data + ')');
			    // var default_data=JSON.parse(data);
				// alert(default_data[0].ID);

				//document.getElementById('div_popup').style.display = "block";
				//document.getElementById("ID1").value=default_data[0].ID;
                document.getElementById("txt_Vendor").value=default_data[0].Vendor;
				//var dt=default_data[0].Date_Submitted["date"];
				 //document.getElementById("datepicker1").value=dt.substr(0,10);
				document.getElementById("datepicker1").value=default_data[0].Date_Submitted;
				document.getElementById("txt_StatementOfWork1").value=default_data[0].StatementOfWork;
				document.getElementById("txt_NumberOfPallets1").value=default_data[0].NumberOfPallets;
				document.getElementById("txt_PickupLocation").value=default_data[0].PickUpLocation;
				document.getElementById("txt_LocalRIMContact1").value=default_data[0].LocalRIMContact;
				document.getElementById("txt_WO1").value=default_data[0].LoadID;

				document.getElementById("txt_Vendor").readOnly=true;
				document.getElementById("datepicker1").readOnly=true;
				document.getElementById("txt_StatementOfWork1").readOnly=true;
				document.getElementById("txt_NumberOfPallets1").readOnly=true;
				document.getElementById("txt_PickupLocation").readOnly=true;
				document.getElementById("txt_LocalRIMContact1").readOnly=true;

            }
        });
}

//Load WO# from database
$(document).ready(function(){
	$("#txt_WO1").keyup(function(){

		var type="WO";
      // ocument.getElementById("assettype").style.display="none";
		$.ajax({
		type: "POST",
		url: "common.php",
		data:'keyword='+$(this).val()+"&Type="+type,
		beforeSend: function(){
		},
		success: function(data){
			//alert(data);
			//alert(document.getElementById("WOList"));
			$("#WOList").show();
			$("#WOList").html(data);
			$("#txt_WO1").css("background","#FFF");
		}
		});
	});

});


function selectWO(val)
{
//alert(val);
$("#txt_WO1").val(val);
$("#WOList").hide();
FillFromLoadID();
}

//Load WO# from database
$(document).ready(function(){
	$("#txt_WO").keyup(function(){

		var type="WO1";
	   	document.getElementById("assettype").style.display="none";
		$.ajax({
		type: "POST",
		url: "common.php",
		data:'keyword='+$(this).val()+"&Type="+type,
		beforeSend: function(){
		},
		success: function(data){
			//alert(data);
			//alert(document.getElementById("WOList"));
			$("#WOList").show();
			$("#WOList").html(data);
			$("#txt_WO").css("background","#FFF");
		}
		});
	});

});


function selectWO1(val) {
//alert(val);
$("#txt_WO").val(val);
$("#WOList").hide();

}

function closeclick(){
  location.reload(true);
}

// Globals
var Asset = [];
var counter=0;
var type;
var Search_Count=0;
var NotFound=0;
var infoADTF = [];
var infoAssets = [];
var checkvendor=1;
var err_index=[];
// 'START' Clicked..
function start(){
if(checkvendor==0)
	{
		$("#Vendor_myModal1").modal()
	}
	else
	{
  // Toggle Instructions
  $("#startHelp").hide();
  $("#scanHelp").show();
  // Store ADTF Info
  infoADTF.push({
    Vendor: $("#txt_Vendor").val(),
    DateSubmitted: $("#datepicker1").val(),
    StatementOfWork: $("#txt_StatementOfWork1").val(),
    NumberOfPallets: $("#txt_NumberOfPallets1").val(),
    LoadID: $("#txt_WO1").val(),
    PickUpLocation: $("#txt_PickupLocation").val(),
    LocalRIMContact: $("#txt_LocalRIMContact1").val()
  });

  // Hide ADTF Info, Show Scan Elements
  $("#adtfInfo").hide();
  // Display ADTF Info (During Scan)
  $("#vendorInfo").html(infoADTF[0]['Vendor']);
  $("#datesubmittedInfo").html(infoADTF[0]['DateSubmitted']);
  if(infoADTF[0]['StatementOfWork'] == "")
    infoADTF[0]['StatementOfWork'] = "Unknown";
  $("#sow").html(infoADTF[0]['StatementOfWork']);
  $("#nop").html(infoADTF[0]['NumberOfPallets']);
  if(infoADTF[0]['LoadID'] == "")
    infoADTF[0]['LoadID'] = "<font class='red-bb'>TBD</font>";
  $("#wo").html(infoADTF[0]['LoadID']);
  $("#pickup").html(infoADTF[0]['PickUpLocation']);
  $("#contact").html(infoADTF[0]['LocalRIMContact']);

  // Show Scan Elements
  $("#savedInfo").show();
  $("#search").show();


//  console.log(infoADTF);
	}
}

// Execute Search
function search_ID() {
  if($("#txt_ID").val() == "")
    return false;

	Search_Count++;
	type="indi";
	$("#loading").show();
	$("#cnt").show();
	if(NotFound==0)
	{
	 $("#errorMsg").hide();
	}
	counter++;
	document.getElementById("cnt").innerHTML= counter;

  // Unique ID to modify table rows after loading...
	var uniq = Math.random();
	Asset.push({
		"arg_FK":uniq,
		a_ID:$("#txt_ID").val(),
		a_Vendor:$("#txt_Vendor").val(),
		a_DateSubmitted:$("#datepicker1").val(),
		a_StatementOfWork:$("#txt_StatementOfWork1").val(),
		a_NumberOfPallets:$("#txt_NumberOfPallets1").val(),
		a_PickUpLocation:$("#txt_PickupLocation").val(),
		a_LocalRIMContact:$("#txt_LocalRIMContact1").val(),
		"Asset Type":"Processing",
		"Asset ID":$("#search-box").val(),
		a_Manufacturer:"Processing",
		a_Model:"Processing",
		a_SerialNo:$("#search-box").val(),
		a_WO:$("#txt_WO1").val(),
		a_Description:$("#txt_Description").val(),
		a_Weight:$("#txt_Weight").val()
	});
  // console.log(Asset);
	Index_div_show();

  // Blank Search Value Check
	if($("#txt_ID").val() == "") {
		$("#txt_ID").css({"border": "1px solid red"});
		Asset = Asset.filter(function(e) {
      return e.arg_FK != uniq;
    });
  } else {
    $("#txt_ID").css("border: 1px solid lightgray");
    var id = $("#txt_ID").val();
  }

	$.ajax({
    type: "POST",
    url: "rest/assetSearch/",
    data: "id="+id,
    success: function (data) {
      var default_data = eval('(' + data + ')');
		  document.getElementById("search-box").value=default_data.Asset_Type;
			document.getElementById("Manufactsearch-box1").value=default_data.Manufacturer;
			document.getElementById("txt_Model1").value=default_data.Model;
			document.getElementById("txt_AssetID1").value=default_data.Asset_ID;
			document.getElementById("txt_SerialNo1").value=default_data.Serial_No;
			if(default_data.Asset_Type==null) {
  			/*document.getElementById("datatable").disabled=false;
  			NotFound++;
  			var c=Search_Count-1;
  			document.getElementById("msg").innerHTML=document.getElementById("msg").innerHTML+"<input type='button' class='btn btn-danger spacer-t-sm' id='"+c+"' data-toggle='modal' data-target='#myModal' onclick='err_View_Unknown(this.id);' value='"+id.toUpperCase()+"' />"+"<br>";
  		  $("#errorMsg").show(); */
		    // $("#scanHelp").hide();
  			//code to add data when no record found
  			document.getElementById("search-box").value="Unknown";
        document.getElementById("Manufactsearch-box1").value="Unknown";
        document.getElementById("txt_Model1").value="Unknown";
        document.getElementById("txt_AssetID1").value=id.toUpperCase();
        document.getElementById("txt_SerialNo1").value=id.toUpperCase();
			}
      // Add Record To Table
			Index_Add_Data(uniq);

			for(i=0;i<Asset.length;i++)
			{
				if(Asset[i]["a_Model"]=="Unknown")
				{
					if(err_index.indexOf(i) == -1 )
					{
						 err_index.push(i);
            NotFound++;
            // Hand Icon: <i class='fa-hand-o-right fa fa-lg fa-fw'></i>
				     document.getElementById("msg").innerHTML=document.getElementById("msg").innerHTML+"<input type='button' class='btn btn-danger spacer-t-sm' id='"+i+"' data-toggle='modal' data-target='#myModal' onclick='err_View_Unknown(this.id);' value='"+id.toUpperCase()+"' />"+"<br>";
  		           $("#errorMsg").show();
					}


				}
			}
      // Update Loader...
      if(counter!=0) {
        $("#loading").show();
      } else {
        $("#loading").hide();
      }
      if(counter==0) {
			     document.getElementById("datatable").disabled=false;
			}
			else {
					document.getElementById("datatable").disabled=true;
			}
      if(NotFound>0)
    {
    document.getElementById("datatable").disabled=true;
    }
    } // end success
  });
  // end $.ajax
    // err_index++;
	document.getElementById("txt_ID").value="";
	document.getElementById("ind").style.display="inline";
} // end Search

//Search record on TAB key press
$(document).ready(function(){
	$("#loading").hide();
	$("#success").hide();
$("#txt_ID").keydown(function (e) {
    if (e.keyCode === 9)
	{
		if(document.getElementById("txt_ID").value=="")
       {
        document.getElementById("txt_ID").title="Please Enter AssetID/Serial No";
        $('[data-toggle="tooltip7"]').tooltip();
		document.getElementById("txt_ID").style.border="1px solid red";

       }
	   else
	   {
		search_ID();
	   }
		$("#txt_ID").focus();
		e.preventDefault();
	}
});
});




function ShowIndividual()
{

  document.getElementById("indvAssets").style.display="inline";
  document.getElementById("bulkAssets").style.display="none";
  //$("#indi").addClass("active");
  //$("#blk").removeClass("active");
   document.getElementById("indi").classList.add("active");
  document.getElementById("blk").classList.remove("active");
}
function ShowBulk()
{
  document.getElementById("indvAssets").style.display="none";
  document.getElementById("bulkAssets").style.display="inline";
 document.getElementById("blk").classList.add("active");
  document.getElementById("indi").classList.remove("active");

}


 function SetColor(id)
 {
	// alert(id);
	 document.getElementById(id).style.border="1px solid lightgray";
	 if(id=="txt_Vendor")
	 {
	 $('[data-toggle="tooltip1"]').tooltip('destroy');
	 }
	 if(id=="datepicker1")
	 {
	 $('[data-toggle="tooltip2"]').tooltip('destroy');
	 }
	  if(id=="txt_StatementOfWork1")
	 {
	 $('[data-toggle="tooltip3"]').tooltip('destroy');
	 }
	  if(id=="txt_NumberOfPallets1")
	 {
	 $('[data-toggle="tooltip4"]').tooltip('destroy');
	 }
	  if(id=="txt_PickupLocation")
	 {
	 $('[data-toggle="tooltip5"]').tooltip('destroy');
	 }
	  if(id=="txt_LocalRIMContact1")
	 {
	 $('[data-toggle="tooltip6"]').tooltip('destroy');
	 }
	 if(id=="txt_ID")
	 {
	 $('[data-toggle="tooltip7"]').tooltip('destroy');
	 }
	// document.getElementById(id).data-toggle="";
 }

//Show record in the table
function Index_Add_Data(uniq)
{
var ID=document.getElementById("txt_ID").value;
var Vendor = document.getElementById("txt_Vendor").value;
var DateSubmitted = document.getElementById("datepicker1").value;
var StatementOfWork = document.getElementById("txt_StatementOfWork1").value;
var NumberOfPallets = document.getElementById("txt_NumberOfPallets1").value;
var PickUpLocation = document.getElementById("txt_PickupLocation").value;
var LocalRIMContact = document.getElementById("txt_LocalRIMContact1").value;
var AssetType= document.getElementById("search-box").value;
if(AssetType=="")
{
	AssetType=document.getElementById("search-box1").value;
}
var Manufacturer = document.getElementById("Manufactsearch-box1").value;
if(Manufacturer=="")
{
	Manufacturer="N/A";
}
var Model= document.getElementById("txt_Model1").value;
if(Model=="")
{
	Model="N/A";
}
var AssetID=document.getElementById("txt_AssetID1").value;
if(AssetID=="")
{
	AssetID="N/A";
}
var SerialNo=document.getElementById("txt_SerialNo1").value;
if(SerialNo=="")
{
	SerialNo="N/A";
}
var WO=document.getElementById("txt_WO1").value;
var Description=document.getElementById("txt_Description").value;
if(Description=="")
{
	Description="N/A";
}
var Weight=document.getElementById("txt_Weight").value;
if(Weight=="")
{
	Weight="N/A";
}
//Check for blank fields
if (Vendor == '' || DateSubmitted == '' || NumberOfPallets == ''|| PickUpLocation == ''|| LocalRIMContact == '') {

event.preventDefault();
}
else{
	if(uniq!=undefined && uniq!=null){
		$.each(Asset,function(k1,v1){
			$.each(v1,function(k,v){
				if(v == uniq.toString()){
					Asset[k1]['Asset Type'] = AssetType;
					Asset[k1]['Asset ID'] = AssetID;
					Asset[k1]["a_Manufacturer"] = Manufacturer;
					Asset[k1]["a_Model"] = Model;
					Asset[k1]['a_SerialNo'] = SerialNo;
          if(AssetID=="N/A")
          {
           Asset[k1]['a_Description']=Description;
          }
          else
          {
          Asset[k1]['a_Description']="N/A";
          }
          Asset[k1]['a_Weight'] = Weight;
				}
			});
		});
	}
	// Asset.push({a_ID:ID,a_Vendor:Vendor,a_DateSubmitted:DateSubmitted,a_StatementOfWork:StatementOfWork,a_NumberOfPallets:NumberOfPallets,a_PickUpLocation:PickUpLocation,a_LocalRIMContact:LocalRIMContact,"Asset Type":AssetType,"Asset ID":AssetID,a_Manufacturer:Manufacturer,a_Model:Model,a_SerialNo:SerialNo,a_WO:WO,a_Description:Description,a_Weight:Weight});
 document.getElementById("datatable").style.display="block";
 //Show Table
 Index_div_show();
 //Allocate value to Textbox
 document.getElementById("txt_Vendor").value=Vendor;
 document.getElementById("datepicker1").value=DateSubmitted;
 document.getElementById("txt_StatementOfWork1").value=StatementOfWork;
 document.getElementById("txt_NumberOfPallets1").value=NumberOfPallets;
 document.getElementById("txt_PickupLocation").value=PickUpLocation;
 document.getElementById("txt_LocalRIMContact1").value=LocalRIMContact;
 document.getElementById("search-box").value="";
 document.getElementById("Manufactsearch-box1").value="";
 document.getElementById("txt_Model1").value="";
 document.getElementById("txt_AssetID1").value="";
 document.getElementById("txt_SerialNo1").value="";
 document.getElementById("txt_WO1").value=WO;

}
counter--;
document.getElementById("cnt").innerHTML=counter;
}

//Confirm before closing current page
$(window).bind('beforeunload',
function(){
	if(Asset.length>0)
  {
	return 'Attention! Assets you scanned will be lost';
  }
});

// Build Dynamic Table...

function Index_div_show() {

		var outputTable = [];
		$.each(Asset,function(k,v){
			var temp = {};
			temp['Asset Type'] = v['Asset Type'];
			temp['Manufacturer']=v.a_Manufacturer;
			temp['Model']=v.a_Model;
			temp['Asset ID'] = v['Asset ID'];
			temp['Serial No']=v.a_SerialNo;
			temp['Weight']=v.a_Weight;
			outputTable.push(temp);
		});

		if(NotFound==0)
		{
         if(outputTable.length>0)
		 {
			 //alert(NotFound);
		$("#table3").html(createTable(outputTable,"","tableID3"));
	    $("#tableID3").dataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
		"bSort": false
  });
		 }
		}
		else if(NotFound>0)
		{
			if(outputTable.length>0)
		 {
			 //alert(NotFound);
		$("#table3").html(createTable(outputTable,"","tableID3"));
	    $("#tableID3").dataTable({
		"bSort": false
  });
		 }
		}
}
// End Index_div_show()

//	##### TABLE CREATION #####
// 	Pass an array of objects, array of tool tips, and a table name
//  and a table will be created and passed back (as html) to implement

function createTable(array, tooltips, tableName){


	var rownum=0;
 if(tableName!=null)
		var output = "<table id='" + tableName + "'><thead><tr>";
	else
		var output = "<table id='data'><thead><tr>";
	$.each(array, function(k,v){
		var count = 0;
		$.each(v, function(k,v){
			output += "<th>" + k + "</th>";
			count++;
		});//go through each object under the object
		output += "<th>" + "Action" + "</th>";
		count++;
		return false;
	});
	output += "</tr></thead>"
	output += "<tbody>";
	$.each(array, function(k,v){
		if(array[rownum]["Model"]=="Unknown")
		{
			output+="<tr style='background-color:#FCDDDD'>";
		}
		else
		{
			output += "<tr>";
		}



		$.each(v, function(k,v){
			if(k=="asset_number" || k=="Asset ID")
				output += "<td><text class='action' onclick='showDetails(\"" + v + "\");' >" + v + "</text></td>";
			else if(k=="rowID")
				output += "<td style='display:none;' >" + v + "</td>";
			else
				output += "<td>" + v + "</td>";
		});//go through each object
		output+="<td><a href='#'><i class='fa fa-trash fa-lg' id='"+rownum+"' onclick='Delete_Row(this.id);' title='Delete'></i></a> | <a href='#'><i class='fa fa-info fa-lg' id='"+rownum+"' data-toggle='modal' data-target='#myModal' onclick='View_Unknown(this.id);' title='View'></i></a></td>";
		output += "</tr>";
		rownum++;
	});
	output += "</tbody>";
	output += "</table>";
	return output;
}//end of createTable

// Add Record to Database
function Index_AddData() {
  // Hide Confirm
  $("#confirmADTF").hide();
  $("#confirmADTF_btn").hide();
  // Show Loader...
  $("#loadingADTF").show();
  // Add Type
  var type = "Add_MultipleAssets";
  $.post("rest/createADTF/", {val: JSON.stringify(Asset), type: type, user: sessionUser})
    .success(function(data){
        var default_data = eval('(' + data + ')');
        // Set Ticket & URL
        $("#ticket").html(default_data[0]);
        url = default_data[1];
        // ???
        $("#instructions").hide();
        $("#success").show();
        Asset = [];
        // Hide Loader
        $("#loadingADTF").hide();
        // Show Success
        $("#successADTF").show();
        $("#successADTF_btn").show();
    });
} // end of Index_AddDate

function openLink(modal){
  // Close modal if passed...
  if(modal)
    $("#" + modal).modal('hide');
  // Open link (new window)
  window.open(url);
  location.reload();
}
//Add Bulk Data
function Index_Add_Data_Bulk(){
	if(document.getElementById("txt_Description").value=="")
	{
		document.getElementById("txt_Description").title="Please Enter Description";
        $('[data-toggle="tooltip7"]').tooltip();
		document.getElementById("txt_Description").style.border="1px solid red";
	}
	else
	{
	document.getElementById("txt_Description").style.border="1px solid lightgrey";
	Search_Count++;
	type="bulk";
	counter++;
 	var uniq = Math.random();
	Asset.push({
		"arg_FK":uniq,
		a_ID:$("#txt_ID").val(),
		a_Vendor:$("#txt_Vendor").val(),
		a_DateSubmitted:$("#datepicker1").val(),
		a_StatementOfWork:$("#txt_StatementOfWork1").val(),
		a_NumberOfPallets:$("#txt_NumberOfPallets1").val(),
		a_PickUpLocation:$("#txt_PickupLocation").val(),
		a_LocalRIMContact:$("#txt_LocalRIMContact1").val(),
		"Asset Type":"Processing",
		"Asset ID":$("#search-box1").val(),
		a_Manufacturer:"Processing",
		a_Model:"Processing",
		a_SerialNo:$("#search-box").val(),
		a_WO:$("#txt_WO1").val(),
		a_Description:$("#txt_Description").val(),
		a_Weight:$("#txt_Weight").val()
	});
	Index_Add_Data(uniq);
	 if(counter==0)
					{
						document.getElementById("datatable").disabled=false;
					}
					else
					{
						document.getElementById("datatable").disabled=true;
					}
	document.getElementById("txt_Description").value="";
	document.getElementById("txt_Weight").value="";
	}

}
//End of Add Bulk Data


function View_Unknown(ID)
{
	ID_Asset=ID;

//	document.getElementById('div_popup').style.display = "block";
	//document.getElementById('showtable').style.display = "block";
	//document.getElementById("ID1").value=Asset[ID][];
	document.getElementById("search-box2").value=Asset[ID]["Asset Type"];
	document.getElementById("Manufactsearch-box").value=Asset[ID]["a_Manufacturer"];
	document.getElementById("txt_Model").value=Asset[ID]["a_Model"];
	document.getElementById("txt_AssetID").value=Asset[ID]["Asset ID"];
	document.getElementById("txt_SerialNo").value=Asset[ID]["a_SerialNo"];
	if(document.getElementById("txt_Model").value=="Unknown")
	{
		// document.getElementById("modal_close").style.display="none";
	}
}
/*function div_hide() {
//location.reload();
Index_div_show();
document.getElementById('div_popup').style.display = "none";
}*/
function err_View_Unknown(ID)
{
	ID_Asset=ID;
	//document.getElementById('div_popup').style.display = "block";
//	document.getElementById('showtable').style.display = "block";
	//document.getElementById("ID1").value=Asset[ID][];
	document.getElementById("search-box2").value=Asset[ID]["Asset Type"];
	document.getElementById("Manufactsearch-box").value=Asset[ID]["a_Manufacturer"];
	document.getElementById("txt_Model").value=Asset[ID]["a_Model"];
	document.getElementById("txt_AssetID").value=Asset[ID]["Asset ID"];
	document.getElementById("txt_SerialNo").value=Asset[ID]["a_SerialNo"];
	if(document.getElementById("txt_Model").value=="Unknown")
	{
		// document.getElementById("modal_close").style.display="none";
	}
}
function err_div_hide() {
//location.reload();
if(document.getElementById("txt_Model").value!="Unknown" && document.getElementById("txt_Model").value!="")
{
  NotFound--;
  if(NotFound==0)
  {
	  document.getElementById("datatable").disabled=false;
	  document.getElementById("msg").innerHTML="No Record Found For <br>";
	  $("#errorMsg").hide();
	  $("#scanHelp").show();
  }
  Index_div_show();
  document.getElementById('myModal').style.display = "none";
   document.getElementById("msg").innerHTML="";
  err_index=[];
  NotFound=0;
                 for(i=0;i<Asset.length;i++)
			{
				if(Asset[i]["a_Model"]=="Unknown")
				{

					if((err_index.indexOf(i)) == -1 )
					{
						 err_index.push(i);
					NotFound++;

				   document.getElementById("msg").innerHTML=document.getElementById("msg").innerHTML+"<input type='button' class='btn btn-danger spacer-t-sm' id='"+i+"' data-toggle='modal' data-target='#myModal' onclick='err_View_Unknown(this.id);' value='"+Asset[i]["a_ID"].toUpperCase()+"' />"+"<br>";

  		           $("#errorMsg").show();
					}


				}
			}
 // document.getElementById(ID_Asset).style.display="none";

 // $( "."+ID_Asset ).remove();
}
else{
	if(document.getElementById("txt_Model").value=="Unknown")
	{
		document.getElementById("txt_Model").style.borderColor="red";
	}
}
}
function index_div_change()
   {
	   document.getElementById("update").style.display="block";
	   document.getElementById("change").style.display="none";
	  //  document.getElementById("modal_close").style.display="none";
	   document.getElementById("search-box2").readOnly=false;
	   document.getElementById("Manufactsearch-box").readOnly=false;
	   document.getElementById("txt_Model").readOnly=false;
	   document.getElementById("txt_AssetID").readOnly=false;
	   document.getElementById("txt_SerialNo").readOnly=false;

	   document.getElementById("search-box2").style.backgroundColor="white";
	   document.getElementById("Manufactsearch-box").style.backgroundColor="white";
	   document.getElementById("txt_Model").style.backgroundColor="white";
	   document.getElementById("txt_AssetID").style.backgroundColor="white";
	   document.getElementById("txt_SerialNo").style.backgroundColor="white";
   }
function index_div_update()
{
	   if(document.getElementById("txt_Model").value=="Unknown")
	   {
		    document.getElementById("update").style.display="block";
	       document.getElementById("change").style.display="none";
	      //  document.getElementById("modal_close").style.display="none";
	   }
	   else
	   {
		    document.getElementById("update").style.display="none";
	   document.getElementById("change").style.display="block";
	  //  document.getElementById("modal_close").style.display="block";
	   Asset[ID_Asset]["Asset Type"]=document.getElementById("search-box2").value;
	   Asset[ID_Asset]["a_Manufacturer"]=document.getElementById("Manufactsearch-box").value;
	   Asset[ID_Asset]["a_Model"]=document.getElementById("txt_Model").value;
	   Asset[ID_Asset]["Asset ID"]=document.getElementById("txt_AssetID").value;
	   Asset[ID_Asset]["a_SerialNo"]=document.getElementById("txt_SerialNo").value;
	   document.getElementById("txt_Model").style.backgroundColor=" #f2f2f2";
	   document.getElementById("search-box2").style.backgroundColor="f2f2f2";
	   document.getElementById("Manufactsearch-box").style.backgroundColor="f2f2f2";
	   document.getElementById("txt_AssetID").style.backgroundColor="f2f2f2";
	   document.getElementById("txt_SerialNo").style.backgroundColor="f2f2f2";

       document.getElementById("txt_Model").readOnly=true;
	  document.getElementById("search-box2").readOnly=true;
	   document.getElementById("Manufactsearch-box").readOnly=true;

	   document.getElementById("txt_AssetID").readOnly=true;
	   document.getElementById("txt_SerialNo").readOnly=true;
	   err_index.splice(ID_Asset,1);
	   }
	   Check_Model();
}
function DisableADTF()
	{
		document.getElementById("datatable").disabled=true;
	}
function Delete_Row(ID)
{
	  //alert(ID);
	  var i =ID
	  i++;
	 // alert(JSON.stringify(Asset[0]));
	  //alert($(Asset).length);
	  document.getElementById("tableID3").deleteRow(i);
	  var uniq=Asset[ID]["arg_FK"];
	  var Model_Val=Asset[ID]["a_Model"];
	  if(Model_Val=="Unknown")
	  {
		  NotFound--;
         if(NotFound==0)
        {
	      document.getElementById("datatable").disabled=false;
	      document.getElementById("msg").innerHTML="No Record Found For <br>";
	      $("#errorMsg").hide();
		  $("#scanHelp").show();
        }
		//$( "."+ID).remove();
		document.getElementById("msg").innerHTML="";
         err_index=[];
         NotFound=0;

                 for(i=0;i<Asset.length;i++)
			{
				if(Asset[i]["a_Model"]=="Unknown" && i!=ID)
				{

					if((err_index.indexOf(i))==-1)
					{
						 err_index.push(i);
					NotFound++;

				   document.getElementById("msg").innerHTML=document.getElementById("msg").innerHTML+"<input type='button' class='btn btn-danger spacer-t-sm' id='"+i+"' data-toggle='modal' data-target='#myModal' onclick='err_View_Unknown(this.id);' value='"+Asset[i]["a_ID"].toUpperCase()+"' />"+"<br>";

  		           $("#errorMsg").show();
					}


				}
			}
	  }
	  Asset = Asset.filter(function(e) {
      return e.arg_FK != uniq;
});
	 // alert($(Asset).length);
	 if($(Asset).length==0)
	 {
		 document.getElementById("datatable").disabled=true;
		 document.getElementById("cnt").style.display="none";
	 }
	 Index_div_show();
}

//Load AssetType from database
$(document).ready(function(){
	$("#search-box2").keyup(function(){
		var type="assettype2";
        // ocument.getElementById("assettype").style.display="none";
		$.ajax({
		type: "POST",
		url: "common.php",
		data:'keyword='+$(this).val()+"&Type="+type,
		beforeSend: function(){
		},
		success: function(data){
			$("#suggesstion-box2").show();
			$("#suggesstion-box2").html(data);
			$("#search-box2").css("background","#FFF");
		}
		});
	});

});

function selectAssetType2(val) {

$("#search-box2").val(val);
$("#suggesstion-box2").hide();

}

function Check_Model()
	{
		if(document.getElementById("txt_Model").value!="Unknown")
		{
			document.getElementById("txt_Model").style.borderColor="lightgrey";
			//alert(document.getElementById("modal_close"));
			//document.getElementById("modal_close").style.display="block";
		}
		else
		{
			document.getElementById("txt_Model").style.borderColor="red";
			// document.getElementById("modal_close").style.display="none";
		}

	}

/////////////

//Reset Values entered in Textbox
function func_reset()
{
  document.getElementById("txt_Vendor").value="";
  document.getElementById("datepicker").value="";
  document.getElementById("txt_StatementOfWork").value="";
  document.getElementById("txt_NumberOfPallets").value="";
  document.getElementById("txt_PickupLocation").value="";
  document.getElementById("txt_LocalRIMContact").value="";
  document.getElementById("search-box").value="";
  document.getElementById("txt_Description").value="";
  document.getElementById("txt_Weight").value="";
  document.getElementById("txt_WO").value="";

}

//Insert record to database
$(document).ready(function(){
$("#btnsubmit").click(function(){

var Vendor = $("#txt_Vendor").val();
var DateSubmitted = $("#datepicker").val();
var StatementOfWork = $("#txt_StatementOfWork").val();
var NumberOfPallets = $("#txt_NumberOfPallets").val();
var PickUpLocation = $("#txt_PickupLocation").val();
var LocalRIMContact = $("#txt_LocalRIMContact").val();
var AssetType = $("#search-box").val();
var Description = $("#txt_Description").val();
var Weight = $("#txt_Weight").val();
var WO = $("#txt_WO").val();
if (Vendor == '' || DateSubmitted == '' || StatementOfWork == ''|| NumberOfPallets == ''|| PickUpLocation == ''|| LocalRIMContact == ''|| AssetType == ''|| Weight == '') {
//alert("Please Fill Required Fields");
if(Vendor=='')
 {
        document.getElementById("txt_Vendor").title="Please Enter Vendor";
        $('[data-toggle="tooltip1"]').tooltip();
		document.getElementById("txt_Vendor").style.border="1px solid red";

 }
 if(DateSubmitted=='')
 {
        document.getElementById("datepicker").title="Please Select Any Date";
        $('[data-toggle="tooltip2"]').tooltip();
		document.getElementById("datepicker").style.border="1px solid red";

 }
 if(StatementOfWork=='')
 {
        document.getElementById("txt_StatementOfWork").title="Please Enter StatementOfWork";
        $('[data-toggle="tooltip3"]').tooltip();
		document.getElementById("txt_StatementOfWork").style.border="1px solid red";

 }
 if(NumberOfPallets=='')
 {
        document.getElementById("txt_NumberOfPallets").title="Please Enter Number Of Pallets";
        $('[data-toggle="tooltip4"]').tooltip();
		document.getElementById("txt_NumberOfPallets").style.border="1px solid red";

 }
 if(PickUpLocation=='')
 {
        document.getElementById("txt_PickupLocation").title="Please Enter PickUp Location";
        $('[data-toggle="tooltip5"]').tooltip();
		document.getElementById("txt_PickupLocation").style.border="1px solid red";

 }
 if(LocalRIMContact=='')
 {
        document.getElementById("txt_LocalRIMContact").title="Please Enter LocalRIM Contact Detail";
        $('[data-toggle="tooltip6"]').tooltip();
		document.getElementById("txt_LocalRIMContact").style.border="1px solid red";

 }
 if(AssetType=='')
 {
        document.getElementById("search-box").title="Please Select AssetType";
        $('[data-toggle="tooltip6"]').tooltip();
		document.getElementById("search-box").style.border="1px solid red";

 }
  if(Weight=='')
 {
        document.getElementById("txt_Weight").title="Please Enter Weight";
        $('[data-toggle="tooltip6"]').tooltip();
		document.getElementById("txt_Weight").style.border="1px solid red";

 }
event.preventDefault();
}
else{
$.post("Add_BulkAssets.php", //Required URL of the page on server
{ // Data Sending With Request To Server
txt_Vendor:Vendor,
txt_DateSubmitted:DateSubmitted,
txt_StatementOfWork:StatementOfWork,
txt_NumberOfPallets:NumberOfPallets,
txt_PickupLocation:PickUpLocation,
txt_LocalRIMContact:LocalRIMContact,
txt_AssetType:AssetType,
txt_Description:Description,
txt_Weight:Weight,
txt_WO:WO,
},
function(response,status){ // Required Callback Function
$("#form")[0].reset();
location.reload();
});
}
});
});


//Load AssetType from database
$(document).ready(function(){
	$("#search-box").keyup(function(){
		var type="assettype";
	   	document.getElementById("assettype").style.display="none";
		$.ajax({
		type: "POST",
		url: "common.php",
		data:'keyword='+$(this).val()+"&Type="+type,
		beforeSend: function(){
		},
		success: function(data){
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
			$("#search-box").css("background","#FFF");
		}
		});
	});

});


function selectAssetType(val) {

$("#search-box").val(val);
$("#suggesstion-box").hide();

}

$(document).ready(function(){
	$("#Manufactsearch-box").keyup(function(){
	var type="manufacturer";
	var AssetType_val=document.getElementById("search-box").value;
		$.ajax({
		type: "POST",
		url: "common.php",
		data:'keyword='+$(this).val()+"&Type="+type,
		beforeSend: function(){
		},
		success: function(data){
			$("#Manufact_suggesstion-box").show();
			$("#Manufact_suggesstion-box").html(data);
			$("#Manufactsearch-box").css("background","#FFF");
		}
		});
	});
});

function selectManufacturer(val) {

$("#Manufactsearch-box").val(val);
$("#Manufact_suggesstion-box").hide();

}

$(document).ready(function(){
	$("#txt_Model").keyup(function(){
	var type="model";
	var Manufacturer=document.getElementById("Manufactsearch-box").value;
		$.ajax({
		type: "POST",
		url: "common.php",
		data:'keyword='+$(this).val()+"&Type="+type,
		beforeSend: function(){
		},
		success: function(data){
			$("#Model_suggesstion-box").show();
			$("#Model_suggesstion-box").html(data);
			$("#txt_Model").css("background","#FFF");
		}
		});
	});
});

function selectModel(val) {

$("#txt_Model").val(val);
$("#Model_suggesstion-box").hide();

}
function SetWhite(id)
{
      document.getElementById(id).style.border="1px solid lightgray";
	  if(id=="txt_Vendor")
	  {
	        $('[data-toggle="tooltip1"]').tooltip('destroy');
	  }
	  else if(id=="datepicker")
	  {
	        $('[data-toggle="tooltip2"]').tooltip('destroy');
	  }
	  else if(id=="txt_StatementOfWork")
	  {
	        $('[data-toggle="tooltip3"]').tooltip('destroy');
	  }
	  else if(id=="txt_NumberOfPallets")
	  {
	        $('[data-toggle="tooltip4"]').tooltip('destroy');
	  }
	  else if(id=="txt_PickupLocation")
	  {
	        $('[data-toggle="tooltip5"]').tooltip('destroy');
	  }
	  else if(id=="txt_LocalRIMContact")
	  {
	        $('[data-toggle="tooltip6"]').tooltip('destroy');
	  }
	  else if(id=="search-box")
	  {
	        $('[data-toggle="tooltip7"]').tooltip('destroy');
	  }
	   else if(id=="txt_Weight")
	  {
	        $('[data-toggle="tooltip8"]').tooltip('destroy');
	  }

}

$(document).ready( function () {
    $('#tableid').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    });
} );

function div_show(id) {
       	//	alert(id);
		//document.getElementById('txt_ID').value=id;
		var type1="View";
	     $.ajax({
            type: "POST",
            url: "common.php",
            data: "id="+id+"&Type="+type1,
            success: function (data) {
			  //alert(data);
               var default_data = eval('(' + data + ')');
			    // var default_data=JSON.parse(data);
				// alert(default_data[0].ID);

				//document.getElementById('div_popup').style.display = "block";
				document.getElementById("ID1").value=default_data[0].ID;
                document.getElementById("txt_Vendor1").value=default_data[0].Vendor;
				//var dt=default_data[0].Date_Submitted["date"];
				 //document.getElementById("datepicker1").value=dt.substr(0,10);
				document.getElementById("datepicker1").value=default_data[0].Date_Submitted;
				document.getElementById("txt_StatementOfWork1").value=default_data[0].StatementOfWork;
				document.getElementById("txt_NumberOfPallets1").value=default_data[0].NumberOfPallets;
				document.getElementById("txt_PickupLocation1").value=default_data[0].PickUpLocation;
				document.getElementById("txt_LocalRIMContact1").value=default_data[0].LocalRIMContact;
				document.getElementById("search-box1").value=default_data[0].Asset_Type;
				document.getElementById("Manufactsearch-box1").value=default_data[0].Manufacturer;
				document.getElementById("txt_Model1").value=default_data[0].Model;
				document.getElementById("txt_AssetID1").value=default_data[0].Asset_ID;
				document.getElementById("txt_SerialNo1").value=default_data[0].Serial_No;
				document.getElementById("txt_WO1").value=default_data[0].LoadID;
				document.getElementById("txt_Description1").value=default_data[0].Description;
                document.getElementById("txt_Weight1").value=default_data[0].Weight;
            }
        });
		}

    function GOBack()
    {
      window.history.go(-2);
    }

    function del_single_confirm(v)
    {

	    sessionStorage.ID=v;
	      $("#del_confirm").show();
	    $("#DelModal").modal('show');
    }

    function del_single()
    {
    	    var v;
			var type="DelSingle";
    	    v=sessionStorage.ID;
    		$.ajax({
    		type: "POST",
    		url: "common.php",
    		data:'id='+v+"&Type="+type,
    		success: function(data){
    			window.location.reload(true);
    		}
    		});
    }

    function del_multiple_Confirm()
{
	// $("#Multidel_confirm").show();
	$("#MultipleDelModal").modal('show');
}

function del_multiple()
{

   var selchb = getSelectedChbox();     // gets the array returned by getSelectedChbox()
   var type="DelMultiple";
   $.ajax({
   type: "POST",
   url: "common.php",
   data:'checked_id='+selchb+"&Type="+type,
   success: function(data){
     window.location.reload(true);
   }
   });

}
// Returns an array with values of the selected (checked) checkboxes in "frm"
 function getSelectedChbox() {
 // JavaScript & jQuery Course - http://coursesweb.net/javascript/
  var selchbox = [];        // array that will store the value of selected checkboxes

  // gets all the input tags in frm, and their number

 // var inpfields = frm.getElementsByTagName('input');
   var inpfields = document.getElementsByTagName('input');
  var nr_inpfields = inpfields.length;

  // traverse the inpfields elements, and adds the value of selected (checked) checkbox in selchbox
  for(var i=0; i<nr_inpfields; i++) {

    if(inpfields[i].type == 'checkbox' && inpfields[i].checked == true) selchbox.push(inpfields[i].value);
  }

  return selchbox;
}

function senddata()
{
	 var type="Search_EditMultiple";
	 var selchb = getSelectedChbox(this.form);
	 window.location="common.php?Type="+type+"&chb=" + selchb;
}
function senddata_bulk()
{
	 var type="Search_EditMultiple_bulk";
	 var selchb = getSelectedChbox(this.form);
	 window.location="common.php?Type="+type+"&chb=" + selchb;
}

function rpt_senddata()
{
	 var type="Indi_EditMultiple";
	 var selchb = getSelectedChbox(this.form);
	 window.location="common.php?Type="+type+"&chb=" + selchb;
}
function rpt_senddata_bulk()
{
	 var type="Indi_EditMultiple_bulk";
	 var selchb = getSelectedChbox(this.form);
	 window.location="common.php?Type="+type+"&chb=" + selchb;
}
function validate()
{
  var AssetType=document.getElementById("search-box").value;
  var Manufacturer=document.getElementById("Manufactsearch-box").value;
  var Model=document.getElementById("txt_Model").value;
  var AssetID=document.getElementById("txt_AssetID").value;
  var SerialNo=document.getElementById("txt_SerialNo").value;
	  if(AssetType=="" && Manufacturer=="" && Model=="" && AssetID=="" && SerialNo=="")
	  {
	    alert("Please fill atleast one field");
	  }
}

 function viewdata()
{
	 var type="Search_MultiView";
	var selchb = getSelectedChbox(this.form);
	 window.location="common.php?Type="+type+"&chb=" + selchb;
}
function viewdata_Indi()
{
	var type="Indi_MultiView";
	var selchb = getSelectedChbox(this.form);
	 window.location="common.php?Type="+type+"&chb=" + selchb;
}
var checkbox_count=0;
function set_display()
{
	//checkbox_count++;
	getSelected();
	if(checkbox_count>=2)
	{
  //document.getElementById("submit_mult").style.display="inline";
  document.getElementById("submit_mult_bulk").style.display="inline";
  document.getElementById("del").style.display="inline";
	}
	else
	{
		document.getElementById("submit_mult_bulk").style.display="none";
        document.getElementById("del").style.display="none";
	}
 // document.getElementById("view_mult").style.display="inline";
   //document.getElementById("submit_mult1").style.display="inline";
  //document.getElementById("del1").style.display="inline";
}

function getSelected() {
 // JavaScript & jQuery Course - http://coursesweb.net/javascript/
  var selchbox = [];        // array that will store the value of selected checkboxes
  checkbox_count=0;
  // gets all the input tags in frm, and their number

 // var inpfields = frm.getElementsByTagName('input');
   var inpfields = document.getElementsByTagName('input');
  var nr_inpfields = inpfields.length;

  // traverse the inpfields elements, and adds the value of selected (checked) checkbox in selchbox
  for(var i=0; i<nr_inpfields; i++) {

    if(inpfields[i].type == 'checkbox' && inpfields[i].checked == true)
	{
		checkbox_count++;
	}
  }

  //return selchbox;
}


//////////


$(document).ready(function(){
	$("#txt_Vendor").keyup(function(){
		var type="vendor";
		$.ajax({
		type: "POST",
		url: "common.php",
		data:'keyword='+$(this).val()+"&Type="+type,
		beforeSend: function(){
		},
		success: function(data){
			if(data=="")
			{
				checkvendor=0;
			}
			else
			{
				checkvendor=1;
			}
			$("#VendorList").show();
			$("#VendorList").html(data);
			$("#txt_Vendor").css("background","#FFF");
		}
		});
	});

});


function selectVendor(val) {

$("#txt_Vendor").val(val);
$("#VendorList").hide();

}

$(document).ready(function(){
	$("#txt_PickupLocation").keyup(function(){
		var type="location";
		$.ajax({
		type: "POST",
		url: "common.php",
		data:'keyword='+$(this).val()+"&Type="+type,
		beforeSend: function(){
		},
		success: function(data){
			$("#LocationList").show();
			$("#LocationList").html(data);
			$("#txt_PickupLocation").css("background","#FFF");
		}
		});
	});

});


function selectLocation(val) {

$("#txt_PickupLocation").val(val);
$("#LocationList").hide();

}

$(document).ready(function(){
	$("#txt_Vendor1").keyup(function(){
		var type="vendor1";
		$.ajax({
		type: "POST",
		url: "common.php",
		data:'keyword='+$(this).val()+"&Type="+type,
		beforeSend: function(){
		},
		success: function(data){
			$("#VendorList1").show();
			$("#VendorList1").html(data);
			$("#txt_Vendor1").css("background","#FFF");
		}
		});
	});

});


function selectVendor1(val) {

$("#txt_Vendor1").val(val);
$("#VendorList1").hide();

}

$(document).ready(function(){
	$("#txt_PickupLocation1").keyup(function(){
		var type="location1";
		$.ajax({
		type: "POST",
		url: "common.php",
		data:'keyword='+$(this).val()+"&Type="+type,
		beforeSend: function(){
		},
		success: function(data){
			$("#LocationList1").show();
			$("#LocationList1").html(data);
			$("#txt_PickupLocation1").css("background","#FFF");
		}
		});
	});

});


function selectLocation1(val) {

$("#txt_PickupLocation1").val(val);
$("#LocationList1").hide();

}

$(document).ready(function(){
	$("#search-box1").keyup(function(){
		var type="assettype1";
	   	  document.getElementById("assettype").style.display="none";
		$.ajax({
		type: "POST",
		url: "common.php",
		data:'keyword='+$(this).val()+"&Type="+type,
		beforeSend: function(){
		},
		success: function(data){
			$("#suggesstion-box1").show();
			$("#suggesstion-box1").html(data);
			$("#search-box1").css("background","#FFF");
		}
		});
	});

});

function selectAssetType1(val) {

$("#search-box1").val(val);
$("#suggesstion-box1").hide();

}

$(document).ready(function(){
	$("#Manufactsearch-box1").keyup(function(){
		var type="manufacturer1";
	var AssetType_val=document.getElementById("search-box1").value;
		$.ajax({
		type: "POST",
		url: "common.php",
		data:'keyword='+$(this).val()+"&Type="+type,
		beforeSend: function(){
		},
		success: function(data){
			$("#Manufact_suggesstion-box1").show();
			$("#Manufact_suggesstion-box1").html(data);
			$("#Manufactsearch-box1").css("background","#FFF");
		}
		});
	});
});

function selectManufacturer1(val) {

$("#Manufactsearch-box1").val(val);
$("#Manufact_suggesstion-box1").hide();

}

$(document).ready(function(){
	$("#txt_Model1").keyup(function(){
	var type="model1";
	var Manufacturer=document.getElementById("Manufactsearch-box1").value;
		$.ajax({
		type: "POST",
		url: "common.php",
		data:'keyword='+$(this).val()+"&Type="+type,
		beforeSend: function(){
		},
		success: function(data){
			$("#Model_suggesstion-box1").show();
			$("#Model_suggesstion-box1").html(data);
			$("#txt_Model1").css("background","#FFF");
		}
		});
	});
});

function selectModel1(val) {

$("#txt_Model1").val(val);
$("#Model_suggesstion-box1").hide();

}

$(document).ready(function(){
	$("#s_txt_Vendor").keyup(function(){
		var type="vendor2";
		$.ajax({
		type: "POST",
		url: "common.php",
		data:'keyword='+$(this).val()+"&Type="+type,
		beforeSend: function(){
		},
		success: function(data){

			$("#s_VendorList").show();
			$("#s_VendorList").html(data);
			$("#s_txt_Vendor").css("background","#FFF");
		}
		});
	});

});


function selectVendor2(val) {

$("#s_txt_Vendor").val(val);
$("#s_VendorList").hide();

}

$(document).ready(function(){
	$("#s_txt_PickupLocation").keyup(function(){
		var type="location2";
		$.ajax({
		type: "POST",
		url: "common.php",
		data:'keyword='+$(this).val()+"&Type="+type,
		beforeSend: function(){
		},
		success: function(data){
			$("#s_LocationList").show();
			$("#s_LocationList").html(data);
			$("#s_txt_PickupLocation").css("background","#FFF");
		}
		});
	});

});


function selectLocation2(val) {

$("#s_txt_PickupLocation").val(val);
$("#s_LocationList").hide();

}
///////////////////////////////

function div_change()
   {
	   document.getElementById("update").style.display="block";
	   document.getElementById("change").style.display="none";
	    document.getElementById("txt_Vendor1").readOnly=false;
		//var dt=default_data[0].Date_Submitted["date"];
		// document.getElementById("datepicker1").value=dt.substr(0,10);
		document.getElementById("datepicker1").readOnly=false;
		document.getElementById("txt_StatementOfWork1").readOnly=false;
		document.getElementById("txt_NumberOfPallets1").readOnly=false;
		document.getElementById("txt_PickupLocation1").readOnly=false;
		document.getElementById("txt_LocalRIMContact1").readOnly=false;
		document.getElementById("search-box1").readOnly=false;
		if(document.getElementById("Manufactsearch-box1").value=="N/A")
		{
			document.getElementById("Manufactsearch-box1").readOnly=true;
		    document.getElementById("txt_Model1").readOnly=true;
		    document.getElementById("txt_AssetID1").readOnly=true;
		    document.getElementById("txt_SerialNo1").readOnly=true;
		    document.getElementById("txt_Description1").readOnly=false;
            document.getElementById("txt_Weight1").readOnly=false;
		}
		else
		{
			document.getElementById("Manufactsearch-box1").readOnly=false;
		    document.getElementById("txt_Model1").readOnly=false;
		    document.getElementById("txt_AssetID1").readOnly=false;
		    document.getElementById("txt_SerialNo1").readOnly=false;
		    document.getElementById("txt_Description1").readOnly=true;
            document.getElementById("txt_Weight1").readOnly=true;
		}
		document.getElementById("txt_WO1").readOnly=false;

		document.getElementById("txt_Vendor1").focus();
   }
function div_update()
{
var ID=	$("#ID1").val();
var Vendor = $("#txt_Vendor1").val();
var DateSubmitted = $("#datepicker1").val();
var StatementOfWork = $("#txt_StatementOfWork1").val();
var NumberOfPallets = $("#txt_NumberOfPallets1").val();
var PickUpLocation = $("#txt_PickupLocation1").val();
var LocalRIMContact = $("#txt_LocalRIMContact1").val();
var AssetType = $("#search-box1").val();
var Description = $("#txt_Description1").val();
var Weight = $("#txt_Weight1").val();
var WO = $("#txt_WO1").val();
var AssetID = $("#txt_AssetID1").val();
var Manufacturer = $("#Manufactsearch-box1").val();
var Model = $("#txt_Model1").val();
var SerialNo = $("#txt_SerialNo1").val();

if (Vendor == '' || DateSubmitted == '' || NumberOfPallets == ''|| PickUpLocation == ''|| LocalRIMContact == ''|| AssetType == ''|| Weight == '') {
//alert("Please Fill Required Fields");
if(Vendor=='')
 {
        document.getElementById("txt_Vendor1").title="Please Enter Vendor";
        $('[data-toggle="tooltip1"]').tooltip();
		document.getElementById("txt_Vendor1").style.border="1px solid red";

 }
 if(DateSubmitted=='')
 {
        document.getElementById("datepicker1").title="Please Select Any Date";
        $('[data-toggle="tooltip2"]').tooltip();
		document.getElementById("datepicker1").style.border="1px solid red";

 }

 if(NumberOfPallets=='')
 {
        document.getElementById("txt_NumberOfPallets1").title="Please Enter Number Of Pallets";
        $('[data-toggle="tooltip4"]').tooltip();
		document.getElementById("txt_NumberOfPallets1").style.border="1px solid red";

 }
 if(PickUpLocation=='')
 {
        document.getElementById("txt_PickupLocation1").title="Please Enter PickUp Location";
        $('[data-toggle="tooltip5"]').tooltip();
		document.getElementById("txt_PickupLocation1").style.border="1px solid red";

 }
 if(LocalRIMContact=='')
 {
        document.getElementById("txt_LocalRIMContact1").title="Please Enter LocalRIM Contact Detail";
        $('[data-toggle="tooltip6"]').tooltip();
		document.getElementById("txt_LocalRIMContact1").style.border="1px solid red";

 }
 if(AssetType=='')
 {
        document.getElementById("search-box1").title="Please Select AssetType";
        $('[data-toggle="tooltip6"]').tooltip();
		document.getElementById("search-box1").style.border="1px solid red";

 }
  if(Weight=='')
 {
        document.getElementById("txt_Weight1").title="Please Enter Weight";
        $('[data-toggle="tooltip6"]').tooltip();
		document.getElementById("txt_Weight1").style.border="1px solid red";

 }
event.preventDefault();
}
else{
var type1="editassets";
$.post("common.php", //Required URL of the page on server
{ // Data Sending With Request To Server
Type:type1,
txt_ID:ID,
txt_Vendor:Vendor,
txt_DateSubmitted:DateSubmitted,
txt_StatementOfWork:StatementOfWork,
txt_NumberOfPallets:NumberOfPallets,
txt_PickupLocation:PickUpLocation,
txt_LocalRIMContact:LocalRIMContact,
txt_AssetType:AssetType,
txt_AssetID:AssetID,
txt_Manufacturer:Manufacturer,
txt_Model:Model,
txt_SerialNo:SerialNo,
txt_Description:Description,
txt_Weight:Weight,
txt_WO:WO,
},
function(response,status){ // Required Callback Function
document.getElementById("update").style.display="none";
document.getElementById("change").style.display="block";
document.getElementById("txt_Vendor1").readOnly=true;
document.getElementById("datepicker1").readOnly=true;
document.getElementById("txt_StatementOfWork1").readOnly=true;
document.getElementById("txt_NumberOfPallets1").readOnly=true;
document.getElementById("txt_PickupLocation1").readOnly=true;
document.getElementById("txt_LocalRIMContact1").readOnly=true;
document.getElementById("search-box1").readOnly=true;
document.getElementById("Manufactsearch-box1").readOnly=true;
document.getElementById("txt_Model1").readOnly=true;
document.getElementById("txt_AssetID1").readOnly=true;
document.getElementById("txt_SerialNo1").readOnly=true;
document.getElementById("txt_WO1").readOnly=true;
document.getElementById("txt_Description1").readOnly=true;
document.getElementById("txt_Weight1").readOnly=true;

//$("#form")[0].reset();
});
}
}

// js for Search.php
function loaddata()
{

  ShowSelection();

}
var query;
function Search_CreateTable()
{

  var type="search";
   
  vendor="";
  assettype="";
  manufacturer="";
  model="";
  assetid="";
  serialno="";
  wo="";
  var selection=document.getElementById("searchby").value;
  if(selection=="Vendor")
  {
    vendor=document.getElementById("txt_Vendor").value;
    query=" Vendor='"+vendor+"'";

  }
  else if(selection=="Asset Type")
  {
    assettype=document.getElementById("search-box").value;
    query=" Asset_Type='"+assettype+"'";

  }
  else if(selection=="Manufacturer")
  {
    manufacturer=document.getElementById("Manufactsearch-box").value;
    query=" Manufacturer='"+manufacturer+"'";

  }
  else if(selection=="Model")
  {
    model=document.getElementById("txt_Model").value;
    query=" Model='"+model+"'";

  }
  else if(selection=="Asset ID")
  {

    assetid=document.getElementById("txt_AssetID").value;
    query=" Asset_ID='"+assetid+"'";


  }
  else if(selection=="Serial#")
  {
    serialno=document.getElementById("txt_SerialNo").value;
    query=" Serial_No LIKE '"+serialno+"'";


  }
  else if(selection=="WO#")
  {
    wo=document.getElementById("txt_WO").value;
    query=" LoadID LIKE '"+wo+"'";

  }


 window.location="common.php?Type="+type+"&query=" + query+"&vendor="+vendor+"&assettype="+assettype+"&manufacturer="+manufacturer+"&model="+model+"&assetid="+assetid
                           +"&serialno="+serialno+"&wo="+wo+"&searchby="+selection;
}
function ShowSelection()
{

  HideAll();
  var selection=document.getElementById("searchby").value;
  if(selection == "Vendor")
  {
     document.getElementById("Vendor").style.display="inline";
	 document.getElementById("filter").style.display="none";


  }
  if(selection == "Asset Type")
  {
     document.getElementById("AssetType").style.display="inline";
	 document.getElementById("filter").style.display="none";
  }
  if(selection == "Manufacturer")
  {
     document.getElementById("Manufacturer").style.display="inline";
	 document.getElementById("filter").style.display="none";
  }
  if(selection == "Model")
  {
     document.getElementById("Model").style.display="inline";
	 document.getElementById("filter").style.display="none";
  }
  if(selection == "Asset ID")
  {
     document.getElementById("AssetID").style.display="inline";
	 document.getElementById("filter").style.display="none";
  }
  if(selection == "Serial#")
  {
     document.getElementById("SerialNo").style.display="inline";
	 document.getElementById("filter").style.display="none";
  }
  if(selection == "WO#")
  {
     document.getElementById("WO").style.display="inline";
	 document.getElementById("filter").style.display="inline";
  }
}


 function div_hide() {
location.reload();
//document.getElementById('div_popup').style.display = "none";
}

var vendor,AssetType,Manufacturer,Model,AssetID,SerialNo,WO;

function HideAll()
	{
		document.getElementById("Vendor").style.display="none";
		document.getElementById("AssetType").style.display="none";
		document.getElementById("Manufacturer").style.display="none";
		document.getElementById("Model").style.display="none";
		document.getElementById("AssetID").style.display="none";
		document.getElementById("SerialNo").style.display="none";
		document.getElementById("WO").style.display="none";
		//document.getElementById("btn_search").style.display="none";

	}


	function senddata_bulk_adv_WO()
{

        vendor=document.getElementById("txt_Vendor").value;
		assettype=document.getElementById("search-box").value;
		manufacturer=document.getElementById("Manufactsearch-box").value;
		model=document.getElementById("txt_Model").value;
		assetid=document.getElementById("txt_AssetID").value;
		serialno=document.getElementById("txt_SerialNo").value;
		wo=document.getElementById("txt_WO").value;
     var selection=document.getElementById("searchby").value;
	 var type="Search_MultiUpdate_Bulk_adv_WO";
	 var Vendor1=document.getElementById("s_txt_Vendor").value;
	 var Date_Submitted1=document.getElementById("s_datepicker").value;
	 var sow1=document.getElementById("s_txt_StatementOfWork").value;
	 var pallets1=document.getElementById("s_txt_NumberOfPallets").value;
	 var WO1=document.getElementById("s_txt_WO").value;
	 var Plocation1=document.getElementById("s_txt_PickupLocation").value;
	 var contact1=document.getElementById("s_txt_LocalRIMContact").value;
	// var selchb = getSelectedChbox(this.form);
	 window.location="common.php?Type="+type+"&Vendor="+Vendor1+"&Date_Submitted="+Date_Submitted1+"&sow="+sow1+"&pallets="+pallets1+"&wo="+WO1+"&Plocation="+Plocation1+"&contact="+contact1
	                 +"&vendor1="+vendor+"&assettype1="+AssetType+"&manufacturer1="+Manufacturer+"&model1="+Model+"&assetid1="+AssetID
		                         +"&serialno1="+SerialNo+"&wo1="+wo+"&searchby1="+selection+"&query=" + query;
}

  function senddata_bulk_adv_Vendor()
{

        vendor=document.getElementById("txt_Vendor").value;
		assettype=document.getElementById("search-box").value;
		manufacturer=document.getElementById("Manufactsearch-box").value;
		model=document.getElementById("txt_Model").value;
		assetid=document.getElementById("txt_AssetID").value;
		serialno=document.getElementById("txt_SerialNo").value;
		wo=document.getElementById("txt_WO").value;
     var selection=document.getElementById("searchby").value;
	 var type="Search_MultiUpdate_Bulk_adv_Vendor";
	 var PrimaryVendor=document.getElementById("s_txt_PrimaryVendor").value;
	var SecondaryVendor=document.getElementById("s_txt_SecondaryVendor").value;
	var VendorLocation=document.getElementById("s_txt_Location").value;
	var ApprovalStatus=document.getElementById("s_txt_ApprovalStatus").value;
	var Resale=document.getElementById("s_txt_Resale").value;
	var Recycling=document.getElementById("s_txt_Recycling").value;
	var RecyclingType=document.getElementById("s_txt_RecyclingType").value;
	var DeviceDestruction=document.getElementById("s_txt_DeviceDestruction").value;
	var HDWiping=document.getElementById("s_txt_HDWiping").value;
	var VendorSecurity=document.getElementById("s_txt_VendorSecurity").value;
	var Environment=document.getElementById("s_txt_Environment").value;
	var Contract=document.getElementById("s_txt_Contract").value;
	var PickupProcess=document.getElementById("s_txt_PickupProcess").value;
	var Notes=document.getElementById("s_txt_Notes").value;
	// var location1=document.getElementById("s_txt_Location").value;
	// var selchb = getSelectedChbox(this.form);
	 window.location="common.php?Type="+type+"&PrimaryVendor="+PrimaryVendor+"&SecondaryVendor="+SecondaryVendor+"&VendorLocation="+VendorLocation+"&ApprovalStatus="+ApprovalStatus
	     +"&Resale="+Resale+"&Recycling="+Recycling+"&RecyclingType="+RecyclingType+"&DeviceDestruction="+DeviceDestruction+"&HDWiping="+HDWiping+"&VendorSecurity="+VendorSecurity
		 +"&Environment="+Environment+"&Contract="+Contract+"&PickupProcess="+PickupProcess+"&Notes="+Notes
	                 +"&vendor1="+vendor+"&assettype1="+AssetType+"&manufacturer1="+Manufacturer+"&model1="+Model+"&assetid1="+AssetID
		                         +"&serialno1="+SerialNo+"&wo1="+wo+"&searchby1="+selection+"&query=" + query;
}

function AddNewVendor()
{
	var type="AddNewVendor";
	var PrimaryVendor=document.getElementById("txt_PrimaryVendor").value;
	var SecondaryVendor=document.getElementById("txt_SecondaryVendor").value;
	var VendorLocation=document.getElementById("txt_Location").value;
	var ApprovalStatus=document.getElementById("txt_ApprovalStatus").value;
	var Resale=document.getElementById("txt_Resale").value;
	var Recycling=document.getElementById("txt_Recycling").value;
	var RecyclingType=document.getElementById("txt_RecyclingType").value;
	var DeviceDestruction=document.getElementById("txt_DeviceDestruction").value;
	var HDWiping=document.getElementById("txt_HDWiping").value;
	var VendorSecurity=document.getElementById("txt_VendorSecurity").value;
	var Environment=document.getElementById("txt_Environment").value;
	var Contract=document.getElementById("txt_Contract").value;
	var PickupProcess=document.getElementById("txt_PickupProcess").value;
	var Notes=document.getElementById("txt_Notes").value;

	var s_Vendor=document.getElementById("txt_Vendor").value;
	window.location="common.php?Type="+type+"&PrimaryVendor="+PrimaryVendor+"&SecondaryVendor="+SecondaryVendor+"&VendorLocation="+VendorLocation+"&ApprovalStatus="+ApprovalStatus
	     +"&Resale="+Resale+"&Recycling="+Recycling+"&RecyclingType="+RecyclingType+"&DeviceDestruction="+DeviceDestruction+"&HDWiping="+HDWiping+"&VendorSecurity="+VendorSecurity
		 +"&Environment="+Environment+"&Contract="+Contract+"&PickupProcess="+PickupProcess+"&Notes="+Notes+"&s_Vendor="+s_Vendor;
}

function ReadonlyFalse()
{
	document.getElementById("s_txt_Vendor").readOnly=false;
	document.getElementById("s_datepicker").readOnly=false;
	document.getElementById("s_txt_StatementOfWork").readOnly=false;
	document.getElementById("s_txt_NumberOfPallets").readOnly=false;
	document.getElementById("s_txt_WO").readOnly=false;
	document.getElementById("s_txt_PickupLocation").readOnly=false;
	document.getElementById("s_txt_LocalRIMContact").readOnly=false;
	document.getElementById("btnedit").style.display="none";
	document.getElementById("btnsubmit").style.display="block";
}

function ReadonlyFalse_Vendor()
{
	document.getElementById("s_txt_PrimaryVendor").readOnly=false;
	document.getElementById("s_txt_SecondaryVendor").readOnly=false;
	document.getElementById("s_txt_Location").readOnly=false;
	document.getElementById("s_txt_ApprovalStatus").readOnly=false;
	document.getElementById("s_txt_Resale").readOnly=false;
	document.getElementById("s_txt_Recycling").readOnly=false;
	document.getElementById("s_txt_RecyclingType").readOnly=false;
	document.getElementById("s_txt_DeviceDestruction").readOnly=false;
	document.getElementById("s_txt_HDWiping").readOnly=false;
	document.getElementById("s_txt_VendorSecurity").readOnly=false;
	document.getElementById("s_txt_Environment").readOnly=false;
	document.getElementById("s_txt_Contract").readOnly=false;
	document.getElementById("s_txt_PickupProcess").readOnly=false;
	document.getElementById("s_txt_Notes").readOnly=false;
	document.getElementById("btnedit_vendor").style.display="none";
	document.getElementById("btnsubmit_vendor").style.display="block";
}

function updatedata_bulk(ch)
{
     // alert(ch);
	 var type="Search_MultiUpdate_Bulk";
	 var Vendor1=document.getElementById("txt_Vendor").value;
	 var Date_Submitted1=document.getElementById("datepicker").value;
	 var sow1=document.getElementById("txt_StatementOfWork").value;
	 var pallets1=document.getElementById("txt_NumberOfPallets").value;
	 var WO1=document.getElementById("txt_WO").value;
	 var Plocation1=document.getElementById("txt_PickupLocation").value;
	 var contact1=document.getElementById("txt_LocalRIMContact").value;
	// var location1=document.getElementById("s_txt_Location").value;
	// var selchb = getSelectedChbox(this.form);
	 window.location="common.php?Type="+type+"&Vendor="+Vendor1+"&Date_Submitted="+Date_Submitted1+"&sow="+sow1+"&pallets="+pallets1+"&wo="+WO1+"&Plocation="+Plocation1+"&contact="+contact1+"&ch="+ch;
}

function infoModal(SearchType)
{

	if(SearchType=="vendor")
	{

		var instruction="Vendor";
		$("#search_inst").html(instruction);
	}
	else if(SearchType=="loadID")
	{
    // Header
    var header = "ADTF LOAD ID";
    // Title
    var title = "What is an ADTF Load ID #:";
    // Body
		var body = "";
    body += "<ul>";
      body += "<li><p>To properly track and audit asset removal requests, each workflow is assigned a Load ID (JIRA Ticket WO-#).</p></li>";
      body += "<li><p>You can search an asset removal request by this load ID # and make changes if required.</p></li>";
      body += "<li><p>It's possible to add additional assets to a load as well.</p></li>";
    body += "</ul>";
    // Push to HTML
		$("#search_inst_header").html(header);
		$("#search_inst_title").html(title);
		$("#search_inst_body").html(body);
	}
}
function Search_CreateTable_Filter()
{

  var type="search_filter";
   /*	vendor=document.getElementById("txt_Vendor").value;
  assettype=document.getElementById("search-box").value;
  manufacturer=document.getElementById("Manufactsearch-box").value;
  model=document.getElementById("txt_Model").value;
  assetid=document.getElementById("txt_AssetID").value;
  serialno=document.getElementById("txt_SerialNo").value;
  wo=document.getElementById("txt_WO").value; */
  vendor="";
  assettype="";
  manufacturer="";
  model="";
  assetid="";
  serialno="";
  wo="";
  var selection=document.getElementById("searchby").value;
  if(selection=="Vendor")
  {
    vendor=document.getElementById("txt_Vendor").value;

  }
  else if(selection=="Asset Type")
  {
    assettype=document.getElementById("search-box").value;

  }
  else if(selection=="Manufacturer")
  {
    manufacturer=document.getElementById("Manufactsearch-box").value;

  }
  else if(selection=="Model")
  {
    model=document.getElementById("txt_Model").value;

  }
  else if(selection=="Asset ID")
  {

    assetid=document.getElementById("txt_AssetID").value;
  }
  else if(selection=="Serial#")
  {
    serialno=document.getElementById("txt_SerialNo").value;
  }
  else if(selection=="WO#")
  {
    wo=document.getElementById("txt_WO").value;
  }


 window.location="common.php?Type="+type+"&vendor="+vendor+"&assettype="+assettype+"&manufacturer="+manufacturer+"&model="+model+"&assetid="+assetid
                           +"&serialno="+serialno+"&wo="+wo+"&searchby="+selection;
}

$(document).ready(function(){
$( "#myModal2" )
  .focusout(function() {
    location.reload();
  });
});
