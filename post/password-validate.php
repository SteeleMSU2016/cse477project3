<?php
$open = true;		// Can be accessed when not logged in
require '../lib/site.inc.php';

$controller = new Steampunked\PasswordValidateController($site, $_POST);

header("location: " . $controller->getRedirect());