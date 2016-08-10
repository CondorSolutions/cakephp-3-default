var user_id;
var usersStandardShifts;
var usersStandardDayOffs;
var userRepeatedShifts;
var userSpecialShifts;
var userSpecialDayOffs;

function buildUsersStandardShifts(){
	$('#standard-shift-container').html('');
	var html = '';
	html += '';
	$.each( usersStandardShifts, function( key, usersStandardShift ) {
		var matchedStandardShift;
		$.each( standardShifts, function( key, standardShift ) {
			if(standardShift.id ==usersStandardShift.standard_shift_id )
				matchedStandardShift = standardShift;
		});
		html += '<span style="margin: 10px;">';
		html +=matchedStandardShift.name +' <small>('+toTime(matchedStandardShift.start)+' to '+toTime(matchedStandardShift.end)+') </small><a href="javascript:void(0)" onclick="removeStandardShift('+matchedStandardShift.id+')"> <small>Remove</small></a>' ;
		html += '</span><br/>';
	});
	html += '<br/>';
	$(html).appendTo('#standard-shift-container');
}

function buildUsersStandardDayOffs(){
	$('#standard-day-offs-container').html('');
	var html = '';
	html += '';
	$.each( usersStandardDayOffs, function( key, usersStandardDayOff ) {
		var matchedStandardDayOff;
		$.each( standardDayOffs, function( key, standardDayOff ) {
			if(standardDayOff.id ==usersStandardDayOff.standard_day_off_id )
				matchedStandardDayOff = standardDayOff;
		});
		html += '<span style="margin: 10px;">';
		html +=matchedStandardDayOff.name +' <small></small><a href="javascript:void(0)" onclick="removeStandardDayOff('+matchedStandardDayOff.id+')"> <small>Remove</small></a>' ;
		html += '</span><br/>';
	});
	html += '<br/>';
	$(html).appendTo('#standard-day-offs-container');
}

var currentMonth;
var currentYear;
function day_click(d){
	var year = parseInt(d.split("-")[0]);
	var month = parseInt(d.split("-")[1]);
	var day = parseInt(d.split("-")[2]);
	if(month!=currentMonth || currentYear!=year){
		currentMonth= month;
		currentYear=year;
		
		getMonthShifts(month, year).done(handleData);
	}
	$("[id^=day_row_]").removeClass('day-selected');
	$('#day_row_'+parseInt(day)).addClass('day-selected');
	$('#day_row_'+parseInt(day)).scrollView(-100);
}

function daysInMonth(month,year) {
    return new Date(year, month, 0).getDate();
}

function handleData(data){
	//console.log(data);
	monthShifts = JSON.parse(data.monthShifts);
	//console.log(monthShifts);
	userSpecialShifts = JSON.parse(data.userSpecialShifts);
	userSpecialDayOffs = JSON.parse(data.userSpecialDayOffs);
	buildMonth(currentMonth, currentYear);
}
var monthShifts;
function buildMonth(month, year){
	$('#days-container').html('');
	var html = '';
	html += '';
	html += '<table class="dataTable striped hovered" data-role="datatable" data-auto-width="false" >';
	for(var i = 1; i<=daysInMonth(month, year); i++){
		html += dayRowTemplate(i, month, year);
	}
	html += '</table>';
	$(html).appendTo('#days-container').show('slow');
	buildUserSpecialShifts();
	buildUserSpecialDayOffs();
}

