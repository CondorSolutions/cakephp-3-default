<?= $this->Form->create($user,['url' => ['action' => 'save-personal-info']]) ?>
<input name="user_id" id="user_id" value="<?php echo $user->id;?>" type="hidden" />
    <div class="grid" >
        <div class="row cells2">
            <div class="cell2"><!-- Left cell -->
			     <div class="cell">
			     	<label>Gender</label><br/>
			    	<label class="input-control radio small-check">
			    		<?php if($user->person->gender == 'male'):?>
			    			<input type="radio" name="gender" value="male" checked>
			    		<?php else:?>
			    			<input type="radio" name="gender" value="male">
			    		<?php endif;?>
					    <span class="check"></span>
					    <span class="caption">Male</span>
					</label>
					<label class="input-control radio small-check">
					    <?php if($user->person->gender == 'female'):?>
			    			<input type="radio" name="gender" value="female" checked>
			    		<?php else:?>
			    			<input type="radio" name="gender" value="female">
			    		<?php endif;?>
					    <span class="check"></span>
					    <span class="caption">Female</span>
					</label>
			    </div>
			     <div class="cell">
			    	<label>Date of birth</label>
			    	     <div class="input-control text full-size" data-role="datepicker">
			    	     	<?php 
			    	     	$dateStr = "";
			    	     	if($user->person->dob){
								$date = new DateTime($user->person->dob);
								$dateStr = $date->format('Y.m.d');
							}
			    	     	?>
					        <input name="dob"  id="dob" type="text" value="<?php echo $dateStr;?>">
					        <button class="button"><span class="mif-calendar"></span></button>
					    </div>
			    </div>
			     <div class="cell">
			    	<label>Place of birth</label>
			    	 <div class="input-control text full-size">
				        	 <input name="birth_place" id="birth_place" type="text" value="<?php echo $user->person->birth_place;?>">
				       </div>
			    </div>
			    <div class="cell">
			    	<label>Citizenship</label>
			    	 <div class="input-control text full-size">
				        	 <input name="citizenship" id="citizenship" type="text" value="<?php echo $user->person->citizenship;?>">
				       </div>
			    </div>
			</div>
			<!-- ---------------------- -->
            <div class="cell2" style="margin-left: 20px;"><!-- Right cell -->
            	 <div class="cell">
			    	<label>TIN</label>
			    	 <div class="input-control text full-size">
				        	 <input name="tin" id="tin" type="text" value="<?php echo $user->person->tin;?>">
				       </div>
			    </div>
			    <div class="cell">
			    	<label>SSS</label>
			    	 <div class="input-control text full-size">
				        	 <input name="sss" id="sss" type="text" value="<?php echo $user->person->sss;?>">
				       </div>
			    </div>
			    <div class="cell">
			    	<label>Philhealth</label>
			    	 <div class="input-control text full-size">
				        	 <input name="philhealth" id="philhealth" type="text" value="<?php echo $user->person->philhealth;?>">
				       </div>
			    </div>
			    <div class="cell">
			    	<label>Pagibig</label>
			    	 <div class="input-control text full-size">
				        	 <input name="pagibig" id="pagibig" type="text" value="<?php echo $user->person->pagibig;?>">
				       </div>
			    </div>
            </div>
            
        </div>
        <div class="row" >
            	<?= $this->Form->button(__('Submit'), array('class' => 'button success')) ?>
					<?= $this->Form->end() ?>
		</div>
	</div>