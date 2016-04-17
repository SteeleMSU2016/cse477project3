<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 4/14/16
 * Time: 9:24 PM
 */

namespace Steampunked;


class GameSets extends Table
{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "Gameset");
    }

    public function setPiece($rowIndex, $colIndex,$game, $Rotation, $Type, $Ownership){

        $sql = <<<SQL
INSERT INTO $this->tableName
(xLoc, yloc, Gameid, Rotation, Type, Ownership)
VALUES (?, ?, ?, ?, ?, ?)
SQL;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($rowIndex, $colIndex,$game, $Rotation, $Type, $Ownership));

        return $id = $this->pdo()->lastInsertId();

    }

    public function getPieces($id){
        $sql = <<<__SQL__
SELECT * FROM $this->tableName
WHERE Gameid = ?
__SQL__;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($id));

        /*if ($statement->rowCount() === 0) {
            return null;
        }*/

        return $statement->fetchAll(\PDO::FETCH_ASSOC);

    }
}