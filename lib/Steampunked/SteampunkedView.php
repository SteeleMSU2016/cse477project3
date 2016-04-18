<?php
/**
 * Created by PhpStorm.
 * User: MatthewWiechec
 * Date: 2/9/16
 * Time: 7:25 PM
 */

namespace Steampunked;


class SteampunkedView extends View {

    private $steampunked;
    private $site;

    public function __construct(Site $site) {
        $this->site = $site;

        $games = new Games($this->site);
        $game = $games->get($_SESSION['game']);

        if($game->getState() == 0) {
            return $this->waiting();
        }

        if ($game->getState() == 3) {
            if($game->getPlayer1() == $_SESSION['user']->getId() && $game->getPlayerTurn() == 1) {
                return $this->winning();
            } else if($game->getPlayer2() == $_SESSION['user']->getId() && $game->getPlayerTurn() == 2) {
                return $this->winning();
            } else {
                return $this->losing();
            }
        }

        if($game->getPlayer1() == $_SESSION['user']->getId() && $game->getPlayerTurn() == 2) {
            return $this->waiting();
        }

        if($game->getPlayer2() == $_SESSION['user']->getId() && $game->getPlayerTurn() == 1) {
            return $this->waiting();
        }
    }

    public function present() {
        // Page submits to does-not-exist.php so we can tell if we ever cause a page refresh. This
        // form should never submit
        $html = '<form method="post" action="does-not-exist.php"><div id="errorMessage"></div>';
        $games = new Games($this->site);
        $game = $games->get($_SESSION['game']);

        $userPushKey = $_SESSION['user']->getPushKey();
        $html .= "<div id=\"myPushKey\" class=\"hidden\">$userPushKey</div>";
        if($game->getState() == 0) {
            $html .= $this->waiting();
            $html .= "</form>";
            return $html;
        }

        if($game->getState() == 3){
            if ($game->getPlayer1() == $_SESSION['user']->getId() && $game->getPlayerTurn() == 1) {
                return $this->winning();
            } else if ($game->getPlayer2() == $_SESSION['user']->getId() && $game->getPlayerTurn() == 2) {
                return $this->winning();
            } else {
                return $this->losing();
            }
        }

        if($game->getPlayer1() == $_SESSION['user']->getId() && $game->getPlayerTurn() == 2) {
            $html .= $this->waiting();
            $html .= "</form>";
            return $html;
        }

        if($game->getPlayer2() == $_SESSION['user']->getId() && $game->getPlayerTurn() == 1) {
            $html .= $this->waiting();
            $html .= "</form>";
            return $html;
        }

        $this->steampunked = $this->setupGame();
        $_SESSION['steampunked'] = $this->steampunked;

        $html .= $this->getBoardHtml();
        $html .= $this->getPlayerTurnMessage();
        $html .= $this->getPlayerPieces();
        $html .= $this->getPlayerButtons();
        $html .= '</form>';

        return $html;
    }

    public function presentGameOver() {
        $html = "<div class=\"gameOverGameBoard\">";
        $html .= $this->getBoardHtml();
        $html .= "</div>";
        return $html;
    }

    private function getBoardHtml() {
        $boardSize = $this->steampunked->getBoardSize();
        $board = $this->steampunked->getBoard();

        $boardHtml = '<div class="game">';

        for($i = 0; $i < $boardSize; $i++) {
            $boardHtml .= '<div class="row">';
            for ($k = 0; $k < $boardSize; $k++) {
                if ($board[$i][$k]->getPieceImage() != null) {
                    $boardHtml .= '<div class="cell"><img src="images/' . $board[$i][$k]->getPieceImage() . '"></div>';
                } else {
                    if ($this->steampunked->isPlaceable($i, $k) && $this->steampunked->isGameOver() === false) {
                        $steamDirection = $this->steampunked->getSteamDirection($i, $k);
                        $boardHtml .= "<div class=\"cell\"><input type=\"submit\" class=\"$steamDirection insertAtCell\" name=\"insertAtCell\" value=\"$i, $k\"></div>";
                    } else {
                        $steamDirection = $this->steampunked->getSteamDirection($i, $k);
                        $boardHtml .= "<div class=\"cell $steamDirection\"></div>";
                    }
                }
            }
            $boardHtml .= '</div>';
        }

        $boardHtml .= '</div>';

        return $boardHtml;
    }

    private function getPlayerTurnMessage() {
        $playerName = $this->steampunked->getCurrentPlayer()->getPlayerName();
        $html = "<p class=\"playerTurnMessage\">$playerName" . ", it is your turn</p>";
        return $html;
    }

    public function getPlayerPieces() {
        $this->steampunked = $_SESSION['steampunked'];
        $playerPieces = $this->steampunked->getCurrentPlayer()->getPlayerPieces();

        $html = '<div id="playerPiecesWrapper">';

        for($i = 0; $i < 5; $i++) {
            $imgHtml = "<img src=\"images/". $playerPieces[$i]->getPieceImage() . "\">";
            $html .= "$imgHtml <input type=\"radio\" name=\"selectedButton\" value=\"$i\">";
        }

        $html .= "</div>";
        return $html;
    }

    public function getPlayerButtons() {
        $html = '<br>';
        $html .= '<input type="submit" id="rotate" name="rotate" value="Rotate">';
        $html .= '<input type="submit" id="discard" name="discard" value="Discard">';
        $html .= '<input type="submit" id="openValve" name="openValve" value="Open Valve">';
        $html .= '<input type="submit" id="giveUp" name="giveUp" value="Give Up">';

        return $html;

    }

    public function setupGame(){
        $steam = new Steampunked();
        $games = new Games($this->site);
        $users = new Users($this->site);
        $gamesets = new GameSets($this->site);
        $game = $games->get($_SESSION['game']);
        $size = $game->getSize();
        $turn = $game->getPlayerTurn();
        $player1 = $users->get($game->getPlayer1())->getName();
        $player2 = $users->get($game->getPlayer2())->getName();

        $steam->initGame($size, $player1, $player2);
        $steam->addTiles($gamesets->getPieces($_SESSION['game']));
        $steam->setTurn($turn);

        if(isset($_SESSION['player'])){
            if($_SESSION['player']->getPlayerNumber() == 1){
                $steam->setPlayer1($_SESSION['player']);
            }
            else{
                $steam->setPlayer2($_SESSION['player']);
            }
        }
        else{
            if($game->getPlayer1() == $_SESSION['user']->getId()){
                $_SESSION['player'] = $steam->getPlayer1();
            }

            if($game->getPlayer2() == $_SESSION['user']->getId()){
                $_SESSION['player'] = $steam->getPlayer2();
            }
        }

        return $steam;
    }

    public function waiting() {
        $userPushKey = $_SESSION['user']->getPushKey();
        $this->setTitle("Please Wait for The Other Player");
        $result = <<<__HTML__
<p class="waiting"><br><img src="images/IntPumpLarge.gif" width="354" height="267" alt="Pump animation from pumpschool.com"></p>
__HTML__;
        return $result;
    }

    public function winning() {
        $this->setTitle("");
        return "<form><p>You Win!</p><a href=\"".$this->site->getRoot() . '/new-steampunked.php'."\">Play another game.</form>";
    }

    public function losing() {
        $this->setTitle("");
        return "<form><p>You Lose!</p><a href=\"".$this->site->getRoot() . '/new-steampunked.php'."\">Play another game.</form>";
    }
}