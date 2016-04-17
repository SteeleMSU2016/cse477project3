<?php
/**
 * Created by PhpStorm.
 * User: Jason Steele
 * Date: 3/16/2016
 * Time: 2:40 PM
 */

namespace Steampunked;


/**
 * Responsible for creating a new account and providing any redirects and error codes
 * @package Steampunked
 */
class NewUserController {

    private $redirect; // Page we will redirect the user to.

    /**
     * LoginController constructor.
     * @param Site $site The Site object
     * @param array $session $_SESSION
     * @param assay $post $_POST
     */
    public function __construct(Site $site, array &$session, array $post) {
        $root = $site->getRoot();
        $this->redirect = "$root/index.php";

        if ($post['email'] != $post['confirmEmail']) {
            $this->redirect = "$root/new-user.php?e";
            return;
        }
        // Create a Users object to access the table
        $users = new Users($site);

        // Create the new user with the supplied information from $_POST
        $newUser = new User(['id' => null,
                'email' => $post['email'],
                'name' => $post['name'],
                'password' => null,
                'pushKey' => null]);

        $mailer = new Email();
        $result = $users->add($newUser, $mailer);

        // If the result is not success the creation failed
        if($result != 'success') {
            $this->redirect = "$root/new-user.php?n";
        }
    }

    public function getRedirect() {
        return $this->redirect;
    }
}