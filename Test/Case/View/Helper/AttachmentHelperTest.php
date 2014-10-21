<?php
App::uses('View', 'View');
App::uses('Helper', 'View');
App::uses('HtmlHelper', 'View/Helper');
App::uses('JsHelper', 'View/Helper');
App::uses('AttachmentHelper', 'Attachment.View/Helper');

/**
 * AttachmentHelper Test Case
 *
 */
class AttachmentHelperTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$View = new View();
		$this->Html = new HtmlHelper($View);
		$this->Js = new JsHelper($View);
		$this->Attachment = new AttachmentHelper($View, array('foo' => 1, 'bar' => array('baz' => 2)));
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Ckeditor);

		parent::tearDown();
	}

/**
 * testGetOptionsUno method
 */
	public function testGetOptionsUno() {
		$expected = array('foo' => 1, 'bar' => array('baz' => 2));
		$actual = $this->Attachment->getOptions();
		$this->assertEqual($expected, $actual);
	}

/**
 * testGetOptionsDos method
 */
	public function testGetOptionsDos() {
		$expected = array('baz' => 2);
		$actual = $this->Attachment->getOptions('bar');
		$this->assertEqual($expected, $actual);
	}

/**
 * testJs method
 */
	public function testJs() {
		$object = array(
			'request' => array(
				'query' => array(),
				'webroot' => '/'
			),
			'adminAttachUrl' => '/admin/attachment/attachments/attach',
			'adminDetachUrl' => '/admin/attachment/attachments/detach'
		);
		$expected = $this->Html->scriptBlock('var Attachment = ' . $this->Js->object((object)$object) . ';');
		$actual = $this->Attachment->js();
		$this->assertTextEquals($expected, $actual);
	}

/**
 * testBuildKeyUno method
 */
	public function testBuildKeyUno() {
		$expect = '';
		$actual = $this->Attachment->buildKey();
		$this->assertTextEquals($expect, $actual);
	}

/**
 * testBuildKeyDos method
 */
	public function testBuildKeyDos() {
		$expect = 'foo.bar';
		$actual = $this->Attachment->buildKey('foo', 'bar');
		$this->assertTextEquals($expect, $actual);
	}

/**
 * testParseKeyUno method
 */
	public function testParseKeyUno() {
		$expect = array();
		$actual = $this->Attachment->parseKey();
		$this->assertEqual($expect, $actual);
	}

/**
 * testParseKeyDos method
 */
	public function testParseKeyDos() {
		$expect = array('foo', 'bar');
		$actual = $this->Attachment->parseKey('foo.bar');
		$this->assertEqual($expect, $actual);
	}

/**
 * testBuildBrowseUrlUno method
 */
	public function testBuildBrowseUrlUno() {
		$expect = '/admin/attachment/attachments?key=foo&type=bar';
		$actual = $this->Attachment->buildBrowseUrl('foo', 'bar');
		$this->assertTextEquals($expect, $actual);
	}

/**
 * testExistsUnderWebrootUno method
 */
	public function testExistsUnderWebrootUno() {
		$this->assertFalse($this->Attachment->existsUnderWebroot('/', WWW_ROOT));
	}

/**
 * testExistsUnderWebrootDos method
 */
	public function testExistsUnderWebrootDos() {
		$this->assertTrue($this->Attachment->existsUnderWebroot(WWW_ROOT, WWW_ROOT));
	}

/**
 * testExistsUnderWebrootTres method
 */
	public function testExistsUnderWebrootTres() {
		$this->assertTrue($this->Attachment->existsUnderWebroot(WWW_ROOT . 'foo', WWW_ROOT));
	}

/**
 * testGetThumbnailPathUno method
 */
	public function testGetThumbnailPathUno() {
		$settings = '{"thumbnailName":"foo","thumbnailPath":"\/tmp\/","thumbnailPrefixStyle":true}';
		$actual = $this->Attachment->getThumbnailPath(1, 'bar.png', 'baz', $settings);
		$this->assertTextEquals('/tmp/1/foo.png', $actual);
	}

