<?php
/**
 * Created by PhpStorm.
 * User: Jason Steele
 * Date: 3/16/2016
 * Time: 1:43 PM
 */

namespace Steampunked;


class User
{

    const SESSION_NAME = 'user';

    private $id;		///< The internal ID for the user
    private $email;		///< Email address
    private $name; 		///< Name as last, first
    private $password;  ///< The password for the user
    private $pushKey;   ///< The push key for websockets

    /**
     * Constructor
     * @param $row Row from the user table in the database
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->email = $row['email'];
        $this->name = $row['name'];
        $this->password = $row['password'];
        $this->pushKey = $row['pushKey'];

    }

    /**
     * @param mixed $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @param mixed $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPushKey() {
        return $this->pushKey;
    }

    /**
     * @param mixed $pushKey
     */
    public function setPushKey($pushKey) {
        $this->pushKey = $pushKey;
    }
}