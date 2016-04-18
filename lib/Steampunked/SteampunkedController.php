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
    private $html = 'steampunked-game.php';

    public function __construct($site, array &$session, $postData) {
        $this->steampunked = $session['steampunked'];

        // The user recieved a refresh messsage
        if (isset($postData['getView'])) {
            $steampunkedView = new SteampunkedView($site);
            $boardHtml = $steampunkedView->present();
            $this->html = json_encode(array('message' => 'ok', 'html' => $boardHtml));
            return;
        }

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

                $steampunkedView = new SteampunkedView($site);
                $boardHtml = $steampunkedView->present();

                new PushController($site, $player1PushKey);
                $this->html = json_encode(array('message' => 'ok', 'html' => $boardHtml));
                return;
            }
        }

        // The user indicated they want to rotate a piece
        if (isset($postData['rotate'])) {
            if (isset($postData['selectedButton'])) {
                $this->steampunked->getCurrentPlayer()->rotateGamePiece($postData['selectedButton']);

                $steampunkedView = new SteampunkedView($site);
                $viewHtml = $steampunkedView->getPlayerPieces();
                $this->html = json_encode(array('message' => 'ok', 'html' => $viewHtml));
                return;
            }
        }

        // The user indicated they want to discard a piece
        if (isset($postData['discard'])) {
            if (isset($postData['selectedButton'])) {
                $other =$this->steampunked->discardPieceAtIndex($site, $postData['selectedButton']);
                $player = $games->getPlayerIdForGame($session['game'], $other);
                $player1PushKey = $users->getPushKey($player);

                new PushController($site, $player1PushKey);

                $steampunkedView = new SteampunkedView($site);
                $viewHtml = $steampunkedView->present();
                $this->html = json_encode(array('message' => 'ok', 'html' => $viewHtml));
                return;
            }
        }

        // Check if the current player has won
        if (isset($postData['openValve'])) {
            $other = $this->steampunked->checkForWinner($site, $session['game']);

            $player = $games->getPlayerIdForGame($session['game'], $other);
            $player1PushKey = $users->getPushKey($player);

            new PushController($site, $player1PushKey);

            $steampunkedView = new SteampunkedView($site);
            $viewHtml = $steampunkedView->present();
            $this->html = json_encode(array('message' => 'ok', 'html' => $viewHtml));
            return;
        }

        // The current player surrenders
        if (isset($postData['giveUp'])) {
            $otherPlayer = $this->steampunked->surrender($site, $session['game']);
            $player = $games->getPlayerIdForGame($session['game'], $otherPlayer);
            $player1PushKey = $users->getPushKey($player);

            new PushController($site, $player1PushKey);

            $steampunkedView = new SteampunkedView($site);
            $viewHtml = $steampunkedView->present();
            $this->html = json_encode(array('message' => 'ok', 'html' => $viewHtml));
            return;
        }

        // the has said they want to go the new game page
        if (isset($postData['newGamePage'])) {
            $this->html = 'index.php';
        }
    }

    public function getPage() {
        if ($this->steampunked->isGameOver() && $this->html != 'index.php') {
            return 'steampunked-game-over.php';
        } else {
            return $this->html;
        }
    }

    public function getHtml() {
        return $this->html;
    }

    public function getSteampunked() {
        return $this->steampunked;
    }

    public function resetGame() {
        if ($this->html == 'index.php') {
            return true;
        } else {
            return false;
        }
    }
}