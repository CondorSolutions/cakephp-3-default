<!-- Contexts (Entities) -->
<?php 
use Cake\I18n\Time;
?>
<ul class="sidebar">
	<li <?php if( $this->request->params['controller'] == 'Users') echo 'class="active"';?>><a href="<?php echo $this->request->webroot;?>users" >
		<span class="mif-users icon"></span>
		<span class="title">Users</span>
		<span class="counter"><?=$usersCount?></span>
	</a></li>
	<li  <?php if( $this->request->params['controller'] == 'Locations') echo 'class="active"';?>><a href="<?php echo $this->request->webroot;?>locations">
		<span class="mif-location icon"></span>
		<span class="title">Locations</span>
		<span class="counter"><?=$locationsCount?></span>
	</a></li>
	<li  <?php if( $this->request->params['controller'] == 'Terminals') echo 'class="active"';?>><a href="<?php echo $this->request->webroot;?>terminals">
		<span class="mif-display icon"></span>
		<span class="title">Terminals</span>
		<span class="counter"><?=$terminalsCount?></span>
	</a></li>
	<li <?php if( $this->request->params['controller'] == 'Reports') echo 'class="active"';?>><a href="<?php echo $this->request->webroot;?>reports" >
		<span class="mif-file-text icon"></span>
		<span class="title">Reports</span>
	</a></li>
	<li <?php if( $this->request->params['controller'] == 'Admin') echo 'class="active"';?>><a href="<?php echo $this->request->webroot;?>admin" >
		<span class="mif-cogs icon"></span>
		<span class="title">Admin</span>
	</a></li>
	<li <?php if( $this->request->params['controller'] == 'Options') echo 'class="active"';?>><a href="<?php echo $this->request->webroot;?>options" >
		<span class="mif-equalizer icon"></span>
		<span class="title">Settings</span>
	</a></li>
	<!-- 
	<li>
		<?=date('Y-m-d H:i:s')?>
	</li>
	 -->
</ul>