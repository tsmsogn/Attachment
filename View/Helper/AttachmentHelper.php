<?php
/**
 * Attachment Helper
 *
 * @author   Jose Diaz-Gonzalez
 * @author   Takashi Kikunaga <takashi.shu@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 */
App::uses('AppHelper', 'Helper');

class AttachmentHelper extends AppHelper {

/**
 * @var string
 */
	private $keyDelimiter = '.';

/**
 * @var array
 */
	private $__defaults = array(
		'attachElement' => 'Attachment.Attachment/attach',
		'detachElement' => 'Attachment.Attachment/detach',
		'browse' => array(
			'name' => 'browse',
			'specs' => 'width=700, height=500, menubar=no, toolbar=no, scrollbars=yes',
			'replace' => false
		)
	);

/**
 * @var array
 */
	protected $_imageMimetypes = array(
		'image/bmp',
		'image/gif',
		'image/jpeg',
		'image/pjpeg',
		'image/png',
		'image/vnd.microsoft.icon',
		'image/x-icon',
		'image/x-png',
	);

/**
 * @var array
 */
	public $helpers = array(
		'Html',
		'Form',
		'Image',
		'Js'
	);

/**
 * @param View $View
 * @param array $settings
 */
	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
		$this->View = $View;
		$this->__defaults = Set::merge($this->getOptions, $settings);
	}

/**
 * @param string $nameSpace
 * @return mixed
 */
	public function getOptions($nameSpace = '') {
		return Set::extract($nameSpace, $this->__defaults);
	}

/**
 * @return mixed
 */
	public function js() {
		$object = array(
			'request' => array(
				'query' => $this->request->query,
				'webroot' => $this->request->webroot
			),
			'adminAttachUrl' => router::url(array('plugin' => 'Attachment', 'admin' => true, 'controller' => 'attachments', 'action' => 'attach')),
			'adminDetachUrl' => router::url(array('plugin' => 'Attachment', 'admin' => true, 'controller' => 'attachments', 'action' => 'detach'))
		);
		return $this->Html->scriptBlock('var Attachment = ' . $this->Js->object((object)$object) . ';');
	}

/**
 * @return string
 */
	public function buildKey() {
		return implode($this->keyDelimiter, func_get_args());
	}

/**
 * @param string $key
 * @return array
 */
	public function parseKey($key = '') {
		if (strpos($key, $this->keyDelimiter) === false) {
			return array();
		}
		return explode('.', $key);
	}

/**
 * Checks if a given mimetype is an image mimetype
 *
 * @param string $mimetype mimetype
 * @return bool
 **/
	public function isImage($mimetype) {
		return in_array($mimetype, $this->_imageMimetypes);
	}

/**
 * @param array $attach
 * @param array $attachment
 * @param string $type
 * @param array $options
 * @return string
 */
	public function input($attach = array(), $type = '' , $options = array()) {
		$defaults = array('wrap' => 'div');
		$options += $defaults;
		$output = '';

		extract($attach);

		$key = $this->buildKey($relation, $name, $model, $name);

		$data = $this->request->data;

		$isPost = $this->request->is(array('post', 'put'));

		if ($isPost && isset($data[$relation][$name]['Attached']['attachment_id'])) { // For Post
			$output .= $this->generateDetachTag($key, $type, array('Attachment' => $data[$relation][$name]['Attachment']));
		} else if (!$isPost && ($index = array_search($name, Set::extract("/$relation/Attached/name", $data))) !== false && isset($data[$relation][$index]['Attached']['attachment_id'])) { // For Edit
			$output .= $this->generateDetachTag($key, $type, array('Attachment' => $data[$relation][$index]));
		} else {
			$output .= $this->generateAttachTag($key, $type);
		}

		$tag = (is_string($options['wrap'])) ? $options['wrap'] : 'div';
		$output = $this->Html->tag($tag, $output, array('id' => $key));

		$output .= $this->Form->hidden("$relation.$name.Attached.model", array('value' => $model));
		$output .= $this->Form->hidden("$relation.$name.Attached.name", array('value' => $name));

		$this->Form->unlockField("$relation.$name.Attached.attachment_id");
		$this->Form->unlockField("$relation.$name.Attachment.id");
		$this->Form->unlockField("$relation.$name.Attachment.attachment");
		$this->Form->unlockField("$relation.$name.Attachment.dir");
		$this->Form->unlockField("$relation.$name.Attachment.type");
		$this->Form->unlockField("$relation.$name.Attachment.size");
		$this->Form->unlockField("$relation.$name.Attachment.active");
		$this->Form->unlockField("$relation.$name.Attachment.settings");
		$this->Form->unlockField("$relation.$name.Attachment.created");
		$this->Form->unlockField("$relation.$name.Attachment.updated");

		return $output;
	}

