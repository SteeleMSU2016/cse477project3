<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
class ViewTest extends \PHPUnit_Framework_TestCase {

	public function test_head() {
		$view = new Steampunked\View(new \Steampunked\Steampunked());
		$view->setTitle("Testing 101");

		$this->assertContains('<title>Testing 101</title>',
			$view->head());

		$this->assertContains('<meta charset="utf-8">',
			$view->head());

		$this->assertContains('<meta name="viewport" content="width=device-width, initial-scale=1">',
			$view->head());

		$this->assertContains('<link href="steampunked.css" type="text/css" rel="stylesheet" />',
			$view->head());


	}

	public function test_header() {
		$view = new Steampunked\View(new \Steampunked\Steampunked());
		$view->setTitle("whatever");
		$html = $view->header();

		$this->assertContains('<h1 class="welcomeScreen">whatever</h1>', $html);


		$this->assertNotContains('<ul class="right">', $html);
	}



}
/// @endcond
?>
