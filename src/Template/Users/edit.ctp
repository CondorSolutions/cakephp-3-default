<h1 class="text-light">User Profile<span class="mif-user place-right"></span></h1>
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
		<li class="">
			<a href="#frame_1_2">Personal Info</a>
		</li>
		<li class="">
			<a href="#frame_1_3">Contact Info</a>
		</li>
		<li class="">
			<a href="#frame_1_4">Employment Info</a>
		</li>
		<!-- <li class="disabled"><a href="">Disabled</a></li> -->
	</ul>
	<div class="frames">
		<div style="display: block;" class="frame" id="frame_1_1">
			<?php echo $this->element('Users/edit_basic_info_form');?>
		</div>
		<div style="display: none;" class="frame" id="frame_1_2">
			<?php echo $this->element('Users/edit_personal_info_form');?>
		</div>
		<div style="display: none;" class="frame" id="frame_1_3">
			<?php echo $this->element('Users/edit_contact_info_form');?>
		</div>
		<div style="display: none;" class="frame" id="frame_1_4">
			<?php echo $this->element('Users/edit_employment_info_form');?>
		</div>
	</div>
</div>



