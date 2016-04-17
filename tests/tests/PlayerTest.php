<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */

require __DIR__ . "/../../vendor/autoload.php";
use SteamPunked\Steampunked as Steampunked;
use Steampunked\Player as Player;

class PlayerTest extends \PHPUnit_Framework_TestCase
{
	public function testConstruct() {
		$player = new Player("test1");
		$this->assertEquals("test1",$player->getPlayerName());
	}

    public function testPipes() {
        $player = new Player("test1");
        $player->setInitialPipes(array(0,0,0,0,0));
        $this->assertEquals(0, $player->getTileAt(2));
        $player->replaceTileAt(2, 2);
        $this->assertEquals(2, $player->getTileAt(2));
    }

    public function testPlayerNumber() {
        $player = new Player("test1");
        $player->setPlayerNumber(1);
        $this->assertEquals(1, $player->getPlayerNumber(1));
    }
}

/// @endcond
?>
