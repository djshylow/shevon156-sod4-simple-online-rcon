<div id="leftblock">
	 <h2><?php echo __('Navigation') ?></h2>
    <ul class="leftmenu">
        <li><a href="<?php echo URL::site('users/index') ?>"><?php echo __('Manage users') ?></a></li>
    	<li class="active" style="background-image: url(images/log.png)"><a><?php echo __('Actions log') ?></a></li>
    </ul>
</div>
<div id="rightblock">
 <h2><?php echo __('Logs') ?></h2>
<table cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<td><?php echo __('ID') ?></td>
			<td><?php echo __('Username') ?></td>
			<td><?php echo __('Date') ?></td>
			<td><?php echo __('Actions') ?></td>
		</tr>
	</thead>
	<tbody>
		<?php foreach($logs as $l): ?>
		<tr>
			<td><?php echo $l['id'] ?></td>
			<td><?php echo strip_tags($l['username']) ?></td>
			<td><?php echo $l['date'] ?></td>
			<td><?php echo strip_tags($l['content']) ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</div>