<?php
/**
 * Created by PhpStorm.
 * User: MatthewWiechec
 * Date: 2/9/16
 * Time: 7:17 PM
 */


namespace Steampunked;


use Composer\Package\Package;

class SteampunkedNewGameController {

//    private $steampunked;
//
//    private $player1;
//    private $player2;
//    private $boardSize;
//    private $page = 'steampunked-game.php';

    public function __construct()
    {
        if (isset($post['login'])) {
            $this->redirect = "/login.php?";
        }
    }
    public function getRedirect() {
        return $this->redirect;
    }


    private $redirect;	///< Page we will redirect the user to.

//        // The player has selected to start a new game
//        if (isset($postData['startGame'])) {
//            if (isset($postData['player1Name'])) {
//                $this->player1 = strip_tags($postData['player1Name']);
//            }
//
//            if (isset($postData['player2Name'])) {
//                $this->player2 = strip_tags($postData['player2Name']);
//            }
//
//            if (isset($postData['boardSize'])) {
//                $this->boardSize = strip_tags($postData['boardSize']);
//            }
//            $this->steampunked->initGame($this->boardSize, $this->player1, $this->player2);
//        }

}