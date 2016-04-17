<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 4/13/2016
 * Time: 7:17 PM
 */

namespace Steampunked;


class WaitingView extends View
{
    public function __construct() {
        $this->setTitle("Please Wait for The Other Player");
    }

    public function present(){
        $this->setTitle("Please Wait for The Other Player");
        $result = <<<__HTML__

<p class="waiting"><br><img src="images/IntPumpLarge.gif" width="354" height="267" alt="Pump animation from pumpschool.com"></p>
__HTML__;
        return $result;
    }

    public function isRedirect(){

    }

}