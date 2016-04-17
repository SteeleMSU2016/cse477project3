<?php
/**
 * Created by PhpStorm.
 * User: MatthewWiechec
 * Date: 2/9/16
 * Time: 8:21 PM
 */
require __DIR__ . '/lib/steampunked.inc.php';
$view = new Steampunked\SteampunkedView($steampunked);
$gameOverView = new \Steampunked\GameOverView($steampunked);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Guessing Game</title>
    <link href="steampunked.css" type="text/css" rel="stylesheet" />

</head>
<body>
<?php
    echo $gameOverView->getTitleImage();
    echo $view->presentGameOver();
    echo $gameOverView->present();

?>
</body>
</html>