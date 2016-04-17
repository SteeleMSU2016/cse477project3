<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
require __DIR__ . "/../../vendor/autoload.php";


class PasswordValidateView extends \PHPUnit_Framework_TestCase {

	public function test_constructor() {
		$view = new \Steampunked\PasswordValidateView(new \Steampunked\Site(), array('v' => '14831e3f21b'));
		$view->setTitle("Testing 101");

		$this->assertContains('<form method="post" action="post/password-validate.php">', $view->present());
		$this->assertContains('<legend>Change Password</legend>', $view->present());
		$this->assertContains('<input type="hidden" name="validator" value="14831e3f21b">', $view->present());
		$this->assertContains('<input type="email" id="email" name="email" placeholder="Email">', $view->present());
		$this->assertContains('<label for="password">Password:</label><br>', $view->present());
		$this->assertContains('<input type="password" id="password" name="password" placeholder="Password">', $view->present());
		$this->assertContains('<label for="passwordAgain">Password(again):</label><br>',
			$view->present());
		$this->assertContains('<input type="password" id="passwordAgain" name="passwordAgain" placeholder="Password">',
			$view->present());
		$this->assertContains('<input type="submit" value="OK"> <input type="submit" value="Cancel">', $view->present());

		$_GET['e1'] = 'error';
		$this->assertContains('<p id="error">Email entered is invalid</p>', $view->present());

		unset($_GET['e1']);
		$_GET['e2'] = 'error';
		$this->assertContains('<p id="error">Passwords do not match</p>', $view->present());

		unset($_GET['e2']);
		$_GET['e3'] = 'error';
		$this->assertContains('<p id="error">Password too short</p>', $view->present());
	}
}
/// @endcond
?>
