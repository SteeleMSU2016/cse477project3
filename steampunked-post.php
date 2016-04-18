<?php
/**
 * Created by PhpStorm.
 * User: MatthewWiechec
 * Date: 2/9/16
 * Time: 8:08 PM
 */

require __DIR__ . '/lib/site.inc.php';
$controller = new Steampunked\SteampunkedController($site, $_SESSION, $_POST);
echo $controller->getHtml();
exit;