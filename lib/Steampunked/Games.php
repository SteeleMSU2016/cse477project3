<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 4/13/2016
 * Time: 2:44 AM
 */

namespace Steampunked;


class Games extends Table
{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "Game");
    }

    public function getGames(){
        $sql = <<<__SQL__
SELECT * FROM $this->tableName
__SQL__;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addNewGame($userId, $size, $state, $playerTurn){
        $sql = <<<SQL
INSERT INTO $this->tableName
(player1, size, state, playerTurn)
VALUES (?, ?, ?, ?)
SQL;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($userId, $size, $state, $playerTurn));

        return $id = $this->pdo()->lastInsertId();
    }

    public function getNewGames(){
        $sql = <<<__SQL__
SELECT * FROM $this->tableName
WHERE state = 0
__SQL__;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute();
        //$result = array();
        //foreach($statement as $row){
        //    array_push($result, $row);
        //}

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
        //return $result;
    }

    public function addPlayer2toGame($player2, $id){
        $sql =<<<SQL
UPDATE $this->tableName
SET player2 = ?, state = ?
where id=?
SQL;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($player2, 1, $id));
    }

    public function get($id){
        $sql = <<<__SQL__
SELECT * FROM $this->tableName
WHERE id = ?
__SQL__;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($id));

        if ($statement->rowCount() === 0) {
            return null;
        }

        return new Game($statement->fetch(\PDO::FETCH_ASSOC));

    }

    /**
     * @param $game The gameId for the game
     * @param $playerNumber Return The player number, can be 1 or 2 representing player 1 or 2
     */
    public function getPlayerIdForGame($game, $playerNumber) {
        $sql = <<< __SQL__
            select player1, player2 from $this->tableName where id=?
__SQL__;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($game));

        if ($statement->rowCount() === 0) {
            return null;
        }

        $results = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($playerNumber == 1) {
            return $results['player1'];
        } else {
            return $results['player2'];
        }
    }

    public function setState($id, $state){
        $sql = <<<__SQL__
UPDATE $this->tableName
SET state = ?
where id=?
__SQL__;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($state, $id));

    }

    public function setTurn($id, $turn){
        $sql = <<<__SQL__
UPDATE $this->tableName
SET playerTurn = ?
where id=?
__SQL__;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($turn, $id));

    }



}