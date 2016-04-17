<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 4/14/16
 * Time: 5:17 PM
 */

namespace Steampunked;


class WaitingController
{

    private $redirect; // Page we will redirect the user to.

    /**
     * LoginController constructor.
     * @param Site $site The Site object
     * @param array $session $_SESSION
     * @param assay $post $_POST
     */
    public function __construct(Site $site, array &$session, array $post) {
        $root = $site->getRoot();
        if(isset($post['newgame']) && isset($post['boardSize'])){
            //create new GameSet
            //create new Game
            $games = new Games($site);
            $session['game'] = $games->addNewGame($session['user']->getId(), $post['boardSize'], 0, 1);
            //redirect to waiting page
            $this->redirect = "$root/steampunked-game.php";
        }
        else{
            $this->redirect = "$root/new-steampunked.php";
        }

    }

    public function getRedirect() {
        return $this->redirect;
    }
}