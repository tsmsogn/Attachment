<div class="attachments form">
<?php echo $this->Form->create('Attachment', array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __d('attachment', 'Admin Add Attachment'); ?></legend>
	<?php
		echo $this->Form->input('attachment', array('type' => 'file'));
	?>
	</fieldset>
<?php echo $this->Form->end(__d('attachment', 'Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __d('attachment', 'Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__d('attachment', 'List Attachments'), array('action' => 'index', '?' => $this->request->query)); ?></li>
	</ul>
</div>
