<?php

abstract class Annotation
{
    private $params;

    private function __construct(array $params)
    {
        $this->params = $params;
    }

    public static function box(array $params = [])
    {
        return new static($params);
    }

    public function get($field)
    {
        return $this->params[$field];
    }
}
