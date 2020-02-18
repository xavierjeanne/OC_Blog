<?php

namespace App\Blog\Controller;

use App\Framework\Validator;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

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
                $mail = "xavier.jeanne@gmail.com";
                $subject = "Demande de renseignement: " . $params['name'];
                $headers = 'MIME-Version: 1.0' . "\n";
                $headers .= 'Reply-To: ' . $params['email'] . "\n";
                $content = $params['content'];
                mail($mail, $subject, $content, $headers);
                return $this->renderer->render('@blog/index');
            }

            $errors = $validator->getErrors();
            $item = $params;
            //get params use in form (with errors and item value)
            $params = $this->formParams(compact('item', 'errors'));

            //return render with the namespace and params
            return $this->renderer->render('@blog/index', $params);
        }
        return $this->renderer->render('@blog/index');
    }

    protected function getValidator(ServerRequestInterface $request)
    {
        return (new Validator($request->getParsedBody()))
            ->notEmpty('name', 'email', 'content')
            ->email('email');
    }

    protected function formParams(array $params): array
    {
        return $params;
    }
}
