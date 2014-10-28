<?php
$attachmentUrl = $this->Attachment->getThumbnailUrl($attachment['Attachment']['id'], $attachment['Attachment']['attachment'], 'thumb', $attachment['Attachment']['settings']);
echo $this->Html->image($attachmentUrl);

$options = $this->Attachment->getOptions('browse');
$browseUrl = $this->Attachment->buildBrowseUrl($key, $type, true);

list($relation, $i, $model, $name) = $this->Attachment->parseKey($key);

echo $this->Form->hidden("$relation.$i.Attached.attachment_id", array('value' => $attachment['Attachment']['id']));

echo $this->Html->link(__('Browse'), '#', array(
	'onclick' => "Attachment.browse('" . $browseUrl . "', '" . $options['name'] . "', '" . $options['specs'] . "', '" . $options['replace'] . "'); return false;",
	'escape' => false
));
echo $this->Html->link(__('Detach'), '#', array(
	'onclick' => "Attachment.detach('" . $attachment['Attachment']['id'] . "', '" . $key . "'); return false;"
));

if (!empty($attachment['Attachment'])) {
	foreach ($attachment['Attachment'] as $field => $value) {
		if (!is_array($value)) {
			echo $this->Form->hidden("$relation.$i.Attachment.$field", array('value' => $value));
		}
	}
}
?>