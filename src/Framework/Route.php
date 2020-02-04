<?php

namespace Framework;

/**
 * represent a matched route
 */
class Route
{
    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var callable
     */

    private $callback;

    /**
     *
     * @var array
     */
    private $params;

    /**
     * constructor
     *
     * @param string $name
     * @param string|callable $callback
     * @param array $params
     */
    public function __construct(string $name, $callback, array $params)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->params = $params;
    }


    /**
     * return name of route
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * return  a callable
     *
     * @return callable|string
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * return url parmaters
     *
     * @return string[]
     */
    public function getParams()
    {
        return $this->params;
    }
}