function dayRowTemplate(day, month, year){//
	var d = new Date(year, month-1, day);
	var rowClass = "";
	if(toDate(d)==toDate(today))
		rowClass=" date-label-today";
	var html = '';
	html += '';
	html += '<tr id="day_row_'+day+'" ><td>';
	html += '<div class="date-label '+rowClass+'"><small>'+window.METRO_LOCALES.en.months[parseInt(month)+11]+' '+day+'</small><br><span style="font-size: 12px;">'+window.METRO_LOCALES.en.days[d.getDay()+7]+'</span>';
	if(toDate(d)==toDate(today))
		html += '<br><small>TODAY</small>';
	html += '</div>';
	//if(d>=today)
		html += dayShifts(day);//left column
		
	html += '</td>';
	html += '<td>';
		html += dayFunctions(day, month, year);//right column
	html += '</td></tr>';
	return html;
}
function dayFunctions(day, month, year){
	var html = '';
	html += '';
	html += '<div>';
	html += '<a href="'+webroot+'punchLogs/index/'+user_id+'/'+year+'/'+month+'/'+day+'" target="_blank">Punch Logs</a>';
	html += '</div>';
	
	return html;
}
function dayShifts(day){
	var html = '';
	if('day_off' in monthShifts[day]){
		html += '<div class="shift-label fg-red" ><small>Day Off</small><br>';
		$.each( monthShifts[day], function( key, dayOff ) {
			if('standard_day_off' in dayOff){
				html +='<small> '+dayOff.standard_day_off.name +' - Standard</small>' ;
			}
			else{
				html +='<small> '+dayOff.name +'</small>' ;
			}
		});
	}
	else{
		html += '<div class="shift-label fg-darkGreen" ><small>Shifts/s:</small><br>';
		$.each( monthShifts[day], function( key, shift ) {
			
			$.each( shift, function( key,userShift ) {
				html += '<span >';
				if('standard_shift' in userShift){
					html +=toTime(userShift.standard_shift.start)+' to '+toTime(userShift.standard_shift.end)+' <small>('+userShift.standard_shift.name +' - Standard) </small>' ;
				}
				else{
					html +=toTime(userShift.start)+' to '+toTime(userShift.end)+' <small>('+userShift.name +') </small>' ;
				}
				
				html += '</span><br/>';
			})
		});
	}
	return html;
}

function getMonthShifts(month, year){//ajax
	 var data = "";
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
			
		},
		type : "POST",
		url : webroot+'users/getShiftsByMonth/'+user_id+'/'+year+'/'+month
	});
}

var standardShifts;
var standardDayOffs;
var currentAddStandardShiftDialog;
function showAddStandardShift(){
	var html = '';
	
	$('#select_standard_shifts_container').html('');
	$.each( standardShifts, function( key, standardShift ) {
		html += '<label class="input-control checkbox">';
	  	html += '    <input type="checkbox" id="'+ standardShift.id+'" class="standardShift">';
	  	html += '    <span class="check"></span>';
	  	html += '    <span class="caption">' + standardShift.name + ' <small>(' +toTime(standardShift.start)+' to '+toTime(standardShift.end)+')</small></span>';
	  	html += '</label>';
	  	html += '<br>';
	});
	currentAddStandardShiftDialog = $('#select_standard_shifts_dialog').data('dialog');
	html += '<button class="button success" onclick="addStandardShifts()">Add</button>'; 
	$(html).appendTo('#select_standard_shifts_container');
	currentAddStandardShiftDialog.open();
}

var currentAddStandardDayOffsDialog;
function showAddStandardDayOffs(){
	var html = '';
	
	$('#select_standard_day_offs_container').html('');
	$.each( standardDayOffs, function( key, standardDayOff ) {
		html += '<label class="input-control checkbox">';
	  	html += '    <input type="checkbox" id="'+ standardDayOff.id+'" class="standardDayOff">';
	  	html += '    <span class="check"></span>';
	  	html += '    <span class="caption">' + standardDayOff.name + ' <small></small></span>';
	  	html += '</label>';
	  	html += '<br>';
	});
	currentAddStandardDayOffsDialog = $('#select_standard_day_offs_dialog').data('dialog');
	html += '<button class="button success" onclick="addStandardDayOffs()">Add</button>'; 
	$(html).appendTo('#select_standard_day_offs_container');
	currentAddStandardDayOffsDialog.open();
}

function addStandardShifts()
{
	$('.standardShift:checkbox:checked').each(function () {
	       var data = "";
	       data += "user_id="+user_id;
	       data += "&standard_shift_id="+this.id;
	       $.ajax({
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
	   			usersStandardShifts = JSON.parse(data.usersStandardShifts);
	   			buildUsersStandardShifts();
	   			buildMonth(currentMonth, currentYear);
	   		},
	   		type : "POST",
	   		url : webroot+"users/addStandardShifts"
	   	});
	  });
	$('#select_standard_shifts_container').html('');
	currentAddStandardShiftDialog.close();
}

