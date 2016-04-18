<?php
/**
 * Created by PhpStorm.
 * User: MatthewWiechec
 * Date: 2/9/16
 * Time: 8:21 PM
 */
//require __DIR__ . '/lib/steampunked.inc.php';
require __DIR__ . '/lib/site.inc.php';

$view = new Steampunked\SteampunkedView($site);
?>
<!doctype html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="jslib/PushInit.js"></script>
    <script src="jslib/Steampunked.js"></script>
    <script>
        $(document).ready(function() {
            pushInit($('#myPushKey').html());
            new Steampunked("form").installButtonListeners();
        })
    </script>
    <?php echo $view->head(); ?>

</head>
<body>
<?php echo $view->header(); ?>
<?php echo $view->present(); ?>
</body>
</html>