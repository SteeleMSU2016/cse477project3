<?php
/**
 * Created by PhpStorm.
 * User: Jason Steele
 * Date: 3/16/2016
 * Time: 2:40 PM
 */

namespace Steampunked;


/**
 * Responsible for making sure a user has logged in and providing any redirects and error codes
 * @package Steampunked
 */
class LoginController {

    private $redirect; // Page we will redirect the user to.

    /**
     * LoginController constructor.
     * @param Site $site The Site object
     * @param array $session $_SESSION
     * @param assay $post $_POST
     */
    public function __construct(Site $site, array &$session, array $post) {
        $root = $site->getRoot();

        // Create a Users object to access the table
        $users = new Users($site);

        if (isset($post['Guest'])) {
            $guestUser = $users->createGuestAccount();
            $session[User::SESSION_NAME] = $guestUser;
            $this->redirect = "$root/new-steampunked.php";
            return;
        }

        $email = strip_tags($post['email']);
        $password = strip_tags($post['password']);
        $user = $users->login($email, $password);
        $session[User::SESSION_NAME] = $user;

        // If user is null login falied. Otherwise success
        if($user === null) {
            $this->redirect = "$root/index.php?e";
        } else {
            $this->redirect = "$root/new-steampunked.php";
        }
    }

    public function getRedirect() {
        return $this->redirect;
    }
}