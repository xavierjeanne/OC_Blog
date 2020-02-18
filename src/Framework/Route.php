<?php

namespace Framework;

/**
 * represent a matched route
 */
class Route
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var callable
     */

    private $callback;

    /**
     * @var array
     */
    private $params;

    public function __construct(string $name, $callback, array $params)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->params = $params;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCallback()
    {
        return $this->callback;
    }

    public function getParams()
    {
        return $this->params;
    }
}
