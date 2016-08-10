<?php 
?>
	<a href="standardDayOffs/add"><button class="button primary" ><span class="mif-plus"></span> New Standard Day Off</button></a>
	<table class="dataTable striped hovered border bordered" data-role="" data-auto-width="false" style="width: 700px;">
		<thead>
		<tr >
			<td>ID</td>
			<td>Day Off Name</td>
			<td>Every</td>
			<td>Actions</td>
		</tr>
		</thead>
		<tbody>
			<?php foreach ($standardDayOffs as $standardDayOff): ?>
				<tr style="cursor: pointer;" onclick="selectLocation(<?= $standardDayOff->id?>)" id="location_<?= $standardDayOff->id?>">
					<td><?= $this->Number->format($standardDayOff->id) ?></td>
					<td id="standard_day_off_name_<?=$standardDayOff->id?>"><?= h($standardDayOff->name) ?></td>
					<?php if($standardDayOff->date == ""):?>
						<td><?= date('l', strtotime("Sunday +{$standardDayOff->day} days"))?>s</td>
					<?php else:?>
						<td><?= date_format($standardDayOff->date, 'F jS')?></td>
					<?php endif;?>
					
					<td class="actions">
						<?= $this->Html->link(__('Edit'), ['controller' => 'standardDayOffs', 'action' => 'edit', $standardDayOff->id]) ?> |
						<?= $this->Form->postLink(__('Delete'), ['controller' => 'standardDayOffs',  'action' => 'delete', $standardDayOff->id], ['confirm' => __('Are you sure you want to delete "{0}" standard day off?', $standardDayOff->name)]) ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
