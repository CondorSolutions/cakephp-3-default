var userAddresses = [];
var selectWait =  [ {'code':'0', 'name':'wait...'}];
var refRegions = [];
var refProvinces = [];
var refCityMuns = [];
var refBrgys = [];
var addresIndices = [];

function loadAddresses(){
	$.each( userAddresses, function( key, value ) {
		  	addAddressWindow(value);
		});
}
function addAddressWindow(data)
{
	if(data==null)
		data = {'id':0,'line_1':'','line_2':'','description':'Permanent Address'};
	var index = 0;
	if(addresIndices.length == 0){
		index = 0;
	}
	else
	{
		index = addresIndices[addresIndices.length-1] + 1;
	}
	addresIndices.push(index);
	$('#address_count').val(index+1);
	var row = '';
	row += 	'<div class="window" style="margin-bottom: 10px; display: none;" id="address_windows_'+index+'">';
	row +=	'<div class="window-caption bg-cyan fg-white">';
	row +=	'		<span class="window-caption-icon">';
	row +=	'			<span class="mif-location"></span>';
	row +=	'			<span class="btn-close" onclick="remove_address(address_windows_'+index+');"></span>';
	row +=	'		</span>';
	row +=	'		<span class="window-caption-title">';
	if(data.id==0){
		row +=	'			<span id="address_label">New Address '+(index+1)+'</span>';
	}
	else{
		row +=	'			<span id="address_label"> '+data['description']+'</span>';
	}
	
	row +=	'		</span>';
	row +=	'	</div>';
	row +=	'	<div class="window-content bg-white">';
	row +=	'		<div class="cell">';
	row +=	'			<label>Address Type</label>';
	row +=	'			 <div class="input-control text full-size">';
	row +=	'			 <span class="mif-chevron-thin-down prepend-icon"></span>';
	row +=	'					 <select name="address_name_'+index+'" style="padding-left: 30px;" id="address_name_'+index+'">';
	if(data['description']=='Permanent Address'){
		row +=	'					 	<option value="Permanent Address" selected>Permanent Address</option>';
	}
	else{
		row +=	'					 	<option value="Permanent Address">Permanent Address</option>';
	}
	if(data['description']=='City Address'){
		row +=	'					 	<option value="City Address" selected>City Address</option>';
	}
	else{
		row +=	'					 	<option value="City Address">City Address</option>';
	}
	if(data['description']=='Provincial Address'){
		row +=	'					 	<option value="Provincial Address" selected="selected">Provincial Address</option>';
	}
	else{
		row +=	'					 	<option value="Provincial Address">Provincial Address</option>';
	}
	row +=	'					 </select>';
	row +=	'			   </div>';
	row +=	'		</div>';//<div class="cell">';
	row +=	'		<div class="cell">';
	row +=	'			<label>Region</label>';
	row +=	'			 <div class="input-control text full-size">';
	row +=	'			 <span class="mif-chevron-thin-down prepend-icon"></span>';
	row +=	'					 <select name="ref_region_'+index+'" style="padding-left: 30px;" id="ref_region_'+index+'">';
	row +=	'					 	<option value="">N/A</option>';
	row +=	'					 </select>';
	row +=	'			   </div>';
	row +=	'		</div>';//<div class="cell">';
	row +=	'		<div class="cell">';
	row +=	'			<label>Province</label>';
	row +=	'			 <div class="input-control text full-size">';
	row +=	'			 <span class="mif-chevron-thin-down prepend-icon"></span>';
	row +=	'					 <select name="ref_province_'+index+'" style="padding-left: 30px;" id="ref_province_'+index+'">';
	row +=	'					 	<option value="">N/A</option>';
	row +=	'					 </select>';
	row +=	'			   </div>';
	row +=	'		</div>';//<div class="cell">';
	row +=	'		<div class="cell">';
	row +=	'			<label>City/Municipality</label>';
	row +=	'			 <div class="input-control text full-size">';
	row +=	'			 <span class="mif-chevron-thin-down prepend-icon"></span>';
	row +=	'					 <select name="ref_citymun_'+index+'" style="padding-left: 30px;" id="ref_citymun_'+index+'">';
	row +=	'					 	<option value="">N/A</option>';
	row +=	'					 </select>';
	row +=	'			   </div>';
	row +=	'		</div>';//<div class="cell">';
	row +=	'		<div class="cell">';
	row +=	'			<label>Barangay</label>';
	row +=	'			 <div class="input-control text full-size">';
	row +=	'			 <span class="mif-chevron-thin-down prepend-icon"></span>';
	row +=	'					 <select name="ref_brgy_'+index+'" style="padding-left: 30px;" id="ref_brgy_'+index+'">';
	row +=	'					 	<option value="">N/A</option>';
	row +=	'					 </select>';
	row +=	'			   </div>';
	row +=	'		</div>';//<div class="cell">';
	row +=	'		<div class="cell">';
	row +=	'			<label>Number/Building/Street/Village</label>';
	row +=	'			 <div class="input-control text full-size">';
	row +=	'					 <input name="line_1_'+index+'"  maxlength="255" id="line_1_'+index+'" type="text"  value="'+data['line_1']+'">';
	row +=	'			   </div>';
	row +=	'		</div>';//<div class="cell">';
	row +=	'		<div class="cell">';
	row +=	'			 <div class="input-control text full-size">';
	row +=	'					 <input name="line_2_'+index+'"  maxlength="255" id="line_2_'+index+'" type="text"  value="'+data['line_2']+'">';
	row +=	'			   </div>';
	row +=	'		</div>';//<div class="cell">';
	row +=	'	</div>';
	row +=	'</div>';
	$(row).appendTo('#address_container').show('slow');
	//$('#address_container').append(row);
	buildRefSelect('ref_region_'+index,refRegions, data['ref_region_code']);
	
	if(data.id != 0){
		var code = $( "#ref_region_"+index+" option:selected" ).val();
		
		getChildReferences('RefProvinces',data['ref_region_code'], index, data['ref_province_code']);
		
		getChildReferences('RefCitymuns',data['ref_province_code'], index, data['ref_citymun_code']);
		
		getChildReferences('RefBrgys',data['ref_citymun_code'], index,data['ref_brgy_code']);
	}
	$( "#address_name_"+index ).change(function() {
		updateLabel(index);
	});
	
	addSelectFunctions(index);
	$('address_windows_'+index).show('slow');
	if(data.id == 0){
		$('html, body').animate({
	        scrollTop: $("#address_windows_"+index).offset().top
	    }, 1000);
	}
	
};
function updateLabel(index){
	$('#address_label').html($( "#address_name_"+index+" option:selected" ).val());
}	
function addSelectFunctions(index){
	//set elements functions
	$("#ref_region_"+index ).unbind();
	$( "#ref_region_"+index ).change(function() {
			var code = $( "#ref_region_"+index+" option:selected" ).val();
			getChildReferences('RefProvinces',code, index);
			//reset other selects
			refProvinces =selectWait;
			buildRefSelect('ref_province_'+index, refProvinces);
			refCityMuns = selectWait;
			buildRefSelect('ref_citymun_'+index, refCityMuns);
			refBrgys =selectWait;
			buildRefSelect('ref_brgy_'+index, refBrgys);
		});
	
	$("#ref_province_"+index ).unbind();
	$( "#ref_province_"+index ).change(function() {
		var code = $( "#ref_province_"+index+" option:selected" ).val();
		getChildReferences('RefCitymuns',code, index);
		//reset other selects
		refBrgys =selectWait;
		buildRefSelect('ref_brgy_'+index, refBrgys);
	});
	
	$("#ref_citymun_"+index ).unbind();
	$( "#ref_citymun_"+index ).change(function() {
		var code = $( "#ref_citymun_"+index+" option:selected" ).val();
		getChildReferences('RefBrgys',code, index);
	});
}

