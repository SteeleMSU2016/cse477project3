<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
class SiteTest extends \PHPUnit_Framework_TestCase
{
	public function test1() {
		$view = new Steampunked\Site();

		$view->setRoot('another');
		$this->assertEquals('another', $view->getRoot());

		$view->setEmail('another');
		$this->assertEquals('another', $view->getEmail());


		$this->assertEquals('', $view->getTablePrefix());

	}

	public function test_localize() {
		$site = new Steampunked\Site();
		$localize = require 'localize.inc.php';
		if(is_callable($localize)) {
			$localize($site);
		}
		$this->assertEquals('testP2_', $site->getTablePrefix());
	}


}

/// @endcond
?>
