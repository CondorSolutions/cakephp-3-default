<?= $this->Form->create($user, ['type' => 'file']) ?>
    <div class="grid" >
        <div class="row cells2">
            <div class="cell2"><!-- Left cell -->
            	 <div class="cell">
			    	<label>Email</label>
			    	 <div class="input-control text full-size">
			    	 		<strong><?php echo $user->email;?></strong>
				       </div>
			    </div>
			     <div class="cell">
			    	<label>First Name</label>
			    	 <div class="input-control text full-size">
				        	 <input name="first_name" required="required" maxlength="255" id="first_name" type="text"  value="<?php echo $user->person->first_name;?>">
				       </div>
			    </div>
			     <div class="cell">
			    	<label>Middle Name</label>
			    	 <div class="input-control text full-size">
				        	 <input name="middle_name" required="required" maxlength="255" id="middle_name" type="text" value="<?php echo $user->person->middle_name;?>">
				       </div>
			    </div>
			     <div class="cell">
			    	<label>Last Name</label>
			    	 <div class="input-control text full-size">
				        	 <input name="last_name" required="required" maxlength="255" id="last_name" type="text" value="<?php echo $user->person->last_name;?>">
				       </div>
			    </div>
			     <div class="cell">
			    	<label>Role</label>
			    	 <div class="input-control text full-size">
			    	 		<span class="mif-chevron-thin-down prepend-icon"></span>
				        	 <select name="roles[_ids][]" >
				        	 	<?php foreach ($rolesAll as $role):?>
				        	 		<option  value="<?php echo $role['id'];?>" <?php if($role['id'] == $user->roles[0]['id']){echo 'selected';} ?>><?php echo $role['name']; ?></option>
				        	 	<?php endforeach;?>
				        	 </select>
				       </div>
			    </div>
			</div>
			<!-- ---------------------- -->
            <div class="cell2" style="margin-left: 20px;"><!-- Right cell -->
            	<div class="cell">
            		 <img src="<?php echo $this->request->webroot . $user->person->photo_path;?> " alt="User Photo" class="user-photo-big">
			    	<?= $this->Form->input('photo', ['type' => 'file' , 'value'=>$user->photo]); ?>
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