function buildRefSelect(element_id, data, selectedVal)
{
	var s = '';
	s+='<select style="padding-left: 30px;" name="'+element_id+'" id="'+element_id+'">';
	s+='<option></option>';
	if(data.length>0){
		$.each( data, function( key, value ) {
			  s+='<option value='+value['code'] ;
			  if(value['code'] == selectedVal)
				  s+=' selected';
			  s+='>'+value['name'] +'</option>';
			});
	}
	s+='</select>';
	$( "#"+element_id ).replaceWith( s);
}


function getChildReferences(type, parent_code, index, selectedVal){
	$.ajax({
		async : true,
		data : "type="+type+"&parent_code="+parent_code,
		dataType : "JSON",
		error : function(XMLHttpRequest, textStatus, errorThrown) {
			console.log("--error--");
			console.log(textStatus);
			console.log(errorThrown);
		},
		success : function(data, textStatus) {
			console.log(data);
			switch (type) {
			case 'RefProvinces':
				buildRefSelect('ref_province_'+index,data, selectedVal);
				break;
			case 'RefCitymuns':
				buildRefSelect('ref_citymun_'+index,data, selectedVal);
				break;
			case 'RefBrgys':
				buildRefSelect('ref_brgy_'+index,data, selectedVal);
				break;
			default:
				console.log("getChildReferences: type not found!");
				break;
			}
			addSelectFunctions(index);
		},
		type : "POST",
		//url : "ajaxValidate.json"
		url : webroot+"users/getPlaces"
	});
}

function remove_address(e){
	$(e).hide('slow', function(){ $(e).remove(); });
}
