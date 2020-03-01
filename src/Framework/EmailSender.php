<?php

namespace Framework;

class EmailSender
{
    /**
     * @var string
     */
    private $mail;


    public function __construct()
    {
        $this->mail = "xavier.jeanne@gmail.com";
    }

    public function send(string $subject, string $content, string $headers)
    {
        mail($this->mail, $subject, $content, $headers);
    }
}
