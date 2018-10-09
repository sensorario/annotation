<?php

use Sensorario\Container\Container;

class ContainerLoader
{
    public static function load() : Sensorario\Container\Container
    {
        $container =  new Container();

        $container->loadServices([
            'property.reader' => [
                'class' => 'PropertyReader',
            ]
        ]);

        return $container;
    }
}
