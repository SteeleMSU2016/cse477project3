<?php
/**
 * Created by PhpStorm.
 * User: MatthewWiechec
 * Date: 2/9/16
 * Time: 7:17 PM
 */

namespace Steampunked;


use Composer\Package\Package;

class SteampunkedController {

    private $steampunked;

    private $player1;
    private $player2;
    private $boardSize;
    private $page = 'steampunked-game.php';

    public function __construct($site, array &$session, $postData) {
        $this->steampunked = $session['steampunked'];

        // The player has clicked on a grid to insert the selected piece at the grid
        $games = new Games($site);
        $users = new Users($site);
        if (isset($postData['insertAtCell'])) {
            $arrayIndexes = explode(',', $_POST['insertAtCell']);
            $rowIndex = intval($arrayIndexes[0]);
            $colIndex = intval($arrayIndexes[1]);

            if (isset($postData['selectedButton'])) {
                $other =$this->steampunked->insertAtCell($site, $rowIndex, $colIndex, $postData['selectedButton']);

                $player = $games->getPlayerIdForGame($session['game'], $other);
                $player1PushKey = $users->getPushKey($player);

                new PushController($site, $player1PushKey);
                $this->page = 'steampunked-game.php';

            }
        }

        // The user indicated they want to rotate a piece
        if (isset($postData['rotate'])) {
            if (isset($postData['selectedButton'])) {
                $this->steampunked->getCurrentPlayer()->rotateGamePiece($postData['selectedButton']);

            }
        }

        // The user indicated they want to discard a piece
        if (isset($postData['discard'])) {
            if (isset($postData['selectedButton'])) {
                $other =$this->steampunked->discardPieceAtIndex($site, $postData['selectedButton']);
                $player = $games->getPlayerIdForGame($session['game'], $other);
                $player1PushKey = $users->getPushKey($player);

                new PushController($site, $player1PushKey);
                $this->page = 'steampunked-game.php';
            }
        }

        // Check if the current player has won
        if (isset($postData['openValve'])) {
            $other = $this->steampunked->checkForWinner($site, $session['game']);

            $player = $games->getPlayerIdForGame($session['game'], $other);
            $player1PushKey = $users->getPushKey($player);

            new PushController($site, $player1PushKey);
            $this->page = 'steampunked-game.php';
        }

        // The current player surrenders
        if (isset($postData['giveUp'])) {
            $otherPlayer = $this->steampunked->surrender($site, $session['game']);
            $player = $games->getPlayerIdForGame($session['game'], $otherPlayer);
            $player1PushKey = $users->getPushKey($player);

            new PushController($site, $player1PushKey);
            $this->page = 'steampunked-game.php';

        }

        // the has said they want to go the new game page
        if (isset($postData['newGamePage'])) {
            $this->page = 'index.php';
        }
    }

    public function getPage() {
        if ($this->steampunked->isGameOver() && $this->page != 'index.php') {
            return 'steampunked-game-over.php';
        } else {
            return $this->page;
        }
    }

    public function getSteampunked() {
        return $this->steampunked;
    }

    public function resetGame() {
        if ($this->page == 'index.php') {
            return true;
        } else {
            return false;
        }
    }
}