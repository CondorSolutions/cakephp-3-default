<a href="javascript:void(0)" ><button class="button primary" onclick="addDepartmentRow();" ><span class="mif-plus"></span> New Department</button></a>
<table class="dataTable striped hovered border bordered" data-role="" data-auto-width="false" style="width: 500px;">
	<thead>
	<tr >
		<td>ID</td>
		<td>Department</td>
		<td>Actions</td>
	</tr>
	</thead>
	<tbody id="departments_tbody">
		<?php foreach ($departments as $department): ?>
			<tr style="cursor: pointer;" onclick="selectLocation(<?= $department->id?>)" id="department_<?= $department->id?>">
				<td><?= $this->Number->format($department->id) ?></td>
				<td id="department_name_<?=$department->id?>"><?= h($department->name) ?></td>
				<td class="actions">
					<?= $this->Form->postLink(__('Delete'), ['controller' => 'departments',  'action' => 'delete', $department->id], ['confirm' => __('Are you sure you want to delete "{0}" Department?', $department->name)]) ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
	