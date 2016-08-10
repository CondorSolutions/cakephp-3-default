<?= $this->Form->create($user, ['type' => 'file', 'onSubmit'=>'return addBasicInfo()', 'autocomplete'=>'off']) ?>
    <div class="grid" >
        <div class="row cells2">
            <div class="cell2"><!-- Left cell -->
            	 <div class="cell">
			    	<label>Email</label>
			    	 <div class="input-control text full-size">
				        	 <input name="email" required="required" maxlength="255" id="email" type="text"  value="">
				       </div>
			    </div>
			     <div class="cell">
			    	<label>First Name</label>
			    	 <div class="input-control text full-size">
				        	 <input name="first_name" required="required" maxlength="255" id="first_name" type="text"  value="">
				       </div>
			    </div>
			     <div class="cell">
			    	<label>Middle Name</label>
			    	 <div class="input-control text full-size">
				        	 <input name="middle_name" required="required" maxlength="255" id="middle_name" type="text" value="">
				       </div>
			    </div>
			     <div class="cell">
			    	<label>Last Name</label>
			    	 <div class="input-control text full-size">
				        	 <input name="last_name" required="required" maxlength="255" id="last_name" type="text" value="">
				       </div>
			    </div>
			     <div class="cell">
			    	<label>Role</label>
			    	 <div class="input-control text full-size">
			    	 		<span class="mif-chevron-thin-down prepend-icon"></span>
				        	 <select name="role">
				        	 	<?php foreach ($rolesAll as $role):?>
				        	 		<option value="<?php echo $role['id'];?>" <?php if($role['id'] == 3){echo 'selected';} ?>><?php echo $role['name']; ?></option>
				        	 	<?php endforeach;?>
				        	 </select>
				       </div>
			    </div>
			   <div class="cell">
				    <span data-role="hint"
				        data-hint-background="bg-green"
				        data-hint-color="fg-white"
				        data-hint-mode="2"
				        data-hint="Auto Activate|Does not send activation email to user and auto-activates account."
				    >
				    	<label class="input-control checkbox small-check">
						    <input type="checkbox" name="auto-activate" id="auto-activate" >
						    <span class="check"></span>
						    <span class="caption">Auto-activate</span>
						</label>
				    </span>
			    </div>
			    <div id="password-container" style="display: none;">
			    	 <div class="cell">
				    	<label>Password</label>
				    	 <div class="input-control text full-size">
					        	 <input name="password" maxlength="255" id="password" type="password" value="">
					       </div>
				    </div>
				    <div class="cell">
				    	<label>Confirm Password</label>
				    	 <div class="input-control text full-size">
					        	 <input name="confirm-password" maxlength="255" id="confirm-password" type="password" value="">
					       </div>
				    </div>
			    </div>
			</div>
			<!-- ---------------------- -->
            <div class="cell2" style="margin-left: 20px;"><!-- Right cell -->
            	<div class="cell">
            		 <img src="<?php echo $this->request->webroot .'files/Persons/photo/default-photo.jpg';?> " alt="User Photo" class="user-photo-big">
			    	<?= $this->Form->input('photo', ['type' => 'file'] ); ?>
			    </div>
			    <div class="cell">
				   
			    </div>
            </div>
            
        </div>
        <div class="row" >
            	<?= $this->Form->button(__('Submit'), array('class' => 'button success')) ?>
					<?= $this->Form->end() ?>
		</div>
	</div>
<script>
	$(document).ready(function(){
		$( "#auto-activate" ).change(function() {
			toggleAutoActivate();
		});
	});
</script>