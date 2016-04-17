<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
require __DIR__ . "/../../vendor/autoload.php";

class ResetPasswordControllerTest extends \PHPUnit_Extensions_Database_TestCase {

	private static $site;

	public function test_construct() {
		$root = self::$site->getRoot();

		// Test cancel
		$controller = new \Steampunked\ResetPasswordController(self::$site, array('email' => 'wiechecm'));

		$this->assertInstanceOf('\Steampunked\ResetPasswordController', $controller);
		$this->assertEquals("$root/", $controller->getRedirect());
	}

	public static function setUpBeforeClass() {
		self::$site = new Steampunked\Site();
		$localize  = require 'localize.inc.php';
		if(is_callable($localize)) {
			$localize(self::$site);
		}
	}

	/**
	 * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
	 */
	public function getConnection() {
		return $this->createDefaultDBConnection(self::$site->pdo(), 'steele41');
	}

	/**
	 * @return PHPUnit_Extensions_Database_DataSet_IDataSet
	 */
	public function getDataSet() {
		return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/validator.xml');
	}
}

/// @endcond
?>
