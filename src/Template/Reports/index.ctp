<div>
    <div class="grid">
        <div class="row cells2">
            <div class="cell">
            	<div class="panel" style="z-index: 99; width: 200px;"><!-- Date Range Panel -->
				    <div class="heading">
				        <span class="title">Date Range</span>
				    </div>
				    <div class="content" style="padding: 10px;">
				       <span>From:</span>
						<div class="input-control text full-size" data-role="datepicker">
						  	<input  id="date_from" type="text" value="" onchange="" value="2016.06.01">
						  	<button class="button"><span class="mif-calendar"></span></button>
					  	</div>
					  	<span>To:</span>
						<div class="input-control text full-size" data-role="datepicker">
						  	<input  id="date_to" type="text" value="" onchange=""  value="2016.06.15">
						  	<button class="button"><span class="mif-calendar"></span></button>
					  	</div>
				    </div>
			</div>
            </div><!-- Cell 1 -->
            <div class="cell">
            	<div  style="width: 400px;">
					<button class="button small-button warning" onclick="openCreator()">Open Report Creator</button>
				</div>
            </div><!-- Cell 2 -->
        </div>
    </div>
</div>


<div class="panel" style="width: 600px;"><!-- Employees Range Panel -->
    <div class="heading">
        <span class="title">Employees</span>
    </div>
    <div class="content" style="padding: 10px; ">
       <table class="dataTable striped hovered border bordered" data-role="datatable" data-auto-width="false" data-searching="true" data-paging="false">
			<thead>
				<tr>
					<th>Name</th>
					<th>Department</th>
					<th>Position</th>
					<th>Agency</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($users as $user): ?>
					<tr style="cursor: pointer;" onclick="selectUser(<?= $user->id?>)" id="user_row_<?= $user->id?>">
						<td id="user_fullname_<?=$user->id?>"><?= h($user->person->last_name) .', '. h($user->person->first_name) ?></td>
						<td><?=isset($departmentList[$user->person->department_id])?$departmentList[$user->person->department_id]:''?></td>
						<td><?=isset($positionList[$user->person->position_id])?$positionList[$user->person->position_id]:''?></td>
						<td><?=isset($agencyList[$user->person->agency_id])?$agencyList[$user->person->agency_id]:''?></td>
						<td><?=$user->status?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
    </div>
</div>



<style>
.table th {padding: 5px;}
.table {font-size: 12px;}
.dataTable {font-size: 12px;}
</style>

<script>
	$(document).ready(function(){
		$( "input[aria-controls='DataTables_Table_0']" ).bind( "click", function() {
			  //alert( "User clicked on 'foo.'" );
			  selectUser(0);
			});
	});

	var date_from = "";
	var date_to = "";
	var user_id = 0;
	function selectUser(id){
		$("[id^=user_row_]").removeClass('bg-grayDark fg-white');
		$('#user_row_'+id).addClass('bg-grayDark fg-white');
		user_id =id;
	}

	function openCreator(){
		date_from = $('#date_from').val();
		date_to = $('#date_to').val();
		
		var message = "";
		if(date_from == "")
			message += "Select Date From \n";

		if(date_to == "")
			message += "Select Date To \n";

		if(user_id == 0)
			message += "Select User/Employee \n";

		/* console.log(getDate(date_from));
		console.log( getDate(date_from).getTime()); */
		if( getDate(date_from).getTime() > getDate(date_to).getTime()){
			message += "Invalid Date Range \n";
		}
		
		if(message == ""){
			//ajaxGetPunchLogs(date_from, date_to, user_id).done(buildPunchLogsTable);
			var url = webroot +'reports/report_creator/'+user_id+'/'+date_from+'/'+date_to;
			var win = window.open(url, '_blank');
			if (win) {
			    //Browser has allowed it to be opened
			    win.focus();
			} else {
			    //Browser has blocked it
			    alert('Please allow popups for this website');
			}
		}else{
			alert(message);
		}
	}

	function buildPunchLogsTable(data){
		$('#punch_logs_table_body').html("");
		var dates = $.parseJSON(data.dates);
		var row = "";
		
		$.each(dates, function(logs_key, logs) {
			//console.log(logs_key + ' is ' + logs);
			row += "<tr>";
			row += "<td colspan=2>";
			row += logs_key;
			row += "</td>";
			row += "<td>";
			d = new Date(logs['first_in']['log_created'].replace('0000', '0800'));
			console.log(logs['first_in']['log_created']);
			row +=d.toLocaleTimeString('en-GB');
			row += "</td>";
		    //display the key and value pair
		    
		   /*  $.each(logs, function(log_key, log) {
			    //display the key and value pair
			    console.log(log_key + ' = ' + log['id']);
			    
			}); */
		    row += "</tr>";
		   
		});
		 $(row).appendTo('#punch_logs_table_body');
	}

	function ajaxGetPunchLogs(from, to, user_id){
		var data = "";
		data += "from="+from;
		data += "&to="+to;
		data += "&user_id="+user_id;
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
			url : webroot+'reports/ajaxGetPunchLogs'
		});
	}
	//util
	function getDate(dateStr){
		dateStrArr = dateStr.split('.');
		/* console.log(dateStrArr[0]);
		console.log(parseInt(dateStrArr[1])-1);
		console.log(parseInt(dateStrArr[2])+1); */
		var d = new Date(dateStrArr[0],(parseInt(dateStrArr[1])-1), (parseInt(dateStrArr[2])+1));
		return d;
	}
</script>