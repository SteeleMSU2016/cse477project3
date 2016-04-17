<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
require __DIR__ . "/../../vendor/autoload.php";

class GameOverViewTest extends \PHPUnit_Framework_TestCase
{

	public function testPresentGameOver() {
		$game = new \Steampunked\Steampunked(1234);
		$game->initGame(6, "test1", "test2");
		$game->surrender();
		$view = new \Steampunked\GameOverView($game);
		$this->assertContains("test2, you are the winner!", $view->present());
		$this->assertContains('<p class="gameOverTitle"><img src="images/title.png"/></p>', $view->getTitleImage());
		$this->assertContains('<input type="submit" value="New Game" name="newGamePage"/>', $view->present());
	}
}

/// @endcond
?>
