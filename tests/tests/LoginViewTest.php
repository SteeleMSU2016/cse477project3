<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
require __DIR__ . "/../../vendor/autoload.php";


class LoginViewTest extends \PHPUnit_Framework_TestCase {

	public function test_constructor() {
		$view = new \Steampunked\LoginView();
		$view->setTitle("Testing 101");

		$this->assertContains('<div class="login" >', $view->present());
		$this->assertContains('<form method="post" action="post/login.php">', $view->present());
		$this->assertContains('<fieldset>', $view->present());
		$this->assertContains('<label for="email">Email:</label><br>', $view->present());
		$this->assertContains('<input type="email" id="email" name="email" placeholder="Email">', $view->present());
		$this->assertContains('<label for="password">Password:</label><br>', $view->present());
		$this->assertContains('<input type="password" id="password" name="password" placeholder="Password">',
			$view->present());
		$this->assertContains('<input type="submit" value="Log In"> <input name="Guest" type="submit" value="Guest">',
			$view->present());
		$this->assertContains('Lost Password', $view->present());
		$this->assertContains('<p><a href="new-user.php?id=0">New User</a></p>', $view->present());

		$_GET['e'] = 'error';
		$this->assertContains('<p id="error">Incorrect Login and/or Password</p>', $view->present());
	}
}
/// @endcond
?>
