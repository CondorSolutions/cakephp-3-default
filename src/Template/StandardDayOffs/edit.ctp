<?= $this->Form->create($standardDayOff, ['onSubmit'=>'return validateEditStandardDayOff()']) ?>
<?= $this->Html->script('admin') ?>
<input name="address_count" id="address_count" value="0" type="hidden"/>
<div class="grid" >
	<div class="row cells2">
		<div class="cell2"><!-- Left cell -->
			<div class="cell">
				<label>Day Off Name</label>
				 <div class="input-control text full-size">
						 <input name="name"  maxlength="255" id="name" type="text" required="required" value="<?=$standardDayOff->name?>">
				   </div>
			</div>
			<div class="cell">
				<label>Repeat Every Specific Date</label>
				<div class="input-control text full-size" data-role="datepicker">
  					<input  id="date" type="text" value="" name="date" onchange="toggleDayOffType(this)" value="<?=$standardDayOff->date?>">
  					<button class="button"><span class="mif-calendar"></span></button></div>
			</div>
			
			<div class="cell">
				<label>OR Repeat Every Day of Week</label>
				 <div class="input-control text full-size">
				 <span class="mif-chevron-thin-down prepend-icon"></span>
				 		<select id="day" name="day" onchange="toggleDayOffType(this)">
				 			<option value=""></option>
				 			<?php for($i = 1; $i<=7;$i++):?>
				 				<option value="<?=$i?>"><?= date('l', strtotime("Sunday +{$i} days"))?>s</option>
				 			<?php endfor;?>
				 		</select>
				   </div>
			</div>
			
		</div>
		<!-- ---------------------- -->
	</div>
	<div class="row" >
			<?= $this->Form->button(__('Submit'), array('class' => 'button success')) ?>
	</div>
</div>
<?= $this->Form->end() ?>
<script>
	$(document).ready(function(){
		<?php if($standardDayOff->date != ''):?>
			$('#date').val('<?=date_format($standardDayOff->date, "Y.m.d")?>');
		<?php else:?>
			$('#day').val('<?=$standardDayOff->day?>');
		<?php endif;?>
		
		
	});
	function toggleDayOffType(e){
		console.log(e.id);
		if(e.id == 'day'){
			$('#date').val('');
		}
		else{
			$('#day').val('');
		}
	}
	
	function validateEditStandardDayOff(){
		var message = "";
		var name =  $("#name").val();
		var date =  $("#date").val();
		var day =  $("#day").val();
		if(name == '')
			message += "Day off name is required. \n"

		if(date == '' && day == '')
			message += "Repeat date or repeat day is required."			
		
		if(message != ""){
			alert(message);
			return false;
		}
		
		
		return true;
	}
</script>