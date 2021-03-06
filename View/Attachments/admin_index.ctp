<?php
echo $this->Attachment->js();
echo $this->Html->script('/Attachment/js/attachment');
?>
<div class="attachments index">
	<h2><?php echo __d('attachment', 'Attachments'); ?></h2>
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
			<th class="actions"><?php echo __d('attachment', 'Actions'); ?></th>
	</tr>
	<?php foreach ($attachments as $attachment): ?>
	<tr>
		<?php if ($browseType == 'ckeditor') : ?>
			<td><?php echo $this->Html->link(__d('attachment', 'Attach'), '#', array('onclick' => "Attachment.attachToCKEditor('" . Router::url($this->Attachment->getUrl($attachment['Attachment']['id'], $attachment['Attachment']['attachment'], $attachment['Attachment']['settings']), true) . "'); return false;")); ?>&nbsp;</td>
		<?php elseif ($browseType == 'browse') : ?>
			<td><?php echo $this->Html->link(__d('attachment', 'Attach'), '#', array('onclick' => "Attachment.attach({$attachment['Attachment']['id']}, '{$this->request->query['key']}'); return false;")); ?>&nbsp;</td>
		<?php endif; ?>
		<td>
			<?php
			if ($this->Attachment->isImage($attachment['Attachment']['type'])) {
				$path = Router::url(array('action' => 'read_file', $attachment['Attachment']['id']));
				echo $this->Html->tag('img', null, array('src' => $path));
			} else {
				// @todo
			}
			?>&nbsp;
		</td>
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
			<?php echo $this->Html->link(__d('attachment', 'View'), array('action' => 'view', $attachment['Attachment']['id'], '?' => $this->request->query)); ?>
			<?php echo $this->Html->link(__d('attachment', 'Edit'), array('action' => 'edit', $attachment['Attachment']['id'], '?' => $this->request->query)); ?>
			<?php echo $this->Form->postLink(__d('attachment', 'Delete'), array('action' => 'delete', $attachment['Attachment']['id'], '?' => $this->request->query), null, __d('attachment', 'Are you sure you want to delete # %s?', $attachment['Attachment']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __d('attachment', 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __d('attachment', 'previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__d('attachment', 'next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __d('attachment', 'Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('attachment', 'New Attachment'), array('action' => 'add', '?' => $this->request->query)); ?></li>
	</ul>
</div>
