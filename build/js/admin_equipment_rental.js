$(document).ready(function() {
	requestAccountability();
});

function requestAccountability()
{
	console.log("loading...");
	$.post("build/ajax/adminEquipmentRental.php",{showAccounts:1},function(data)
	{
		$('#history_loader').hide();
		$('#history_request_div').html(data);
		$('#history_request_div').show();
		console.log("loaded");
	});
}

$('body').delegate('.adminView','click',function()
{
		var viewP = $(this).attr("idPv");
		var viewC = $(this).attr("conditionPv");
		var viewL = $(this).attr("locationPv");
		$.ajax
		({
						url : 'build/ajax/adminEquipmentRental.php',
						async : false,
						type : 'POST',
						data :
						{
								showInformation : 1,
								prowareID : viewP,
								condition_id: viewC,
								location_id: viewL
						},
						success : function(adminDatas)
						{
								$("#adminInformation").html(adminDatas);
						}
		});
		$.post('build/ajax/adminShowRepairHistory.php',{showRequest : 1 , viewP : viewP},function(data){
			$("#adminRepairHistory").html(data);
		});
		$.post('build/ajax/adminShowLocationHistory.php',{showRequests : 1 , viewPs : viewP},function(datas){
			$("#adminLocationHistory").html(datas);
		});
});
function updateAdminCondition(propertyId, locationId, oldConditionId, emp_id) {
	var newConditionId = $("#condition" + propertyId + locationId + oldConditionId + emp_id).val();

	$.post("build/ajax/updateAdminCondition.php", {id: propertyId,  new_condition_id:newConditionId, location_id : locationId, old_condition_id : oldConditionId, empid:emp_id}, function(data) {
		var result = parseInt(data);

		if (result == 1)
    {
      $.Notify({
      	caption: 'Update Success',
          content: 'Condition successfully Updated' ,
          icon: "<span class='mif-pencil icon'></span>",
          type: "success"
      });
			console.log(data);
		}

    else if(result == 2)
    {
      prowareTable();
    }
    else
    {
			console.log(data);
      $.Notify({
        caption: 'Update Failed',
        content: 'Condition Update failed' ,
        icon: "<span class='mif-pencil icon'></span>",
        type: "alert"
        });
		}
	});
}
function changeAccountability(id , pcode , sno , qty , location , condition)
{
	var accountID = $("#selectAccount").val();
	//Parameters for location and others
	$.post("build/ajax/updateAccountability.php",{pcode:pcode , sno:sno, id:id, account:accountID, qty:qty , location:location , condition:condition}, function(data)
	{
		var result = parseInt(data);
		if(result == 1){
			//Proceed
			$.Notify({
				caption: 'Update Success',
				content: 'Property Accountability Update success',
				icon: "<span class='mif-pencil icon'></span>",
				type: "success"
			});


		}
		else if(result == -1){
			//Server Error
			$.Notify({
			caption: 'Update Failed',
			content: 'Condition Update failed' ,
			icon: "<span class='mif-pencil icon'></span>",
			type: "alert"
			});
		}
		else{
			//Natural Error
		}
		console.log(data);
	});
}
