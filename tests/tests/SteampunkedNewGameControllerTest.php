<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
require __DIR__ . "/../../vendor/autoload.php";

class SteampunkedNewGameControllerTest extends \PHPUnit_Framework_TestCase
{
	public function test1() {
		//$this->assertEquals($expected, $actual);
	}

	public function test_construct() {
		$game = new \Steampunked\Steampunked(1234);
		$controller = new \Steampunked\SteampunkedNewGameController($game, array());

		$this->assertInstanceOf('\Steampunked\SteampunkedNewGameController', $controller);
		//$this->assertEquals('steampunked-game.php', $controller->getPage());

		$array = array("startGame"=>"yes","player1Name"=>"test1","player2Name"=>"test2","boardSize"=>6);
		$game = new \Steampunked\Steampunked(1234);
		$controller = new \Steampunked\SteampunkedNewGameController($game, $array);

	}


}

/// @endcond
?>
