<?php
/**
 * Created by PhpStorm.
 * User: Jason Steele
 * Date: 3/16/2016
 * Time: 3:32 PM
 */

namespace Steampunked;


/**
 * View responsible for presenting the login page html
 */
class LoginView extends View {

    /**
     * Constructor
     * Sets the page title and any other settings.
     */
    public function __construct() {
        $this->setTitle("Steampunked Login");

    }

    /**
     * @return string Returns html for any error that occurred during the login process
     */
    private function error_message() {
        if(isset($_GET['e'])){
            return <<<HTML
                <p id="error">Incorrect Login and/or Password</p>
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
            <div class="login" >
                <form method="post" action="post/login.php">
                    <fieldset>
                        <legend>Login</legend>

                        <p>
                            <label for="email">Email:</label><br>
                            <input type="email" id="email" name="email" placeholder="Email">
                        </p>
                        <p>
                            <label for="password">Password:</label><br>
                            <input type="password" id="password" name="password" placeholder="Password">
                        </p>
                        <p>
                            <input type="submit" value="Log In"> <input name="Guest" type="submit" value="Guest">
                        </p>
                        <p>
                            <a href="forgotpassword.php">Lost Password</a>
                        </p>

                        <p><a href="new-user.php?id=0">New User</a></p>

                    </fieldset>
                </form>
            </div>
__HTML__;

        $html .= $errorMessage;

        return $html;
    }

}