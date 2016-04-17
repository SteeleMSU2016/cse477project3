<?php
/**
 * Created by PhpStorm.
 * User: MatthewWiechec
 * Date: 2/9/16
 * Time: 7:45 PM
 */

namespace Steampunked;


class Player {
    // The players name
    private $name;

    // Used to identify who is player 1 and who is player 2
    private $playerNumber;

    // The array of pipes the player can select to place on the game board
    private $pipes;

    public function __construct($name) {
        $this->name = $name;
    }

    public function setInitialPipes($pipes) {
        $this->pipes = $pipes;
    }

    public function getPlayerPieces() {
        return $this->pipes;
    }

    public function getPlayerName() {
        return $this->name;
    }

    // rotate the piece at the provided index in the pipes array
    public function rotateGamePiece($index) {
        $this->pipes[$index]->rotatePiece();
    }

    public function replaceTileAt($tile, $index) {
        $this->pipes[$index] = $tile;
    }

    public function getTileAt($index) {
        return $this->pipes[$index];
    }

    public function setPlayerNumber($i) {
        $this->playerNumber = $i;
    }

    public function getPlayerNumber() {
        return $this->playerNumber;
    }
}