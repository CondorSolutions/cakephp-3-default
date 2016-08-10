var firstLocation = -1;
function selectLocation(id){
	$("[id^=location_]").removeClass('bg-grayDark fg-white');
	$('#location_'+id).addClass('bg-grayDark fg-white');
	$('#terminals_header').html('<strong>'+$('#location_name_'+id).html()+'</strong>' + ' Terminals <a href="javascript: void(0)" onclick="showAddTerminals('+id+')">[add]</a>' );
	$('#users_header').html('<strong>'+$('#location_name_'+id).html()+'</strong>' + ' Users');
	showLocationTerminals(id);
	showLocationUsers(id);
}

function showLocationTerminals(id){
	$('#location_terminals_container').html('');
	var html = '';
	html ='<table class="table striped hovered border bordered" style="width: 500px;">';
	html +='<thead>';
	html +='	<tr>';
	html +='		<td>ID</td>';
	html +='		<td>Terminal Name</td>';
	html +='		<td>Status</td>';
	html +='		<td>Actions</td>';
	html +='	</tr>';
	html +='</thead>';
		
	html +='<tbody>';
	$.each( terminalsLocations, function( key, terminalsLocation ) {
		if(id == terminalsLocation.location_id){
			$.each( terminals, function( key, terminal ) {
				if(terminal.Terminal.id ==  terminalsLocation.terminal_id){
					var t = terminal.Terminal;
					html +='	<tr id="terminal_row_'+t.id+'">';
					html +='		<td>'+t.id+'</td>';
					html +='		<td>'+t.name+'</td>';
					html +='		<td>'+t.status+'</td>';
					html +='		<td><a href="javascript: void(0)"  id="remove_terminal_'+t.id+'" onclick="removeTerminal('+t.id+','+id+')">Remove</a></td>';
					html +='	</tr>';
				}
			});
		}
	});
	html +='</tbody>';
	html +='</table>';
	$('#location_terminals_container').html(html);
}

function showLocationUsers(id){
	$('#location_users_container').html('');
	var html = '';
	html ='<table class="table striped hovered border bordered" style="width: 500px;">';
	html +='<thead>';
	html +='	<tr>';
	html +='		<td>ID</td>';
	html +='		<td>Name</td>';
	html +='		<td>Actions</td>';
	html +='	</tr>';
	html +='</thead>';
		
	html +='<tbody>';
	$.each( locationsUsers, function( key, locationsUser ) {
		if(id == locationsUser.location_id){
			$.each( persons, function( key, person ) {
				if(person.user_id ==  locationsUser.user_id){
					html +='	<tr id="user_row_'+person.user_id+'">';
					html +='		<td>'+person.user_id+'</td>';
					html +='		<td>'+person.last_name +', '+person.first_name+'</td>';
					html +='		<td><a href="javascript: void(0)"  id="remove_user_'+person.user_id+'" onclick="removeUser('+person.user_id+','+id+')">Remove</a></td>';
					html +='	</tr>';
				}
			});
		}
	});
	html +='</tbody>';
	html +='</table>';
	$('#location_users_container').html(html);
}

var terminals;
var terminalsLocations;
var currentAddTerminalsDialog;
function showAddTerminals(locationId)
{
	var html = '';
	$('#select_terminals_container').html('');
	$.each( terminals, function( key, value ) {
		//filter
		var assigned = false;
		$.each( terminalsLocations, function( key, terminalsLocation ) {
			console.log(terminalsLocation);
			if(terminalsLocation.terminal_id ==value.Terminal.id )
				assigned = true;
		});
		if(!assigned){
			html += '<label class="input-control checkbox">';
		  	html += '    <input type="checkbox" id="'+ value.Terminal.id+'" class="terminal">';
		  	html += '    <span class="check"></span>';
		  	html += '    <span class="caption">' + value.Terminal.name + '</span>';
		  	html += '</label>';
		  	html += '<br>';
		}
	  	
	  	
	});
	currentAddTerminalsDialog = $('#select_terminals_dialog').data('dialog');
	html += '<button class="button success" onclick="addTerminals('+locationId+')">Add</button>'; 
	$(html).appendTo('#select_terminals_container');
	currentAddTerminalsDialog.open();
}

function addTerminals(locationId)
{
	$('.terminal:checkbox:checked').each(function () {
	       var data = "";
	       data += "location_id="+locationId;
	       data += "&terminal_id="+this.id;
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
	   			//console.log(data.data);
	   			terminalsLocations.push($.parseJSON(data.data));
	   			showLocationTerminals(locationId);
	   		},
	   		type : "POST",
	   		url : webroot+"locations/addLocationTerminal"
	   	});
	  });
	$('#select_terminals_container').html('');
	currentAddTerminalsDialog.close();
}

function removeTerminal(terminal_id, location_id){
	console.log(terminal_id);
	console.log(location_id);
	var data = "";
    data += "location_id="+location_id;
    data += "&terminal_id="+terminal_id;
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
			if(data.data == 1){
				var index = 0;
				$.each( terminalsLocations, function( key, terminalsLocation ) {
					if(terminalsLocation.terminal_id ==terminal_id && terminalsLocation.location_id ==location_id ){
						return false;
					}
					index++;
				});
				console.log('index: '+index);
				terminalsLocations.splice(index, 1);
				showLocationTerminals(location_id);
			}
			
		},
		type : "POST",
		url : webroot+"locations/removeLocationTerminal"
	});
}

var persons;
var locationsUsers;
var currentAssignUsersDialog;
function showAssignUsers(location_id){
	var html = '';
	$('#select_users_container').html('');
	html += '<div style="max-height: 500px; overflow: scroll; overflow-x: hidden;">'
	$.each( persons, function( key, value ) {
		console.log(value);
		//filter
		var assigned = false;
		$.each( locationsUsers, function( key, locationsUser ) {
			console.log(locationsUser);
			if(locationsUser.user_id ==value.id )
				assigned = true;
		});
		if(!assigned){
			html += '<label class="input-control checkbox">';
		  	html += '    <input type="checkbox" id="'+ value.id+'" class="terminal">';
		  	html += '    <span class="check"></span>';
		  	html += '    <span class="caption">' + value.last_name +', '+value.first_name+ '</span>';
		  	html += '</label>';
		  	html += '<br>';
		}
	  	
	  	
	});
	html += '</div>';
	currentAssignUsersDialog = $('#select_users_dialog').data('dialog');
	html += '<button class="button success" onclick="addTerminals('+location_id+')">Add</button>'; 
	$(html).appendTo('#select_users_container');
	currentAssignUsersDialog.open();
}

function removeUser(user_id, location_id){
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
			console.log(JSON.parse(data.data));
			locationsUsers = JSON.parse(data.data);
			selectLocation(location_id);
		},
		type : "POST",
		url : webroot+"locations/removeLocationUser"
	});
}