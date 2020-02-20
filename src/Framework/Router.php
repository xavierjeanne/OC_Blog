<?php

namespace Framework;

use Framework\Middleware\CallableMidlleware;
use Framework\Route;
use Mezzio\Router\FastRouteRouter;
use Mezzio\Router\Route as MezzioRoute;
use Psr\Http\Message\ServerRequestInterface;

class Router
{
    /**
     * @var FastRouteRouter
     */
    private $router;

    public function __construct()
    {
        $this->router = new FastRouteRouter();
    }

    public function get(string $path, $callable, ?string $name = null)
    {
        $this->router->addRoute(new MezzioRoute($path, new CallableMidlleware($callable), ['GET'], $name));
    }

    public function delete(string $path, $callable, ?string $name = null)
    {
        $this->router->addRoute(new MezzioRoute($path, new CallableMidlleware($callable), ['DELETE'], $name));
    }

    public function post(string $path, $callable, ?string $name = null)
    {
        $this->router->addRoute(new MezzioRoute($path, new CallableMidlleware($callable), ['POST'], $name));
    }

    public function match(ServerRequestInterface $request): ?Route
    {
        //try to macth url with routes
        $result = $this->router->match($request);

        if ($result->isSuccess()) {
            //create a route with name , callable(middleware interface) and params
            return new Route(
                $result->getMatchedRouteName(),
                $result->getMatchedRoute()->getMiddleware()->getCallable(),
                $result->getMatchedParams()
            );
        }

        return null;
    }

    public function generateUri(string $name, array $params = [], array $queryParams = []): string
    {
        //generate uri
        $uri = $this->router->generateUri($name, $params);

        //if not empty $queryParams (pagination)
        if (!empty($queryParams)) {
            //return $uri with pagination
            return $uri . '?' . http_build_query($queryParams);
        }

        return $uri;
    }
}
