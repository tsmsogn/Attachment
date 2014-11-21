<?php
App::uses('AttachmentAppController', 'Attachment.Controller');
/**
 * Attachments Controller
 *
 * @property Attachment $Attachment
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AttachmentsController extends AttachmentAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'RequestHandler');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Attachment->recursive = 0;

		$browseType = '';
		if (isset($this->request->query['CKEditorFuncNum']) && $this->request->query['CKEditorFuncNum']) {
			$browseType = 'ckeditor';
		} else if (isset($this->request->query['key']) && $this->request->query['key']) {
			$browseType = 'browse';
		}

		$type = (isset($this->request->query['type'])) ? $this->request->query['type'] : '';

		if ($type !== '') {
			$this->Paginator->settings = array(
				'conditions' => array(
					'type LIKE' => $type
				)
			);
		}

		$this->set('attachments', $this->Paginator->paginate());
		$this->set('browseType', $browseType);
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Attachment->exists($id)) {
			throw new NotFoundException(__d('attachment', 'Invalid attachment'));
		}
		$options = array('conditions' => array('Attachment.' . $this->Attachment->primaryKey => $id));
		$this->set('attachment', $this->Attachment->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$uploadSettingKey = (isset($this->request->query['uploadSetting'])) ? $this->request->query['uploadSetting'] : '';
		$validateSettingKey = (isset($this->request->query['validateSetting'])) ? $this->request->query['validateSetting'] : '';

		if ($uploadSettingKey !== '') {
			$this->Attachment->uploadSettings('attachment', Configure::read("Attachment.uploadSettings.$uploadSettingKey"));
		}
		if ($validateSettingKey !== '') {
			$this->Attachment->validate['Upload.Upload']['attachment'] = Configure::read("Attachment.validaSettings.$validateSettingKey");
		}

		if ($this->request->is('post')) {
			$this->Attachment->create();
			if ($this->Attachment->save($this->request->data)) {
				$this->Session->setFlash(__d('attachment', 'The attachment has been saved.'));
				return $this->redirect(array('action' => 'index', '?' => $this->request->query));
			} else {
				$this->Session->setFlash(__d('attachment', 'The attachment could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Attachment->exists($id)) {
			throw new NotFoundException(__d('attachment', 'Invalid attachment'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Attachment->save($this->request->data)) {
				$this->Session->setFlash(__d('attachment', 'The attachment has been saved.'));
				return $this->redirect(array('action' => 'index', '?' => $this->request->query));
			} else {
				$this->Session->setFlash(__d('attachment', 'The attachment could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Attachment.' . $this->Attachment->primaryKey => $id));
			$this->request->data = $this->Attachment->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Attachment->id = $id;
		if (!$this->Attachment->exists()) {
			throw new NotFoundException(__d('attachment', 'Invalid attachment'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Attachment->delete()) {
			$this->Session->setFlash(__d('attachment', 'The attachment has been deleted.'));
		} else {
			$this->Session->setFlash(__d('attachment', 'The attachment could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index', '?' => $this->request->query));
	}

/**
 * @param null $id
 * @param null $settings
 * @throws NotFoundException
 */
	public function admin_read_file($id = null, $settings = null) {
		$this->Attachment->id = $id;
		if (!$this->Attachment->exists()) {
			throw new NotFoundException(__d('attachment', 'Invalid attachment'));
		}
		$options = array('conditions' => array('Attachment.' . $this->Attachment->primaryKey => $id));
		$attachment = $this->Attachment->find('first', $options);
		$settings = json_decode($attachment['Attachment']['settings'], true);

		$file = new File($settings['path'] . $id . DS . $attachment['Attachment']['attachment']);

		if (!$file->exists() || !$file->readable()) {
			throw new NotFoundException(__d('attachment', 'Invalid attachment'));
		}

		$this->RequestHandler->respondAs($attachment['Attachment']['type']);
		$this->autoRender = false;
		echo $file->read();
		$file->close();
	}

/**
 * @param null $id
 * @throws NotFoundException
 */
	public function admin_attach($id = null) {
		$this->Attachment->id = $id;
		if (!$this->Attachment->exists()) {
			throw new NotFoundException(__d('attachment', 'Invalid attachment'));
		}

		if (func_num_args() < 2) {
			throw new NotFoundException(__d('attachment', 'Invalid attachment'));
		}

		$key = $type = '';
		if (func_num_args() == 2) {
			$key = func_get_arg(1);
		} else {
			$key = func_get_arg(1);
			$type = func_get_arg(2);
		}

		$this->viewClass = 'Json';
		$view = new View($this);

		$name = isset($this->helpers['Attachment.Attachment']['detachElement']) ? $this->helpers['Attachment.Attachment']['detachElement'] : 'Attachment.Attachment/detach';

		$options = array('conditions' => array('Attachment.' . $this->Attachment->primaryKey => $id));
		$attachment = $this->Attachment->find('first', $options);

		// Generate returned HTML
		$html = $view->element($name, array('key' => $key, 'type' => $type, 'attachment' => $attachment));

		$this->set(compact('attachment', 'html'));
		$this->set('_serialize', array('attachment', 'html'));
	}

/**
 * @param null $id
 * @throws NotFoundException
 */
	public function admin_detach($id = null) {
		$this->Attachment->id = $id;
		if (!$this->Attachment->exists()) {
			throw new NotFoundException(__d('attachment', 'Invalid attachment'));
		}

		if (func_num_args() < 2) {
			throw new NotFoundException(__d('attachment', 'Invalid attachment'));
		}

		$key = $type = '';
		if (func_num_args() == 2) {
			$key = func_get_arg(1);
		} else {
			$key = func_get_arg(1);
			$type = func_get_arg(2);
		}

		$this->viewClass = 'Json';
		$view = new View($this);

		$name = isset($this->helpers['Attachment.Attachment']['attachElement']) ? $this->helpers['Attachment.Attachment']['attachElement'] : 'Attachment.Attachment/attach';

		$options = array('conditions' => array('Attachment.' . $this->Attachment->primaryKey => $id));
		$attachment = $this->Attachment->find('first', $options);

		// Generate returned HTML
		$html = $view->element($name, array('key' => $key, 'type' => $type, 'attachment' => $attachment));

		$this->set(compact('attachment', 'html'));
		$this->set('_serialize', array('attachment', 'html'));
	}

}
