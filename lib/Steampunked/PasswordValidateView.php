<?php
/**
 * Created by PhpStorm.
 * User: Jason Steele
 * Date: 3/29/2016
 * Time: 6:51 PM
 */

namespace Steampunked;


class PasswordValidateView extends View {

    private $site;	            ///< The Site object
    private $validatorCode;     ///< Unique code that allows the user to reset their password

    /**
     * Constructor
     * Sets the page title and any other settings.
     * @param $site Site object
     * @param $get $_GET array
     */
    public function __construct(Site $site, $get) {
        $this->site = $site;
        $this->validatorCode = $get['v'];
        $this->setTitle("Steampunked Password Entry");
    }

    /**
     * Present the password validator form
     * @return string
     */
    public function present() {

        $errorMessage = $this->error_message();

        $html = <<<HTML
            <form method="post" action="post/password-validate.php">
                <fieldset>
                    <legend>Change Password</legend>
                    $errorMessage
                    <input type="hidden" name="validator" value="$this->validatorCode">
                    <p>
                        <input type="email" id="email" name="email" placeholder="Email">
                    </p>
                    <p>
                        <label for="password">Password:</label><br>
                        <input type="password" id="password" name="password" placeholder="Password">
                    </p>
                    <p>
                        <label for="passwordAgain">Password(again):</label><br>
                        <input type="password" id="passwordAgain" name="passwordAgain" placeholder="Password">
                    </p>
                    <p>
                        <input type="submit" value="OK"> <input type="submit" value="Cancel">
                    </p>

                </fieldset>
            </form>
HTML;
        return $html;
    }

    /**
     * Get the error message
     * @return string html formatted error message
     */
    public function error_message() {
        if (isset($_GET['e1'])) {
            return <<<HTML
<p id="error">Email entered is invalid</p>
HTML;
        }
        if (isset($_GET['e2'])) {
            return <<<HTML
<p id="error">Passwords do not match</p>
HTML;
        }

        if (isset($_GET['e3'])) {
            return <<<HTML
<p id="error">Password too short</p>
HTML;
        }
    }
}