function addStandardDayOffs()
{
	$('.standardDayOff:checkbox:checked').each(function () {
	       var data = "";
	       data += "user_id="+user_id;
	       data += "&standard_day_off_id="+this.id;
	       $.ajax({
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
	   			usersStandardDayOffs = JSON.parse(data.usersStandardDayOffs);
	   			buildUsersStandardDayOffs();
	   			buildMonth(currentMonth, currentYear);
	   		},
	   		type : "POST",
	   		url : webroot+"users/addStandardDayOffs"
	   	});
	  });
	$('#select_standard_day_offs_container').html('');
	currentAddStandardDayOffsDialog.close();
}

function removeStandardShift(standard_shift_id){
	var data = "";
    data += "user_id="+user_id;
    data += "&standard_shift_id="+standard_shift_id;
    $.ajax({
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
			usersStandardShifts = JSON.parse(data.usersStandardShifts);
			buildUsersStandardShifts();
			buildMonth(currentMonth, currentYear);
		},
		type : "POST",
		url : webroot+"users/removeStandardShift"
	});
}

function removeStandardDayOff(standard_day_off_id){
	var data = "";
    data += "user_id="+user_id;
    data += "&standard_day_off_id="+standard_day_off_id;
    $.ajax({
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
			usersStandardDayOffs = JSON.parse(data.usersStandardDayOffs);
			buildUsersStandardDayOffs();
			buildMonth(currentMonth, currentYear);
		},
		type : "POST",
		url : webroot+"users/removeStandardDayOff"
	});
}

function buildUsersCustomRepeatingShifts(){
	$('#custom-repeating-shift-container').html('');
	var html = '';
	html += '';
	$.each( userRepeatedShifts, function( key, userRepeatedShift ) {
		html += '<span style="margin: 10px;">';
		html += toTime(userRepeatedShift.start)+' to '+toTime(userRepeatedShift.end)+' <a href="javascript:void(0)" onclick="removeCustomRepeatingShift('+userRepeatedShift.id+')"> <small>Remove</small></a><br/>' ;
		html += '<small style="padding-left: 20px;">'+userRepeatedShift.name +' </small><br/>';
		var ends = toDate(userRepeatedShift.repeat.end);
		if(ends=='Jan 1, 1970')
			ends = 'Never';
		html += '<small style="padding-left: 20px;">Starts: '+toDate(userRepeatedShift.repeat.start) +'</small><br/>';
		html += '<small style="padding-left: 20px;">Ends: '+ends+'</small>';
		html += '</span><hr class="thin bg-grayLighter">';
	});
	html += '<br/>';
	$(html).appendTo('#custom-repeating-shift-container');
}

function buildUsersCustomRepeatingDayOffs(){
	$('#custom-repeating-day-off-container').html('');
	var html = '';
	html += '';
	$.each( userRepeatedDayOffs, function( key, userRepeatedDayOff ) {
		html += '<span style="margin: 10px;">';
		html += userRepeatedDayOff.name+' <a href="javascript:void(0)" onclick="removeCustomRepeatingDayOff('+userRepeatedDayOff.id+')"> <small>Remove</small></a><br/>' ;
		var ends = toDate(userRepeatedDayOff.repeat.end);
		if(ends=='Jan 1, 1970')
			ends = 'Never';
		html += '<small style="padding-left: 20px;">Starts: '+toDate(userRepeatedDayOff.repeat.start) +'</small><br/>';
		html += '<small style="padding-left: 20px;">Ends: '+ends+'</small>';
		html += '</span><hr class="thin bg-grayLighter">';
	});
	html += '<br/>';
	$(html).appendTo('#custom-repeating-day-off-container');
}

function buildUserSpecialShifts(){
	$('#special-shift-container').html('');
	var html = '';
	html += '';
	html += '<h4 class="fg-green">Special Shifts ('+window.METRO_LOCALES.en.months[currentMonth + 11]+')</h4>'
	$.each( userSpecialShifts, function( key, userSpecialShift ) {
		html += '<span style="margin: 10px;">';
		html +=toDate(userSpecialShift.date)+' <a href="javascript:void(0)" onclick="removeSpecialShift('+userSpecialShift.id+')"><small> Remove</small></a><br/>' ;
		html += '<small style="padding-left: 20px;">'+toTime(userSpecialShift.start)+' to '+toTime(userSpecialShift.end)+'</small><br/>';
		
		html += '</span><hr class="thin bg-grayLighter">';
	});
	html += '<br/>';
	$(html).appendTo('#special-shift-container');
}

