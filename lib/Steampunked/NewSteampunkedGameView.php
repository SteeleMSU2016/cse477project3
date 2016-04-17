<?php
/**
 * Created by PhpStorm.
 * User: MatthewWiechec
 * Date: 2/9/16
 * Time: 7:25 PM
 */

namespace Steampunked;



class NewSteampunkedGameView extends View {

    private $site;

    public function __construct(Site $site) {
        $this->site = $site;
        $this->setTitle("Choose a Game!");
    }

    public function present()
    {
        $new  = <<< _HTML_
        <form action="post/newsteampunkedgame.php" method="post">
            <h1>New Game</h1>
            <p>

                <label for="boardSize">Select a Board Size:</label>

                <select id="boardSize" name="boardSize">
                    <option value="6">6 x 6</option>
                    <option value="10">10 x 10</option>
                    <option value="20">20 x 20</option>
                </select><br>
                <input type="submit" name="newgame" value="New Game">

            </p>
        </form>

_HTML_;
        $new.=$this->getGames();

        return $new;
    }

    public function head(){
        $html = parent::head();
        $html.= <<<__HEAD__
            <link href="steampunked.css" type="text/css" rel="stylesheet" />
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
            <script src="jslib/PushInit.js"></script>
__HEAD__;
        return $html;
    }

    public function getGames(){
        $result = "<form action=\"post/joingame.php\" method=\"post\">";
        $result.="<h1>Existing Games</h1>";
        //$result.="<input type=\"submit\" name=\"enter\" value=\"Select Game\"><br>";
        $games = new Games($this->site);
        $players = new Users($this->site);
        $gameList = $games->getNewGames();
        foreach($gameList as $game){
            $game = new Game($game);
            $result.="<input type=\"radio\" name=\"game\" value=\"".$game->getId()."\"> Player1: ".$players->get($game->getPlayer1())->getName().", Size: ".$game->getSize().", Status: Waiting<br>";
        }
        $result.="<input type=\"submit\" name=\"enter\" value=\"Select Game\"><br>";
        $result .= "</form>";
        return $result;
    }
}