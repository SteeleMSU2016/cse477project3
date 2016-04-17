<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 4/13/2016
 * Time: 7:45 PM
 */

require '../lib/site.inc.php';
$controller = new Steampunked\JoinGameController($site, $_SESSION, $_POST);
header("location: " . $controller->getRedirect());