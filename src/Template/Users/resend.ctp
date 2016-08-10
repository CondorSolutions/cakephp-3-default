	<div class="login-form padding40 block-shadow">
       <?= $this->Form->create() ?>
           <?php if($type == 'activation'):?>
            	<h1 class="text-light">Resend Activation</h1>
            <?php else:?>
            	<h1 class="text-light">Reset Password</h1>
            <?php endif;?>
            <hr class="thin"/>
            <div class="cell">
		    	<label>Email</label>
		    	 <div class="input-control text full-size">
			        	 <input name="email" required="required" maxlength="255" id="email" type="text"  >
			       </div>
		    </div>
            <?= $this->Form->button(__('Submit'), ['class'=>'button primary']) ?>
            <hr class="thin"/>
            <div class="row" >
	            	<?= $this->Html->link(__('Login'), ['action' => 'login']) ?> 
			</div>
    <?= $this->Form->end() ?>
    </div>