$(document).ready(function(){
	//console.log(departments_JSON);
});

//Maintenance Data
var currentAddDepartmentDialog;
function showAddDepartment(){
	var html = '';
	
	$('#add_department_container').html('');
	
	html += '<label class="input-control checkbox">';
	html += '<input maxlength="255" id="" type="text" required="required"  class="" value=""/>';
  	html += '</label>';
  	
	currentAddDepartmentDialog = $('#add_department_dialog').data('dialog');
	html += '<button class="button success" onclick="addDepartment()">Add</button>'; 
	$(html).appendTo('#add_department_container');
	currentAddDepartmentDialog.open();
}

var newDeptCount = 0;
function addDepartmentRow()
{
	var html = '';
	html += '<tr>';
	html += '<td id="new_department_id_'+newDeptCount+'">';
	html+= '</td>';
	html += '<td id="new_department_name_'+newDeptCount+'">';
	html += '<div class="input-control text full-size">';
	html += '<input id="new_department_name_input_'+newDeptCount+'" maxlength="255" id="" type="text" required="required"  >';
	html += '</div>';
	html+= '</td>';
	html += '<td id="new_department_actions_'+newDeptCount+'">';
	html += '<button class="button success" onclick="saveDepartmentRow('+newDeptCount+')">Save</button>'; 
	html+= '</td>';
	html += '</tr>';
	$(html).appendTo('#departments_tbody');
	newDeptCount++;
}

function saveDepartmentRow(id){
	var name = $('#new_department_name_input_'+id).val();
	if(name == ""){
		alert("Department name is required.");
	}
	else{
		var data = "name="+name;
		 return  $.ajax({
			async : true,
			data : data,
			dataType : "JSON",
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				console.log("--error--");
				console.log(textStatus);
				console.log(errorThrown);
				ajaxError(errorThrown);
			},
			success : function(data, textStatus) {
				
				var department =  $.parseJSON(data['department']);
				console.log(department.id);
				$('#new_department_id_'+id).html(department.id);
				$('#new_department_name_'+id).html(department.name);
				$('#new_department_actions_'+id).html('');
			},
			type : "POST",
			url : webroot+'departments/addAjax/'
		});
	}
}

var newPositionsCount = 0;
function addPositionRow()
{
	var html = '';
	html += '<tr>';
	html += '<td id="new_position_id_'+newPositionsCount+'">';
	html+= '</td >';
	html+= '<td id="new_positions_department_id_col_'+newPositionsCount+'"><select name="new_positions_department_id_'+newPositionsCount+'"  id="new_positions_department_id_'+newPositionsCount+'">';
	html += '<option value="0"></option>';
	$.each(departments_JSON, function(key, department) {
		console.log(key);
		console.log(department);
		html += '<option value="'+department.id+'">'+department.name+'</option>';
	});
	html+= '</select></td>';
	html += '<td id="new_position_name_'+newPositionsCount+'">';
	html += '<div class="input-control text full-size">';
	html += '<input id="new_position_name_input_'+newPositionsCount+'" maxlength="255" id="" type="text" required="required"  >';
	html += '</div>';
	html+= '</td>';
	html += '<td id="new_position_actions_'+newPositionsCount+'">';
	html += '<button class="button success" onclick="savePositionRow('+newPositionsCount+')">Save</button>'; 
	html+= '</td>';
	html += '</tr>';
	$(html).appendTo('#positions_tbody');
	newPositionsCount++;
}

function savePositionRow(id){
	var department_id = $('#new_positions_department_id_'+id).val();
	var department_name =  $('#new_positions_department_id_'+id+' option:selected').text();
	var name = $('#new_position_name_input_'+id).val();
	var msg = "";
	if(name == ""){
		msg += "Position name is required. \n";
	}
	if(department_id == "0"){
		msg += "Department is required. \n";
	}
	
	if(msg != ""){
		alert(msg);
	}
	else{
		var data = "department_id="+department_id;
		data+= "&name="+name;
		 return  $.ajax({
			async : true,
			data : data,
			dataType : "JSON",
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				console.log("--error--");
				console.log(textStatus);
				console.log(errorThrown);
				ajaxError(errorThrown);
			},
			success : function(data, textStatus) {
				var position =  $.parseJSON(data['position']);
				$('#new_position_id_'+id).html(position.id);
				$('#new_positions_department_id_col_'+id).html(department_name);
				$('#new_position_name_'+id).html(position.name);
				$('#new_position_actions_'+id).html('');
			},
			type : "POST",
			url : webroot+'positions/addAjax/'
		});
	}
}

var newAgencyCount = 0;
function addAgencyRow()
{
	var html = '';
	html += '<tr>';
	html += '<td id="new_agency_id_'+newAgencyCount+'">';
	html+= '</td>';
	html += '<td id="new_agency_name_'+newAgencyCount+'">';
	html += '<div class="input-control text full-size">';
	html += '<input id="new_agency_name_input_'+newAgencyCount+'" maxlength="255" id="" type="text" required="required"  >';
	html += '</div>';
	html+= '</td>';
	html += '<td id="new_agency_actions_'+newAgencyCount+'">';
	html += '<button class="button success" onclick="saveAgencyRow('+newAgencyCount+')">Save</button>'; 
	html+= '</td>';
	html += '</tr>';
	$(html).appendTo('#agencies_tbody');
	newAgencyCount++;
}

function saveAgencyRow(id){
	var name = $('#new_agency_name_input_'+id).val();
	if(name == ""){
		alert("Agency name is required.");
	}
	else{
		var data = "name="+name;
		 return  $.ajax({
			async : true,
			data : data,
			dataType : "JSON",
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				console.log("--error--");
				console.log(textStatus);
				console.log(errorThrown);
				ajaxError(errorThrown);
			},
			success : function(data, textStatus) {
				
				var agency =  $.parseJSON(data['agency']);
				$('#new_agency_id_'+id).html(agency.id);
				$('#new_agency_name_'+id).html(agency.name);
				$('#new_agency_actions_'+id).html('');
			},
			type : "POST",
			url : webroot+'agencies/addAjax/'
		});
	}
}
