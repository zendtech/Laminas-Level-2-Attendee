<?php
/**
 * Greeter
 */
namespace src\modWebServices\XmlRpc;
class Greeter
{
    public function sayHello($name = 'Stranger')
    {
        return sprintf("Hello %s!\n", $name);
    }
}