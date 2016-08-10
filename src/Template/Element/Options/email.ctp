<?php 
use App\Util\OptionsUtil;
?>
<div class="grid" >
	<div class="row cells2">
		<div class="cell2"><!-- Left cell -->
			<div class="cell">
				<label>No-reply Address</label>
				<div class="input-control text full-size">
					<input maxlength="255" id="<?=$options[OptionsUtil::NO_REPLY_ADDRESS]->code?>" name="<?=$options[OptionsUtil::NO_REPLY_ADDRESS]->code?>" type="text"  value="<?=$options[OptionsUtil::NO_REPLY_ADDRESS]->value1?>">
				</div>
			</div>
			<div class="cell">
				<label>Host</label>
				<div class="input-control text full-size">
					<input   maxlength="255" id="<?=$options[OptionsUtil::MAIL_HOST]->code?>" name="<?=$options[OptionsUtil::MAIL_HOST]->code?>" type="text"  value="<?=$options[OptionsUtil::MAIL_HOST]->value1?>">
				</div>
			</div>
			<div class="cell">
				<label>Port</label>
				<div class="input-control text full-size">
					<input   maxlength="255" id="<?=$options[OptionsUtil::MAIL_PORT]->code?>" name="<?=$options[OptionsUtil::MAIL_PORT]->code?>" type="text" value="<?=$options[OptionsUtil::MAIL_PORT]->value1?>">
				</div>
			</div>
			<div class="cell">
				<label>Username</label>
				<div class="input-control text full-size">
					<input   maxlength="255" id="<?=$options[OptionsUtil::MAIL_USERNAME]->code?>" name="<?=$options[OptionsUtil::MAIL_USERNAME]->code?>" type="text" value="<?=$options[OptionsUtil::MAIL_USERNAME]->value1?>">
				</div>
			</div>
			<div class="cell">
				<label>Password</label>
				<div class="input-control text full-size">
					<input type="password"   maxlength="255" id="<?=$options[OptionsUtil::MAIL_PASSWORD]->code?>" name="<?=$options[OptionsUtil::MAIL_PASSWORD]->code?>" type="text" value="<?=$options[OptionsUtil::MAIL_PASSWORD]->value1?>">
				</div>
			</div>
		</div>
	</div>
</div>


