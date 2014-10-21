# Attachment

[![Build Status](https://travis-ci.org/tsmsogn/Attachment.svg)](https://travis-ci.org/tsmsogn/Attachment)

Attachment plugin for CakePHP.

## Requirements

- CakePHP 2.5+
- [cakephp-upload](https://github.com/josegonzalez/cakephp-upload)
- [jQuery](http://jquery.com/)

## Features

- Admin attachment CRUD
- Support CKEditor callback
- Dosen't support `cakephp-upload` callback methods like `pathMethod`
- Attachments are attached/detached only when relation model is saved

## Installation

Put your app plugin directory as `Attachment`.

### Enable plugin

In 2.0 you need to enable the plugin your app/Config/bootstrap.php file:

```php
<?php
CakePlugin::load('Attachment', array('bootstrap' => false, 'routes' => true));
?>
```

Enable admin routing in app/Config/core.php file:

```php
<?php
Configure::write('Routing.prefixes', array('admin'));
?>
```

### Usage

Update schema:

```sql
CREATE TABLE `attacheds` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `model` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `foreign_key` int(11) NOT NULL,
  `attachment_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `INDEX_MODEL_FOREIGN_KEY` (`model`,`foreign_key`)
)

CREATE TABLE `attachments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attachment` varchar(255) NOT NULL,
  `dir` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `size` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `settings` text NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
)
```

In controller:

```php
<?php
class AppController extends Controller {

	public $helpers = array(
		'Attachment.Attachment' => array(
			'attachElement' => 'Attachment.Attachment/attach',
			'detachElement' => 'Attachment.Attachment/detach'
		)
	);

}
```

In relation model(example):

```php
<?php
class Foo extends AppModel {

	public $hasAndBelongsToMany = array(
		'Video' => array(
			'className' => 'Attachment.Attachment',
			'joinTable' => 'attacheds',
			'foreignKey' => 'foreign_key',
			'associationForeignKey' => 'attachment_id',
			'unique' => 'keepExisting',
			'conditions' => array('Attached.model' => array('Video')),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'Pdf' => array(
			'className' => 'Attachment.Attachment',
			'joinTable' => 'attacheds',
			'foreignKey' => 'foreign_key',
			'associationForeignKey' => 'attachment_id',
			'unique' => 'keepExisting',
			'conditions' => array('Attached.model' => array('Pdf')),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);
}
```

In relation model's view(example):

```php
echo $this->Attachment->js();
echo $this->Html->script('/Attachment/js/attachment');
```

Add `window.attachmentCallback()` method is called when attachment is selected.

```javascript
window.attachmentCallback = function(id, data, error) {
	if (error != null) {
		// Code error
	} else {
		id = id.replace(/\./g, '\\\\\.');
		$('#' + id).html(data.html);
	}
}
```

Add input tag with AttachmentHelper#input();.

```php
<?php
for ($i = 0; $i < 3; $i++) {
	$name = $i + 1;
	echo $this->Attachment->input('Video', 'Video', $name);
}

for ($i = 0; $i < 3; $i++) {
	$name = $i + 1;
	echo $this->Attachment->input('Pdf', 'Pdf', $name);
}
?>
```

## Lisence

The MIT License (MIT)

Copyright (c) 2014 Toshimasa Oguni
