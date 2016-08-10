<?php 
use App\Util\OptionsUtil;
?>
<div class="grid" >
	<div class="row cells2">
		<div class="cell2"><!-- Left cell -->
			<div class="cell">
				<label>Application Name</label>
				<div class="input-control text full-size">
					<input maxlength="255" id="<?=$options[OptionsUtil::APP_NAME]->code?>"  name="<?=$options[OptionsUtil::APP_NAME]->code?>" type="text"  value="<?=$options[OptionsUtil::APP_NAME]->value1?>">
				</div>
			</div>
				<div class="cell">
				<label>Company Name</label>
				<div class="input-control text full-size">
					<input maxlength="255" id="<?=$options[OptionsUtil::COMPANY_NAME]->code?>" name="<?=$options[OptionsUtil::COMPANY_NAME]->code?>" type="text"  value="<?=$options[OptionsUtil::COMPANY_NAME]->value1?>">
				</div>
				</div>
			<div class="cell">
				<label>Upload Files Folder</label>
				<div class="input-control text full-size">
					<input maxlength="255" id="<?=$options[OptionsUtil::FILES_PATH]->code?>" name="<?=$options[OptionsUtil::FILES_PATH]->code?>" type="text" value="<?=$options[OptionsUtil::FILES_PATH]->value1?>">
				</div>
			</div>
		</div>
	</div>
</div>
