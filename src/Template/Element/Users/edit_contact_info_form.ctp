<?= $this->Form->create($user,['url' => ['action' => 'save-contact-info']]) ?>
<input name="user_id" id="user_id" value="<?php echo $user->id;?>" type="hidden" />
<input name="address_count" id="address_count" value="0" type="hidden"/>
<div class="grid" >
	<div class="row cells2">
		<div class="cell2"><!-- Left cell -->
			<div class="cell">
				<label>Mobile</label>
				 <div class="input-control text full-size">
						 <input name="mobile"  maxlength="255" id="mobile" type="text"  value="<?php echo $user->person->mobile;?>">
				   </div>
			</div>
			 <div class="cell">
				<label>Landline</label>
				 <div class="input-control text full-size">
						<input name="landline" maxlength="255" id="landline" type="text"  value="<?php echo $user->person->landline;?>">
				   </div>
			</div>
			<div class="cell">
				<label>Personal Email</label>
				 <div class="input-control text full-size">
						 <input name="personal_email"  maxlength="255" id="personal_email" type="text"  value="<?php echo $user->person->personal_email;?>">
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
		userAddresses =  <?php echo $addresses;?>;
		loadAddresses();
		//addAddressWindow();
	});
</script>