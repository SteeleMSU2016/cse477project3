<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 4/13/2016
 * Time: 3:35 AM
 */

require '../lib/site.inc.php';
//print_r($_POST);
$controller = new Steampunked\NewGameController($site, $_SESSION, $_POST);
echo("<br>");
//print_r($_SESSION);
header("location: " . $controller->getRedirect());