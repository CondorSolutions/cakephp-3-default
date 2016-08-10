<?php 
?>
	<a href="standardShifts/add"><button class="button primary" ><span class="mif-plus"></span> New Standard Shift</button></a>
	<table class="dataTable striped hovered border bordered" data-role="" data-auto-width="false" style="width: 700px;">
		<thead>
		<tr >
			<td>ID</td>
			<td>Shift Name</td>
			<td>Start</td>
			<td>End</td>
			<td>Break(mins.)</td>
			<td>Full Shift</td>
			<td>Actions</td>
		</tr>
		</thead>
		<tbody>
			<?php foreach ($standardShifts as $standardShift): ?>
				<tr style="cursor: pointer;" onclick="selectLocation(<?= $standardShift->id?>)" id="location_<?= $standardShift->id?>">
					<td><?= $this->Number->format($standardShift->id) ?></td>
					<td id="location_name_<?=$standardShift->id?>"><?= h($standardShift->name) ?></td>
					<td><?= tt($standardShift->start) ?></td>
					<td><?= tt($standardShift->end) ?></td>
					<td><?= h($standardShift->break_minutes) ?></td>
					<td><?= ($standardShift->is_full_shift)? "Yes":"No" ?></td>
					<td class="actions">
						<?= $this->Html->link(__('Edit'), ['controller' => 'standardShifts', 'action' => 'edit', $standardShift->id]) ?> | 
						<?= $this->Form->postLink(__('Delete'), ['controller' => 'StandardShifts', 'action' => 'delete', $standardShift->id], ['confirm' => __('Are you sure you want to delete "{0}" standard shift?', $standardShift->name)]) ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