function buildUserSpecialDayOffs(){
	$('#special-day-off-container').html('');
	var html = '';
	html += '';
	html += '<h4 class="fg-red">Special Day Offs ('+window.METRO_LOCALES.en.months[currentMonth + 11]+')</h4>'
	$.each( userSpecialDayOffs, function( key, userSpecialDayOff ) {
		html += '<span style="margin: 10px;">';
		html +=toDate(userSpecialDayOff.date)+' <a href="javascript:void(0)" onclick="removeSpecialDayOff('+userSpecialDayOff.id+')"><small> Remove</small></a><br/>' ;
		
		html += '</span><hr class="thin bg-grayLighter">';
	});
	html += '<br/>';
	$(html).appendTo('#special-day-off-container');
}

var currentAddCustomRepeatingShiftDialog;
function showAddCustomRepeatingShift(){
	custom_repeating_type = 'shift';
	var html = '';
	$('#select_custom_repeating_shifts_container').html('');
	html += '';
	html += '<label>Shift Description</label>';
	html += '<div class="input-control text full-size">';
	html += '<input maxlength="255" id="shift_name" type="text" required="required"  class="" value="'+$('#full_name').html()+'">';
	html += '</div>';
	html += '<br>';
	html += '<label>Start Time</label>';
	html += '<div class="input-control text full-size">';
	html += '<input maxlength="255" id="shift_start" type="text" required="required"  class="timepicker">';
	html += '</div>';
	html += '<br>';
	html += '<label>End Time</label>';
	html += '<div class="input-control text full-size">';
	html += '<input maxlength="255" id="shift_end" type="text" required="required"  class="timepicker">';
	html += '</div>';
	html += '<br>';
  	html += '<span>Repeat Every:</span> ';
  	html += '<br>';
  	html += '<input type="text" id="every_count" class="numeric input-control" style="width: 50px;" value="1" onchange="updateCustomRepeatingShiftName();">';
  	html += '&nbsp;<select id="every" class="input-control" onchange="everyChanged();"><option value="days">days</option>';
  	html += '<option value="weeks" selected>weeks</option>';
  	html += '<option value="months">months</option>';
  	html += '</select>';
  	html += '<br>';
  	html += '<div id="week_days_container" class="">';
  	html += '<input type="checkbox" style="margin-right: 5px;" id="day_1" onchange="dayCheckChanged(this);" checked><span style="margin-right: 15px;" id="day_label_1">Mo</span></input>';
	html += '<input type="checkbox" style="margin-right: 5px;" id="day_2" onchange="dayCheckChanged(this);"><span style="margin-right: 15px;" id="day_label_2">Tu</span></input>';
	html += '<input type="checkbox" style="margin-right: 5px;" id="day_3" onchange="dayCheckChanged(this);"><span style="margin-right: 15px;" id="day_label_3">We</span></input>';
	html += '<input type="checkbox" style="margin-right: 5px;" id="day_4" onchange="dayCheckChanged(this);"><span style="margin-right: 15px;" id="day_label_4">Th</span></input>';
	html += '<input type="checkbox" style="margin-right: 5px;" id="day_5" onchange="dayCheckChanged(this);"><span style="margin-right: 15px;" id="day_label_5">Fr</span></input>';
	html += '<input type="checkbox" style="margin-right: 5px;" id="day_6" onchange="dayCheckChanged(this);"><span style="margin-right: 15px;" id="day_label_6">Sa</span></input>';
	html += '<input type="checkbox" style="margin-right: 5px;" id="day_7" onchange="dayCheckChanged(this);"><span style="margin-right: 15px;" id="day_label_7">Su</span></input>';
  	html += '</div>';
  	html += '<br>';
  	html += '<span>Starts</span><div class="input-control text full-size" data-role="datepicker">';
  	html += '	<input  id="shift_date_start" type="text" value="" onchange="updateCustomRepeatingShiftName()">';
  	html += '<button class="button"><span class="mif-calendar"></span></button></div>';
  	html += '<br>';
  	html += '<span>Ends</span><div class="input-control text full-size" data-role="datepicker">';
  	html += '	<input id="shift_date_end" type="text" value="">';
  	html += '<button class="button"><span class="mif-calendar"></span></button></div>';

	currentAddCustomRepeatingShiftDialog = $('#select_repeating_shifts_dialog').data('dialog');
	html += '<button class="button success" onclick="addCustomRepeatingShift()">Add</button>'; 
	$(html).appendTo('#select_custom_repeating_shifts_container');
	numeric();//app.js
	$('.timepicker').wickedpicker(timePickerOptions);
	currentAddCustomRepeatingShiftDialog.open();
}

