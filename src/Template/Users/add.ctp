<h1 class="text-light">New User<span class="mif-user place-right"></span></h1>
<hr class="thin bg-grayLighter">
	<a href="<?php echo $this->request->webroot;?>users"><button class="button primary" ><span class="mif-plus"></span> List Users </button></a>
<hr class="thin bg-grayLighter">
<?php 
	//$this->log($user->roles[0]);
?>
<div class="tabcontrol2" data-role="tabcontrol">
	<ul class="tabs">
		<li class="active">
			<a href="#frame_1_1">Basic Info</a>
		</li>
		<li class="disabled">
			<a href="#frame_1_2">Personal Info</a>
		</li>
		<li class="disabled">
			<a href="#frame_1_3">Contact Info</a>
		</li>
		<!-- <li class="disabled"><a href="">Disabled</a></li> -->
	</ul>
	<div class="frames">
		<div style="display: block;" class="frame" id="frame_1_1">
			<?php echo $this->element('Users/add_basic_info_form');?>
		</div>
		<div style="display: none;" class="frame" id="frame_1_2">
		</div>
		<div style="display: none;" class="frame" id="frame_1_3">
		</div>
	</div>
</div>



