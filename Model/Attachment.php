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
				'thumbnailSizes' => array(
					'xvga' => '1024x768',
					'vga' => '640x480',
					'thumb' => '80x80',
				),
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
			'uploadError' => array(
				'rule' => array('uploadError'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	public function beforeSave($options = array()) {
		$this->data[$this->alias]['settings'] = json_encode($this->Behaviors->Upload->settings[$this->alias]['attachment']);
		return true;
	}

}
