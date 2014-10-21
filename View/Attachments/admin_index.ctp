<?php
echo $this->Attachment->js();
echo $this->Html->script('/Attachment/js/attachment');
?>
<div class="attachments index">
	<h2><?php echo __('Attachments'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<?php if ($browseType == 'ckeditor') : ?>
				<th></th>
			<?php elseif ($browseType == 'browse') : ?>
				<th></th>
			<?php endif; ?>
			<th></th>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('attachment'); ?></th>
			<th><?php echo $this->Paginator->sort('dir'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('size'); ?></th>
			<th><?php echo $this->Paginator->sort('active'); ?></th>
			<th><?php echo $this->Paginator->sort('settings'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('updated'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($attachments as $attachment): ?>
	<tr>
		<?php if ($browseType == 'ckeditor') : ?>
			<td><?php echo $this->Html->link(__('Attach'), '#', array('onclick' => "Attachment.attachToCKEditor('" . Router::url($this->Attachment->getUrl($attachment['Attachment']['id'], $attachment['Attachment']['attachment'], $attachment['Attachment']['settings'])) . "'); return false;")); ?>&nbsp;</td>
		<?php elseif ($browseType == 'browse') : ?>
			<td><?php echo $this->Html->link(__('Attach'), '#', array('onclick' => "Attachment.attach({$attachment['Attachment']['id']}, '{$this->request->query['key']}'); return false;")); ?>&nbsp;</td>
		<?php endif; ?>
		<td><?php echo $this->Html->image($this->Attachment->getThumbnailUrl($attachment['Attachment']['id'], $attachment['Attachment']['attachment'], 'thumb', $attachment['Attachment']['settings'])); ?>&nbsp;</td>
		<td><?php echo h($attachment['Attachment']['id']); ?>&nbsp;</td>
		<td><?php echo h($attachment['Attachment']['attachment']); ?>&nbsp;</td>
		<td><?php echo h($attachment['Attachment']['dir']); ?>&nbsp;</td>
		<td><?php echo h($attachment['Attachment']['type']); ?>&nbsp;</td>
		<td><?php echo h($attachment['Attachment']['size']); ?>&nbsp;</td>
		<td><?php echo h($attachment['Attachment']['active']); ?>&nbsp;</td>
		<td><?php echo h($attachment['Attachment']['settings']); ?>&nbsp;</td>
		<td><?php echo h($attachment['Attachment']['created']); ?>&nbsp;</td>
		<td><?php echo h($attachment['Attachment']['updated']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $attachment['Attachment']['id'], '?' => $this->request->query)); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $attachment['Attachment']['id'], '?' => $this->request->query)); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $attachment['Attachment']['id'], '?' => $this->request->query), null, __('Are you sure you want to delete # %s?', $attachment['Attachment']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Attachment'), array('action' => 'add', '?' => Set::merge($this->request->query, array('browse' => true)))); ?></li>
	</ul>
</div>
