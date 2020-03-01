<?php

namespace App\Blog\Controller;

use Framework\Validator;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\EmailSender;

class HomepageController
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var EmailSender
     */
    private $emailSender;


    public function __construct(RendererInterface $renderer, EmailSender $emailSender)
    {
        $this->renderer = $renderer;
        $this->emailSender = $emailSender;
    }

    public function __invoke(ServerRequestInterface $request): string
    {
        if ($request->getMethod() === 'POST') {
            //get params form request
            $params = $request->getParsedBody();
            //check validation error
            $validator = $this->getValidator($request);

            if ($validator->isValid()) {
                $subject = "Demande de renseignement : " .$params['name'];
                $content = $params['content'];
                $headers = "Reply To: ".$params['email'];
                $this->emailSender->send($subject, $content, $headers);
                
                return $this->renderer->render('@blog/index');
            }

            $errors = $validator->getErrors();
            $item = $params;
            //return render with the namespace and params
            return $this->renderer->render('@blog/index', compact('item', 'errors'));
        }
        return $this->renderer->render('@blog/index');
    }

    protected function getValidator(ServerRequestInterface $request)
    {
        return (new Validator($request->getParsedBody()))
            ->notEmpty('name', 'email', 'content')
            ->email('email');
    }
}
