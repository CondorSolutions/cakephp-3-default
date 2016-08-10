<h1 class="text-light">Users<span class="mif-user place-right"></span></h1>
<hr class="thin bg-grayLighter">
	<a href="users/add"><button class="button primary" ><span class="mif-plus"></span> New User</button></a>
<hr class="thin bg-grayLighter">
<div style="max-width: 700px;float: left;" ><!-- Left Panel -->
	<?php foreach ($users as $user): ?>
		<script>
				if(firstUser==-1)
					firstUser=<?=$user->id?>;
			</script>
	<?php endforeach; ?>
	<table class="dataTable striped hovered border bordered" data-role="datatable" data-auto-width="false" data-searching="true" data-paging="false">
		<thead>
		<tr>
			<th>
				<label class="input-control checkbox small-check">
				    <input type="checkbox" onclick="toggleSelectAllUsers(this);">
				    <span class="check"></span>
				</label>
			</th>
			<th>ID</th>
			<th>Status</th>
			<th>Name</th>
			<th>Email</th>
			<th>Actions</th>
		</tr>
		</thead>
		<tbody>
			
			<?php foreach ($users as $user): ?>
				<tr style="cursor: pointer;" onclick="selectUser(<?= $user->id?>)" id="user_row_<?= $user->id?>">
					<td>
						<label class="input-control checkbox small-check">
						    <input type="checkbox" id="user_checkbox_<?=$user->id?>">
						    <span class="check"></span>
						</label>
					</td>
					<td><?= $this->Number->format($user->id) ?></td>
					<td><?= h($user->status) ?></td>
					<td id="user_fullname_<?=$user->id?>"><?= h($user->person->last_name) .', '. h($user->person->first_name) ?></td>
					<td><?= h($user->email) ?></td>
					<td class="actions">
						<?= $this->Html->link(__('Calendar'), ['action' => 'calendar', $user->id]) ?> | 
						<?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
						<!-- | <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete "{0}"?', h($user->person->last_name) .', '. h($user->person->first_name))]) ?>
						-->
					</td>
				</tr>
				
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
			<?= $this->Paginator->counter() ?>
        </ul>
        
    </div>
<br>
<br>
<br>
With selected: 	<button class="button small-button warning" onclick="showAssignLocations(0)">Assign to locations</button>
</div>
<div style="float: left; padding: 0px 0px 0px 20px;"><!-- Right Panel -->
	<h4 id="locations_header">Locations</h4>
	<div id="user_locations_container">
		<!-- Locations -->
	</div>
</div>
<!-- Hiddens -->
   <div style="width: auto; height: auto; visibility: hidden; " data-role="dialog" id="assign_locations_dialog" class="padding20 dialog" data-close-button="true" data-overlay="true" data-overlay-color="op-dark" data-overlay-click-close="true">
	    <h3>Select Locations</h3>
	    <div id="assign_locations_container">
	    	<!-- Locations selection -->
	    </div>
	</div>
<!-- end Hiddens -->
    
<script type="text/javascript">
$(document).ready(function(){
	locations = <?= $locations;?>;
	locationsUsers = <?= $locationsUsers;?>;
	selectUser(firstUser);
});
</script>
<style>
<!--
.input-control {
	margin: 0 !important;
}
-->
</style>
<!-- 
<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Users') ?></h3>
    <table cellpadding="0" cellspacing="0">
        
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
 -->
