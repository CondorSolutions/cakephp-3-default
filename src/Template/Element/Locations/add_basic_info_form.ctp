<?= $this->Form->create($location) ?>
<input name="address_count" id="address_count" value="0" type="hidden"/>
<div class="grid" >
	<div class="row cells2">
		<div class="cell2"><!-- Left cell -->
			<div class="cell">
				<label>Name</label>
				 <div class="input-control text full-size">
						 <input name="name"  maxlength="255" id="name" type="text"required="required"  >
				   </div>
			</div>
		</div>
		<!-- ---------------------- -->
		<div class="cell2" style="margin-left: 20px; max-width: 600px; width: 600px;"><!-- Right cell -->
			<div class="cell" id="address_container">
				<!-- ADDRESSES -->
			</div>
			<button class="button primary" onclick="addAddressWindow(); return false;" type="button"><span class="mif-plus"></span> Add address</button>
		</div>
	</div>
	<div class="row" >
			<?= $this->Form->button(__('Submit'), array('class' => 'button success')) ?>
	</div>
</div>
<?= $this->Form->end() ?>
<script>
	$(document).ready(function(){
		refRegions = <?php echo $refRegions;?>;
		//savedAddresses =  []<?php //echo $addresses;?>;
		//loadAddresses();
		//addAddressWindow();
	});
</script>