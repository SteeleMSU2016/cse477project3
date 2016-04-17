<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 4/13/2016
 * Time: 2:45 AM
 */

namespace Steampunked;


class Game
{
    private $id;
    private $player1;
    private $player2;
    private $size;
    private $state;
    private $playerTurn;

    /**
     * Constructor
     * @param $row Row from the user table in the database
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->player1 = $row['player1'];
        $this->player2 = $row['player2'];
        $this->size = $row['size'];
        $this->state = $row['state'];
        $this->playerTurn = $row['playerTurn'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPlayer1()
    {
        return $this->player1;
    }

    /**
     * @return mixed
     */
    public function getPlayer2()
    {
        return $this->player2;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return mixed
     */
    public function getPlayerTurn()
    {
        return $this->playerTurn;
    }

}