/**
 * testGetThumbnailPathDos method
 */
	public function testGetThumbnailPathDos() {
		$settings = '{"thumbnailName":null,"thumbnailPath":"\/tmp\/","thumbnailPrefixStyle":true}';
		$actual = $this->Attachment->getThumbnailPath(1, 'bar.png', 'baz', $settings);
		$this->assertTextEquals('/tmp/1/baz_bar.png', $actual);
	}

/**
 * testGetThumbnailPathTres method
 */
	public function testGetThumbnailPathTres() {
		$settings = '{"thumbnailName":null,"thumbnailPath":"\/tmp\/","thumbnailPrefixStyle":false}';
		$actual = $this->Attachment->getThumbnailPath(1, 'bar.png', 'baz', $settings);
		$this->assertTextEquals('/tmp/1/bar_baz.png', $actual);
	}

/**
 * testPathUno method
 */
	public function testPathUno() {
		$settings = '{"path":"\/tmp\/"}';
		$actual = $this->Attachment->getPath(1, 'foo.png', $settings);
		$this->assertTextEquals('/tmp/1/foo.png', $actual);
	}

/**
 * testGetThumbnailUrlUno method
 */
	public function testGetThumbnailUrlUno() {
		$settings = array(
			"thumbnailName" => 'foo',
			"thumbnailPath" => dirname(WWW_ROOT),
			"thumbnailPrefixStyle" => true
		);

		$actual = $this->Attachment->getThumbnailUrl(1, 'bar.png', 'baz', json_encode($settings));
		$this->assertTextEquals('', $actual);
	}

/**
 * testGetThumbnailUrlDos method
 */
	public function testGetThumbnailUrlDos() {
		$settings = array(
			"thumbnailName" => 'foo',
			"thumbnailPath" => WWW_ROOT . 'files' . DS . 'model' . DS . 'field' . DS,
			"thumbnailPrefixStyle" => true
		);
		$actual = $this->Attachment->getThumbnailUrl(1, 'bar.png', 'baz', json_encode($settings));
		$this->assertTextEquals('/files/model/field/1/foo.png', $actual);
	}

/**
 * testGetThumbnailUrlTres method
 */
	public function testGetThumbnailUrlTres() {
		$settings = array(
			"thumbnailName" => 'foo',
			"thumbnailPath" => WWW_ROOT . 'files' . DS . 'model' . DS . 'field' . DS,
			"thumbnailPrefixStyle" => true
		);
		$actual = $this->Attachment->getThumbnailUrl(1, 'bar.png', 'baz', json_encode($settings), true);
		$this->assertTextEquals(FULL_BASE_URL . '/files/model/field/1/foo.png', $actual);
	}

/**
 * testGetUrlUno method
 */
	public function testGetUrlUno() {
		$settings = array(
			"path" => dirname(WWW_ROOT) . DS . 'files' . DS
		);

		$actual = $this->Attachment->getUrl(1, 'foo.png', json_encode($settings));
		$this->assertTextEquals('', $actual);
	}

/**
 * testGetUrlDos method
 */
	public function testGetUrlDos() {
		$settings = array(
			"path" => WWW_ROOT . 'files' . DS
		);
		$actual = $this->Attachment->getUrl(1, 'foo.png', json_encode($settings));
		$this->assertTextEquals('/files/1/foo.png', $actual);
	}

/**
 * testGetUrlTres method
 */
	public function testGetUrlTres() {
		$settings = array(
			"path" => WWW_ROOT . 'files' . DS
		);
		$actual = $this->Attachment->getUrl(1, 'foo.png', json_encode($settings), true);
		$this->assertTextEquals(FULL_BASE_URL . '/files/1/foo.png', $actual);
	}

}
