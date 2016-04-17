<?php
/**
 * Created by PhpStorm.
 * User: MatthewWiechec
 * Date: 2/6/16
 * Time: 10:14 PM
 */

require __DIR__ . "/../vendor/autoload.php";

session_start();

define("STEAMPUNKED_SESSION", 'steampunked');

if (!isset($_SESSION[STEAMPUNKED_SESSION])) {
    $_SESSION[STEAMPUNKED_SESSION] = new \Steampunked\Steampunked();
}

if(isset($_GET['seed'])) {
    $_SESSION[STEAMPUNKED_SESSION] = new Steampunked\Steampunked(strip_tags($_GET['seed']));
}

$steampunked = $_SESSION[STEAMPUNKED_SESSION];