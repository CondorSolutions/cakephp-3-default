<?= $this->Form->create($standardShift) ?>
<div class="grid" >
	<div class="row cells2">
		<div class="cell2"><!-- Left cell -->
			<div class="cell">
				<label>Shift Name</label>
				 <div class="input-control text full-size">
						 <input name="name"  maxlength="255" id="name" type="text" required="required"  value="<?= $standardShift['name']?>">
				   </div>
			</div>
			<div class="cell">
				<label>Start Time</label>
				 <div class="input-control text full-size">
				 		<input name="start"  maxlength="255" id="start" type="text" required="required"  class="" value="<?= date_format($standardShift['start'], 'g : i A')?>">
				   </div>
			</div>
			<div class="cell">
				<label>End Time</label>
				 <div class="input-control text full-size">
				 		<input name="end"  maxlength="255" id="end" type="text" required="required"  class="" value="<?= date_format($standardShift['end'], 'g : i A')?>">
				   </div>
			</div>
			<div class="cell">
				<label>Break Minutes</label>
				 <div class="input-control text full-size">
						 <input name="break_minutes"  maxlength="255" id="break_minutes" type="text" required="required"  value="<?= $standardShift['break_minutes']?>">
				   </div>
			</div>
			<div class="cell">
				<label>Full Shift</label>
				 <div class="input-control text full-size">
				 		<span class="mif-chevron-thin-down prepend-icon"></span>
						<select name="is_full_shift">
							<option value="1" <?=($standardShift['is_full_shift'])?"selected":""?>>Yes</option>
							<option value="0" <?=(!$standardShift['is_full_shift'])?"selected":""?>>No</option>
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
		var timePickerOptions = {
		        now: "<?= date_format($standardShift['start'], 'H:i')?>", //hh:mm 24 hour format only, defaults to current time
		        twentyFour: false,  //Display 24 hour format, defaults to false
		        upArrow: 'wickedpicker__controls__control-up',  //The up arrow class selector to use, for custom CSS
		        downArrow: 'wickedpicker__controls__control-down', //The down arrow class selector to use, for custom CSS
		        close: 'wickedpicker__close', //The close class selector to use, for custom CSS
		        hoverState: 'hover-state', //The hover state class to use, for custom CSS
		        title: 'Select Time', //The Wickedpicker's title
			    minutesInterval: 15    
		    };
		$('#start').wickedpicker(timePickerOptions);
		var timePickerOptions = {
		        now: "<?= date_format($standardShift['end'], 'H:i')?>", //hh:mm 24 hour format only, defaults to current time
		        twentyFour: false,  //Display 24 hour format, defaults to false
		        upArrow: 'wickedpicker__controls__control-up',  //The up arrow class selector to use, for custom CSS
		        downArrow: 'wickedpicker__controls__control-down', //The down arrow class selector to use, for custom CSS
		        close: 'wickedpicker__close', //The close class selector to use, for custom CSS
		        hoverState: 'hover-state', //The hover state class to use, for custom CSS
		        title: 'Select Time', //The Wickedpicker's title
			    minutesInterval: 15    
		    };
		$('#end').wickedpicker(timePickerOptions);
	});
</script>