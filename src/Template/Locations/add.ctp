<h1 class="text-light">New Location<span class="mif-location place-right"></span></h1>
<hr class="thin bg-grayLighter">
	<a href="<?php echo $this->request->webroot;?>locations"><button class="button primary" ><span class="mif-plus"></span> List Locations </button></a>
<hr class="thin bg-grayLighter">
<?php 
	//$this->log($user->roles[0]);
?>
<div class="tabcontrol2" data-role="tabcontrol">
	<ul class="tabs">
		<li class="active">
			<a href="#frame_1_1">Basic Info</a>
		</li>
		<!-- <li class="disabled"><a href="">Disabled</a></li> -->
	</ul>
	<div class="frames">
		<div style="display: block;" class="frame" id="frame_1_1">
			<?php echo $this->element('Locations/add_basic_info_form');?>
		</div>
	</div>
</div>



