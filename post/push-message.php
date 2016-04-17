<?php
/**
 * Created by PhpStorm.
 * User: MatthewWiechec
 * Date: 4/9/16
 * Time: 1:27 PM
 */

require '../lib/site.inc.php';

$controller = new Steampunked\PushController($site, $_POST['pushKey']);

header("location: " . $controller->getRedirect());