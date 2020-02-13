<?php

namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    /**
     * @var array
     */
    private $modules = [];

    /**
     *
     * @var Router
     */
    private $router;

    /**
     *
     * @var container
     */
    private $container;

    public function __construct(ContainerInterface $container, array $modules = [])
    {
        $this->container = $container;
        //for every modules , instanciate this with container get module
        foreach ($modules as $module) {
            $this->modules[] = $container->get($module);
        }
    }

    /**
     * run app and send response
     *
     * @param  mixed $request
     *
     * @return ResponseInterface
     */
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        //get path uri of request
        $uri = $request->getUri()->getPath();

        //redirect to an url without / a the end
        if (!empty($uri) && $uri[-1] === "/") {
            //create response guzzle with status code and header
            return (new Response())->withStatus(301)->withHeader('Location', substr($uri, 0, -1));
        }
        //get router with container
        $router = $this->container->get(Router::class);

        //get route with match method of router
        $route = $router->match($request);

        //if route is nul send error 404
        if (is_null($route)) {
            //create response 404
            return new Response(404, [], '<h1>Erreur 404</h1>');
        }

        //get callback from route
        $callback = $route->getCallback();

        //if callback is a string,the class of the callback must be insantiate by container injection
        if (is_string($callback)) {
            $callback = $this->container->get($callback);
        }

        //call callback route call with request
        $response = call_user_func_array($callback, [$request]);

        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new \Exception('The response is not a string or an instance of ResponseInterface');
        }
    }
}