var currentAddCustomRepeatingDayOffDialog;
function showAddCustomRepeatingDayOff(){
	custom_repeating_type = 'day_off';
	var html = '';
	$('#select_custom_repeating_day_offs_container').html('');
	
	html += '<label>Day Off Description</label>';
	html += '<div class="input-control text full-size">';
	html += '<input maxlength="255" id="day_off_name" type="text" required="required"  class="" value="'+$('#full_name').html()+'">';
	html += '</div>';
	html += '<br>';
	
  	html += '<span>Repeat Every:</span> ';
  	html += '<br>';
  	html += '<input type="text" id="every_count" class="numeric input-control" style="width: 50px;" value="1" onchange="updateCustomRepeatingShiftName();">';
  	html += '&nbsp;<select id="every" class="input-control" onchange="everyChanged();"><option value="days">days</option>';
  	html += '<option value="weeks" selected>weeks</option>';
  	html += '<option value="months">months</option>';
  	html += '</select>';
  	html += '<br>';
  	html += '<div id="week_days_container" class="">';
  	html += '<input type="checkbox" style="margin-right: 5px;" id="day_1" onchange="dayCheckChanged(this);" checked><span style="margin-right: 15px;" id="day_label_1">Mo</span></input>';
	html += '<input type="checkbox" style="margin-right: 5px;" id="day_2" onchange="dayCheckChanged(this);"><span style="margin-right: 15px;" id="day_label_2">Tu</span></input>';
	html += '<input type="checkbox" style="margin-right: 5px;" id="day_3" onchange="dayCheckChanged(this);"><span style="margin-right: 15px;" id="day_label_3">We</span></input>';
	html += '<input type="checkbox" style="margin-right: 5px;" id="day_4" onchange="dayCheckChanged(this);"><span style="margin-right: 15px;" id="day_label_4">Th</span></input>';
	html += '<input type="checkbox" style="margin-right: 5px;" id="day_5" onchange="dayCheckChanged(this);"><span style="margin-right: 15px;" id="day_label_5">Fr</span></input>';
	html += '<input type="checkbox" style="margin-right: 5px;" id="day_6" onchange="dayCheckChanged(this);"><span style="margin-right: 15px;" id="day_label_6">Sa</span></input>';
	html += '<input type="checkbox" style="margin-right: 5px;" id="day_7" onchange="dayCheckChanged(this);"><span style="margin-right: 15px;" id="day_label_7">Su</span></input>';
  	html += '</div>';
  	html += '<br>';
  	html += '<span>Starts</span><div class="input-control text full-size" data-role="datepicker">';
  	html += '	<input  id="day_off_date_start" type="text" value="" onchange="updateCustomRepeatingShiftName()">';
  	html += '<button class="button"><span class="mif-calendar"></span></button></div>';
  	html += '<br>';
  	html += '<span>Ends</span><div class="input-control text full-size" data-role="datepicker">';
  	html += '	<input id="day_off_date_end" type="text" value="">';
  	html += '<button class="button"><span class="mif-calendar"></span></button></div>';

  	currentAddCustomRepeatingDayOffDialog = $('#select_repeating_day_offs_dialog').data('dialog');
	html += '<button class="button success" onclick="addCustomRepeatingDayOff()">Add</button>'; 
	$(html).appendTo('#select_custom_repeating_day_offs_container');
	numeric();//app.js
	console.log(timePickerOptions);
	$('.timepicker').wickedpicker(timePickerOptions);
	currentAddCustomRepeatingDayOffDialog.open();
}

