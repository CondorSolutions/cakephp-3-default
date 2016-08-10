	<div class="login-form padding20 block-shadow">
       <?= $this->Form->create() ?>
            <h1 class="text-light">Login</h1>
            <hr class="thin"/>
            <div class="cell">
		    	<label>Email</label>
		    	 <div class="input-control text full-size">
			        	 <input name="email" required="required" maxlength="255" id="email" type="text"  >
			       </div>
		    </div>
             <div class="cell">
		    	<label>Password</label>
		    	 <div class="input-control text full-size">
			        	 <input name="password" required="required" maxlength="255" id="password" type="password"  >
			       </div>
		    </div>
            <?= $this->Form->button(__('Login'), ['class'=>'button primary']) ?>
    <?= $this->Form->end() ?>
    <?php if(isset($showResendActivation) && $showResendActivation):?>
    		<hr class="thin"/>
    	   <?= $this->Html->link(__('Resend activation code'), ['controller' => 'Users', 'action' => 'resend/activation']) ?>
   	<?php else:?>
   			<hr class="thin"/>
   			<?= $this->Html->link(__('Forgot password'), ['controller' => 'Users', 'action' => 'resend/reset_password']) ?>
    <?php endif;?>
    </div>