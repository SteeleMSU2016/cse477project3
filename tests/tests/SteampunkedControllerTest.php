<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */

require __DIR__ . "/../../vendor/autoload.php";
use SteamPunked\Steampunked as Steampunked;
use Steampunked\SteampunkedController as Controller;

class SteampunkedControllerTest extends \PHPUnit_Framework_TestCase
{
	public function test_construct() {
		$game = new \Steampunked\Steampunked(1234);
		$controller = new \Steampunked\SteampunkedController($game, array());

		$this->assertInstanceOf('\Steampunked\SteampunkedController', $controller);
		$this->assertEquals('steampunked-game.php', $controller->getPage());

		$array = array("startGame"=>"yes","player1Name"=>"test1","player2Name"=>"test2","boardSize"=>6);
		$game = new \Steampunked\Steampunked(1234);
		$controller = new \Steampunked\SteampunkedController($game, $array);
		$this->assertEquals(null, $controller->resetGame());
	}

	public function test_giveUp(){
		$array = array("giveUp"=>"yes");
		$game = new \Steampunked\Steampunked(1234);
		$controller = new \Steampunked\SteampunkedController($game, $array);
		$this->assertNotEquals(null, $controller->getSteampunked());
	}

	public function test_newGame(){
		$array = array("newGamePage"=>"yes");
		$game = new \Steampunked\Steampunked(1234);
		$controller = new \Steampunked\SteampunkedController($game, $array);
		$this->assertEquals("index.php", $controller->getPage());
		$this->assertEquals(true, $controller->resetGame());
	}

	public function test_openValve(){
		$array = array("openValve"=>"yes");
		$game = new \Steampunked\Steampunked(1234);
		$controller = new \Steampunked\SteampunkedController($game, $array);
		$this->assertNotEquals(null, $controller->getSteampunked());
	}

	public function test_discard(){
		$array = array("discard"=>"yes", "selectedButton"=>2);
		$game = new \Steampunked\Steampunked(1234);
		$game->initGame(6,"test1","test2");
		$controller = new \Steampunked\SteampunkedController($game, $array);
		$this->assertNotEquals("test1", $controller->getSteampunked()->getCurrentPlayer()->getPlayerName());
	}

	public function test_rotate(){
		$array = array("rotate"=>"yes", "selectedButton"=>2);
		$game = new \Steampunked\Steampunked(1234);
		$game->initGame(6,"test1","test2");
		$controller = new \Steampunked\SteampunkedController($game, $array);
		$this->assertNotEquals("test2", $controller->getSteampunked()->getCurrentPlayer()->getPlayerName());
	}
}

/// @endcond
?>