var custom_repeating_type;
function updateCustomRepeatingShiftName(){
	var name = '';
	if(!$('#week_days_container').hasClass('hidden')){
		$.each( $("[id^=day_]"), function( key, checkbox ) {
			if($(checkbox).prop('checked'))
				name += $('#day_label_'+$(checkbox).prop('id').replace('day_', '')).html() + ', ';
		});
	}
	else{
		name += $('#'+custom_repeating_type+'_date_start').val() + ' ';
	}
	var every_count = parseInt($('#every_count').val());
	var every = $('#every').val();
	if(every_count==1)
		every = every.substring(0, every.length -1);
	name += 'every ' + every_count + ' ' + every;
	$('#'+custom_repeating_type+'_name').val(name);
}

function dayCheckChanged(e){
	console.log($(e).prop('checked'));
	if(!$(e).prop('checked')){//if unchecking
		var hasOneChecked = false;
		$.each( $("[id^=day_]"), function( key, checkbox ) {
			if($(checkbox).prop('checked'))
				hasOneChecked = true;
		});
		if(!hasOneChecked)//prevent uncheking
			$(e).prop('checked', true);
	}
	updateCustomRepeatingShiftName();
}

function everyChanged(){
	if($('#every').val()=='weeks'){
		$('#week_days_container').removeClass('hidden');
	}
	else{
		$('#week_days_container').addClass('hidden');
	}
	updateCustomRepeatingShiftName();
}

function addCustomRepeatingShift()
{
	var shift_start = $('#shift_start').val();
	var shift_name = $('#shift_name').val();
	var shift_end = $('#shift_end').val();
	var every_count = $('#every_count').val();
	var every = $('#every').val();
	var shift_date_start = $('#shift_date_start').val();
	var shift_date_end = $('#shift_date_end').val();
	
	var error = '';
	//validate
	if(shift_start=='')
		error += 'Start Time is required. \n'
	if(shift_end=='')
		error += 'End Time is required. \n'
	if(every_count=='' || every_count<1)
		error += 'Repeat Every is required. \n'
	if(shift_date_start=='')
		error += 'Start Date is required. \n'
			
	if(error==''){
		var data = "";
	    data += "user_id="+user_id;
	    data += "&shift_name="+shift_name;
	    data += "&shift_start="+shift_start;
	    data += "&shift_end="+shift_end;
	    data += "&every_count="+every_count;
	    data += "&every="+every;
	    data += "&shift_date_start="+shift_date_start;
	    data += "&shift_date_end="+shift_date_end;
	    for(var i = 1; i<=7; i++){
	    	data += "&day_"+i+"="+$('#day_'+i).prop('checked');
	    }
	    $.ajax({
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
				userRepeatedShifts = JSON.parse(data.userRepeatedShifts);
				buildUsersCustomRepeatingShifts();
				buildMonth(currentMonth, currentYear);
			},
			type : "POST",
			url : webroot+"users/addCustomRepeatingShift"
		});
		$('#select_custom_repeating_shifts_container').html('');
		currentAddCustomRepeatingShiftDialog.close();
	}//if(error==''){
	else{
		alert(error);
	}
}

function addCustomRepeatingDayOff()
{
	var day_off_name = $('#day_off_name').val();
	var every_count = $('#every_count').val();
	var every = $('#every').val();
	var day_off_date_start = $('#day_off_date_start').val();
	var day_off_date_end = $('#day_off_date_end').val();
	
	var error = '';
	//validate
	if(every_count=='' || every_count<1)
		error += 'Repeat Every is required. \n'
	if(day_off_date_start=='')
		error += 'Start Date is required. \n'
			
	if(error==''){
		var data = "";
	    data += "user_id="+user_id;
	    data += "&day_off_name="+day_off_name;
	    data += "&every_count="+every_count;
	    data += "&every="+every;
	    data += "&day_off_date_start="+day_off_date_start;
	    data += "&day_off_date_end="+day_off_date_end;
	    for(var i = 1; i<=7; i++){
	    	data += "&day_"+i+"="+$('#day_'+i).prop('checked');
	    }
	    $.ajax({
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
				userRepeatedDayOffs = JSON.parse(data.userRepeatedDayOffs);
				buildUsersCustomRepeatingDayOffs();
				buildMonth(currentMonth, currentYear);
			},
			type : "POST",
			url : webroot+"users/addCustomRepeatingDayOff"
		});
		$('#select_custom_repeating_day_offs_container').html('');
		currentAddCustomRepeatingDayOffDialog.close();
	}//if(error==''){
	else{
		alert(error);
	}
}

