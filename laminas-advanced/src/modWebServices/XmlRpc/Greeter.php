<?php
/**
 * Greeter
 */
class Greeter
{
    public function hello(string $name = 'Stranger')
    {
        return sprintf("Hello %s!\n", $name);
    }
}
