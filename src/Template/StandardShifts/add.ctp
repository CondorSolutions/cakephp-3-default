<?= $this->Form->create($standardShift) ?>
<?= $this->Html->script('admin') ?>
<input name="address_count" id="address_count" value="0" type="hidden"/>
<div class="grid" >
	<div class="row cells2">
		<div class="cell2"><!-- Left cell -->
			<div class="cell">
				<label>Shift Name</label>
				 <div class="input-control text full-size">
						 <input name="name"  maxlength="255" id="name" type="text" required="required"  >
				   </div>
			</div>
			<div class="cell">
				<label>Start Time</label>
				 <div class="input-control text full-size">
				 		<input name="start"  maxlength="255" id=""start"" type="text" required="required"  class="timepicker">
				   </div>
			</div>
			<div class="cell">
				<label>End Time</label>
				 <div class="input-control text full-size">
				 		<input name="end"  maxlength="255" id="end" type="text" required="required"  class="timepicker">
				   </div>
			</div>
			<div class="cell">
				<label>Break Minutes</label>
				 <div class="input-control text full-size">
						 <input name="break_minutes"  maxlength="255" id="break_minutes" type="text" required="required"  >
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
		
	});
</script>