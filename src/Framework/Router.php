<?php

namespace Framework;

use Framework\Middleware\CallableMidlleware;
use Framework\Route;
use Mezzio\Router\FastRouteRouter;
use Mezzio\Router\Route as MezzioRoute;
use Psr\Http\Message\ServerRequestInterface;

/**
 * register and match routes
 */
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

    /**
     * retrieve routes with get method
     *
     * @return void
     */
    public function get(string $path, $callable, ?string $name = null)
    {
        $this->router->addRoute(new MezzioRoute($path, new CallableMidlleware($callable), ['GET'], $name));
    }

    /**
     * retrieve routes with post method
     *
     * @return void
     */
    public function delete(string $path, $callable, ?string $name = null)
    {
        $this->router->addRoute(new MezzioRoute($path, new CallableMidlleware($callable), ['DELETE'], $name));
    }

    /**
     * retrieve routes with delete method
     *
     * @return void
     */
    public function post(string $path, $callable, ?string $name = null)
    {
        $this->router->addRoute(new MezzioRoute($path, new CallableMidlleware($callable), ['POST'], $name));
    }

    /**
     * match url with routes and return a route or null
     *
     * @return Route|null
     */
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

    public function generateUri(string $name, array $params = [], array $queryParams = []): ?string
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
