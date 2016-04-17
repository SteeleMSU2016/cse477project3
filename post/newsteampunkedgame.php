<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 4/13/2016
 * Time: 3:35 AM
 */

require '../lib/site.inc.php';
$controller = new Steampunked\NewGameController($site, $_SESSION, $_POST);
header("location: " . $controller->getRedirect());