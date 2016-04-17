<?php
/**
 * Created by PhpStorm.
 * User: Jason Steele
 * Date: 3/15/2016
 * Time: 5:04 PM
 */

namespace Steampunked;

/**
 * Base view class used to present html common to the entire site
 */
class View {

    private $title = "";	            ///< The page title
    private $links = array();	        ///< Links to add to the nav bar
    private $protectRedirect = null;    ///< Page protection redirect
    private $steampunked;               ///< The steampunked game

    /**
     * Constructor
     * @Param The current steampunked game
     */
    public function __construct(Steampunked $steampunked) {
        $this->steampunked = $steampunked;
    }

    /**
     * Set the page title
     * @param $title New page title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Create the HTML for the contents of the head tag
     * @return string HTML for the page head
     */
    public function head() {
        return <<<HTML
            <meta charset="utf-8">
            <title>$this->title</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="steampunked.css" type="text/css" rel="stylesheet" />

HTML;
    }

    /**
     * Create the HTML for the page header
     * @return string HTML for the standard page header
     */
    public function header() {
        $html = <<<HTML

            <header>
                <p class="welcomeScreen" ><img src="images/title.png" alt="" ></p>
                <h1 class="welcomeScreen">$this->title</h1>
            </header>
HTML;
        return $html;
    }


    /**
     * Get any optional error messages
     * @return string Optional error message HTML or empty if none.
     */
    public function errorMsg() {
        if(isset($this->get['e']) && isset($this->session[self::SESSION_ERROR])) {
            return '<p class="error">' . $this->session[self::SESSION_ERROR] . '</p>';
        } else {
            return '';
        }
    }

}