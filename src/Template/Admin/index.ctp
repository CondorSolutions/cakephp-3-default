<?= $this->Html->script('admin.js') ?>
<h1 class="text-light">Admin<span class="mif-cogs place-right"></span></h1>
<hr class="thin bg-grayLighter">
<?php 
	//$this->log($user->roles[0]);
?>
<div class="tabcontrol2" data-role="tabcontrol">
	<ul class="tabs">
		<li class="active">
			<a href="#frame_1_1">Standard Shifts</a>
		</li>
		<li class="">
			<a href="#frame_1_2">Standard Day Offs</a>
		</li>
		<li class="">
			<a href="#frame_1_3">Maintenance Data</a>
		</li>
		<!-- <li class="disabled"><a href="">Disabled</a></li> -->
	</ul>
	<div class="frames">
		<div style="display: block;" class="frame" id="frame_1_1">
			<?php echo $this->element('Admin/standard_shifts');?>
		</div>
		<div style="display: none;" class="frame" id="frame_1_2">
			<?php echo $this->element('Admin/standard_day_offs');?>
		</div>
		<div style="display: none;" class="frame" id="frame_1_3">
			<?php echo $this->element('Admin/maintenance_data');?>
		</div>
	</div>
</div>
<script type="text/javascript">
var departments_JSON = <?= $departments_JSON;?>;
$(document).ready(function(){
	
});
</script>


