<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
require __DIR__ . "/../../vendor/autoload.php";


class NewUserViewTest extends \PHPUnit_Framework_TestCase {

	public function test_constructor() {
		$view = new \Steampunked\NewUserView();
		$view->setTitle("Testing 101");

		$this->assertContains('<form method="post" action="post/create-user.php">', $view->present());
		$this->assertContains('<legend>Create User</legend>', $view->present());
		$this->assertContains('<label for="name">Name:</label><br>', $view->present());
		$this->assertContains('<input type="text" id="name" name="name" placeholder="Name">', $view->present());
		$this->assertContains('<label for="email">Email:</label><br>', $view->present());
		$this->assertContains('<input type="email" id="email" name="email" placeholder="Email">', $view->present());
		$this->assertContains('<label for="confirmEmail">Confirm Email:</label><br>',
			$view->present());
		$this->assertContains('<input type="email" id="confirmEmail" name="confirmEmail" placeholder=" Confirm Email">',
			$view->present());
		$this->assertContains('<input type="submit" value="Create">', $view->present());

		$_GET['e'] = 'error';
		$this->assertContains('<p id="error">The emails you entered did not match</p>', $view->present());

		unset($_GET['e']);
		$_GET['n'] = 'error';
		$this->assertContains('<p id="error">The email you entered already exists</p>', $view->present());

	}
}
/// @endcond
?>