function removeCustomRepeatingShift(custom_repeating_shift_id){
	var data = "";
    data += "user_id="+user_id;
    data += "&custom_repeating_shift_id="+custom_repeating_shift_id;
    $.ajax({
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
			userRepeatedShifts = JSON.parse(data.userRepeatedShifts);
			buildUsersCustomRepeatingShifts();
			buildMonth(currentMonth, currentYear);
		},
		type : "POST",
		url : webroot+"users/removeCustomRepeatingShift"
	});
}

function removeCustomRepeatingDayOff(custom_repeating_day_off_id){
	var data = "";
    data += "user_id="+user_id;
    data += "&custom_repeating_day_off_id="+custom_repeating_day_off_id;
    $.ajax({
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
			userRepeatedDayOffs = JSON.parse(data.userRepeatedDayOffs);
			buildUsersCustomRepeatingDayOffs();
			buildMonth(currentMonth, currentYear);
		},
		type : "POST",
		url : webroot+"users/removeCustomRepeatingDayOff"
	});
}

var currentAddSpecialShiftsDialog;
function showAddSpecialShifts(){
	custom_repeating_type = 'shift';
	var html = '';
	$('#select_special_shifts_container').html('');
	html += '';
	html += '<label>Shift Description</label>';
	html += '<div class="input-control text full-size">';
	html += '<input maxlength="255" id="shift_name" type="text" required="required"  class="" value="Special Shift - '+$('#full_name').html()+'">';
	html += '</div>';
	html += '<br>';
	html += '<label>Start Time</label>';
	html += '<div class="input-control text full-size">';
	html += '<input maxlength="255" id="shift_start" type="text" required="required"  class="timepicker" >';
	html += '</div>';
	html += '<br>';
	html += '<label>End Time</label>';
	html += '<div class="input-control text full-size" >';
	html += '<input maxlength="255" id="shift_end" type="text" required="required"  class="timepicker">';
	html += '</div>';
	html += '<br>';
	html += '<div style="height: 300px;">';
	html += '<span>Date/s</span><div id="shift_dates_calendar" data-role="calendar" data-multi-select="true" >';
  	html += '<button class="button"><span class="mif-calendar"></span></button></div>';
  	html += '</div>';
  	html += '<br>';

  	currentAddSpecialShiftsDialog = $('#select_special_shifts_dialog').data('dialog');
	html += '<button class="button success" onclick="addSpecialShifts()">Add Shift</button>'; 
	$(html).appendTo('#select_special_shifts_container');
	numeric();//app.js
	$('.timepicker').wickedpicker(timePickerOptions);
	currentAddSpecialShiftsDialog.open();
}

var calendarResults
function addSpecialShifts(){
	var name = $('#full_name').html() + ' - ';
	name += $('#shift_start').val() + ' to ' + $('#shift_end').val();
	console.log(name);
	
	$('#'+custom_repeating_type+'_name').val(name);
    var selectedDates = $("#shift_dates_calendar").calendar('getDates');
    
    var shift_name = $('#'+custom_repeating_type+'_name').val();
    var shift_start = $('#shift_start').val();
    var shift_end = $('#shift_end').val();
    //validate
    var error = '';
    if(shift_name == "")
    	error += 'Shift name is required. \n'
	if(shift_start=='')
		error += 'Start Time is required. \n'
	if(shift_end=='')
		error += 'End Time is required. \n'		
	if(selectedDates.length<1)
		error += 'Date is required. \n'		
			
	if(error==''){
		var data = "";
	    data += "user_id="+user_id;
	    data += "&shift_name="+shift_name;
	    data += "&shift_start="+shift_start;
	    data += "&shift_end="+shift_end;
	    $.each( selectedDates, function( key, selectedDate ) {
	    	 data += "&dates[]="+selectedDate;
	    });
	    data += "&current_month="+currentMonth;
	    data += "&current_year="+currentYear;
	   
	    $.ajax({
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
				userSpecialShifts = JSON.parse(data.userSpecialShifts);
				buildUserSpecialShifts();
				buildMonth(currentMonth, currentYear);
			},
			type : "POST",
			url : webroot+"users/addSpecialShifts"
		});
		$('#select_special_shifts_container').html('');
		currentAddSpecialShiftsDialog.close();
	}
	else{
		alert(error);
	}	
}

