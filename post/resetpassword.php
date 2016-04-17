<?php
$open = true;		// Can be accessed when not logged in
require '../lib/site.inc.php';

$controller = new Steampunked\ResetPasswordController($site, $_POST);
header("location: " . $controller->getRedirect());