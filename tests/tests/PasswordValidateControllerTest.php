<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
require __DIR__ . "/../../vendor/autoload.php";

class PasswordValidateControllerTest extends \PHPUnit_Extensions_Database_TestCase {

	private static $site;

	public function test_construct() {
		$session = array();	// Fake session
		$root = self::$site->getRoot();

		// Test cancel
		$controller = new \Steampunked\PasswordValidateController(self::$site,
			array('validator' => '14831e3f21b', 'cancel' => 'yes',
				'password' => '12341234', 'passwordAgain' => '12341234', 'email' => 'wiechecm'));

		$this->assertInstanceOf('\Steampunked\PasswordValidateController', $controller);
		$this->assertEquals("$root/", $controller->getRedirect());

		// Test password mismatch
		$controller = new \Steampunked\PasswordValidateController(self::$site,
			array('validator' => '14831e3f21b', 'password' => '12341234',
				'passwordAgain' => '123431234', 'email' => 'wiechecm'));

		$this->assertEquals("$root/password-validate.php?e2&v=14831e3f21b", $controller->getRedirect());

		// Test password too short
		$controller = new \Steampunked\PasswordValidateController(self::$site,
			array('validator' => '14831e3f21b', 'password' => '1234',
				'passwordAgain' => '1234', 'email' => 'wiechecm'));

		$this->assertEquals("$root/password-validate.php?e3&v=14831e3f21b", $controller->getRedirect());

		// Test validator was not found
		$controller = new \Steampunked\PasswordValidateController(self::$site,
			array('validator' => '31e3f21b', 'password' => '12341234',
				'passwordAgain' => '12341234', 'email' => 'wiechecm'));

		$this->assertEquals("$root/", $controller->getRedirect());

		// Test email does not match
		$controller = new \Steampunked\PasswordValidateController(self::$site,
			array('validator' => '14831e3f21b', 'password' => '12341234',
				'passwordAgain' => '12341234', 'email' => 'wiechecm'));

		$this->assertEquals("$root/password-validate.php?e1&v=14831e3f21b", $controller->getRedirect());

		// Test everything worked
		$controller = new \Steampunked\PasswordValidateController(self::$site,
			array('validator' => '14831e3f21b', 'password' => '12341234',
				'passwordAgain' => '12341234', 'email' => 'cbowen@cse.msu.edu'));

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
