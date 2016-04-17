<?php
/**
 * Created by PhpStorm.
 * User: Jason Steele
 * Date: 3/16/2016
 * Time: 3:32 PM
 */

namespace Steampunked;


/**
 * View responsible for presenting the new user creation html
 */
class NewUserView extends View {

    /**
     * Constructor
     * Sets the page title and any other settings.
     */
    public function __construct() {
        $this->setTitle("Steampunked New User");

    }

    /**
     * @return string Returns html for any error that occurred during the login process
     */
    private function error_message() {
        if(isset($_GET['e'])){
            return <<<HTML
                <p id="error">The emails you entered did not match</p>
HTML;
       }

        if (isset($_GET['n'])) {
            return <<<HTML
                <p id="error">The email you entered already exists</p>
HTML;
        }

        // Return no error
        return '';

    }

    /**
     * @return string Returns the html to present the login form
     */
    public function present() {

        $errorMessage = $this->error_message();

        $html = <<< __HTML__
            <form method="post" action="post/create-user.php">
                <fieldset>
                    <legend>Create User</legend>
                    $errorMessage
                    <p>
                        <label for="name">Name:</label><br>
                        <input type="text" id="name" name="name" placeholder="Name">
                    </p>
                    <p>
                        <label for="email">Email:</label><br>
                        <input type="email" id="email" name="email" placeholder="Email">
                    </p>
                    <p>
                        <label for="confirmEmail">Confirm Email:</label><br>
                        <input type="email" id="confirmEmail" name="confirmEmail" placeholder=" Confirm Email">
                    </p>
                    <p>
                        <input type="submit" value="Create">
                    </p>
                </fieldset>
            </form>
__HTML__;

        return $html;
    }

}