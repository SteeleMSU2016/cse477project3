<?php
$open = true;
require 'lib/site.inc.php';
$view = new Steampunked\View(new \Steampunked\Steampunked());
$view->setTitle("Reset Password");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Steampunked Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="steampunked.css">
</head>

<body>
<div class="login">
    <?php
        echo $view->header();
    ?>

    <form method="POST" action="post/resetpassword.php">
        <fieldset>
            <legend>Request Password Reset</legend>
            <p>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" placeholder="Email">
            </p>
            <p>
                <input type="submit" value="Send Email">
            </p>

        </fieldset>
    </form>

    <?php echo $view->footer(); ?>

</div>