<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */

require __DIR__ . "/../../vendor/autoload.php";
use SteamPunked\Steampunked as Steampunked;
use Steampunked\Tile as Tile;

class TileTest extends \PHPUnit_Framework_TestCase
{
	public function testConstruct() {
		$tile = new Tile(Tile::TEE, Tile::NINETY_ROTATION);
		$this->assertEquals(Tile::TEE, $tile->getPieceType());
		$this->assertEquals(Tile::NINETY_ROTATION, $tile->getRotation());
	}

	public function testRotate() {
		$tile = new Tile(Tile::TEE, Tile::NINETY_ROTATION);
		$this->assertEquals(Tile::NINETY_ROTATION, $tile->getRotation());
		$this->assertEquals(true,$tile->checkOpening(0));
		$tile->rotatePiece();
		$this->assertEquals(Tile::HALF_ROTATION, $tile->getRotation());
		$this->assertEquals(true,$tile->checkOpening(1));
		$tile->rotatePiece();
		$this->assertEquals(Tile::TWO_SEVENTY_ROTATION, $tile->getRotation());
		$this->assertEquals(true,$tile->checkOpening(2));
		$tile->rotatePiece();
		$this->assertEquals(Tile::ZERO_ROTATION, $tile->getRotation());
		$this->assertEquals(true,$tile->checkOpening(3));
		$tile->rotatePiece();
		$this->assertEquals(Tile::NINETY_ROTATION, $tile->getRotation());
		$this->assertEquals(true,$tile->checkOpening(0));
	}
}

/// @endcond
?>
