<div class="attachments view">
<h2><?php echo __d('attachment', 'Attachment'); ?></h2>
	<dl>
		<dt><?php echo __d('attachment', 'Id'); ?></dt>
		<dd>
			<?php echo h($attachment['Attachment']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('attachment', 'Attachment'); ?></dt>
		<dd>
			<?php echo h($attachment['Attachment']['attachment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('attachment', 'Dir'); ?></dt>
		<dd>
			<?php echo h($attachment['Attachment']['dir']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('attachment', 'Type'); ?></dt>
		<dd>
			<?php echo h($attachment['Attachment']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('attachment', 'Size'); ?></dt>
		<dd>
			<?php echo h($attachment['Attachment']['size']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('attachment', 'Active'); ?></dt>
		<dd>
			<?php echo h($attachment['Attachment']['active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('attachment', 'Metas'); ?></dt>
		<dd>
			<?php echo h($attachment['Attachment']['settings']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('attachment', 'Created'); ?></dt>
		<dd>
			<?php echo h($attachment['Attachment']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('attachment', 'Updated'); ?></dt>
		<dd>
			<?php echo h($attachment['Attachment']['updated']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __d('attachment', 'Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('attachment', 'Edit Attachment'), array('action' => 'edit', $attachment['Attachment']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__d('attachment', 'Delete Attachment'), array('action' => 'delete', $attachment['Attachment']['id']), null, __d('attachment', 'Are you sure you want to delete # %s?', $attachment['Attachment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('attachment', 'List Attachments'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('attachment', 'New Attachment'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__d('attachment', 'List Attacheds'), array('controller' => 'attacheds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('attachment', 'New Attached'), array('controller' => 'attacheds', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __d('attachment', 'Related Attacheds'); ?></h3>
	<?php if (!empty($attachment['Attached'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __d('attachment', 'Id'); ?></th>
		<th><?php echo __d('attachment', 'Model'); ?></th>
		<th><?php echo __d('attachment', 'Foreign Key'); ?></th>
		<th><?php echo __d('attachment', 'Attachment Id'); ?></th>
		<th><?php echo __d('attachment', 'Key'); ?></th>
		<th><?php echo __d('attachment', 'Created'); ?></th>
		<th><?php echo __d('attachment', 'Modified'); ?></th>
		<th class="actions"><?php echo __d('attachment', 'Actions'); ?></th>
	</tr>
	<?php foreach ($attachment['Attached'] as $attached): ?>
		<tr>
			<td><?php echo $attached['id']; ?></td>
			<td><?php echo $attached['model']; ?></td>
			<td><?php echo $attached['foreign_key']; ?></td>
			<td><?php echo $attached['attachment_id']; ?></td>
			<td><?php echo $attached['key']; ?></td>
			<td><?php echo $attached['created']; ?></td>
			<td><?php echo $attached['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__d('attachment', 'View'), array('controller' => 'attacheds', 'action' => 'view', $attached['id'])); ?>
				<?php echo $this->Html->link(__d('attachment', 'Edit'), array('controller' => 'attacheds', 'action' => 'edit', $attached['id'])); ?>
				<?php echo $this->Form->postLink(__d('attachment', 'Delete'), array('controller' => 'attacheds', 'action' => 'delete', $attached['id']), null, __d('attachment', 'Are you sure you want to delete # %s?', $attached['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__d('attachment', 'New Attached'), array('controller' => 'attacheds', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
