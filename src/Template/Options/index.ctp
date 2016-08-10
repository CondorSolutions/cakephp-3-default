<?php 
use App\Util\OptionsUtil;
?>    
<h1 class="text-light">System Settings<span class="mif-equalizer place-right"></span></h1>
<hr class="thin bg-grayLighter">
<?= $this->Form->create('options', ['url'=>'/options/update','onSubmit'=>'return validateOptions()', 'autocomplete'=>'off']) ?>
    <div class="tabcontrol2"      
    	data-role="tabcontrol"
     	data-on-tab-click="tab_click"
     	data-on-tab-change="tab_change">
        <ul class="tabs">
            <li><a href="#application_tab">Application</a></li>
            <li><a href="#terminals_tab">Terminals Management</a></li>
            <li><a href="#email_tab">Email</a></li>
        </ul>
        
        <div class="frames">
            <div style="display: block;" class="frame" id="application_tab">
            	<?= $this->element('Options/application');?>
            </div>
            <div style="display: none;" class="frame" id="terminals_tab">
            	<?= $this->element('Options/terminals');?>
            </div>
            <div style="display: none;" class="frame" id="email_tab">
            	<?= $this->element('Options/email');?>
            </div>
        </div>
    </div>
    
    <div>
    <?= $this->Form->button(__('Save'), array('class' => 'button success')) ?>
					<?= $this->Form->end() ?>
					</div>
<script>
function validateOptions(){
	return true;
}


    function tab_click(tab){
        console.log(tab);
        return true;
    }
    function tab_change(tab){
        console.log(tab);
    }
</script>