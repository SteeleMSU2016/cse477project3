<?php
/**
 * Created by PhpStorm.
 * User: MatthewWiechec
 * Date: 4/9/16
 * Time: 4:59 PM
 */

namespace Steampunked;

/**
 * Controller used to send a reset a password
 * Class ResetPasswordController
 * @package Steampunked
 */
class ResetPasswordController {

    private $redirect;	///< Page we will redirect the user to.

    /**
     * Constructor
     * @param Site $site The site object
     * @param array $post $_POST array
     */
    public function __construct(Site $site, array $post) {
        $root = $site->getRoot();
        $this->redirect = "$root/";

        // Send the reset password email
        if(isset($post['email'])) {
            $email = strip_tags($post['email']);
            $users = new Users($site);
            $mailer = new Email();

            $users->resetPassword($email, $mailer);
        } else {
            return;
        }
    }

    /**
     * @return mixed
     */
    public function getRedirect() {
        return $this->redirect;
    }
}