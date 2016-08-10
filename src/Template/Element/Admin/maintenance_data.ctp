<div class="tabcontrol2" data-role="tabcontrol">
	<ul class="tabs">
		<li class="active">
			<a href="#frame_3_1">Departments</a>
		</li>
		<li class="">
			<a href="#frame_3_2">Positions</a>
		</li>
		<li class="">
			<a href="#frame_3_3">Agencies</a>
		</li>
		<!-- <li class="disabled"><a href="">Disabled</a></li> -->
	</ul>
	<div class="frames">
		<div style="display: block;" class="frame" id="frame_3_1">
			<?php echo $this->element('Admin/MaintenanceData/departments');?>
		</div>
		<div style="display: none;" class="frame" id="frame_3_2">
			<?php echo $this->element('Admin/MaintenanceData/positions');?>
		</div>
		<div style="display: none;" class="frame" id="frame_3_3">
			<?php echo $this->element('Admin/MaintenanceData/agencies');?>
		</div>
	</div>
</div>