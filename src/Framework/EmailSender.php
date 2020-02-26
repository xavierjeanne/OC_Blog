<?php

namespace Framework;

class EmailSender
{
    /** 
     * @var string
     */
    private $mail="xavier.jeanne@gmail.com";

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $headers;

    /**
     * @var string
     */
    private $content;

    public function __construct(array $params)
    {
        $this->subject = "Demande de renseignement : " .$params['name'];
        $this->headers = "Reply To: ".$params['email'];
        $this->content = $params['content'];
    }

    public function send()
    {
        mail($this->mail,$this->subject,$this->headers);
    }
}