<h2>Punch Logs</h2>
<h3><?=$selectedUser->full_name?> - <?=date_create($selectedDate)->format('l jS F Y')?></h3>
<table class="table"  style="width: auto;">
<thead>
	<tr>
		<th>Time</th>
		<th>Type</th>
	</tr>
</thead>

<?php foreach ($punchLogs as $punchLog):?>
	<tr>
	<td><?=$punchLog->log_created->i18nFormat('HH:mm:ss p')?></td>
		<td><?= ($punchLog->is_log_in=="1") ? 'In' : 'Out' ?></td>
		
	</tr>
<?php endforeach;?>
</table>
