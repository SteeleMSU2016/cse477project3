<?php
$open = true;
require 'lib/site.inc.php';
$view = new Steampunked\NewUserView($_SESSION, $_GET);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $view->head(); ?>
</head>
<body>
<div class="login" >
	<?php
		echo $view->header();
		echo $view->present();
	?>

</div>

</body>
</html>
