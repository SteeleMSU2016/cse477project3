<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */

require __DIR__ . "/../../vendor/autoload.php";
use SteamPunked\Steampunked as Steampunked;
use Steampunked\SteampunkedView as View;

class SteampunkedViewTest extends \PHPUnit_Framework_TestCase
{
	public function testPresent() {
		$game = new \Steampunked\Steampunked(1234);
		$site = new \Steampunked\Site();
        //$player1 = new \Steampunked\Player("test1");
		//$player2 = new \Steampunked\Player("test2");
		$game->initGame(6, "test1", "test2");
		$view = new \Steampunked\SteampunkedView($site);

		$this->assertContains("test1, it is your turn", $view->present());
        $this->assertContains("<input type=\"radio\" name=\"selectedButton\" value=\"", $view->present());
        $this->assertContains("<input type=\"submit\" name=\"rotate\" value=\"Rotate\">", $view->present());
        $this->assertContains('<input type="submit" name="discard" value="Discard"', $view->present());
        $this->assertContains('<input type="submit" name="openValve" value="Open Valve">', $view->present());
        $this->assertContains('<input type="submit" name="giveUp" value="Give Up">', $view->present());

	}

    public function testPresentGameOver() {
        $game = new \Steampunked\Steampunked(1234);
        //$player1 = new \Steampunked\Player("test1");
        //$player2 = new \Steampunked\Player("test2");
        $game->initGame(6, "test1", "test2");
        $game->surrender();
        $view = new \Steampunked\SteampunkedView($game);
        //$this->assertContains("test2, you are the winner!", $view->presentGameOver());
        /*$this->assertContains('<form id="newGameForm" method="post" action="steampunked-post.php">
                <input type="submit" value="newGamePage" name="newGamePage"/>
            </form>', $view->presentGameOver());*/
    }
}

/// @endcond
?>
