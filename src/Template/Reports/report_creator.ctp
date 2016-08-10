<form id="invisible_form" action="x" method="post" target="_blank">
<div style="float: left;">
	<span>Employee: <?= h($user->person->last_name) .', '. h($user->person->first_name) ?></span>
	<input type="hidden" name="user_id" value="<?=  $user->id ?>"/>
	<input type="hidden" name="first_name" value="<?=  h($user->person->first_name) ?>"/>
	<input type="hidden" name="last_name" value="<?= h($user->person->last_name) ?>"/>
	<br/>
	<span>Period: <?= d($dateFrom).' to '. d($dateTo) ?></span>
	<input type="hidden" name="date_from" value="<?= $dateFrom  ?>"/>
	<input type="hidden" name="date_to" value="<?= $dateTo  ?>"/>
</div>
<div style="float: right;">
	<button class="button small-button warning" onclick="generateReport('csv')">Generate CSV</button>
	<!-- &nbsp;<button class="button small-button warning" onclick="generateReport('pdf')">Generate PDF</button> -->
</div>

<table id="punch_logs_table" class="table striped hoveorange  border " >
	<thead>
		<tr>
			<th rowspan="2" style="width: 60px;"></th>
			<th rowspan="2" style="width: 80px;">Date</th>
			<th rowspan="2"  style="width: 90px;">Shift</th>
			<th colspan="2" >Morning</th>
			<th colspan="2">Afternoon</th>
			<th rowspan="2"  style="width: 60px;">Lates <br/>(mins.)</th>
			<th colspan="2">Overtime</th>
			<th rowspan="2"  style="width: 60px;"># of <br/>hours OT</th>
			<th rowspan="2">Reason For OT</th>
		</tr>
		<tr>
			<!-- Morning -->
			<th class="log-in"  style="width: 60px;">Time In</th>
			<!-- <th  class="log-out">Break Out</th><th class="log-in">Break In</th> -->
			<th class="log-out"  style="width: 60px;">Time Out</th>
			<!-- Afternoon -->
			<th class="log-in"  style="width: 60px;">Time In</th>
			<!-- <th class="log-out">Break Out</th><th class="log-in">Break In</th> -->
			<th class="log-out"  style="width: 60px;">Time Out</th>
			
			<th  style="width: 60px;">Start</th>
			<th  style="width: 60px;">End</th>
		</tr>
	</thead>
	<tbody id="punch_logs_table_body">
		<?php $dateCount = 0;?>
		<?php foreach ($dates as $dateKey => $punchLogs):?>
			<?php $dateCount++;?>
		<tr onclick="selectDate('<?=$dateKey?>')" id="date_row_<?=$dateKey?>">
			<td></td><td id="date_label_<?=$dateKey?>"><?=d($dateKey)?></td>
			<td id="shift_<?=$dateKey?>"></td> <input type="hidden" name="shift_<?=$dateKey?>" id="input_shift_<?=$dateKey?>" value=""/>
			<!-- Morning: Time in -->
			<td >
				<?php if(count($punchLogs)>0):?>
					<select class="time-select" id="select_<?=$dateKey?>_first_in" name="<?=$dateKey?>_first_in" style="color: green;" onchange="selectPunchLog(this);">
						<option value="0"></option>
						<?php foreach ($punchLogs as $punchLog):?>
							<?php if($punchLog->is_log_in):?>
								<option value="<?=$punchLog->id?>"><?=$punchLog->log_created->format('H:i') ;?></option>
							<?php endif;?>
						<?php endforeach;?>
					</select>
				<?php endif;?>
			</td>
			<!-- Morning: Break  out -->
			<!-- 
			<td>
				<?php if(count($punchLogs)>0):?>
					<select class="time-select">
						<option value="0"></option>
						<?php foreach ($punchLogs as $punchLog):?>
							<?php if(!$punchLog->is_log_in):?>
								<option value="<?=$punchLog->id?>"><?=$punchLog->log_created->format('H:i') ;?></option>
							<?php endif;?>
						<?php endforeach;?>
					</select>
				<?php endif;?>
			</td>
			<td>
				<?php if(count($punchLogs)>0)://Morning: Break in?>
					<select class="time-select">
						<option value="0"></option>
						<?php foreach ($punchLogs as $punchLog):?>
							<?php if($punchLog->is_log_in):?>
								<option value="<?=$punchLog->id?>"><?=$punchLog->log_created->format('H:i') ;?></option>
							<?php endif;?>
						<?php endforeach;?>
					</select>
				<?php endif;?>
			</td>
			 -->
			 <!-- Morning: Time  out -->
			<td>
				<?php if(count($punchLogs)>0):?>
					<select class="time-select" id="select_<?=$dateKey?>_first_out" name="<?=$dateKey?>_first_out"  style="color: orange;" onchange="selectPunchLog(this);">
						<option value="0"></option>
						<?php foreach ($punchLogs as $punchLog):?>
							<?php if(!$punchLog->is_log_in):?>
								<option value="<?=$punchLog->id?>"><?=$punchLog->log_created->format('H:i') ;?></option>
							<?php endif;?>
						<?php endforeach;?>
					</select>
				<?php endif;?>
			</td>
			<!-- Afternoon: Time in -->
			<td>
				<?php if(count($punchLogs)>0):?>
					<select class="time-select" id="select_<?=$dateKey?>_second_in"  name="<?=$dateKey?>_second_in" style="color: green;" onchange="selectPunchLog(this);">
						<option value="0"></option>
						<?php foreach ($punchLogs as $punchLog):?>
							<?php if($punchLog->is_log_in):?>
								<option value="<?=$punchLog->id?>"><?=$punchLog->log_created->format('H:i') ;?></option>
							<?php endif;?>
						<?php endforeach;?>
					</select>
				<?php endif;?>
			</td>
			<!-- 
			<td>
				<?php if(count($punchLogs)>0)://Afternoon: Break  out?>
					<select class="time-select">
						<option value="0"></option>
						<?php foreach ($punchLogs as $punchLog):?>
							<?php if(!$punchLog->is_log_in):?>
								<option value="<?=$punchLog->id?>"><?=$punchLog->log_created->format('H:i') ;?></option>
							<?php endif;?>
						<?php endforeach;?>
					</select>
				<?php endif;?>
			</td>
			<td>
				<?php if(count($punchLogs)>0)://Afternoon: Break in?>
					<select class="time-select">
						<option value="0"></option>
						<?php foreach ($punchLogs as $punchLog):?>
							<?php if($punchLog->is_log_in):?>
								<option value="<?=$punchLog->id?>"><?=$punchLog->log_created->format('H:i') ;?></option>
							<?php endif;?>
						<?php endforeach;?>
					</select>
				<?php endif;?>
			</td>
			-->
			<!-- Afternoon: Time  out -->
			<td>
				<?php if(count($punchLogs)>0):?>
					<select class="time-select" id="select_<?=$dateKey?>_last_out" name="<?=$dateKey?>_last_out" style="color: orange;" onchange="selectPunchLog(this);">
						<option value="0"></option>
						<?php foreach ($punchLogs as $punchLog):?>
							<?php if(!$punchLog->is_log_in):?>
								<option value="<?=$punchLog->id?>"><?=$punchLog->log_created->format('H:i') ;?></option>
							<?php endif;?>
						<?php endforeach;?>
					</select>
				<?php endif;?>
			</td>
			<td ><input style="width: 50px;" id="late_minutes_<?=$dateKey?>" name="late_minutes_<?=$dateKey?>" onchange="computeLateTotal();"/></td>
			<td id="ot_start_<?=$dateKey?>"></td><input type="hidden" id="input_ot_start_<?=$dateKey?>" name="input_ot_start_<?=$dateKey?>"/>
			<td id="ot_end_<?=$dateKey?>"></td><input type="hidden" id="input_ot_end_<?=$dateKey?>" name="input_ot_end_<?=$dateKey?>"/>
			<td ><input style="width: 50px;" id="ot_hours_<?=$dateKey?>" name="ot_hours_<?=$dateKey?>" onchange="computeOTTotal();"/></td>
			<td ><input id="ot_reason_<?=$dateKey?>"  name="ot_reason_<?=$dateKey?>" style="width: 390px;" /></td>
		</tr>
		<?php endforeach;?>
	</tbody>
	<tfoot>
		<td>Totals:</td><td><?=$dateCount?> days</td>							<input type="hidden" value="<?=$dateCount?>" name="input_days_total"/>
		<td colspan="5" style="text-align: right;">Total Lates:</td>
		<td id="lates_total"></td>																		<input type="hidden" id="input_lates_total" name="input_lates_total"/>
		<td colspan="2" style="text-align: right;">Total Overtimes:</td>	<input type="hidden"  id="input_ot_total" name="input_ot_total"/>
		<td id="ot_total" colspan="2"></td>
	</tfoot>
