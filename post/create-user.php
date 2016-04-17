<?php
/**
 * Created by PhpStorm.
 * User: MatthewWiechec
 * Date: 4/9/16
 * Time: 1:27 PM
 */

$open = true;		// Can be accessed when not logged in
require '../lib/site.inc.php';

$controller = new Steampunked\NewUserController($site, $_SESSION, $_POST);

header("location: " . $controller->getRedirect());