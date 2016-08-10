<?php 
use App\Util\OptionsUtil;
use Cake\Core\Configure;
?>
 <div class="grid" >
	<div class="row cells2">
		<div class="cell2"><!-- Left cell -->
			<div class="cell">
				<h3>Account ID: <?=Configure::read('Account.active')?></h3>
				<!-- 
				<label>Account ID: </label>
				<div class="input-control text full-size">
					<input   maxlength="255" id="<?=''//$options[OptionsUtil::TERMINALS_MANAGER_ACCOUNT_ID]->value1?>" name="<?=''//$options[OptionsUtil::TERMINALS_MANAGER_ACCOUNT_ID]->code?>" type="text"  value="<?=''//$options[OptionsUtil::TERMINALS_MANAGER_ACCOUNT_ID]->value1?>"> 
				</div>
				-->
			</div>
			<div class="cell">
				<label>Account Key</label>
				<div class="input-control text full-size">
					<input    maxlength="255" id="<?=$options[OptionsUtil::TERMINALS_MANAGER_ACCOUNT_KEY]->value1?>" name="<?=$options[OptionsUtil::TERMINALS_MANAGER_ACCOUNT_KEY]->code?>" type="text" value="<?=$options[OptionsUtil::TERMINALS_MANAGER_ACCOUNT_KEY]->value1?>">
				</div>
			</div>
			<div class="cell">
				<label>Terminals Manager URL</label>
				<div class="input-control text full-size">
					<input   maxlength="255" id="<?=$options[OptionsUtil::TERMINALS_MANAGER_URL]->value1?>"  name="<?=$options[OptionsUtil::TERMINALS_MANAGER_URL]->code?>" type="text"  value="<?=$options[OptionsUtil::TERMINALS_MANAGER_URL]->value1?>">
				</div>
			</div>
			<div class="cell">
				<label>Default PIN</label>
				<div class="input-control text full-size">
					<input  maxlength="255" id="<?=$options[OptionsUtil::TERMINALS_DEFAULT_PIN]->value1?>" name="<?=$options[OptionsUtil::TERMINALS_DEFAULT_PIN]->code?>" type="text" value="<?=$options[OptionsUtil::TERMINALS_DEFAULT_PIN]->value1?>">
				</div>
			</div>
		</div>
	</div>
</div>
