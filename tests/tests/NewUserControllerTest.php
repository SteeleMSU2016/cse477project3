<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
require __DIR__ . "/../../vendor/autoload.php";

class NewUserControllerTest extends \PHPUnit_Extensions_Database_TestCase {

	private static $site;

	public function test_construct() {
		$session = array();	// Fake session
		$root = self::$site->getRoot();

		$controller = new \Steampunked\NewUserController(self::$site, $session,
			array('email' => 'wiechecm', 'confirmEmail' => 'wiechecm', 'name' => 'Matt'));

		$this->assertInstanceOf('\Steampunked\NewUserController', $controller);
		$this->assertEquals("$root/index.php", $controller->getRedirect());

		// Test emails do not match
		$controller = new \Steampunked\NewUserController(self::$site, $session,
			array('email' => 'wiechecm', 'confirmEmail' => 'wie', 'name' => 'Matt'));
		$this->assertEquals("$root/new-user.php?e", $controller->getRedirect());

		// Test user with email already exists
		$controller = new \Steampunked\NewUserController(self::$site, $session,
			array('email' => 'cbowen@cse.msu.edu', 'confirmEmail' => 'cbowen@cse.msu.edu', 'name' => 'Matt'));
		$this->assertEquals("$root/new-user.php?n", $controller->getRedirect());
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
		return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/user.xml');
	}
}

/// @endcond
?>
