<?php
App::uses('AttachmentAppModel', 'Attachment.Model');
/**
 * Attachment Model
 *
 * @property Attached $Attached
 */
class Attachment extends AttachmentAppModel {

	public $actsAs = array(
		'Upload.Upload' => array(
			'attachment' => array(
			),
		),
	);

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'attachment';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'attachment' => array(
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	public function beforeSave($options = array()) {
		$this->data[$this->alias]['settings'] = json_encode($this->Behaviors->Upload->settings[$this->alias]['attachment']);
		return true;
	}

}
