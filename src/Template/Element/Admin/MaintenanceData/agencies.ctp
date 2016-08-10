<a href="javascript:void(0)" ><button class="button primary" onclick="addAgencyRow();" ><span class="mif-plus"></span> New Agency</button></a>
<table class="dataTable striped hovered border bordered" data-role="" data-auto-width="false" style="width: 500px;">
	<thead>
	<tr >
		<td>ID</td>
		<td>Agency</td>
		<td>Actions</td>
	</tr>
	</thead>
	<tbody id="agencies_tbody">
		<?php foreach ($agencies as $agency): ?>
			<tr style="cursor: pointer;" onclick="selectLocation(<?= $agency->id?>)" id="department_<?= $agency->id?>">
				<td><?= $this->Number->format($agency->id) ?></td>
				<td id="agencyt_name_<?=$agency->id?>"><?= h($agency->name) ?></td>
				<td class="actions">
					<?= $this->Form->postLink(__('Delete'), ['controller' => 'agencies',  'action' => 'delete', $agency->id], ['confirm' => __('Are you sure you want to delete "{0}" Agency?', $agency->name)]) ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
	