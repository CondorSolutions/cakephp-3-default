<h1 class="text-light">Users<span class="mif-user place-right"></span></h1>
<hr class="thin bg-grayLighter">
	<a href="users/add"><button class="button primary" ><span class="mif-plus"></span> New User</button></a>
<hr class="thin bg-grayLighter">
<table class="dataTable border bordered" data-role="datatable" data-auto-width="false">
	<thead>
	<tr>
		<td>ID</td>
		<td>Status</td>
		<td>First Name</td>
		<td>Last Name</td>
		<td>Email</td>
		<td>Created</td>
		<td>Modified</td>
		<td>Actions</td>
		<!--  
		<td><?= $this->Paginator->sort('id') ?></td>
		<td><?= $this->Paginator->sort('active') ?></td>
		<td><?= $this->Paginator->sort('first_name') ?></td>
		<td><?= $this->Paginator->sort('last_name') ?></td>
		<td><?= $this->Paginator->sort('email') ?></td>
		<td><?= $this->Paginator->sort('created') ?></td>
		<td><?= $this->Paginator->sort('created_by') ?></td>
		<td><?= $this->Paginator->sort('modified') ?></td>
		<td><?= $this->Paginator->sort('modified_by') ?></td>
		<th class="actions"><?= __('Actions') ?></td>
		-->
	</tr>
	</thead>
	<tbody>
		<?php foreach ($users as $user): ?>
			<tr>
				<td><?= $this->Number->format($user->id) ?></td>
				<td><?= h($user->status) ?></td>
				<td><?= h($user->person->first_name) ?></td>
				<td><?= h($user->person->last_name) ?></td>
				<td><?= h($user->email) ?></td>
				<td><?= h($user->created) ?></td>
				<!-- <td><?= $this->Number->format($user->created_by) ?></td> -->
				<td><?= h($user->modified) ?></td>
				<!-- <td><?= $this->Number->format($user->modified_by) ?></td> -->
				<td class="actions">
					<?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
					<?php //= //$this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
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
