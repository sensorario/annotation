<?php

class PropertyReader
{
    private $className;

    public function learnClassName(string $className)
    {
        $this->className = $className;

        return $this;
    }

    public function lookForPropertiesOnClass() : array
    {
        $ref = new ReflectionClass($this->className);

        return $ref->getProperties();
    }
}
