<div class="attachments view">
<h2><?php echo __('Attachment'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($attachment['Attachment']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Attachment'); ?></dt>
		<dd>
			<?php echo h($attachment['Attachment']['attachment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dir'); ?></dt>
		<dd>
			<?php echo h($attachment['Attachment']['dir']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($attachment['Attachment']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Size'); ?></dt>
		<dd>
			<?php echo h($attachment['Attachment']['size']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Active'); ?></dt>
		<dd>
			<?php echo h($attachment['Attachment']['active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Metas'); ?></dt>
		<dd>
			<?php echo h($attachment['Attachment']['settings']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($attachment['Attachment']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Updated'); ?></dt>
		<dd>
			<?php echo h($attachment['Attachment']['updated']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Attachment'), array('action' => 'edit', $attachment['Attachment']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Attachment'), array('action' => 'delete', $attachment['Attachment']['id']), null, __('Are you sure you want to delete # %s?', $attachment['Attachment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Attachments'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Attachment'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Attacheds'), array('controller' => 'attacheds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Attached'), array('controller' => 'attacheds', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Attacheds'); ?></h3>
	<?php if (!empty($attachment['Attached'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Model'); ?></th>
		<th><?php echo __('Foreign Key'); ?></th>
		<th><?php echo __('Attachment Id'); ?></th>
		<th><?php echo __('Key'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
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
				<?php echo $this->Html->link(__('View'), array('controller' => 'attacheds', 'action' => 'view', $attached['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'attacheds', 'action' => 'edit', $attached['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'attacheds', 'action' => 'delete', $attached['id']), null, __('Are you sure you want to delete # %s?', $attached['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Attached'), array('controller' => 'attacheds', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
