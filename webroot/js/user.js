function toggleAutoActivate(){
	console.log($( "#auto-activate" ).is(':checked'));
	if($( "#auto-activate" ).is(':checked')){
		$('#password-container').show('slow');
		$('html, body').animate({
	        scrollTop: $("#password-container").offset().top
	    }, 1000);
	}
	else
	{
		$('#password-container').hide('slow');
	}
}

function addBasicInfo(){
	if($( "#auto-activate" ).is(':checked')){
		var message = "";
		var password =  $("#password").val();
		var confirm_password =  $("#confirm-password").val();
		if(password=="")
			message += "Password is required \n";
		if(confirm_password=="")
			message += "Confirm Password is required \n";
		if(password!=confirm_password)
			message += "Confirm password mismatch \n";
		if(message != ""){
			alert(message);
			return false;
		}
	}
	return true;
}

var locations;
var locationsUsers;
var currentAssignLocationsDialog
var firstUser = -1;
function selectUser(id){
	$("[id^=user_row_]").removeClass('bg-grayDark fg-white');
	$('#user_row_'+id).addClass('bg-grayDark fg-white');
	$('#locations_header').html('<strong>'+$('#user_fullname_'+id).html()+'</strong>' + ' Assigned Locations');
	showUserLocations(id);
}

function showUserLocations(id){
	$('#user_locations_container').html('');
	var html = '';
	html ='<table class="table striped hovered border bordered" style="width: 400px;">';
	html +='<thead>';
	html +='	<tr>';
	html +='		<td>Location</td>';
	html +='		<td>Actions</td>';
	html +='	</tr>';
	html +='</thead>';
		
	html +='<tbody>';
	$.each( locationsUsers, function( key, locationsUser ) {
		if(id == locationsUser.user_id){
			$.each( locations, function( key, location ) {
				if(location.id ==  locationsUser.location_id){
					html +='	<tr id="locationl_row_'+location.id+'">';
					html +='		<td>'+location.name+'</td>';
					html +='		<td><a href="javascript: void(0)" id="remove_terminal_'+location.id+'" onclick="removeFromLocation('+location.id+','+id+')">Remove</a></td>';
					html +='	</tr>';
				}
			});
		}
	});
	html +='</tbody>';
	html +='</table>';
	$('#user_locations_container').html(html);
}

function toggleSelectAllUsers(e){
	$.each( $("[id^=user_checkbox_]"), function( key, checkbox ) {
		$(checkbox).prop('checked', $(e).is(':checked'));
	});
}
function toggleSelectAllLocations(e){
	$.each( $("[id^=location_checkbox_]"), function( key, checkbox ) {
		$(checkbox).prop('checked', $(e).is(':checked'));
	});
}
function showAssignLocations(user_id)
{
	if($("[id^=user_checkbox_]:checked").size()>0){
		var html = '';
		html += '<label class="input-control checkbox">';
	  	html += '    <input type="checkbox" id="" class="terminal" onclick="toggleSelectAllLocations(this);">';
	  	html += '    <span class="check"></span>';
	  	html += '    <span style="font-weight: bold;">Select All</span>';
	  	html += '</label>';
	  	html += '<br>';
		html += '<div style="max-height: 400px; overflow: scroll; overflow-x: hidden;">'
		$('#assign_locations_container').html('');
		$.each( locations, function( key, value ) {
			html += '<label class="input-control checkbox">';
		  	html += '    <input type="checkbox" id="location_checkbox_'+ value.id+'" class="terminal">';
		  	html += '    <span class="check"></span>';
		  	html += '    <span class="caption">' + value.name + '</span>';
		  	html += '</label>';
		  	html += '<br>';
		});
		currentAssignLocationsDialog = $('#assign_locations_dialog').data('dialog');
		html += '</div>'
		html += '<button class="button success" onclick="assignLocations()">Add</button>'; 
		$(html).appendTo('#assign_locations_container');
		currentAssignLocationsDialog.open();
	}
}

function assignLocations(){
	if($("[id^=user_checkbox_]:checked").size()>0){
		if($("[id^=location_checkbox_]:checked").size()>0){
			console.log($("[id^=user_checkbox_]:checked").size());
			console.log($("[id^=location_checkbox_]:checked").size());
			var data = "";
			$.each( $("[id^=user_checkbox_]"), function( key, checkbox ) {
				if($(checkbox).is(':checked')){
					var id = $(checkbox).prop('id').replace('user_checkbox_', '');
					data += 'user_id[]='+id+'&';
				}
			});
			$.each( $("[id^=location_checkbox_]"), function( key, checkbox ) {
				if($(checkbox).is(':checked')){
					var id = $(checkbox).prop('id').replace('location_checkbox_', '');
					data += 'location_id[]='+id+'&';
				}
			});
		    $.ajax({
				async : false,
				data : data,
				dataType : "JSON",
				error : function(XMLHttpRequest, textStatus, errorThrown) {
					console.log("--error--");
					console.log(textStatus);
					console.log(errorThrown);
					alert(errorThrown);
				},
				success : function(data, textStatus) {
					locationsUsers = JSON.parse(data.data);
					currentAssignLocationsDialog.close();
				},
				type : "POST",
				url : webroot+"users/assignToLocations"
			});
		}
	}
}

function removeFromLocation(location_id, user_id){
	var data = "";
    data += "location_id="+location_id;
    data += "&user_id="+user_id;
    $.ajax({
		async : false,
		data : data,
		dataType : "JSON",
		error : function(XMLHttpRequest, textStatus, errorThrown) {
			console.log("--error--");
			console.log(textStatus);
			console.log(errorThrown);
			alert(errorThrown);
			
		},
		success : function(data, textStatus) {
			locationsUsers = JSON.parse(data.data);
			selectUser(user_id);
		},
		type : "POST",
		url : webroot+"users/removeFromLocation"
	});
}