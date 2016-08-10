<?= $this->Form->create($user,['url' => ['action' => 'save-employment-info'], 'onSubmit'=>'return validateEmploymentInfo()']) ?>
<input name="user_id" id="user_id" value="<?php echo $user->id;?>" type="hidden" />
    <div class="grid" >
        <div class="row cells2">
            <div class="cell2"><!-- Left cell -->
            	<div class="cell">
			    	<label>Department</label>
			    	 <div class="input-control text full-size">
			    	 		<span class="mif-chevron-thin-down prepend-icon"></span>
				        	 <select name="department_id" onchange="updatePositions(this);" id="department">
				        	 	<option value="0"></option>
				        	 	<?php foreach ($departments as $department):?>
				        	 		<option value="<?php echo $department['id'];?>" <?php if($user->Person->department_id == $department['id']) echo 'selected';?>><?php echo $department['name']; ?></option>
				        	 	<?php endforeach;?>
				        	 </select>
				       </div>
			    </div>
			    <br/>
			    <div class="cell">
			    	<label>Agency</label>
			    	 <div class="input-control text full-size">
			    	 		<span class="mif-chevron-thin-down prepend-icon"></span>
				        	 <select name="agency_id" id="agency" >
				        	 	<option value="0"></option>
				        	 		<?php foreach ($agencies as $agency):?>
				        	 		<option value="<?php echo $agency['id'];?>" <?php if($user->Person->agency_id == $agency['id']) echo 'selected';?>><?php echo $agency['name']; ?></option>
				        	 	<?php endforeach;?>
				        	 </select>
				       </div>
			    </div>
			   </div>
			     
			<!-- ---------------------- -->
            <div class="cell2" style="margin-left: 20px;"><!-- Right cell -->
            	  <div class="cell">
			    	<label>Position</label>
			    	 <div class="input-control text full-size">
			    	 		<span class="mif-chevron-thin-down prepend-icon"></span>
				        	<select name="position_id" id="position">
				        	 	<option value="0"></option>
				        	 	<?php foreach ($positions as $position):?>
				        	 		<option value="<?php echo $position['id'];?>" <?php if($user->Person->position_id == $position['id']) echo 'selected';?>><?php echo $position['name']; ?></option>
				        	 	<?php endforeach;?>
				        	 </select>
				       </div>
			    </div>
            </div>
            
        </div>
        <div class="row" >
            	<?= $this->Form->button(__('Submit'), array('class' => 'button success')) ?>
					<?= $this->Form->end() ?>
		</div>
	</div>
	
	<script>
		function updatePositions(e){
			$('#position').html('');
			if($(e).val()!=0){
				var data = "department_id="+$(e).val();
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
						$('#position').append('<option value=0></option>');
						$.each(data.positions,function(key, value) {
							$('#position').append('<option value='+value.id+'>'+value.name+'</option>');
						});
					},
					type : "POST",
					url : webroot+'positions/ajaxFindByDepartment/'
				});
			}
		}

		function validateEmploymentInfo(){
			var message = "";
			var department =  $("#department").val();
			var position =  $("#position").val();
			var agency =  $("#agency").val();
			
			if(department =="0")
				message += "Department is required \n";
			if(position=="0")
				message += "Position is required \n";
			/* if(agency=="0")
				message += "Agency required \n"; */
			if(message != ""){
				alert(message);
				return false;
			}
			return true;
		}
	</script>