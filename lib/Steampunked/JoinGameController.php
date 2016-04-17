<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 4/13/2016
 * Time: 3:45 AM
 */

namespace Steampunked;


class JoinGameController
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
        if(isset($post['enter']) && isset($post['game'])){
            //create new GameSet
            //create new Game
            $games = new Games($site);
            $session['game'] = $post['game'];
            $games->addPlayer2toGame($session['user']->getId(), $post['game']);

            $users = new Users($site);
            $player1 = $games->getPlayerIdForGame($post['game'], 1);
            $player1PushKey = $users->getPushKey($player1);

            new PushController($site, $player1PushKey);

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