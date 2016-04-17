<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
	public function test1() {
		//$this->assertEquals($expected, $actual);
	}

	public function test_construct() {
		$row = array('id' => 12,
			'email' => 'dude@ranch.com',
			'name' => 'Dude, The',
			'password' => '12345678',
			'pushKey' => '77',

		);
		$user = new Steampunked\User($row);
		$this->assertEquals(12, $user->getId());
		$this->assertEquals('dude@ranch.com', $user->getEmail());
		$this->assertEquals('Dude, The', $user->getName());
		$this->assertEquals('77', $user->getpushKey());
	}

}

/// @endcond
?>
