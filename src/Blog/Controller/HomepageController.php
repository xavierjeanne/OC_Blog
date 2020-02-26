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


    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request): string
    {
        if ($request->getMethod() === 'POST') {
            //get params form request
            $params = $request->getParsedBody();
            //check validation error
            $validator = $this->getValidator($request);

            if ($validator->isValid()) {
                $emailSender = new EmailSender($params);
                $emailSender->send();
                return $this->renderer->render('@blog/index');
            }

            $errors = $validator->getErrors();
            $item = $params;
            //return render with the namespace and params
            return $this->renderer->render('@blog/index', compact('item','errors'));
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