</table>
<div id="punch_logs_container">

</div>
<!-- Hidden -->
<div id="punch_logs_hidden_table" style="display: none;">
	<table class="table striped hoveorange  border bordeorange" style="width: 200px;">
		<thead>
			<tr><th colspan="2">Date: <span id="punch_logs_date"></span></th></tr>
			<tr><th>Time</th><th>Type</th></tr>
		</thead>
		<tbody id="punch_logs_table_tbody">
			
		</tbody>
	</table>
</div>
  <input id="file_format" name="file_format" type="hidden" value="default">
</form>
<style>
#punch_logs_table {text-align: center;}
.table thead th {padding: 5px; text-align: center;}
.table tbody td {padding:5px; }
.table tfoot td {padding:5px; }
.table {font-size: 12px;}
.dataTable {font-size: 12px;}
.time-select{width: 60px;}
.log-in{color: green !important;}
.log-out{color: orange !important;}
</style>

<script>
	var dates = <?= $datesJSON;?>;
	var filledDates = <?= $filledDates;?>;
	var dateShifts = <?= $dateShifts;?>;
	$(document).ready(function(){
		//buildPunchLogsTable('2016-06-29');
		setDefaults();
		$.each(dates, function(date, log) {
			computeLate(date);
			populateOvertimes(date);
		});
	});

	var shiftStarts = new Object();
	var shiftEnds = new Object();

	function isMorningShift(date){//1=true;0=false;-1=full shift
		
		if(typeof dateShifts[date]['shifts'] != 'undefined'){
			var isFullShift = 1;
			if(typeof dateShifts[date]['shifts'][0]['standard_shift'] != 'undefined'){
				isFullShift = dateShifts[date]['shifts'][0]['standard_shift']['is_full_shift'];
			}
			else
			{
				isFullShift = dateShifts[date]['shifts'][0]['is_full_shift'];
			}
			
			if(isFullShift == 1){
				return -1;
			}
			else{
				if(dateShifts[date]['shifts'][0]['standard_shift']['name'].toLowerCase().indexOf('morning') > -1){
					return 1;
				}
				else{
					return 0;
				}
			}
		}
		return -1;
	}	
	
	function setDefaults(){
		$.each(filledDates, function(date, log) {
			
			if(typeof log['first_in'] != 'undefined')
				$("#select_"+date+"_first_in").val(log['first_in']['id']);
			if(isMorningShift(date) == -1){
				if(typeof log['first_out'] != 'undefined')
					$("#select_"+date+"_first_out").val(log['first_out']['id']);
				if(typeof log['second_in'] != 'undefined')
					$("#select_"+date+"_second_in").val(log['second_in']['id']);
				if(typeof log['last_out'] != 'undefined')
					$("#select_"+date+"_last_out").val(log['last_out']['id']);
			}
			else{
				if(typeof log['last_out'] != 'undefined')
					$("#select_"+date+"_first_out").val(log['last_out']['id']);
				if(isMorningShift(date) == 1){
					$( "#select_"+date+"_second_in" ).remove();
					$( "#select_"+date+"_last_out" ).remove();
				}else{
					$( "#select_"+date+"_first_in" ).remove();
					$( "#select_"+date+"_first_out" ).remove();
				}
			}
			
			
		});
		//shifts column
		$.each(dateShifts, function(date, shift) {
			var color = 'DarkCyan';
			var html = '';
			var text = '';
			if(typeof shift['day_off'] != 'undefined'){
				color = 'red';
				text = 'Day Off';
			}
			else if(typeof shift['shifts'] != 'undefined'){
				//console.log(shift['shifts'][0]);
				var shift_obj = null;
				if(typeof shift['shifts'][0]['standard_shift'] != 'undefined'){
					shift_obj = shift['shifts'][0]['standard_shift'];
				}
				else{
					shift_obj = shift['shifts'][0];
				}
				var from = moment(shift_obj['start']).utcOffset(0).format("HH:mm");
				shiftStarts[date] = from;
				var to = moment(shift_obj['end']).utcOffset(0).format("HH:mm");
				shiftEnds[date] = to;
				text +=from+' - '+to;
			}
			else{
				text = '-';
			}
			html += '<span style="color: '+color+'">';
			html += text;
			html += '</span>';
			$('#shift_'+date).html(html);
			$('#input_shift_'+date).val(text);
		});
	}
	
	function selectDate(date){
		$("[id^=date_row_]").removeClass('bg-grayDark fg-white');
		$('#date_row_'+date).addClass('bg-grayDark fg-white');
		buildPunchLogsTable(date);
	}
	
	function buildPunchLogsTable(date){//raw punch logs
		$('#punch_logs_container').html('');
		 $('#punch_logs_table_tbody').html('');
		 
		$('#punch_logs_date').html($('#date_label_'+date).html());
		var row = '';
		$.each(dates[date], function(logs_key, log) {
			var color = 'orange';
			var type = 'Out';
			if(log['is_log_in']){
				type = 'In';
				color = 'green';
			}
				
			row += "<tr style='color:"+color+"'>";
			row += "<td>";
			//d = new Date(log['log_created'].replace('0000', '0800'));
			row += moment(log['log_created']).utcOffset(0).format("HH:mm");
			//row += logs_key;
			row += "</td>";
			row += "<td>";
			
			row += type;
			row += "</td>";
		    row += "</tr>";
		});
		
		 $(row).appendTo('#punch_logs_table_tbody');
		 $( $('#punch_logs_hidden_table').html()).appendTo('#punch_logs_container');
	}

	function selectPunchLog(select){
		var select_id = $(select).attr('id');
		var select_val = $(select).val();
		var date = select_id.substring(select_id.indexOf("_")+1, select_id.length);
		date = date.substring(0, date.indexOf("_"));

		repopulateSelects(date, select_id, select_val);
		if(select_id.indexOf('_first_in')!=-1){
			computeLate(date);
		}
		else if(select_id.indexOf('_last_out')!=-1){
			populateOvertimes(date);
		}
	}

	function repopulateSelects(date, select_id, punchLog_id){
		var zone = "America/Los_Angeles";
		//console.log(date);
		//console.log(select_id);
		//console.log(punchLog_id);
		$('#date_row_'+date+'  select').each(function () { 
			if(this.id!=select_id){
				var is_in = true;
				if(this.id.indexOf('_in')==-1)
					is_in = false;
				
				var the_select = this;
				var selected_val = $(the_select).val();
				$(the_select).html('');//clear options
				var option = "<option></option>";
				if(0==selected_val)
					option = "<option selected></option>";
				$(the_select)
		         .append($(option)
		                    .attr("value",0)
		                    .text(''));
				$.each(dates[date], function(index, punchLog) {
					if(is_in == punchLog.is_log_in){
						option = "<option></option>";
						if(punchLog.id==selected_val)
							option = "<option selected></option>";
						var m = moment(punchLog.log_created).subtract(8, 'hours');
						if(punchLog_id!=punchLog.id){
							$(the_select)
					         .append($(option)
					                    .attr("value",punchLog.id)
					                    .text(m.format('HH:mm')));
						}
					}
				});
				/* $('#mySelect')
		         .append($("<option></option>")
		                    .attr("value",key)
		                    .text(value));  */
				
				/* console.log(this.id);
				console.log(this.value);
				console.log(is_in); */
				/* $('#'+this.id+' option').each(function () { 
					console.log(this.html);
				}); */
				
			}
			
		});
		
	}
	
	function computeLate(date){
		 if(typeof shiftStarts[date] != 'undefined'){
			 $('#late_minutes_'+date).val('');
			var shiftMins = toMinutes( shiftStarts[date]);
			var logMins =  toMinutes( $("#select_"+date+"_first_in option:selected").text());

			 var diff = logMins-shiftMins;
			 if(diff>0)
				 $('#late_minutes_'+date).val(diff);
			 
			 /* var d2 = new Date(date+' '+shiftStarts[date]);
			 var d1 = new Date(date+' '+$("#select_"+date+"_first_in option:selected").text());
			 console.log( d2);
			 console.log( d1); */
		 }
		 computeLateTotal();
	}

	function computeLateTotal(){
		var latesTotal = 0;
		$.each(dateShifts, function(date, shift) {
			var late =  $('#late_minutes_'+date).val();
			if(late!='')
				latesTotal += parseInt(late);
		});
		$('#lates_total').html(latesTotal + ' mins');
		$('#input_lates_total').val(latesTotal);
	}

	function populateOvertimes(date){
		if(typeof shiftEnds[date] != 'undefined'){
			 $('#ot_start_'+date).html('');
			 $("#ot_end_"+date).html('');
			
			$('#ot_hours_'+date).val('');
			var last_out =  $("#select_"+date+"_last_out option:selected").text();
			if(isMorningShift(date)==1){
				 last_out =  $("#select_"+date+"_first_out option:selected").text();
			}
			var shiftEnd = moment(shiftEnds[date], "hh:mm:ss").utcOffset(8);
			var lastOut = moment(last_out, "hh:mm:ss").utcOffset(8);
			//console.log(lastOut);
			//console.log(shiftEnd);
			
			//console.log(lastOut.format( "HH:mm:ss") +" - "+ shiftEnd.format( "HH:mm:ss") + " = " +shiftEnd.to(lastOut));
			console.log(lastOut.format( "HH:mm:ss") +" - "+ shiftEnd.format( "HH:mm:ss") + " = " +shiftEnd.diff(lastOut));
			//console.log();
			 if( last_out != '' && shiftEnd.diff(lastOut) < 0){
				 $('#ot_start_'+date).html(shiftEnds[date]);
				 $("#ot_end_"+date).html(last_out);
				 $('#input_ot_start_'+date).val(shiftEnds[date]);
				 $("#input_ot_end_"+date).val(last_out);
				 //compute OT
				var shiftMins = toMinutes( shiftEnds[date]);
				var logMins =  toMinutes( last_out);
				 var diff = logMins-shiftMins;
				 if(diff>0)
					 $('#ot_hours_'+date).val(parseFloat(diff/60).toFixed(2));
			 }
		}
		computeOTTotal();
	}

	function computeOTTotal(){
		var OTTotal = 0;
		$.each(dateShifts, function(date, shift) {
			var OT =  $('#ot_hours_'+date).val();
			if(OT!='')
				OTTotal += parseFloat(OT);
		});
		$('#ot_total').html(OTTotal.toFixed(2)+' hrs');
		$('#input_ot_total').val(OTTotal.toFixed(2));
	}

	function toMinutes(time){
		var split = time.split(':');
		var total = 0;
		if(split.length > 1){
			total = (parseInt(split[0])*60) + parseInt(split[1]);
		}
		return total;
	}

	function generateReport(file_format){
		$('#file_format').val(file_format);
		$('#invisible_form').attr('action',  webroot +'reports/generate_report_creator');
		$('#invisible_form').submit();
		
		/* var url = webroot +'reports/generate_report_creator';
		var data = "";
		$.post(url, function (data) {
			console.log(data);
		}); */
	}
</script>
