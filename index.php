<?php
$open = true;
require 'lib/site.inc.php';
$view = new Steampunked\LoginView();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $view->head(); ?>
    </head>
    <body>
        <?php echo $view->header(); ?>
        <?php echo $view->present(); ?>
    </body>
</html>
