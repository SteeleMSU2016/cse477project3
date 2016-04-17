<?php
/**
 * Created by PhpStorm.
 * User: Jason Steele
 * Date: 3/29/2016
 * Time: 7:31 PM
 */

namespace Steampunked;


class PasswordValidateController {

    private $redirect;	///< Page we will redirect the user to.

    /**
     * @param Site $site The site object
     * @param array $post $_POST array
     */
    public function __construct(Site $site, array $post) {
        $root = $site->getRoot();
        $this->redirect = "$root/";
        $validator = $post['validator'];

        // The user selected to cancel the password reset
        if(isset($post['cancel'])) {
            $this->redirect = "$root/";
            return;
        }

        // Check the passwords to make sure they are the same
        $password1 = trim(strip_tags($post['password']));
        $password2 = trim(strip_tags($post['passwordAgain']));
        if($password1 !== $password2) {
            // Passwords do not match
            $this->redirect = "$root/password-validate.php?e2&v=$validator";
            return;
        }

        // Make sure the password is at least 8 characters
        if(strlen($password1) < 8) {
            // Password too short
            $this->redirect = "$root/password-validate.php?e3&v=$validator";
            return;
        }

        //
        // If we passed the above checks we can query for the validaotor row
        // 1. Ensure the validator is correct! Use it to get the user ID.
        // 2. Destroy the validator record so it can't be used again!
        //
        $validators = new Validators($site);
        $userid = $validators->getOnce($post['validator']);

        // We did not find anything in the validator table for the provided code
        if($userid === null) {
            $this->redirect = "$root/";
            return;
        }

        $users = new Users($site);
        $editUser = $users->get($userid);

        // We did not find a user with a matching id in the system
        if($editUser === null) {
            // User does not exist!
            $this->redirect = "$root/";
            return;
        }

        // Make sure the email is the same for the provided validator code
        $email = trim(strip_tags($post['email']));
        if($email !== $editUser->getEmail()) {
            // Email entered is invalid
            $this->redirect = "$root/password-validate.php?e1&v=$validator";
            return;
        }

        // All checks pass, set the password
        $users->setPassword($userid, $password1);
    }

    /**
     * @return string URL formatted string
     */
    public function getRedirect() {
        return $this->redirect;
    }
}