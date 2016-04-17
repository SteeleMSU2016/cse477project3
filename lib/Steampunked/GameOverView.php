<?php
/**
 * Created by PhpStorm.
 * User: MatthewWiechec
 * Date: 2/9/16
 * Time: 7:17 PM
 */

namespace Steampunked;

class GameOverView {

    private $steampunked;

    public function __construct(Steampunked $steampunked) {
        $this->steampunked = $steampunked;
    }

    public function present() {
        $html = $this->getWinnerMessage();
        $html .= $this->newGameForm();

        return $html;
    }

    private function getWinnerMessage() {
        return '<p class="winnerMessage">' . $this->steampunked->getWinner()->getPlayerName() . ', you are the winner!</p>';
    }

    private function newGameForm() {
        $html = <<< __HTML__
            <form id="newGameForm" method="post" action="index.php">
                <input type="submit" value="New Game" name="newGamePage"/>
            </form>
__HTML__;
        return $html;
    }

    public function getTitleImage() {
        return "<p class=\"gameOverTitle\"><img src=\"images/title.png\"/></p>";
    }
}