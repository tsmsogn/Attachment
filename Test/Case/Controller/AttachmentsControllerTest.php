<?php
App::uses('AttachmentsController', 'Attachment.Controller');

/**
 * AttachmentsController Test Case
 *
 */
class AttachmentsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.attachment.attachment'
	);

/**
 * testAdminIndexUno method
 *
 * @return void
 */
	public function testAdminIndexUno() {
		$result = $this->_testAction('/admin/attachment/attachments/index');
		debug($result);
	}

/**
 * testAdminIndexDos method
 *
 * @return void
 */
	public function testAdminIndexDos() {
		$this->_testAction('/admin/attachment/attachments/index?CKEditorFuncNum=1');
		$expect = 'ckeditor';
		$this->assertTextEquals($expect, $this->vars['browseType']);
	}

/**
 * testAdminIndexTres method
 *
 * @return void
 */
	public function testAdminIndexTres() {
		$this->_testAction('/admin/attachment/attachments/index?key=1');
		$expect = 'browse';
		$this->assertTextEquals($expect, $this->vars['browseType']);
	}

/**
 * testAdminViewWithInvalidId method
 *
 * @return void
 */
	public function testAdminViewWithInvalidId() {
		$this->setExpectedException('NotFoundException');
		$result = $this->_testAction('/admin/attachment/attachments/view/0', array('method' => 'GET'));
		debug($result);
	}

/**
 * testAdminViewWithJson method
 *
 * @return void
 */
	public function testAdminViewWithJson() {
		$result = $this->_testAction('/admin/attachment/attachments/view/1.json', array('method' => 'GET'));
		debug($result);
	}

/**
 * testAdminView method
 *
 * @return void
 */
	public function testAdminView() {
	}

/**
 * testAdminAddUno method
 *
 * @return void
 */
	public function testAdminAddUno() {
		$data = array(
			'Attachment' => array(
				'title' => 'title',
				'attachment' => 'attachment',
				'settings' => 'settings'
			)
		);
		$result = $this->_testAction('/admin/attachment/attachments/add?foo=1', array('data' => $data));
		$this->assertContains('/admin/attachment?foo=1', $this->headers['Location']);
		debug($result);
	}

/**
 * testAdminEdit method
 *
 * @return void
 */
	public function testAdminEdit() {
	}

/**
 * testAdminDeleteWithInvalidId method
 *
 * @return void
 */
	public function testAdminDeleteWithInvalidId() {
		$this->setExpectedException('NotFoundException');
		$result = $this->_testAction('/admin/attachment/attachments/delete/0');
		debug($result);
	}

/**
 * testAdminDeleteWithNotAllowedMethod method
 *
 * @return void
 */
	public function testAdminDeleteWithNotAllowedMethod() {
		$this->setExpectedException('MethodNotAllowedException');
		$result = $this->_testAction('/admin/attachment/attachments/delete/1', array('method' => 'GET'));
		debug($result);
	}

/**
 * testAdminDeleteUno method
 *
 * @return void
 */
	public function testAdminDeleteUno() {
		$result = $this->_testAction('/admin/attachment/attachments/delete/1');
		debug($result);
	}

/**
 * testAdminAttachUno method
 *
 * @return void
 */
	public function testAdminAttachUno() {
		$this->setExpectedException('NotFoundException');
		$result = $this->_testAction('/admin/attachment/attachments/attach/0');
		debug($result);
	}

/**
 * testAdminAttachDos method
 *
 * @return void
 */
	public function testAdminAttachDos() {
		$this->setExpectedException('NotFoundException');
		$result = $this->_testAction('/admin/attachment/attachments/attach/1');
		debug($result);
	}

/**
 * testAdminAttachTres method
 *
 * @return void
 */
	public function testAdminAttachTres() {
		$this->markTestIncomplete();
	}

/**
 * testAdminDetachUno method
 *
 * @return void
 */
	public function testAdminDetachUno() {
		$this->setExpectedException('NotFoundException');
		$result = $this->_testAction('/admin/attachment/attachments/detach/0');
		debug($result);
	}

/**
 * testAdminDetachDos method
 *
 * @return void
 */
	public function testAdminDetachDos() {
		$this->setExpectedException('NotFoundException');
		$result = $this->_testAction('/admin/attachment/attachments/detach/1');
		debug($result);
	}

/**
 * testAdminDetachTres method
 *
 * @return void
 */
	public function testAdminDetachTres() {
		$this->markTestIncomplete();
	}

}
