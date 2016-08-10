<div class="login-form padding20 block-shadow">
<h1 class="text-light">Reset password<span class="mif-user place-right"></span></h1>
<hr class="thin"/>
<br/>
<h3>Hi, <?php echo $user->person->full_name;?>!</h3>
<h4>Please enter your new password.</h4>
<hr class="thin"/>
<?= $this->Form->create($user,['url' => ['action' => 'resetpw',],  'autocomplete'=>'off']) ?>
	 <input name="activation_id" required="required" maxlength="255" id="activation_id" type="hidden"  value="<?= $activation_id ?>">
	<div class="grid" >
	        <div class="row cells2">
	            <div class="cell2">
		            <div class="cell">
						<label>Password</label>
						 <div class="input-control text full-size">
								 <input name="password" required="required" maxlength="255" id="password" type="password"  value="" >
						   </div>
					</div>
					 <div class="cell">
						<label>Confirm password</label>
						 <div class="input-control text full-size">
								 <input name="confirm_password" required="required" maxlength="255" id="confirm_password" type="password" value="">
						   </div>
					</div>
	            </div>
			</div>
			<div class="row" >
	            	<?= $this->Form->button(__('Submit'), array('class' => 'button success')) ?>
			</div>
			<hr class="thin"/>
            <div class="row" >
	            	<?= $this->Html->link(__('Login'), ['action' => 'login']) ?> 
			</div>
	</div>
<?= $this->Form->end() ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$( "#password" ).focus();
});	
</script>


