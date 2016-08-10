<?= $this->Html->script('location.js') ?>
<h1 class="text-light">Locations<span class="mif-location place-right"></span></h1>
<hr class="thin bg-grayLighter">
	<a href="locations/add"><button class="button primary" ><span class="mif-plus"></span> New Location</button></a>
<hr class="thin bg-grayLighter">
<div style="float: left;"><!-- Left Panel -->
	<h4><strong>Locations</strong></h4>
	<table class="dataTable striped hovered border bordered" data-role="datatable" data-auto-width="false" style="width: 500px;" data-searching="true" data-paging="false" data-sorting="false">
		<thead>
		<tr >
			<td>ID</td>
			<td>Location Name</td>
			<td>Status</td>
			<td>Actions</td>
		</tr>
		</thead>
		<tbody>
			<?php foreach ($locations as $location): ?>
				<tr style="cursor: pointer;" onclick="selectLocation(<?= $location->id?>)" id="location_<?= $location->id?>">
					<td><?= $this->Number->format($location->id) ?></td>
					<td id="location_name_<?=$location->id?>"><?= h($location->name) ?></td>
					<td><?= h($location->status) ?></td>
					<td class="actions">
						<?= $this->Html->link(__('Edit'), ['action' => 'edit', $location->id]) ?><!-- | 
						<a href="javascript: void(0)"  onclick="showAddTerminals(<?=$location->id ?>)">Add Terminal</a>  | 
						<a href="#"  onclick="showAssignUsers(<?=$location->id ?>)">Assign Users</a> -->
						<?php //= //$this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
					</td>
				</tr>
				<script>
					if(firstLocation==-1)
						firstLocation=<?=$location->id?>;
				</script>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<div style="float: left; padding: 0px 0px 0px 20px;" id="right-panel-container"><!-- Right Panel -->
	<h4 id="terminals_header">Terminals</h4>
	<div id="location_terminals_container">
		<!-- Terminals -->
	</div>
	<h4 id="users_header">Users</h4>
	<div id="location_users_container">
		<!-- Users -->
	</div>
</div>
<!-- Hiddens -->
   <div style="width: auto; height: auto; visibility: hidden; " data-role="dialog" id="select_terminals_dialog" class="padding20 dialog" data-close-button="true" data-overlay="true" data-overlay-color="op-dark" data-overlay-click-close="true">
	    <h3>Select Terminals</h3>
	    <div id="select_terminals_container">
	    	<!-- Terminal selection -->
	    </div>
	</div>
	<div style="width: auto; height: auto; visibility: hidden; " data-role="dialog" id="select_users_dialog" class="padding20 dialog" data-close-button="true" data-overlay="true" data-overlay-color="op-dark" data-overlay-click-close="true">
	    <h3>Select Users</h3>
	    <div id="select_users_container" >
	    	<!-- Terminal selection -->
	    </div>
	</div>

<!-- end Hiddens -->
<script>
	$(document).ready(function(){
		terminals = <?= $terminals;?>;
		terminalsLocations = <?= $terminalsLocations;?>;

		persons = <?= $persons;?>;
		locationsUsers = <?= $locationsUsers;?>;
		
		selectLocation(firstLocation);
	});

	var $scrollContainer = $("#right-panel-container");
	/* $(window).scroll(function(){			
		$scrollContainer
			.stop()
			.animate({"marginTop": ($(window).scrollTop() +0) + "px"}, "slow" );			
	}); */
</script>