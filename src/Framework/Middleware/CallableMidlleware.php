<?php

namespace Framework\Middleware;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 *  middleware in order to retrieve a route callable call
 */
class CallableMidlleware implements MiddlewareInterface
{
    private $callable;

    public function __construct($callable)
    {
        $this->callable = $callable;
    }

    /**
     * process an incoming server request and return a response
     *
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return new Response();
    }

    public function getCallable()
    {
        return $this->callable;
    }
}
