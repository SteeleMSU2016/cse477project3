<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
class GameTest extends \PHPUnit_Framework_TestCase
{
	public function test1() {
		//$this->assertEquals($expected, $actual);
	}

	public function test_construct() {
		$row = array('id' => 12,
			'player1' => '39',
			'player2' => '38',
			'size' => '6',
			'state' => '1',
			'playerTurn' => '2',

		);
		$user = new Steampunked\Game($row);
		$this->assertEquals(12, $user->getId());
		$this->assertEquals('39', $user->getPlayer1());
		$this->assertEquals('38', $user->getPlayer2());
		$this->assertEquals('6', $user->getSize());
		$this->assertEquals('1', $user->getState());
		$this->assertEquals('2', $user->getPlayerTurn());

	}

}

/// @endcond
?>
