<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class
 *
 */

require __DIR__ . "/../../vendor/autoload.php";
use SteamPunked\Steampunked as Steampunked;


class SteampunkedTest extends \PHPUnit_Framework_TestCase
{
	public function testConstructor() {
		$game = new \Steampunked\Steampunked(1234);
		$this->assertEquals(\Steampunked\Steampunked::PLAYER1, $game->getPlayersTurn());
	}

	public function testInitGame() {
		$player1 = new \Steampunked\Player("test1");
		$player2 = new \Steampunked\Player("test2");

		$game = new \Steampunked\Steampunked(1234);
        $this->assertEquals(false ,$game->initGame(5, $player1, $player2));
        $this->assertEquals(true ,$game->initGame(6, $player1, $player2));
        $this->assertEquals(6, $game->getBoardSize());

        $this->assertEquals('1', $game->getPlayer1()->getPlayerNumber());
        $this->assertEquals('2', $game->getPlayer2()->getPlayerNumber());


        $p1 = $game->getPlayer1()->getPlayerPieces();
        $this->assertEquals(5, count($p1));
        $this->assertEquals('cap', $p1[0]->getPieceType());
        $this->assertEquals('ninety', $p1[1]->getPieceType());
        $this->assertEquals('tee', $p1[2]->getPieceType());
        $this->assertEquals('ninety', $p1[3]->getPieceType());
        $this->assertEquals('STRAIGHT', $p1[4]->getPieceType());
        $this->assertEquals(5, count($game->getPlayer2()->getPlayerPieces()));

        $board = $game->getBoard();
        $this->assertEquals('start_piece', $board[0][0]->getPieceType());
        $this->assertEquals($game->getPlayer1(), $board[0][0]->getOwnership());
        $this->assertEquals('start_piece', $board[5][0]->getPieceType());
        $this->assertEquals($game->getPlayer2(), $board[5][0]->getOwnership());
        $this->assertEquals('end_piece_top', $board[0][5]->getPieceType());
        $this->assertEquals('end_piece', $board[1][5]->getPieceType());
        $this->assertEquals($game->getPlayer1(), $board[1][5]->getOwnership());
        $this->assertEquals('end_piece_top', $board[3][5]->getPieceType());
        $this->assertEquals('end_piece', $board[4][5]->getPieceType());
        $this->assertEquals($game->getPlayer2(), $board[4][5]->getOwnership());

        $this->assertEquals($game->getPlayer1(), $game->getCurrentPlayer());
	}

    public function testGameplay(){
        $player1 = new \Steampunked\Player("test1");
        $player2 = new \Steampunked\Player("test2");
        $site = new \Steampunked\Site();
        $session = $_SESSION['game'];

        $game = new \Steampunked\Steampunked(1234);
        $game->initGame(6, $player1, $player2);
        $this->assertEquals($game->getPlayer1(), $game->getCurrentPlayer());
        $game->insertAtCell($site,0,1,0);
        $this->assertEquals($game->getPlayer2(), $game->getCurrentPlayer());
        $this->assertEquals('cap', $game->getBoard()[0][1]->getPieceType());
        $this->assertEquals($game->getPlayer1(), $game->getBoard()[0][1]->getOwnership());
        $this->assertNotEquals('cap', $game->getPlayer1()->getPlayerPieces()[0]->getPieceType());
        $game->insertAtCell(0,1,2);
        $this->assertEquals($game->getPlayer1(), $game->getCurrentPlayer());
        $this->assertEquals('tee', $game->getBoard()[0][1]->getPieceType());
        $this->assertEquals($game->getPlayer2(), $game->getBoard()[0][1]->getOwnership());
        $this->assertNotEquals('tee', $game->getPlayer2()->getPlayerPieces()[2]->getPieceType());

        $game->discardPieceAtIndex(0);
        $this->assertEquals($game->getPlayer2(), $game->getCurrentPlayer());
        $this->assertNotEquals('STRAIGHT', $game->getPlayer1()->getPlayerPieces()[0]->getPieceType());

        $game->surrender();
        $this->assertEquals($game->getPlayer1(), $game->getWinner());


    }

}

/// @endcond
?>