/**
 * @param $key
 * @param $type
 * @return string
 */
	public function generateAttachTag($key, $type) {
		$options = $this->getOptions();

		return $this->View->element($options['attachElement'], array(
			'key' => $key,
			'type' => $type
		));
	}

/**
 * @param $key
 * @param $type
 * @param $attachment
 * @return string
 */
	public function generateDetachTag($key, $type, $attachment) {
		$options = $this->getOptions();

		return $this->View->element($options['detachElement'], array(
			'key' => $key,
			'type' => $type,
			'attachment' => $attachment
		));
	}

/**
 * @param $key
 * @param $type
 * @param bool $full_base
 * @return string
 */
	public function buildBrowseUrl($key, $type, $full_base = false) {
		return Router::url(array(
			'admin' => true,
			'plugin' => 'attachment',
			'controller' => 'attachments',
			'action' => 'index',
			'?' => array(
				'key' => $key,
				'type' => $type
			)), $full_base
		);
	}

/**
 * @param $path
 * @return bool
 */
	public function existsUnderWebroot($path) {
		return strpos($path, WWW_ROOT) === 0;
	}

/**
 * @param $id
 * @param $attachment
 * @param $size
 * @param $settings
 * @return string
 */
	public function getThumbnailPath($id, $attachment, $size, $settings) {
		extract(json_decode($settings, true));

		$pathInfo = $this->_pathinfo($attachment);

		$thumbnailName = $this->_getThumbnailName($thumbnailName, $thumbnailPrefixStyle);

		$fileName = str_replace(
			array('{size}', '{filename}'),
			array($size, $pathInfo['filename']),
			$thumbnailName
		);

		return $thumbnailPath . $id . DS . $fileName . '.' . $pathInfo['extension'];
	}

/**
 * @param $id
 * @param $attachment
 * @param $settings
 * @return string
 */
	public function getPath($id, $attachment, $settings) {
		extract(json_decode($settings, true));

		return $path . $id . DS . $attachment;
	}

/**
 * @param $id
 * @param $attachment
 * @param $size
 * @param $settings
 * @param bool $full
 * @return string
 */
	public function getThumbnailUrl($id, $attachment, $size, $settings, $full = false) {
		$path = $this->getThumbnailPath($id, $attachment, $size, $settings);

		if (!$this->existsUnderWebroot($path)) { // @todo readfile?
			return '';
		}

		$url = Router::normalize(substr($path, strlen(WWW_ROOT)));

		return ($full) ? FULL_BASE_URL . $url : $url;
	}

/**
 * @param $id
 * @param $attachment
 * @param $settings
 * @param bool $full
 * @return string
 */
	public function getUrl($id, $attachment, $settings, $full = false) {
		$path = $this->getPath($id, $attachment, $settings);

		if (!$this->existsUnderWebroot($path)) { // @todo readfile?
			return '';
		}

		$url = Router::normalize(substr($path, strlen(WWW_ROOT)));

		return ($full) ? FULL_BASE_URL . $url : $url;
	}

/**
 * Returns the thumbnail name format
 *
 * @param string $configuredName Configured name
 * @param string $usePrefixStyle Whether to use prefix style or not
 * @return string
 */
	protected function _getThumbnailName($configuredName, $usePrefixStyle) {
		if ($configuredName !== null) {
			return $configuredName;
		}

		if ($usePrefixStyle) {
			return '{size}_{filename}';
		}

		return '{filename}_{size}';
	}

/**
 * Returns the pathinfo for a file
 *
 * @param string $filename name of file on disk
 * @return array
 **/
	protected function _pathinfo($filename) {
		$pathInfo = pathinfo($filename);

		if (!isset($pathInfo['extension']) || !strlen($pathInfo['extension'])) {
			$pathInfo['extension'] = '';
		}

		// PHP < 5.2.0 doesn't include 'filename' key in pathinfo. Let's try to fix this.
		if (empty($pathInfo['filename'])) {
			$pathInfo['filename'] = basename($pathInfo['basename'], '.' . $pathInfo['extension']);
		}
		return $pathInfo;
	}

}
