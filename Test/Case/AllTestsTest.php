<?php
class AllTestsTest extends PHPUnit_Framework_TestSuite {

/**
 * suite
 *
 * @return CakeTestSuite
 */
	public static function suite() {
		$suite = new CakeTestSuite('All Attachment tests');
		$suite->addTestDirectoryRecursive(CakePlugin::path('Attachment') . 'Test' . DS . 'Case' . DS);
		return $suite;
	}

}