function removeSpecialShift(special_shift_id){
	var data = "";
    data += "user_id="+user_id;
    data += "&special_shift_id="+special_shift_id;
    data += "&current_month="+currentMonth;
    data += "&current_year="+currentYear;
    $.ajax({
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
			userSpecialShifts = JSON.parse(data.userSpecialShifts);
			buildUserSpecialShifts();
			buildMonth(currentMonth, currentYear);
		},
		type : "POST",
		url : webroot+"users/removeSpecialShift"
	});
}

var currentAddSpecialDayOffsDialog;
function showAddSpecialDayOffs(){
	custom_repeating_type = 'day_off';
	var html = '';
	$('#select_special_day_offs_container').html('');
	html += '';
	html += '<label>Day Off Description</label>';
	html += '<div class="input-control text full-size">';
	html += '<input maxlength="255" id="day_off_name" type="text" required="required"  class="" value="Special Day Off - '+$('#full_name').html()+'">';
	html += '</div>';
	html += '<br>';
	html += '<div style="height: 300px;">';
	html += '<span>Date/s</span><div id="shift_dates_calendar" data-role="calendar" data-multi-select="true" >';
  	html += '<button class="button"><span class="mif-calendar"></span></button></div>';
  	html += '</div>';
  	html += '<br>';

  	currentAddSpecialDayOffsDialog = $('#select_special_day_offs_dialog').data('dialog');
	html += '<button class="button success" onclick="addSpecialDayOffs()">Add Day Off</button>'; 
	$(html).appendTo('#select_special_day_offs_container');
	numeric();//app.js
	$('.timepicker').wickedpicker(timePickerOptions);
	currentAddSpecialDayOffsDialog.open();
}

function addSpecialDayOffs(){
	var name = $('#full_name').html() + ' - ';
	
    var selectedDates = $("#shift_dates_calendar").calendar('getDates');
    
    var day_off_name = $('#'+custom_repeating_type+'_name').val();
    //validate
    var error = '';
    if(day_off_name == "")
    	error += 'Day off name is required. \n'
	if(selectedDates.length<1)
		error += 'Date is required. \n'		
			
	if(error==''){
		var data = "";
	    data += "user_id="+user_id;
	    data += "&day_off_name="+day_off_name;
	    $.each( selectedDates, function( key, selectedDate ) {
	    	 data += "&dates[]="+selectedDate;
	    });
	    data += "&current_month="+currentMonth;
	    data += "&current_year="+currentYear;
	   
	    $.ajax({
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
				userSpecialDayOffs = JSON.parse(data.userSpecialDayOffs);
				buildUserSpecialDayOffs();
				buildMonth(currentMonth, currentYear);
			},
			type : "POST",
			url : webroot+"users/addSpecialDayOffs"
		});
		$('#select_special_day_offs_container').html('');
		currentAddSpecialDayOffsDialog.close();
	}
	else{
		alert(error);
	}	
}

function removeSpecialDayOff(special_day_off_id){
	var data = "";
    data += "user_id="+user_id;
    data += "&special_day_off_id="+special_day_off_id;
    data += "&current_month="+currentMonth;
    data += "&current_year="+currentYear;
    $.ajax({
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
			userSpecialDayOffs = JSON.parse(data.userSpecialDayOffs);
			buildUserSpecialDayOffs();
			buildMonth(currentMonth, currentYear);
		},
		type : "POST",
		url : webroot+"users/removeSpecialDayOff"
	});
}