<div style="max-width: 700px;float: left;" >
	<table style="width: 500px;" class="dataTable striped hovered border bordered" data-role="datatable" data-auto-width="false" data-paging="false">
		<thead>
		<tr>
			<th>
				<label class="input-control checkbox small-check">
				    <input type="checkbox" onclick="toggleSelectAllTerminals(this);">
				    <span class="check"></span>
				</label>
			</th>
			<td>ID</td>
			<td>Status</td>
			<td>Code</td>
			<td>Name</td>
			<td>Version</td>
			<td>PIN</td>
		</tr>
		</thead>
		<tbody>
		<?php 
		foreach ($terminals as $terminal):
		?>
			<tr>
				<td>
						<label class="input-control checkbox small-check">
						    <input type="checkbox" id="terminal_checkbox_<?=$terminal['Terminal']['id']?>">
						    <span class="check"></span>
						</label>
					</td>
				<td>
					<?=$terminal['Terminal']['id']?>
				</td>
				<td>
					<?=$terminal['Terminal']['status']?>
				</td>
				<td>
					<?=$terminal['Terminal']['code']?>
				</td>
				<td>
					<?=$terminal['Terminal']['name']?>
				</td>
				<td>
					<?=$terminal['Terminal']['TerminalDetail']['version']?>
				</td>
				<td>
				    <span data-role="hint"
				    	data-hint-position="right"
				        data-hint-background="bg-green"
				        data-hint-color="fg-white"
				        data-hint-mode="2"
				        data-hint="PIN|<?=$terminal['Terminal']['TerminalDetail']['pin']?>""
				    >
    					<input style="width: 70px;" type="password" readonly="readonly" value="<?=$terminal['Terminal']['TerminalDetail']['pin']?>" alt=""/>
					</span>
					</td>
			</tr>
		<?php 
		endforeach;
		?>
		<tbody>
	</table>
	With selected: 	<button class="button small-button warning" onclick="showChangePIN(0)">Change PIN</button>
</div>
<!-- Hiddens -->
   <div style="width: auto; height: auto; visibility: hidden; " data-role="dialog" id="assign_locations_dialog" class="padding20 dialog" data-close-button="true" data-overlay="true" data-overlay-color="op-dark" data-overlay-click-close="true">
	    <h3>Change PIN</h3>
	    <div id="change_PIN_container">
	    	<!-- Locations selection -->
	    </div>
	</div>
<!-- end Hiddens -->
	
<script>
function toggleSelectAllTerminals(e){
	$.each( $("[id^=terminal_checkbox_]"), function( key, checkbox ) {
		$(checkbox).prop('checked', $(e).is(':checked'));
	});
}

var currentChangePINDialog;
function showChangePIN(user_id)
{
	var size = $("[id^=terminal_checkbox_]:checked").size();
	if(size>0){
		var html = '';
		html += '<div class="input-control text full-size">';
		html += ' <input maxlength="4" id="new_pin" placeholder="New PIN" class="numeric"/>';
		html += '</div>';
		html += '<button class="button success" onclick="changePIN()">Save</button>'; 
		$('#change_PIN_container').html('');
		currentChangePINDialog = $('#assign_locations_dialog').data('dialog');
		$(html).appendTo('#change_PIN_container');
		numeric();
		currentChangePINDialog.open();
	}
}

function changePIN(){
	var size = $("[id^=terminal_checkbox_]:checked").size();
	if(size>0){
		var data = "";
		data +=  'new_pin='+$('#new_pin').val()+'&';
		$.each( $("[id^=terminal_checkbox_]:checked"), function( key, checkbox ) {
			var id = $(checkbox).prop('id').replace('terminal_checkbox_', '');
			data += 'terminal_ids[]='+id+'&';
		});
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
				currentChangePINDialog.close();
				location.reload();
			},
			type : "POST",
			url : webroot+"terminals/changePIN"
		});
	}else{
		
	}
}
</script>