<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 4/13/2016
 * Time: 7:15 PM
 */
require 'lib/site.inc.php';
$view = new Steampunked\WaitingView($site);


?>
<!DOCTYPE html>
<html>
<head>
    <script src="jslib/PushInit.js"></script>
    <?php echo $view->head(); ?>
</head>
<body>
<?php echo $view->header(); ?>
<?php echo $view->present(); ?>
</body>
</html>