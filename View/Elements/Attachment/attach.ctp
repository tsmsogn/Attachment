<?php
$options = $this->Attachment->getOptions('browse');
$browseUrl = $this->Attachment->buildBrowseUrl($key, $type, true);

echo $this->Html->link(__('Browse'), '#', array(
	'onclick' => "Attachment.browse('" . $browseUrl . "', '" . $options['name'] . "', '" . $options['specs'] . "', '" . $options['replace'] . "'); return false;",
	'escape' => false
));
?>