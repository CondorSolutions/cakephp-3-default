<!-- Contexts (Entities) -->
<ul class="sidebar">
	<li <?php if( $this->request->params['controller'] == 'Users') echo 'class="active"';?>><a href="<?php echo $this->request->webroot;?>users" >
		<span class="mif-users icon"></span>
		<span class="title">Users</span>
		<span class="counter">0</span>
	</a></li>
	<li><a href="#">
		<span class="mif-location icon"></span>
		<span class="title">Locations</span>
		<span class="counter">0</span>
	</a></li>
	<li><a href="#">
		<span class="mif-display icon"></span>
		<span class="title">Terminals</span>
		<span class="counter">2</span>
	</a></li>
</ul>