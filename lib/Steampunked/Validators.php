<?php
/**
 * Created by PhpStorm.
 * User: Jason Steele
 * Date: 3/27/2016
 * Time: 1:08 PM
 */

namespace Steampunked;

/**
 * Manage validator codes in our system. Validator codes are one time uniquely generated codes that allow a user to
 * reset their password
 * Class Validators
 * @package Steampunked
 */
class Validators extends Table {

    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "validator");
    }

    /**
    * Create a new validator and add it to the table.
    * @param $userid User this validator is for.
    * @return The new validator.
    */
    public function newValidator($userid) {
        $validator = $this->createValidator();

            $sql = <<<SQL
insert into $this->tableName(userid, validator, date)
values(?, ?, "")
SQL;

            $pdo = $this->pdo();
            $statement = $pdo->prepare($sql);

            $statement->execute(array($userid, $validator));

        return $validator;
    }

    /**
     * @brief Generate a random validator string of characters
     * @param $len Length to generate, default is 32
     * @returns Validator string
     */
    private function createValidator($len = 32) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $l = strlen($chars) - 1;
        $str = '';
        for ($i = 0; $i < $len; ++$i) {
            $str .= $chars[rand(0, $l)];
        }
        return $str;
    }

    /**
     * Determine if a validator is valid. If it is,
     * get the user ID for that validator. Then destroy any
     * validator records for that user ID. Return the
     * user ID.
     * @param $validator Validator to look up
     * @return User ID or null if not found.
     */
    public function getOnce($validator) {
        $sql =<<<SQL
SELECT *
FROM $this->tableName
WHERE validator=?
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($validator));
        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $userid = null;
        foreach($rows as $row){
            $userid = $row['Userid'];
        }

            $sql = <<<SQL
delete from $this->tableName
where Userid=?
SQL;

        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute(array($userid));
        return $userid;
    }
}
