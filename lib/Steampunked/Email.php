<?php
/**
 * Created by PhpStorm.
 * User: Jason Steele
 * Date: 3/27/2016
 * Time: 3:10 PM
 */

namespace Steampunked;


class Email {
    public function mail($to, $subject, $message, $headers) {
        mail($to, $subject, $message, $headers);
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->headers = $headers;
    }

    public $to;
    public $subject;
    public $message;
    public $headers;
}