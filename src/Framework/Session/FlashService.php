<?php

namespace Framework\Session;

use Framework\Session\Session;

class FlashService
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var string
     */
    private $sessionKey = 'flash';

    /**
     * @var string
     */
    private $messages = null;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function success(string $message):void
    {
        //create flash with info from session
        $flash = $this->session->get($this->sessionKey, []);
        //addd success key
        $flash['success'] = $message;
        //stock key in session
        $this->session->set($this->sessionKey, $flash);
    }

    public function error(string $message):void
    {
        //create flash with info from session
        $flash = $this->session->get($this->sessionKey, []);
        //addd success key
        $flash['error'] = $message;
        //stock key in session
        $this->session->set($this->sessionKey, $flash);
    }
   
    public function get(string $type): ?string
    {
        if (is_null($this->messages)) {
            //retieve message from session
            $this->messages = $this->session->get($this->sessionKey, []);
            //empty sessionkey after dstok in message
            $this->session->delete($this->sessionKey);
        }

        //if type exist , display flash message
        if (array_key_exists($type, $this->messages)) {
            return $this->messages[$type];
        }

        return null;
    }
}
