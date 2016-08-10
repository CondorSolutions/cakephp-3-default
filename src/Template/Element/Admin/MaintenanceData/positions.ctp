<a href="javascript:void(0)" ><button class="button primary" onclick="addPositionRow();" ><span class="mif-plus"></span> New Position</button></a>
<table class="dataTable striped hovered border bordered" data-role="" data-auto-width="false" style="width: 500px;">
	<thead>
	<tr >
		<td>ID</td>
		<td>Department</td>
		<td>Position</td>
		<td>Actions</td>
	</tr>
	</thead>
	<tbody id="positions_tbody">
		<?php foreach ($positions as $position): ?>
			<tr style="cursor: pointer;" onclick="selectLocation(<?= $position->id?>)" id="department_<?= $position->id?>">
				<td><?= $this->Number->format($position->id) ?></td>
				<td><?=h($position->department->name)?></td>
				<td id="position_name_<?=$position->id?>"><?= h($position->name) ?></td>
				<td class="actions">
					<?= $this->Form->postLink(__('Delete'), ['controller' => 'positions',  'action' => 'delete', $position->id], ['confirm' => __('Are you sure you want to delete "{0}" Position?', $position->name)]) ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
	