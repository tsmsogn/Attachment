<div class="attachments form">
<?php echo $this->Form->create('Attachment'); ?>
	<fieldset>
		<legend><?php echo __d('attachment', 'Admin Edit Attachment'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('attachment');
		echo $this->Form->input('dir');
		echo $this->Form->input('type');
		echo $this->Form->input('size');
		echo $this->Form->input('active');
		echo $this->Form->input('settings');
	?>
	</fieldset>
<?php echo $this->Form->end(__d('attachment', 'Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __d('attachment', 'Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__d('attachment', 'Delete'), array('action' => 'delete', $this->Form->value('Attachment.id'), '?' => $this->request->query), null, __d('attachment', 'Are you sure you want to delete # %s?', $this->Form->value('Attachment.id'))); ?></li>
		<li><?php echo $this->Html->link(__d('attachment', 'List Attachments'), array('action' => 'index', '?' => $this->request->query)); ?></li>
	</ul>
</div>
