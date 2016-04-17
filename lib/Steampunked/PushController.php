<?php
/**
 * Created by PhpStorm.
 * User: MatthewWiechec
 * Date: 4/9/16
 * Time: 5:36 PM
 */

namespace Steampunked;


/**
 * Controller responsible for pushing a
 * Class PushController
 * @package Steampunked
 */
class PushController {

    private $pushKey;   ///< The key to push a message to
    private $redirect;	///< Page we will redirect the user to.


    /**
     * Constructor
     * @param $pushKey
     */
    public function __construct($site, $pushKey) {
        $this->pushKey = $pushKey;
        $this->push();

        // FOR TESTING. REMOVE/CHANGE WHEN IMPLEMENTED
        $this->redirect = $site->getRoot() . '/new-steampunked.php';
    }

    /**
     * Send the push message
     */
    private function push() {
        /*
         * PHP code to cause a push on a remote client.
         */
        $msg = json_encode(array('key'=>$this->pushKey, 'cmd'=>'reload'));

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        $sock_data = socket_connect($socket, '127.0.0.1', 8078);
        if(!$sock_data) {
            echo "Failed to connect";
        } else {
            socket_write($socket, $msg, strlen($msg));
        }
        socket_close($socket);
    }

    /**
     * @return string URL formatted string
     */
    public function getRedirect() {
        return $this->redirect;
    }
}